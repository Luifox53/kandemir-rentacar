<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adsoyad = $_POST['adsoyad'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $mesaj = $_POST['mesaj'];

    $to = "mcmuhammet54@gmail.com"; // kendi mail adresin
    $subject = "İletişim Formu Mesajı";
    $body = "Ad Soyad: $adsoyad\nE-posta: $email\nTelefon: $telefon\nMesaj: $mesaj";

    if (mail($to, $subject, $body)) {
        $success = "Mesajınız gönderildi!";
    } else {
        $error = "Mesaj gönderilemedi. Lütfen tekrar deneyin.";
    }
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>İletişim - Kandemir Rent a Car</title>
  <link rel="stylesheet" href="assets/css/iletisim.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">
</head>
<body>

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

    <main class="main">
    <!-- İletişim Formu -->
    <section class="forms">
      <h3>Bize Ulaşın</h3>
      <p>Her türlü soru, öneri ve rezervasyon talepleriniz için aşağıdaki formu doldurabilirsiniz.</p>
      <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
      <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
      <form method="POST" action="">
        <div class="column">
          <label>Adınız Soyadınız</label>
          <input type="text" name="adsoyad" placeholder="Adınız Soyadınız" required>
        </div>
        <div class="column">
          <label>E-posta</label>
          <input type="email" name="email" placeholder="E-posta adresiniz" required>
        </div>
        <div class="column">
          <label>Telefon</label>
          <input type="tel" name="telefon" placeholder="05XX XXX XX XX" required>
        </div>
        <div class="column">
          <label>Mesajınız</label>
          <textarea name="mesaj" placeholder="Mesajınızı buraya yazın..." rows="5" required></textarea>
        </div>
        <button type="submit" class="submit-button">Gönder</button>
    </form>
    </section>

    <!-- İletişim Bilgileri -->
    <aside class="contact-info">
      <h4>İletişim Bilgilerimiz</h4>
      <p><strong>📞 Telefon:</strong> <a href="tel:+905XXXXXXXXX">0 (5XX) XXX XX XX</a></p>
      <p><strong>📧 E-posta:</strong> <a href="mailto:info@antalyatransfer.com">info@antaltatransfer.com</a></p>
      <p><strong>📍 Adres:</strong> İstanbul, Türkiye</p>
    
      <h4>Çalışma Saatlerimiz</h4>
      <p>Pazartesi - Cumartesi: 09:00 - 20:00</p>
      <p>Pazar: 10:00 - 18:00</p>

      <h4>Bizi Takip Edin</h4>
      <p class="social-contact">
        <a href="#"><i class="fa-brands fa-instagram"></i></a>  
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
      </p>
    </aside>
    </main>
    <div class="map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12763.163087964125!2d30.696556797662733!3d36.89535328785586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c38ffd76d81ddd%3A0x69d5ac1f1b619739!2sMarkAntalya%20AVM!5e0!3m2!1str!2str!4v1755085815352!5m2!1str!2str" width="1100" height="500" style="border:0; border-radius:9px;" allowfullscreen=""  loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
