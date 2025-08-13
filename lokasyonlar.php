<?php
session_start();

include 'db_connect.php';

$sql = "SELECT lokasyon, fiyat, foto_yolu FROM lokasyonlar";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasyonlar</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/locations.css">
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

<!--Locations-->
<?php
if ($result && $result->num_rows > 0) {
    echo '<h1>Lokasyonlar</h1>';
    echo '<div class="main">';

    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="loc-card">
            <div class="loc-img">
                <img src="<?= htmlspecialchars($row['foto_yolu']) ?>" alt="<?= htmlspecialchars($row['lokasyon']) ?>">
            </div>
            <div class="loc-text"><?= htmlspecialchars($row['lokasyon']) ?></div>
        </div>
        <?php
    }

    echo '</div>';
} else {
    echo "<p>Lokasyon bulunamadı.</p>";
}
?>

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