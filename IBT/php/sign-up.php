<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "", "axentune");
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("SELECT Username FROM registration WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            echo "Username already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO registration(Username, Password) VALUES(?, ?)");

            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            echo "Registration successful...";
            session_start();
            $_SESSION["username"] = $username;
        }
        
        $stmt->close();
        $conn->close();
        header("Location: ../index.html");
        exit;
    }