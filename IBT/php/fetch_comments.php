<?php
header('Content-Type: application/json');

if (!isset($_GET["productid"])) {
    echo json_encode(["error" => "Product ID is required."]);
    exit;
}

$productid = $_GET["productid"];

$conn = new mysqli("localhost", "root", "", "axentune");
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$sql = "SELECT u.comment, r.username 
        FROM usersinteractions u 
        JOIN registration r ON u.userid = r.UserId
        WHERE u.productid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productid);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = ["username" => $row['username'], "comment" => $row['comment']];
    }
}
echo json_encode($comments);

$stmt->close();
$conn->close();