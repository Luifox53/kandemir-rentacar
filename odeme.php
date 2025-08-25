<?php
session_start();

require 'includes/db_connect.php';

$foto_yolu = $_POST['foto_yolu'];
$car_id = $_POST['car_id'] ?? '';
$kisiler = $_POST["kisiler"] ?? "";
$nereye = $_POST['nereye'] ?? '';
$fiyat = $_POST['fiyat'] ?? '';
$musteri_isim = $_POST['musteri_isim'] ?? '';
$email = $_POST['email'] ?? '';
$telno = $_POST['telno'] ?? '';
$ucak_inis = $_POST['ucak_inis'] ?? '';
$ucus_no = $_POST['ucus_no'] ?? '';
$otel = $_POST['otel'] ?? '';
$yolcular = [];
$kisilerint = intval($_POST['kisiler']);

for($i = 1; $i <= $kisilerint; $i++){
    $yolcu_isim = isset($_POST["yolcu$i"]) ? trim($_POST["yolcu$i"]) : '';
    $kimlik_no = isset($_POST["passno$i"]) ? trim($_POST["passno$i"]) : '';

    if($yolcu_isim != ''){
        $yolcular[] = [
            'yolcu_isim' => $yolcu_isim,
            'kimlik_no' => $kimlik_no
        ];
    }
}

 ?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antalya Transfer</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/payment.css">
    <link rel="stylesheet" href="assets/css/progress-bar.css">
    <link rel="stylesheet" href="assets/css/rezervation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">

</head>
<body>

<!-- Header -->
<?php include 'includes/header.php'; ?>

<!--Progress Bar-->
<?php include 'includes/progress_bar.php'; ?>

<!--Content-->

<div class="flex">
  <div class="parent">
    <h4 style="text-align: center;">Ödeme Seçenekleri</h4>
    <form class="payment-options" id="payments" method="POST" action="rez_tamam.php" target="blank">

      <label for="EFT">
        <span> <i class="fa-solid fa-credit-card"></i> EFT / Havale</span>
        <input type="radio" id="EFT" name="pay-option" class="option" value="EFT" checked focus>
      </label>

      <label for="cash">
        <span> <i class="fa-solid fa-wallet"></i> Nakit Öde </span>
        <input type="radio" id="cash" name="pay-option" class="option" value="Cash">
      </label>

      <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_id) ?>">
      <input type="hidden" name="kisiler" value="<?= htmlspecialchars($kisiler) ?>">
      <input type="hidden" name="nereye" value="<?= htmlspecialchars($nereye) ?>">
      <input type="hidden" name="fiyat" value="<?= htmlspecialchars($fiyat) ?>">
      <input type="hidden" name="musteri_isim" value="<?= htmlspecialchars($musteri_isim) ?>">
      <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
      <input type="hidden" name="telno" value="<?= htmlspecialchars($telno) ?>">
      <input type="hidden" name="ucak_inis" value="<?= htmlspecialchars($ucak_inis) ?>">
      <input type="hidden" name="ucus_no" value="<?= htmlspecialchars($ucus_no) ?>">
      <input type="hidden" name="otel" value="<?= htmlspecialchars($otel) ?>">
      <?php foreach($yolcular as $i => $y){ ?>
      <input type="hidden" name="yolcu<?= $i ?>" value="<?= htmlspecialchars($y['yolcu_isim']) ?>">
      <input type="hidden" name="passno<?= $i ?>" value="<?= htmlspecialchars($y['kimlik_no']) ?>">
      <?php } ?>


    </form>

    <div id="info-box">
    <h5 id="info-header"><i id="card" class="fa-solid fa-credit-card"></i> EFT / Havale</h5>
    <p id="info">Rezervasyonunuz onaylandıktan sonra EFT/Havale ile ödeme yapmak
       için IBAN numarası tarafınıza iletilecektir.</p>
    </div>
    <div class="button-box">
        <button form="payments" type="submit">Rezervasyonu Tamamla</button>
    </div>
  </div>
  
  
    <div class="transport-info">
    <div class="car-img" style="background-image: url('<?= htmlspecialchars($foto_yolu) ?>');"></div>
    <h3>Nereden</h3>
    <p>Antalya Havalimanı</p>
    <h3>Nereye</h3>
    <p><?php echo "{$nereye}"; ?></p>
    <h3>Kişi Sayısı</h3>
    <p><?php echo "{$kisiler} kişi"; ?></p>
    <div class="price-box">
      <h4 class="price"><?php echo "{$fiyat} €"; ?></h4>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="scripts/script.js"></script>
<script src="scripts/payment.js"></script>