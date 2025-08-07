<?php
session_start();

$lang_code = $_SESSION['lang'] ?? 'tr';
include "lang/$lang_code.php";

// Gelen veriler
$kisiler = $_GET["kisiler"] ?? "";
$nereden = $_GET["nereden"] ?? "";
$nereye = $_GET["nereye"] ?? "";
?>

<!DOCTYPE html>
<html lang="<?= $lang_code ?>">
<head>
  <meta charset="UTF-8">
  <title>Arabalar - <?= $lang["title"] ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h1>Uygun Arabalar</h1>

  <div class="car-list">
    <?php
    // Basit örnek araba verisi
    $cars = [
      ["id" => 1, "name" => "Renault Clio", "price" => 700],
      ["id" => 2, "name" => "Volkswagen Passat", "price" => 1200],
      ["id" => 3, "name" => "Mercedes Vito", "price" => 1800],
    ];

    foreach ($cars as $car):
    ?>
      <div class="car-box">
        <h3><?= $car["name"] ?></h3>
        <p>Günlük Fiyat: <?= $car["price"] ?> ₺</p>
        <form action="lokasyon.php" method="GET">
          <input type="hidden" name="car_id" value="<?= $car["id"] ?>">
          <input type="hidden" name="kisiler" value="<?= htmlspecialchars($kisiler) ?>">
          <input type="hidden" name="nereden" value="<?= htmlspecialchars($nereden) ?>">
          <input type="hidden" name="nereye" value="<?= htmlspecialchars($nereye) ?>">
          <button type="submit">Bu Aracı Seç</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
