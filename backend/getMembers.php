<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include "config.php";

// Veritabanı bağlantısını kontrol edin
if ($con->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $con->connect_error]));
}

$data = array();
$q = mysqli_query($con, "SELECT * FROM `member`");

// Sorgunun başarısız olup olmadığını kontrol edin
if (!$q) {
    die(json_encode(["error" => "Query failed: " . mysqli_error($con)]));
}

// Veritabanı sonuçlarını al
while ($row = mysqli_fetch_object($q)) {
    $data[] = $row;
}

// JSON formatında yanıtı döndür
echo json_encode($data);

// Bağlantıyı kapat
mysqli_close($con);
?>
