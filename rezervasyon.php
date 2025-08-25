<?php
session_start();

require 'includes/db_connect.php';

$foto_yolu = '';
$car_id = $_POST['car_id'] ?? '';
$kisiler = $_POST["kisiler"] ?? "";
$nereye = $_POST['nereye'] ?? '';
$fiyat = $_POST['fiyat'] ?? '';


$sql = "SELECT foto_yolu FROM arabalar WHERE id = $car_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $foto_yolu = $row['foto_yolu'];
}


?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RezervasyonYap</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/rezervation.css">
    <link rel="stylesheet" href="assets/css/progress-bar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">
</head>
<body>

<!-- Header -->
<?php include 'includes/header.php'; ?>

<!--Progress Bar-->
<?php include 'includes/progress_bar.php'; ?>

<!--Forms-->
<div class="main">
  <div class="forms">
    <!--Personel-->
    <form id="reservation" action="odeme.php" method="POST">
      <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_id) ?>">
      <input type="hidden" name="kisiler" value="<?= htmlspecialchars($kisiler) ?>">
      <input type="hidden" name="nereye" value="<?= htmlspecialchars($nereye) ?>">
      <input type="hidden" name="fiyat" value="<?= htmlspecialchars($fiyat) ?>">
      <input type="hidden" name="foto_yolu" value="<?= htmlspecialchars($foto_yolu) ?>">
      <h3>Kişisel Bilgiler</h3>
      <div class="personelForms">
        <div class="column">
          <label>İsim <br></label>
          <input type="text" name="musteri_isim" placeholder="Ad Soyad" value="" required>
        </div>
        <div class="column">
          <label>E-posta <br></label>
          <input type="email" name="email" placeholder="E-Posta" value="" required>
        </div>  
        <div class="column">
          <label>Tel-No <br></label>
          <input type="tel" name="telno" placeholder="Tel-No" value="" required>
        </div>
      </div>
      <!--About Arrive-->
          <h3>Varış Bilgileri</h3>
          <div class="About-Arrive">
            <div class="column">
              <label>Uçak iniş Tarih/Saat <br></label>
              <input type="datetime-local" name="ucak_inis" value="" required>
            </div>
            <div class="column">
             <label>Uçuş Numarası <br></label>
             <input type="text" name="ucus_no" value="">
            </div>
            <div class="column">
              <label>Otel Adı <br></label>
             <input type="text" placeholder="Otel adı" name="otel" value="">
            </div>
          </div>  
      <!--Passengers-->
      <?php for($i = 1;$i<=$kisiler;$i++){?>

      <h4>Yolcu <?php echo "$i";?></h4>
      <div class="passengerİnfo">
        <div class="column"> 
          <label>Ad Soyad <br></label>
          <input type="text" name="yolcu<?php echo "$i";?>" placeholder="Ad Soyad" value="" required>
        </div>
        <div class="column"> 
          <label>Kimlik/Pasaport No <br></label>
          <input type="number" name="passno<?php echo "$i";?>" required>
        </div>
      </div>
      <?php }?>
    </form>
  </div>
<!--Transport İnfos-->

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
    <button class="submit-button" type="submit" form="reservation">Rezervasyon Yap</button>
  </div>

</div>


<!--Footer-->
<?php include 'includes/footer.php'; ?>

<script src="scripts/script.js"></script>
</body>
</html>