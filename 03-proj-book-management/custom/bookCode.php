<?php
include('../config/function.php'); // Make sure $con is included

// ===== ADD NEW BOOK =====
if (isset($_POST['add_book'])) {
    $title          = trim($_POST['title']);
    $author_name    = trim($_POST['author']);
    $date_published = $_POST['date_published'];
    $description    = trim($_POST['description']);
    $genre          = $_POST['genre'];
    $featured       = isset($_POST['featured']) ? 1 : 0;

    // Handle cover image upload
    $cover_path = '';
    if(isset($_FILES['cover_image']) && $_FILES['cover_image']['name'] != ''){
        $cover_name = time().'_'.basename($_FILES['cover_image']['name']);
        $cover_path = 'uploads/covers/'.$cover_name;
        move_uploaded_file($_FILES['cover_image']['tmp_name'], '../'.$cover_path);
    }

    // Handle book file upload
    $book_path = '';
    if(isset($_FILES['book_file']) && $_FILES['book_file']['name'] != ''){
        $book_name = time().'_'.basename($_FILES['book_file']['name']);
        $book_path = 'uploads/books/'.$book_name;
        move_uploaded_file($_FILES['book_file']['tmp_name'], '../'.$book_path);
    }

    // Insert book using function.php
    $inserted = insertBook($title, $author_name, $date_published, $description, $genre, $featured, $cover_path, $book_path);

    if($inserted){
        echo "<script>alert('Book added successfully!'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Failed to add book!'); window.location.href='../index.php';</script>";
    }
}

// ===== DELETE BOOK =====
if (isset($_GET['delete_book_id'])) {
    $book_id = intval($_GET['delete_book_id']);

    // Optional: fetch book to delete files
    $bookQuery = mysqli_query($con, "SELECT cover_image, book_file FROM books WHERE id=$book_id LIMIT 1");
    if ($bookQuery && mysqli_num_rows($bookQuery) > 0) {
        $book = mysqli_fetch_assoc($bookQuery);

        if (!empty($book['cover_image']) && file_exists('../'.$book['cover_image'])) {
            unlink('../'.$book['cover_image']);
        }

        if (!empty($book['book_file']) && file_exists('../'.$book['book_file'])) {
            unlink('../'.$book['book_file']);
        }
    }

    // Use your function to delete book
    if(deleteBook($book_id)) {
        echo "<script>
                alert('Book deleted successfully!');
                window.location.href='../index.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to delete book!');
                window.location.href='../index.php';
              </script>";
    }
    exit();
}


// ===== UPDATE BOOK =====
elseif (isset($_POST['update_book'])) {
    $book_id        = $_POST['book_id'];
    $title          = trim($_POST['title']);
    $author_name    = trim($_POST['author']);
    $date_published = $_POST['date_published'];
    $description    = trim($_POST['description']);
    $genre          = $_POST['genre'];
    $featured       = isset($_POST['featured']) ? 1 : 0;

    // Handle cover image upload
    $cover_image_path = '';
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['name'] != '') {
        $cover_name = time().'_'.basename($_FILES['cover_image']['name']);
        $target_dir = '../uploads/covers/';
        $target_file = $target_dir . $cover_name;
        if(move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_file)){
            $cover_image_path = 'uploads/covers/' . $cover_name;
        }
    }

    // Handle book file upload
    $book_file_path = '';
    if (isset($_FILES['book_file']) && $_FILES['book_file']['name'] != '') {
        $book_name = time().'_'.basename($_FILES['book_file']['name']);
        $target_dir = '../uploads/books/';
        $target_file = $target_dir . $book_name;
        if(move_uploaded_file($_FILES['book_file']['tmp_name'], $target_file)){
            $book_file_path = 'uploads/books/' . $book_name;
        }
    }

    // Get or create author
    $authorQuery = mysqli_query($con, "SELECT id FROM authors WHERE name='$author_name' LIMIT 1");
    if(mysqli_num_rows($authorQuery) > 0){
        $author = mysqli_fetch_assoc($authorQuery);
        $author_id = $author['id'];
    } else {
        $author_id = insertAuthor($author_name);
    }

    // Build dynamic update query
    $fields = "title=?, author_id=?, date_published=?, description=?, genre=?, featured=?";
    $types  = "sisssi";
    $params = [$title, $author_id, $date_published, $description, $genre, $featured];

    if($cover_image_path != ''){
        $fields .= ", cover_image=?";
        $types .= "s";
        $params[] = $cover_image_path;
    }
    if($book_file_path != ''){
        $fields .= ", book_file=?";
        $types .= "s";
        $params[] = $book_file_path;
    }

    $params[] = $book_id;
    $types .= "i";

    $stmt = mysqli_prepare($con, "UPDATE books SET $fields WHERE id=?");
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if(mysqli_stmt_execute($stmt)){
        echo "<script>alert('Book updated successfully!'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Failed to update book!'); window.location.href='../index.php';</script>";
    }
}

// Prevent direct access
else {
    header("Location: ../index.php");
    exit();
}



?>
