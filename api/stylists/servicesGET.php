<?php
header('Content-Type: application/json');

require_once "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get branch_id from query parameter
    $branch_id = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : 0;

    // Join service to schedule to filter by branch
    $sql = "SELECT s.* 
            FROM service s
            JOIN schedule sch ON s.shift_id = sch.shift_id
            WHERE sch.branch_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $branch_id);
    $stmt->execute();
    $result = $stmt->get_result();

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