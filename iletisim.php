<?php
require 'includes/session_manager.php';
initSession();
require 'includes/email_functions.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adsoyad = $_POST['adsoyad'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $mesaj = $_POST['mesaj'] ?? '';

    // Form verilerini temizle
    $adsoyad = trim($adsoyad);
    $email = trim($email);
    $telefon = trim($telefon);
    $mesaj = trim($mesaj);

    // Basit validasyon
    if (empty($adsoyad) || empty($email) || empty($mesaj)) {
        $error = translate('iletisim_mesaj_hata');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = translate('iletisim_mesaj_hata');
    } else {
        // İletişim formu verilerini hazırla
        $contact_data = [
            'adsoyad' => $adsoyad,
            'email' => $email,
            'telefon' => $telefon,
            'mesaj' => $mesaj
        ];

        // SMTP ile email gönder
        if (sendContactFormEmail($contact_data)) {
            $success = translate('iletisim_mesaj_basarili');
        } else {
            $error = translate('iletisim_mesaj_hata');
        }
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
  <h3><?= translate('iletisim_baslik') ?></h3>
  <p>Her türlü soru, öneri ve rezervasyon talepleriniz için aşağıdaki formu doldurabilirsiniz.</p>
  <?php if (!empty($success)): ?>
    <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
      <strong>✅ <?= $success ?></strong>
    </div>
  <?php endif; ?>
  <?php if (!empty($error)): ?>
    <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
      <strong>⚠️ <?= $error ?></strong>
    </div>
  <?php endif; ?>
  <form method="POST" action="">
    <div class="column">
      <label><?= translate('iletisim_ad') ?></label>
      <input type="text" name="adsoyad" placeholder="<?= translate('iletisim_ad') ?>" required>
    </div>
    <div class="column">
      <label><?= translate('iletisim_email') ?></label>
      <input type="email" name="email" placeholder="<?= translate('iletisim_email') ?>" required>
    </div>
    <div class="column">
      <label><?= translate('iletisim_tel') ?></label>
      <input type="tel" name="telefon" placeholder="05XX XXX XX XX" required>
    </div>
    <div class="column">
      <label><?= translate('iletisim_mesaj') ?></label>
      <textarea name="mesaj" placeholder="<?= translate('iletisim_mesaj') ?>..." rows="5" required></textarea>
    </div>
    <button type="submit" class="submit-button">Gönder</button>
</form>
</section>

<!-- İletişim Bilgileri -->
<aside class="contact-info">
  <h4><?= translate('iletisim_iletisim_bilgileri') ?></h4>
  <p><strong>📞 <?= translate('iletisim_telefon') ?></strong> <a href="tel:+905340172815">+90 (534) 017 28 15</a></p>
  <p><strong>📧 <?= translate('iletisim_email_label') ?></strong> <a href="mailto:antalya.transfer.tr@gmail.com">antalya.transfer.tr@gmail.com</a></p>
  <p><strong>📍 <?= translate('iletisim_adres') ?></strong> <?= translate('footer_istanbul') ?></p>

  <h4><?= translate('iletisim_calisma_saatleri') ?></h4>
  <p><?= translate('iletisim_calisma_saatleri_detay') ?></p>
  <h4><?= translate('iletisim_bizi_takip') ?></h4>
  <p class="social-contact">
    <a href="https://www.instagram.com/antalya_rentakar"><i class="fa-brands fa-instagram"></i></a>  
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
