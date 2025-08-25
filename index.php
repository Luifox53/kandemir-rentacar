<?php
require 'includes/session_manager.php';
initSession();

require 'includes/db_connect.php';

$sql = "SELECT lokasyon, fiyat FROM lokasyonlar";
$result = $conn->query($sql);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">

</head> 
<body>

<!-- Header -->
<?php include 'includes/header.php'; ?>

<!--Slider-->
<div class="slider-container">
  <div class="slider">
    <img src="assets/images/maybach_ic.jpg">  
    <img src="assets/images/maybach.jpg">  
    <img src="assets/images/maybach_ic2.jpg">
  </div>
  <button class="leftArrow" onclick="prevSlide()">&#8592;</button>
  <button class="rightArrow" onclick="nextSlide()">&#8594;</button>
</div>

<!--Reservation form-->
<form action="arabalar.php" method="POST">
  <div class="formgroups">
    <div class="formgroup">
      <label for="kisiler">Kişi Sayısı</label>
      <select name="kisiler" id="kisiler">
          <?php for ($i = 1; $i <= 10; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
      </select>
    </div>
    <div class="formgroup">
      <label for="nereden">Nereden</label>
      <select name="" id="">
        <option value="">Antalya Havalimanı</option>
      </select>
    </div>
    <div class="formgroup">
      <label for="nereye">Nereye</label>
      <select name="nereye" id="nereye" required>
        <option value="" disabled selected>Bir lokasyon seçiniz</option><?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lokasyon = htmlspecialchars($row['lokasyon'], ENT_QUOTES, 'UTF-8');
                echo "<option value=\"$lokasyon\">$lokasyon</option>";
            }
        }?>
      </select>
    </div>
    <button type="submit">Araba Bul</button>
  </div>
</form>

<!--Service Process-->
<section>
<h2>Hizmet Süreci</h2>
<div class="columns">
  <div class="column">
    <div class="ball">1</div>
    <h3>Her Şey Dahil Fiyatlar</h3>
    <p>Fiyatlarımız sabittir ve vergiler, otopark ücretleri gibi tüm maliyetleri içerir. Web sitemizde gördüğünüz kadarını ödersiniz – gizli ücret yok.</p>
  </div>
  <div class="column">
    <div class="ball">2</div>
    <h3>Profesyonel Şoförler</h3>
    <p>Deneyimli şoförlerimiz, alanlarında uzmandır ve tüm yasal standartları karşılar. İyi eğitimli ve güvenli, konforlu bir yolculuk için size birinci sınıf hizmet sunarlar.</p>
  </div>
  <div class="column">
    <div class="ball">3</div>
    <h3>VIP Araç Seçenekleri</h3>
    <p>Araçlarımız, güvenli ve keyifli bir yolculuk için en son güvenlik ve konfor özellikleriyle donatılmıştır. VIP araç seçeneklerimizi seçin ve Antalya’da birinci sınıf bir transfer deneyiminin tadını çıkarın.</p>
  </div>
</div>
</section>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

    <script src="scripts/slider.js"></script>
    <script src="scripts/script.js"></script>
</body>
</html>