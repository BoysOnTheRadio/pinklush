<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "pinklush");
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM service";
    $result = $conn->query($sql);

    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }

    echo json_encode($services);
} else {
    echo json_encode(["error" => "Only GET method is allowed."]);
}

$conn->close();
?>