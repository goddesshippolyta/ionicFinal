<?php
// CORS başlıklarını ayarla (Cross-Origin Resource Sharing)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');
header('Access-Control-Max-Age: 1728000');
header('Content-Type: application/json');

// Session'u başlat
session_start();

// Oturumu sonlandır
session_unset(); // Tüm session değişkenlerini kaldır
session_destroy(); // Oturumu sonlandır

// Başarılı logout mesajı döndür
echo json_encode(["status" => "Success", "message" => "Logged out successfully"]);
?>
