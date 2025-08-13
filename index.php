<?php
session_start();

include 'db_connect.php';

$sql = "SELECT lokasyon, fiyat FROM lokasyonlar";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
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
<!--WhatsApp button-->
<a href="https://wa.me/905323746253" target="_blank" id="whatsapp-float"><i class="fab fa-whatsapp"></i></a>

<!--Header-->
<header>
    <div class="logo"></div>
    <h1 class="headertext"><a href="index.php">Antalya Transfer</a></h1>
    <nav>
      <a class="link" href="sss.php">SSS</a>
      <a class="link" href="lokasyonlar.php">Lokasyonlar</a>
      <a class="link" href="iletisim.php">İletişim</a>
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

<!--Slider-->
<div class="slider-container">
  <div class="slider">
    <img src="assets/images/vito.jpg">  
    <img src="assets/images/audia8.jpg">  
    <img src="assets/images/tesla.jpg">
  </div>
  <button class="leftArrow" onclick="prevSlide()">&#8592;</button>
  <button class="rightArrow" onclick="nextSlide()">&#8594;</button>
</div>

<!--Reservation form-->
<form action="arabalar.php" method="GET">
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
                $lokasyon = htmlspecialchars($row['lokasyon']);
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
    <h3>Lorem İpsum</h3>
    <p>Lorem İpsumLorem İpsumLorem İpsum</p>
  </div>
  <div class="column">
    <div class="ball">2</div>
    <h3>Lorem İpsum</h3>
    <p>Lorem İpsumLorem İpsumLorem İpsum</p>
  </div>
  <div class="column">
    <div class="ball">3</div>
    <h3>Lorem ipsum</h3>
    <p>Lorem İpsumLorem İpsumLorem İpsumLorem İpsumLorem İpsumLorem İpsum</p>
  </div>
</div>
</section>

<!--Footer-->
<footer>
    <div class="footer-container">
        <div class="footer-column">
            <h3>İletişim</h3>
            <ul>
                <li><a href="#">📞 +90 555 555 5555</a></li>
                <li><a href="#">✉ info@kandemirrentacar.com</a></li>
                <li><a href="#">📍 İstanbul, Türkiye</a></li>
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
            <ul class="socials">
                <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
            </ul>
        </div>
    </div>
</footer>

    <script src="slider.js"></script>
    <script src="script.js"></script>
</body>
</html>