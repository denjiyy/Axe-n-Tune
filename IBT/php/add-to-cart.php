<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: ../login.html");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $username = $_SESSION['username'];

        $conn = new mysqli("localhost", "root", "", "axentune");
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $select_user_id_query = $conn->prepare("SELECT UserId FROM registration WHERE username = ?");
        $select_user_id_query->bind_param("s", $username);
        $select_user_id_query->execute();
        $result = $select_user_id_query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['UserId'];

            $select_user_id_query->close();

            $stmt = $conn->prepare("INSERT INTO usersproducts(UserId, ProductName, Price) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $userId, $product_name, $product_price);
            if ($stmt->execute()) {
                header("Location: ../account.html");
                exit();
            } else {
                echo "Error: ". $conn->error;
            }
            $stmt->close();
        } else {
            echo "User not found!";
        }

        $conn->close();
        exit;
    }