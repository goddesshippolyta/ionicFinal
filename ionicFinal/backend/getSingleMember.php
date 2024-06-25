<?php
// CORS başlıkları ekleyin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Devam eden PHP kodunuz...
include "config.php";

$data = array();

// type değişkeninin varlığını kontrol et
$type = isset($_GET['type']) ? mysqli_real_escape_string($con, $_GET['type']) : '';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Güvenlik kontrolü ve integer olarak dönüştürme
if($id > 0) {
  $q = mysqli_query($con, "SELECT * FROM `member` WHERE `id` = $id LIMIT 1");
  if(mysqli_num_rows($q) > 0) {
    while ($row = mysqli_fetch_assoc($q)) { // mysqli_fetch_assoc kullanımı
      $data[] = $row;
    }
    echo json_encode($data);
  } else {
    echo json_encode(array("error" => "member not found"));
  }
} else {
  echo json_encode(array("error" => "Invalid ID"));
}
?>
