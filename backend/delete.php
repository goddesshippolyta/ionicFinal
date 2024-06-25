<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

include "config.php";

// OPTIONS isteğini hemen yanıtlayın
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$message = array();

// URL parametresinden id'yi al ve kontrol et
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    http_response_code(400);
    $message['status'] = "Error";
    $message['message'] = "Invalid member ID";
    echo json_encode($message);
    exit;
}

// Veritabanından silme işlemini gerçekleştir
$query = "DELETE FROM `member` WHERE `id` = '$id' LIMIT 1";
$result = mysqli_query($con, $query);

if ($result) {
    http_response_code(200);
    $message['status'] = "Success";
    $message['message'] = "Record successfully deleted";
} else {
    http_response_code(422);
    $message['status'] = "Error";
    $message['message'] = "Error deleting record: " . mysqli_error($con);
}

echo json_encode($message);
?>
