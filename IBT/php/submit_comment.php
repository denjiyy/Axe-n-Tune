<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["username"])) {
        echo json_encode(["error" => "You need to be logged in to comment."]);
        exit;
    }

    $comment = $_POST["comment"];
    $username = $_SESSION["username"];

    $referer = $_SERVER['HTTP_REFERER'];
    $productNumber = intval(preg_replace('/[^0-9]/', '', basename($referer)));

    $productid = null;
    switch ($productNumber) {
        case 1:
            $productid = 1;
            break;
        case 2:
            $productid = 2;
            break;
        case 3:
            $productid = 3;
            break;
        case 4:
            $productid = 4;
            break;
        case 5:
            $productid = 5;
            break;
        default:
            break;
    }

    if ($productid === null) {
        echo json_encode(["error" => "Invalid product number."]);
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "axentune");
    if ($conn->connect_error) {
        echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
        exit;
    }

    $stmtUserID = $conn->prepare("SELECT UserId FROM registration WHERE Username = ?");
    $stmtUserID->bind_param("s", $username);
    $stmtUserID->execute();
    $resultUserID = $stmtUserID->get_result();
    if ($resultUserID->num_rows === 0) {
        echo json_encode(["error" => "User not found."]);
        exit;
    }
    $user = $resultUserID->fetch_assoc();
    $userId = $user["UserId"];

    $stmt = $conn->prepare("INSERT INTO usersinteractions (comment, userid, productid) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $comment, $userId, $productid);

    if ($stmt->execute()) {
        $stmt->close();
        $stmtUserID->close();
        $conn->close();
        header("Location: ../product$productid.html");
        exit;
    } else {
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $stmtUserID->close();
    $conn->close();
}