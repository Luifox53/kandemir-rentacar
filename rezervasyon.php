<?php
session_start();

include 'db_connect.php';

$foto_yolu = '';
$car_id = $_GET['car_id'] ?? '';
$kisiler = $_GET["kisiler"] ?? "";
$nereye = $_GET['nereye'] ?? '';
$fiyat = $_GET['fiyat'] ?? '';


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

<!--Forms-->
<div class="main">
  <div class="forms">
    <!--Personel-->
    <form id="reservation" action="">
      <h3>Kişisel Bilgiler</h3>
      <div class="personelForms">
        <div class="column">
          <label>İsim <br></label>
          <input type="text" placeholder="Ad Soyad">
        </div>
        <div class="column">
          <label>E-posta <br></label>
          <input type="email" placeholder="E-Posta">
        </div>  
        <div class="column">
          <label>Tel-No <br></label>
          <input type="tel" placeholder="Tel-No">
        </div>
      </div>
      <!--About Arrive-->
          <h3>Varış Bilgileri</h3>
          <div class="About-Arrive">
            <div class="column">
              <label>Uçak iniş Tarih/Saat <br></label>
              <input type="datetime">
            </div>
            <div class="column">
             <label>Uçuş Numarası <br></label>
             <input type="text">
            </div>
            <div class="column">
              <label>Otel Adı <br></label>
             <input type="text">
            </div>
          </div>  
      <!--Passengers-->
      <?php for($i = 1;$i<=$kisiler;$i++){?>

      <h4>Yolcu <?php echo "$i";?></h4>
      <div class="passengerİnfo">
        <div class="column"> 
          <label>Ad Soyad <br></label>
          <input type="text">
        </div>
        <div class="column"> 
          <label>Kimlik/Pasaport No <br></label>
          <input type="number">
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
    <h3>Toplam Fiyat</h3>
    <p><?php echo "{$fiyat} €"; ?></p>
    <button class="submit-button" type="submit" form="reservation">Rezervasyon Yap</button>
  </div>

</div>


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


<script src="script.js"></script>
</body>
</html>