<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: ../index.html");
        exit;
    }

    $conn = mysqli_connect("localhost", "root", "", "axentune");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username'];

    unset($_SESSION['username']);
    // unset($_SESSION['UserId']);

    $sql_delete_products = "DELETE FROM usersproducts WHERE UserId IN (SELECT UserId FROM registration WHERE username = '$username')";

    if (mysqli_query($conn, $sql_delete_products)) {
        $sql_delete_user = "DELETE FROM registration WHERE username = '$username'";
        if (mysqli_query($conn, $sql_delete_user)) {
            echo "Account deleted successfully";
            header("Location: ../index.html");
            exit;
        } else {
            echo "Error deleting account: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting associated products: " . mysqli_error($conn);
    }

    mysqli_close($conn);