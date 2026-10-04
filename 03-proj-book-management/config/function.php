<?php
include('dbconn.php'); // Make sure the path is correct

// ======================
//  AUTHOR CRUD FUNCTIONS
// ======================

function insertAuthor($name, $email = '') {
    global $con;

    $query = "INSERT INTO authors (name, email) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $name, $email);

    return mysqli_stmt_execute($stmt) ? mysqli_insert_id($con) : false;
}

function getAuthors() {
    global $con;

    $query = "SELECT * FROM authors ORDER BY id DESC";
    return mysqli_query($con, $query);
}

function updateAuthor($id, $name, $email) {
    global $con;

    $query = "UPDATE authors SET name=?, email=? WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $id);

    return mysqli_stmt_execute($stmt);
}

function deleteAuthor($id) {
    global $con;

    $query = "DELETE FROM authors WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
}
// ======================
//  BOOK CRUD FUNCTIONS
// ======================

function insertBook($title, $author_name, $date_published, $description, $genre, $featured = 0, $cover_path = '', $book_path = '') {
    global $con;

    // Get author_id or create new author
    $authorQuery = mysqli_query($con, "SELECT id FROM authors WHERE name='$author_name' LIMIT 1");
    if(mysqli_num_rows($authorQuery) > 0){
        $author = mysqli_fetch_assoc($authorQuery);
        $author_id = $author['id'];
    } else {
        $author_id = insertAuthor($author_name); // create new author
    }

    $stmt = mysqli_prepare($con, "INSERT INTO books (title, author_id, date_published, description, genre, featured, cover_image, book_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sisssiss", $title, $author_id, $date_published, $description, $genre, $featured, $cover_path, $book_path);

    return mysqli_stmt_execute($stmt);
}

function getBooks() {
    global $con;

    $query = "SELECT b.*, a.name AS author_name FROM books b 
              LEFT JOIN authors a ON b.author_id = a.id 
              ORDER BY b.id DESC";
    return mysqli_query($con, $query);
}

function updateBook($id, $title, $author_name, $date_published, $description, $genre, $featured = 0, $cover_path = '', $book_path = '') {
    global $con;

    // Get author_id or create new author
    $authorQuery = mysqli_query($con, "SELECT id FROM authors WHERE name='$author_name' LIMIT 1");
    if(mysqli_num_rows($authorQuery) > 0){
        $author = mysqli_fetch_assoc($authorQuery);
        $author_id = $author['id'];
    } else {
        $author_id = insertAuthor($author_name); // create new author
    }

    // Update book
    $stmt = mysqli_prepare($con, "UPDATE books SET title=?, author_id=?, date_published=?, description=?, genre=?, featured=?, cover_image=?, book_file=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sisssisii", $title, $author_id, $date_published, $description, $genre, $featured, $cover_path, $book_path, $id);

    return mysqli_stmt_execute($stmt);
}

function deleteBook($id) {
    global $con;

    $stmt = mysqli_prepare($con, "DELETE FROM books WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
}
?>