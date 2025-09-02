<?php
require 'includes/session_manager.php';
initSession();

require 'includes/db_connect.php';
require 'includes/email_functions.php';

// reCAPTCHA doğrulaması
$recaptcha_secret = "6LdJKbgrAAAAAPyzg3c8kB6Zr5Cxb_N_67HssKWa"; // Buraya secret key'inizi yazın
$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptcha_response)) {
    die("<script>alert('Güvenlik doğrulaması gerekli! Lütfen captcha'yı tamamlayın.'); window.history.back();</script>");
}

// Google'a captcha doğrulama isteği gönder
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_data = [
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$recaptcha_options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($recaptcha_data)
    ]
];

$recaptcha_context = stream_context_create($recaptcha_options);
$recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
$recaptcha_json = json_decode($recaptcha_result, true);

if (!$recaptcha_json['success']) {
    die("<script>alert('Güvenlik doğrulaması başarısız! Lütfen tekrar deneyin.'); window.history.back();</script>");
}

// Rezervasyon tamamlandı - session'ı temizle
completeReservation();

$car_id = $_POST['car_id'] ?? '';
$kisiler = $_POST["kisiler"] ?? "";
$nereden = $_POST['nereden'] ?? '';
$nereye = $_POST['nereye'] ?? '';
$fiyat = $_POST['fiyat'] ?? '';
$musteri_isim = $_POST['musteri_isim'] ?? '';
$email = $_POST['email'] ?? '';
$telno = $_POST['telno'] ?? '';
$ucak_inis = $_POST['ucak_inis'] ?? '';
$ucus_no = $_POST['ucus_no'] ?? '';
$otel = $_POST['otel'] ?? '';
$paymentOption = $_POST['pay-option'] ?? '';
$yolcular = [];
$kisilerint = intval($_POST['kisiler']);

for($i=0; $i<$kisilerint; $i++){
    $yolcular[] = [
        'yolcu_isim' => $_POST["yolcu$i"] ?? '',
        'kimlik_no' => $_POST["passno$i"] ?? ''
    ];
}

$sql = "SELECT isim FROM arabalar WHERE id = $car_id";
$result = $conn->query($sql);

$araba_ismi = 'Bilinmeyen Araç';
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $araba_ismi = $row['isim'];
}

// E-posta gönderimi için rezervasyon bilgilerini hazırla
$rezervasyon_bilgileri = [
    'car_id' => $car_id,
    'kisiler' => $kisiler,
    'nereden' => $nereden,
    'nereye' => $nereye,
    'fiyat' => $fiyat,
    'musteri_isim' => $musteri_isim,
    'email' => $email,
    'telno' => $telno,
    'ucak_inis' => $ucak_inis,
    'ucus_no' => $ucus_no,
    'otel' => $otel,
    'paymentOption' => $paymentOption,
    'araba_ismi' => $araba_ismi,
    'yolcular' => $yolcular
];

// E-posta gönderme durumu
$email_success = false;
$admin_email_success = false;

// Session'da e-posta gönderim kontrolü
$email_sent_key = 'email_sent_' . md5($email . $musteri_isim . $fiyat);

// Müşteriye e-posta gönder (sadece bir kez)
if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !isset($_SESSION[$email_sent_key])) {
    $email_success = sendReservationEmail($rezervasyon_bilgileri);
    
    // Admin'e bildirim gönder
    $admin_email_success = sendAdminNotificationEmail($rezervasyon_bilgileri);
    
    // E-posta gönderildi olarak işaretle
    $_SESSION[$email_sent_key] = true;
} elseif (isset($_SESSION[$email_sent_key])) {
    // Zaten gönderilmiş
    $email_success = true;
    $admin_email_success = true;
}


?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= translate('rez_tamam_sayfa_baslik') ?></title>
    <link rel="stylesheet" href="assets/css/rezdone.css">
</head>
<body>

<div class="card">
    <h1><?= translate('rez_tamam_baslik') ?></h1>
    
    <?php if ($email_success): ?>
        <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <strong>✅ <?= translate('rez_tamam_email_basarili') ?></strong><br>
            <?= str_replace('{email}', '<strong>' . htmlspecialchars($email) . '</strong>', translate('rez_tamam_email_mesaj')) ?>
        </div>
    <?php elseif (!empty($email)): ?>
        <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <strong>⚠️ <?= translate('rez_tamam_email_hata') ?></strong><br>
            <?= translate('rez_tamam_email_hata_mesaj') ?>
        </div>
    <?php endif; ?>

    <div class="top-infos">
        <div class="customer-info">
            <h3><?= translate('rez_tamam_musteri_bilgileri') ?></h3>
            <p><?= translate('rez_tamam_isim') ?>: <?php echo $musteri_isim; ?></p>
            <p><?= translate('rez_tamam_eposta') ?>: <?php echo $email; ?></p>
            <p><?= translate('rez_tamam_telefon') ?>: <?php echo $telno; ?></p>
        </div>
        <div class="reservation-info">
            <h3><?= translate('rez_tamam_rezervasyon_detaylari') ?></h3>
            <div class="flex">
                <div class="left-infos">
                    <p><?= translate('rez_tamam_arac') ?>: <?php echo $araba_ismi; ?></p>
                    <p><?= translate('rez_tamam_kisi_sayisi') ?>: <?php echo $kisiler; ?></p>
                    <p><?= translate('rez_tamam_fiyat') ?>: <?php echo $fiyat; ?> TL</p>
                    <p><?= translate('rez_tamam_nereden') ?>: <?php echo $nereden; ?></p>
                    <p><?= translate('rez_tamam_nereye') ?>: <?php echo $nereye; ?></p>
                </div>
                <div class="right-infos">
                    <p><?= translate('rez_tamam_ucak_varis') ?>: <?php echo $ucak_inis; ?></p>
                    <p><?= translate('rez_tamam_ucus_no') ?>: <?php echo $ucus_no; ?></p>
                    <p><?= translate('rez_tamam_otel') ?>: <?php echo $otel; ?></p>
                    <p><?= translate('rez_tamam_odeme_sekli') ?>: <?php echo $paymentOption; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="passengers">
        <h3><?= translate('rez_tamam_yolcular') ?></h3>
        <div class="passengers-box">
            <?php foreach($yolcular as $index => $y){ ?>
            <div class="passenger-card">
                <div class="passenger-number"><?= translate('rez_tamam_yolcu_no') ?> <?php echo ($index + 1); ?></div>
                <div class="passenger-infos">
                    <p><?= translate('rez_tamam_isim') ?>: <?php echo $y['yolcu_isim']; ?></p>
                    <p><?= translate('rez_tamam_kimlik') ?>: <?php echo $y['kimlik_no']; ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>  
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="index.php" style="background: #007bff; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;">
            🏠 <?= translate('btn_ana_sayfa') ?>
        </a>
    </div>
</div>

</body>
</html>
