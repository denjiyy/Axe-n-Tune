<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION["username"])) {
            echo json_encode(array("error" => "You need to be logged in to delete comments."));
            exit;
        }

        $commentId = $_POST["id"];
        $username = $_SESSION["username"];

        $conn = new mysqli("localhost", "root", "", "axentune");
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $stmtUserID = $conn->prepare("SELECT UserId FROM registration WHERE Username = ?");
        $stmtUserID->bind_param("s", $username);
        $stmtUserID->execute();
        $resultUserID = $stmtUserID->get_result();
        $user = $resultUserID->fetch_assoc();
        $userId = $user["UserId"];
        
        $stmt = $conn->prepare("SELECT userid FROM usersinteractions WHERE userid = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $comment = $result->fetch_assoc();

        if ($comment && $comment['userid'] == $userId) {
            $stmt = $conn->prepare("DELETE FROM usersinteractions WHERE userid = ?");
            $stmt->bind_param("i", $userId);

            if ($stmt->execute()) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("error" => "Error deleting comment: " . $stmt->error));
            }
        } else {
            echo json_encode(array("error" => "You can only delete your own comments."));
        }

        $stmt->close();
        $conn->close();
    }