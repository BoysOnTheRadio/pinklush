<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../db_connect.php";

$query = "SELECT * FROM employee";
$result = mysqli_query($con, $query);
$employee = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)){
        $employee[] = $row; 
    }
    echo json_encode(
        [
            "success" => true,
            "data" => $employee
        ]
        );
} else
{
    echo json_encode([
        "success" => false,
        "message" => "failed to fetch employee"
    ]);
}
?>
