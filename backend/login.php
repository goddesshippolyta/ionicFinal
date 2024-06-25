<?php
// CORS başlıklarını ayarla
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');
header('Access-Control-Max-Age: 1728000');
header('Content-Type: application/json');

require 'config.php';

// OPTIONS isteğine yanıt verin
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Giriş verilerini JSON olarak alın
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data === null) {
    http_response_code(400);
    echo json_encode(["status" => "Error", "message" => "No input data received"]);
    exit;
}

// Kullanıcı adı ve şifreyi alın
$username = isset($data['username']) ? mysqli_real_escape_string($con, $data['username']) : null;
$password = isset($data['password']) ? mysqli_real_escape_string($con, $data['password']) : null;

if ($username && $password) {
    // Şifreyi hash'le
    $hashed_password = hash('sha256', $password);
    
    // Kullanıcıyı sorgula
    $query = "SELECT * FROM users WHERE (username='$username' OR email='$username') AND password='$hashed_password'";
    $result = mysqli_query($con, $query);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode(["status" => "Error", "message" => "Database query error: " . mysqli_error($con)]);
        exit;
    }
    
    if (mysqli_num_rows($result) == 1) {
        // Kullanıcı bulundu, detaylarını alalım
        $userData = mysqli_fetch_assoc($result);
        
       
        echo json_encode(["status" => "Success", "user" => $userData]);
    } else {
        // Kullanıcı bulunamadı
        http_response_code(401);
        echo json_encode(["status" => "Error", "message" => "Invalid username or password"]);
    }
} else {
    // Eksik giriş verileri
    http_response_code(400);
    echo json_encode(["status" => "Error", "message" => "Missing input data"]);
}
?>
