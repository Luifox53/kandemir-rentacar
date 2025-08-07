<?php
// Veritabanı bağlantısı (XAMPP için genelde root/şifre yok)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rent_a_car";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

// POST verilerini al
$car_id = $_POST["car_id"];
$kisiler = $_POST["kisiler"];
$isimler = $_POST["isimler"]; // dizi
$nereden = $_POST["nereden"];
$nereye = $_POST["nereye"];
$lokasyon = $_POST["lokasyon"];
$tarih = $_POST["tarih"];
$telefon = $_POST["telefon"];
$email = $_POST["email"];

// İsimleri JSON formatına çevir
$isimler_json = json_encode($isimler, JSON_UNESCAPED_UNICODE);

// Kayıt SQL
$stmt = $conn->prepare("INSERT INTO rezervasyonlar 
(car_id, kisiler, isimler, nereden, nereye, lokasyon, tarih, telefon, email) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisssssss", $car_id, $kisiler, $isimler_json, $nereden, $nereye, $lokasyon, $tarih, $telefon, $email);

if ($stmt->execute()) {
    echo "<h2>✅ Rezervasyon başarıyla kaydedildi!</h2>";
    echo "<p>En kısa sürede sizinle iletişime geçeceğiz.</p>";
} else {
    echo "<h2>❌ Hata oluştu:</h2>" . $stmt->error;
}

$stmt->close();
$conn->close();
?>
