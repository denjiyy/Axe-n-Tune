<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        http_response_code(401);
        echo json_encode(array("error" => "User not logged in"));
        exit;
    }

    if (!isset($_GET['product_id'])) {
        http_response_code(400);
        echo json_encode(array("error" => "Product ID not provided"));
        exit;
    }

    $conn = mysqli_connect("localhost", "root", "", "axentune");

    if (!$conn) {
        http_response_code(500);
        echo json_encode(array("error" => "Connection failed: " . mysqli_connect_error()));
        exit;
    }

    $username = $_SESSION['username'];
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);

    $sql_delete_product = "DELETE FROM usersproducts 
                        WHERE UserId IN (SELECT UserId FROM registration WHERE username = '$username')
                        AND UserProductId = $product_id";

    if (mysqli_query($conn, $sql_delete_product)) {
        echo json_encode(array("success" => true));
    } else {
        http_response_code(500);
        echo json_encode(array("error" => "Error deleting product from the cart: " . mysqli_error($conn)));
    }

    mysqli_close($conn);