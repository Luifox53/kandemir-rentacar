<?php
session_start();

$lang_code = $_SESSION['lang'] ?? 'tr';
include "lang/$lang_code.php";

// Önceki verileri alalım
$car_id = $_GET["car_id"] ?? "";
$kisiler = $_GET["kisiler"] ?? "";
$nereden = $_GET["nereden"] ?? "";
$nereye = $_GET["nereye"] ?? "";
?>

<!DOCTYPE html>
<html lang="<?= $lang_code ?>">
<head>
  <meta charset="UTF-8">
  <title>Lokasyon Seç - <?= $lang["title"] ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h1>Lokasyon Seçimi</h1>
  <form action="rezervasyon.php" method="GET">
    <input type="hidden" name="car_id" value="<?= $car_id ?>">
    <input type="hidden" name="kisiler" value="<?= htmlspecialchars($kisiler) ?>">
    <input type="hidden" name="nereden" value="<?= htmlspecialchars($nereden) ?>">
    <input type="hidden" name="nereye" value="<?= htmlspecialchars($nereye) ?>">

    <label for="lokasyon">Buluşma Noktası Seçin:</label>
    <select name="lokasyon" id="lokasyon" required>
      <option value="Antalya Havalimanı">Antalya Havalimanı</option>
      <option value="Otogar">Otogar</option>
      <option value="Şehir Merkezi">Şehir Merkezi</option>
      <option value="Belek">Belek</option>
      <option value="Lara">Lara</option>
      <option value="Kundu">Kundu</option>
    </select>

    <br><br>
    <button type="submit">Devam Et</button>
  </form>
</body>
</html>
