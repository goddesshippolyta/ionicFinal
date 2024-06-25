<?php
include "config.php";

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Return CORS headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit();
}

// Set CORS headers for POST and GET requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if JSON decoding was successful
if ($data === null) {
    http_response_code(400);
    echo json_encode(["status" => "Error", "message" => "Invalid JSON"]);
    exit();
}

$message = array();
if (isset($data['year'], $data['memberOne'], $data['memberTwo'])) {
    $year = $data['year'];
    $memberOne = $data['memberOne'];
    $memberTwo = $data['memberTwo'];

    $stmt = $con->prepare("INSERT INTO `member` (`year`, `memberOne`, `memberTwo`) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $year, $memberOne, $memberTwo);

    if ($stmt->execute()) {
        http_response_code(201);
        $message['status'] = "Success";
    } else {
        http_response_code(422);
        $message['status'] = "Error";
        $message['error'] = $stmt->error;
    }

    $stmt->close();
} else {
    http_response_code(400);
    $message['status'] = "Error";
    $message['message'] = "Missing or invalid input data";
}

echo json_encode($message);
?>
