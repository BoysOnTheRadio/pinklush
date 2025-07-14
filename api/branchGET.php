<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "db_connect.php";

$query = "SELECT branch_id, address FROM branch";
$result = mysqli_query($con, $query);

$branches = [];
while ($row = mysqli_fetch_assoc($result)) {
    $branches[] = $row;
}

echo json_encode([
    "success" => true,
    "branches" => $branches
]);
?>