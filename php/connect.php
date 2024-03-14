<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', 'axentune');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO registration(Username, Password) VALUES(?, ?)");

        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        echo "Registration successful...";
        $stmt->close();
        $conn->close();
    }
?>