<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../db_connect.php";

// Get branch_id and service_id from query parameters
$branch_id = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : 0;
$service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;

if ($branch_id === 0 || $service_id === 0) {
    echo json_encode(["success" => false, "error" => "Missing branch_id or service_id"]);
    exit;
}

// Get all booked appointment date-times for the given branch and service
$query = "SELECT 
    a.appointment_date, 
    a.status,
    a.branch_id,
    a.service_id
FROM appointments a
WHERE a.status = 'Scheduled'
  AND a.branch_id = ?
  AND a.service_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $branch_id, $service_id);
$stmt->execute();
$result = $stmt->get_result();

$booked_slots = [];
while ($row = $result->fetch_assoc()) {
    $booked_slots[] = [
        'appointment_date' => $row['appointment_date'],
        'status' => $row['status'],
        'branch_id' => $row['branch_id'],
        'service_id' => $row['service_id']
    ];
}

echo json_encode([
    "success" => true,
    "booked_slots" => $booked_slots
]);

$stmt->close();
$conn->close();
?>