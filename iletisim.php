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

<!-- Header -->
<?php include 'includes/header.php'; ?>


<!-- İletişim Formu -->
<main class="main">
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
  <p><strong>📞 Telefon:</strong> <a href="tel:+905340172815">+90 (534) 017 28 15</a></p>
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
  <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3192.1564159919644!2d30.73781017584124!3d36.862674672229424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzbCsDUxJzQ1LjYiTiAzMMKwNDQnMjUuNCJF!5e0!3m2!1str!2str!4v1755265074425!5m2!1str!2str" style="border:0; border-radius:9px;" allowfullscreen=""  loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>
   
<script src="scripts/script.js"></script>
</body>
</html>
