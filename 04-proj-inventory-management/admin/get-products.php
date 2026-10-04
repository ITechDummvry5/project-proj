<?php
require '../config/function.php';


if (isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];
    
    $query = "SELECT id, name FROM products WHERE category_id = '$categoryId' AND status = 0";
    $result = mysqli_query($conn, $query);

    $products = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }

    echo json_encode($products);
}
?>
