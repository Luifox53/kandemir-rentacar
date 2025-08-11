<?php
session_start();

include 'db_connect.php';

$lokasyon_fiyat = [];
$sql2 = "SELECT lokasyon, fiyat FROM lokasyonlar";
$result2 = $conn->query($sql2);
if ($result2 && $result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $lokasyon_fiyat[$row2['lokasyon']] = $row2['fiyat'];
    }
}

$sql = "SELECT id, isim, foto_yolu, kisi_alani FROM arabalar";
    $result = $conn->query($sql);

$kisiler = $_GET["kisiler"] ?? "";
$secili_lokasyon = $_GET['nereye'] ?? '';
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arabalar</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/cars.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">

</head>
<body>
<!--WhatsApp button-->
<a href="https://wa.me/905323746253" target="_blank" id="whatsapp-float"><i class="fab fa-whatsapp"></i></a>

<!--Header-->
<header>
    <div class="logo"></div>
    <h1 href="index.php" class="headertext"><a href="index.php">Antalya Transfer</a></h1>
    <nav>
      <a class="link" href="">SSS</a>
      <a class="link" href="lokasyonlar.php">Lokasyonlar</a>
      <a class="link" href="">İletişim</a>
      <div id="dropdown-toggle">
        <i class="fi fi-tr"></i> Türkçe
        <div id="dropdown-menu">
          <a href=""><i class="fi fi-ru"></i>Русский</a>
          <a href=""><i class="fi fi-gb"></i>English</a>
          <a href=""><i class="fi fi-de"></i>Deutsch</a>
        </div>
      </div>

    </nav>
</header>
<!--Content-->
<div class="main">
  <h1>Mevcut Arabalar</h1>
  <div class="container">

    <?php

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Seçilen lokasyonun fiyatı varsa al, yoksa 0 veya boş yap
          $fiyat = $lokasyon_fiyat[$secili_lokasyon] ?? 'Fiyat bilgisi yok';
          ?>
          <div class="car-card">
            <div class="car-content">

              <!-- Araç resmi -->
              <div class="car-img" style="background-image: url('<?= htmlspecialchars($row['foto_yolu']) ?>');"></div>

              <!-- Araç bilgileri -->
              <div class="car-infobox">
                <h3><?= htmlspecialchars($row['isim']) ?></h3>
                <div><?= htmlspecialchars($row['kisi_alani']) ?> kişi</div>
              </div>

              <!-- Rezervasyon butonu ve fiyat -->
              <div class="car-pricebox">
                <?= is_numeric($fiyat) ? $fiyat . ' €' : $fiyat ?>
                <form action="rezervasyon.php" method="GET">
                  <input type="hidden" name="car_id" value="<?= htmlspecialchars($row['id']) ?>">
                  <input type="hidden" name="kisiler" value="<?= htmlspecialchars($_GET['kisiler'] ?? '') ?>">
                  <input type="hidden" name="nereye" value="<?= htmlspecialchars($secili_lokasyon) ?>">
                  <button type="submit">Arabayı Seç</button>
                </form>
              </div>

            </div>
          </div>
          <?php
        }
      } else {
        echo "<p>Mevcut araç bulunamadı.</p>";
    } ?>
  </div>
</div>

<!--Footer-->
<footer>
    <div class="footer-container">
      <div class="footer-column">
        <h3>İletişim</h3>
        <ul>
          <li><a href="#">Telefon: +90 555 555 5555</a></li>
          <li><a href="#">E-posta: info@kandemirrentacar.com</a></li>
          <li><a href="#">Adres: İstanbul, Türkiye</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Kurumsal</h3>
        <ul>
          <li><a href="#">Hakkımızda</a></li>
          <li><a href="#">Kariyer</a></li>
          <li><a href="#">Basın</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Bizi Takip Edin</h3>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Instagram</a></li>
        </ul>
      </div>
    </div>
  </footer>

    <script src="script.js"></script>
</body>
</html>