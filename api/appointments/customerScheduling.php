<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../db_connect.php";

// get all booked appointment date-times, service_type, and branch_id
$query = "SELECT 
    a.appointment_date, 
    s.service_type, 
    sch.branch_id
FROM appointments a
JOIN service s ON a.service_id = s.service_id
JOIN schedule sch ON s.shift_id = sch.shift_id
WHERE a.status = 'Scheduled'";

$result = mysqli_query($con, $query);

$booked_slots = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booked_slots[] = [
        'appointment_date' => $row['appointment_date'],
        'service_type' => $row['service_type'],
        'branch_id' => $row['branch_id']
    ];
}

echo json_encode([
    "success" => true,
    "booked_slots" => $booked_slots
]);
?>