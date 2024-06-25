<?php
include "config.php";

// CORS başlıkları ekleyin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// OPTIONS isteğine yanıt verin
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Verileri PUT olarak al
$input = file_get_contents('php://input');
file_put_contents('debug.log', "Raw Input: " . $input . "\n", FILE_APPEND);
$data = json_decode($input, true);
file_put_contents('debug.log', "Decoded Input: " . print_r($data, true) . "\n", FILE_APPEND);

if ($data === null) {
    echo json_encode(["status" => "Error", "message" => "No input data received", "input" => $input]);
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$year = isset($data['year']) ? mysqli_real_escape_string($con, $data['year']) : null;
$memberOne = isset($data['memberOne']) ? mysqli_real_escape_string($con, $data['memberOne']) : null;
$memberTwo = isset($data['memberTwo']) ? mysqli_real_escape_string($con, $data['memberTwo']) : null;

// Debug log
file_put_contents('debug.log', "ID: " . print_r($id, true) . "\n", FILE_APPEND);
file_put_contents('debug.log', "Year: " . print_r($year, true) . "\n", FILE_APPEND);
file_put_contents('debug.log', "Member One: " . print_r($memberOne, true) . "\n", FILE_APPEND);
file_put_contents('debug.log', "Member Two: " . print_r($memberTwo, true) . "\n", FILE_APPEND);

if ($id !== null && $id > 0) {
    if ($year !== null && $memberOne !== null && $memberTwo !== null) {
        $query = "UPDATE `member` SET `year` = '$year', `memberOne` = '$memberOne', `memberTwo` = '$memberTwo' WHERE `id` = '{$id}' LIMIT 1";
        file_put_contents('debug.log', "SQL Query: " . $query . "\n", FILE_APPEND);
        $q = mysqli_query($con, $query);
        if ($q) {
            echo json_encode(["status" => "Success", "message" => "Member updated successfully"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Failed to update member"]);
        }
    } else {
        echo json_encode(["status" => "Error", "message" => "Invalid input data"]);
    }
} else {
    echo json_encode(["status" => "Error", "message" => "Invalid member ID"]);
}
