<?php
require 'includes/session_manager.php';
initSession();

require 'includes/db_connect.php';

// POST verilerini kontrol et ve session'a kaydet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kisiler = $_POST["kisiler"] ?? '';
    $nereden = $_POST['nereden'] ?? '';
    $nereye = $_POST['nereye'] ?? '';
    
    // Session'a kaydet
    setSessionData('kisiler', $kisiler);
    setSessionData('nereden', $nereden);
    setSessionData('nereye', $nereye);
    
    // POST sonrası yönlendirme (PRG pattern)
    header("Location: arabalar.php");
    exit;
}

// GET isteği - session'dan verileri al
$kisiler = getSessionData('kisiler');
$nereden = getSessionData('nereden');
$nereye = getSessionData('nereye');

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
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arabalar</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/cars.css">
    <link rel="stylesheet" href="assets/css/progress-bar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">

</head>
<body>
  
<!-- Header -->
<?php include 'includes/header.php'; ?>

<!--Progress Bar-->
<?php include 'includes/progress_bar.php'; ?>

<!--Content-->
<div class="main">
  <div class="Bbutton-box">
    <a href="index.php" class="back-button">
        <i class="fas fa-arrow-left"></i>
        <?= translate('btn_geri_don') ?>
    </a>
  </div>
  <h1><?= translate('sayfa_mevcut_arabalar') ?></h1>
  <div class="container">

    <?php 

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // Seçilen lokasyonun fiyatı varsa al, yoksa 0 veya boş yap
          $fiyat = $lokasyon_fiyat[$nereye] ?? 'Fiyat bilgisi yok';
          ?>
          <div class="car-card">
            <div class="car-content">

              <!-- Araç resmi -->
              <div class="car-img" style="background-image: url('<?= htmlspecialchars($row['foto_yolu']) ?>');"></div>

              <!-- Araç bilgileri -->
              <div class="car-infobox">
                <h3><?= htmlspecialchars($row['isim']) ?></h3>
                <div><?php echo "$nereden - $nereye"?></div>
                <div>1-<?= htmlspecialchars($row['kisi_alani']) ?></div>
              </div>

              <!-- Rezervasyon butonu ve fiyat -->
              <div class="car-pricebox">
                <?= is_numeric($fiyat) ? $fiyat . ' €' : $fiyat ?>
                <form action="rezervasyon.php" method="POST">
                  <input type="hidden" name="car_id" value="<?= htmlspecialchars($row['id']) ?>">
                  <input type="hidden" name="kisiler" value="<?= htmlspecialchars($kisiler) ?>">
                  <input type="hidden" name="nereden" value="<?= htmlspecialchars($nereden) ?>">
                  <input type="hidden" name="nereye" value="<?= htmlspecialchars($nereye) ?>">
                  <input type="hidden" name="fiyat" value="<?= htmlspecialchars($fiyat) ?>">
                  <button type="submit"><?= translate('btn_arabayı_sec') ?></button>
                </form>
              </div>

            </div>
          </div>
          <?php
        }
      } else {
        echo "<p>" . translate('hata_arac_bulunamadi') . "</p>";
    } ?>
  </div>
</div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

    <script src="scripts/script.js"></script>
</body>
</html>