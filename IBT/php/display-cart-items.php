<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        echo json_encode(['error' => 'User not logged in']);
        exit();
    }

    $username = $_SESSION['username'];

    $conn = new mysqli("localhost", "root", "", "axentune");
    if ($conn->connect_error) {
        echo json_encode(['error' => 'Database connection failed']);
        exit();
    }

    $select_user_id_query = $conn->prepare("SELECT UserId FROM registration WHERE username = ?");
    $select_user_id_query->bind_param("s", $username);
    $select_user_id_query->execute();
    $result = $select_user_id_query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['UserId'];

        $select_user_id_query->close();

        $stmt = $conn->prepare("SELECT UserProductId, ProductName, Price FROM usersproducts WHERE UserId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        echo json_encode($orders);
    } else {
        echo json_encode(['error' => 'User not found']);
    }

    $stmt->close();
    $conn->close();