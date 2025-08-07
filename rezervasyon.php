<?php
session_start();

$lang_code = $_SESSION['lang'] ?? 'tr';
include "lang/$lang_code.php";

// Önceki veriler
$car_id = $_GET["car_id"] ?? "";
$kisiler = $_GET["kisiler"] ?? 1;
$nereden = $_GET["nereden"] ?? "";
$nereye = $_GET["nereye"] ?? "";
$lokasyon = $_GET["lokasyon"] ?? "";
?>

<!DOCTYPE html>
<html lang="<?= $lang_code ?>">
<head>
  <meta charset="UTF-8">
  <title>Rezervasyon Yap - <?= $lang["title"] ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h1>Rezervasyon Formu</h1>
  
  <form action="rez-kayit.php" method="POST">
    <!-- Gizli alanlar -->
    <input type="hidden" name="car_id" value="<?= $car_id ?>">
    <input type="hidden" name="kisiler" value="<?= $kisiler ?>">
    <input type="hidden" name="nereden" value="<?= htmlspecialchars($nereden) ?>">
    <input type="hidden" name="nereye" value="<?= htmlspecialchars($nereye) ?>">
    <input type="hidden" name="lokasyon" value="<?= htmlspecialchars($lokasyon) ?>">

    <label for="tarih">Buluşma Tarihi:</label>
    <input type="date" name="tarih" id="tarih" required>
    <br><br>

    <h3>Kişi Bilgileri</h3>
    <?php for ($i = 1; $i <= $kisiler; $i++): ?>
      <label for="isim<?= $i ?>">Kişi <?= $i ?>:</label>
      <input type="text" name="isimler[]" id="isim<?= $i ?>" placeholder="Ad Soyad" required>
      <br>
    <?php endfor; ?>
    <br>

    <label for="telefon">Telefon Numarası:</label>
    <input type="tel" name="telefon" id="telefon" required>
    <br><br>

    <label for="email">E-Posta Adresi:</label>
    <input type="email" name="email" id="email" required>
    <br><br>

    <button type="submit">Rezervasyonu Tamamla</button>
  </form>
</body>
</html>
