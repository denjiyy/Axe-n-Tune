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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);

        $sql_update_user = "UPDATE registration SET `Username`='$new_username', `Password`='$new_password' WHERE `username`='$username'";

        if (mysqli_query($conn, $sql_update_user)) {
            $_SESSION['username'] = $new_username;
            echo "Account updated successfully";
            header("Location: ../index.html");
            exit;
        } else {
            echo "Error updating account: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);