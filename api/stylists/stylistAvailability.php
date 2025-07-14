<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "pinklush");
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    $employee_id = $data['employee_id'];
    $day = $data['day'];
    $shift_start = $data['shift_start'];
    $shift_end = $data['shift_end'];

    $stmt = $conn->prepare("UPDATE schedule SET day = ?, shift_start = ?, shift_end = ? WHERE employee_id = ?");
    $stmt->bind_param("sssi", $day, $shift_start, $shift_end, $employee_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Availability updated successfully."]);
    } else {
        echo json_encode(["error" => "Update failed."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Only PUT method is allowed."]);
}

$conn->close();
?>