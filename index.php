<?php
require 'includes/session_manager.php';
initSession();

require 'includes/db_connect.php';

$sql = "SELECT lokasyon, fiyat FROM lokasyonlar";
$result = $conn->query($sql);
$result_lokasyonlar = $conn->query($sql); // Lokasyonlar için ikinci kopya

$sql2 = "SELECT id, isim, foto_yolu, kisi_alani FROM arabalar";
$result2 = $conn->query($sql2);

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antalya Transfer</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/homepage.css">
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">

</head> 
<body>
  
<!-- Header -->
<?php include 'includes/header.php'; ?>

<!--Slider-->
<div class="slider-container">
  <div class="slider">
    <img src="assets/images/vitokurumsal.jpg">  
    <img src="assets/images/maybach_ic.jpg">  
    <img src="assets/images/maybach_ic2.jpg">
  </div>
  <button class="leftArrow" onclick="prevSlide()">&#8592;</button>
  <button class="rightArrow" onclick="nextSlide()">&#8594;</button>
</div>

<!--Reservation form-->
<form action="arabalar.php" method="POST">
  <div class="formgroups">
    <div class="formgroup">
      <label for="kisiler"><?= translate('anasayfa_kisi_sayisi') ?></label>
  <select name="kisiler" id="kisiler" required>
        <option value="" disabled selected><i class="fa-solid fa-user"></i> <?= translate('anasayfa_kisi_sayisi') ?></option>
          <?php for ($i = 1; $i <= 10; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
      </select>
    </div>
    <div class="formgroup">
      <label for="nereden"><?= translate('anasayfa_nereden') ?></label>
      <select name="nereden" id="nereden" required>
        <option value="" disabled selected><?= translate('placeholder_lokasyon_sec') ?></option><?php
        if ($result && $result->num_rows > 0) {
            // Reset result pointer to beginning
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $lokasyon = htmlspecialchars($row['lokasyon'], ENT_QUOTES, 'UTF-8');
                echo "<option value=\"$lokasyon\">$lokasyon</option>";
            }
        }?>
      </select>
    </div>
    <div class="formgroup">
      <label for="nereye"><?= translate('anasayfa_nereye') ?></label>
      <select name="nereye" id="nereye" required>
        <option value="" disabled selected><?= translate('placeholder_lokasyon_sec') ?></option><?php
        if ($result_lokasyonlar && $result_lokasyonlar->num_rows > 0) {
            while ($row = $result_lokasyonlar->fetch_assoc()) {
                $lokasyon = htmlspecialchars($row['lokasyon'], ENT_QUOTES, 'UTF-8');
                echo "<option value=\"$lokasyon\">$lokasyon</option>";
            }
        }?>
      </select>
    </div>
    <div class="formgroup" id="checkbox">
      <label id="checklabel" for="gidis_donus">Gidiş - Dönüş</label>
      <input type="checkbox" name="gidis_donus" id="gidis_donus">
    </div>

    <button type="submit"><?= translate('anasayfa_araba_bul') ?></button>
  </div>
</form>

<!--Service Process-->
<section>
<h2><?= translate('anasayfa_hizmet_sureci') ?></h2>
<div class="columns">
  <div class="column">
    <div class="ball">1</div>
    <h3><?= translate('anasayfa_kolay_rezervasyon') ?></h3>
    <p><?= translate('anasayfa_kolay_rez_aciklama') ?></p>
  </div>
  <div class="column">
    <div class="ball">2</div>
    <h3><?= translate('anasayfa_deneyimli_soforler') ?></h3>
    <p><?= translate('anasayfa_deneyimli_soforler_aciklama') ?></p>
  </div>
  <div class="column">
    <div class="ball">3</div>
    <h3><?= translate('anasayfa_konforlu_araclar') ?></h3>
    <p><?= translate('anasayfa_konforlu_araclar_aciklama') ?></p>
  </div>
</div>
</section>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

    <script src="scripts/slider.js"></script>
    <script src="scripts/script.js"></script>
</body>
</html>