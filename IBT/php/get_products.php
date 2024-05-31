<?php
    $conn = new mysqli("localhost", "root", "", "axentune");

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    } else {
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        $products = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        echo json_encode($products);

        $conn->close();
    }