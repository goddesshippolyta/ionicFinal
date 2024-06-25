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

// Gelen verileri yazdırarak kontrol edelim
file_put_contents('debug.log', "Received Input: " . $input . "\n", FILE_APPEND);
file_put_contents('debug.log', "Decoded Input: " . print_r($data, true) . "\n", FILE_APPEND);

// Kullanıcı bilgilerini alın
$username = isset($data['username']) ? mysqli_real_escape_string($con, $data['username']) : null;
$name = isset($data['name']) ? mysqli_real_escape_string($con, $data['name']) : null;
$passwordr = isset($data['password']) ? mysqli_real_escape_string($con, $data['password']) : null;
$email = isset($data['email']) ? mysqli_real_escape_string($con, $data['email']) : null;

if ($username && $name && $password && $email) {
    // Giriş verilerini kontrol et
    $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
    $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
    $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $passwordr);

    if ($username_check && $email_check && $password_check) {
        $sql = "SELECT user_id FROM users WHERE username='$username' OR email='$email'";
        $result = mysqli_query($con, $sql);

        // Hata kontrolü ekleyelim
        if (!$result) {
            http_response_code(500);
            echo json_encode(["status" => "Error", "message" => "Database query error: " . mysqli_error($con)]);
            exit;
        }

        if (mysqli_num_rows($result) == 0) {
            // Şifreyi hash'le
            $password = hash('sha256', $passwordr);

            // Kullanıcıyı ekle
            $sql = "INSERT INTO users (username, password, email, name) VALUES ('$username', '$password', '$email', '$name')";
            if (mysqli_query($con, $sql)) {
                // Başarılı kayıt
                echo json_encode(["status" => "Success", "message" => "User registered successfully"]);
            } else {
                // Kayıt hatası
                http_response_code(500);
                echo json_encode(["status" => "Error", "message" => "Error registering user: " . mysqli_error($con)]);
            }
        } else {
            // Kullanıcı zaten kayıtlı
            http_response_code(400);
            echo json_encode(["status" => "Error", "message" => "User already exists"]);
        }
    } else {
        // Geçersiz giriş verileri
        http_response_code(400);
        echo json_encode(["status" => "Error", "message" => "Invalid input data"]);
    }
} else {
    // Eksik giriş verileri
    http_response_code(400);
    echo json_encode(["status" => "Error", "message" => "Missing input data"]);
}
?>
