<?php
require 'includes/session_manager.php';
initSession();

require 'includes/db_connect.php';

// Rezervasyon tamamlandı - session'ı temizle
completeReservation();

$car_id = $_POST['car_id'] ?? '';
$kisiler = $_POST["kisiler"] ?? "";
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

$sql = "SELECT isim FROM arabalar WHERE id = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $araba_ismi = $row['isim'];
}


?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyon Tamamlandı</title>
    <link rel="stylesheet" href="assets/css/rezdone.css">
</head>
<body>

<div class="card">
    <h1>Rezervasyon Tamamlandı</h1>

    <div class="top-infos">
        <div class="customer-info">
            <h3>Müşteri Bilgileri</h3>
            <p>İsim: <?php echo $musteri_isim; ?></p>
            <p>E-Posta: <?php echo $email; ?></p>
            <p>Telefon: <?php echo $telno; ?></p>
        </div>
        <div class="reservation-info">
            <h3>Rezervasyon Detayları</h3>
            <div class="flex">
                <div class="left-infos">
                    <p>Araç: <?php echo $araba_ismi; ?></p>
                    <p>Kişi Sayısı: <?php echo $kisiler; ?></p>
                    <p>Fiyat: <?php echo $fiyat; ?> TL</p>
                    <p>Nereden: Antalya Havalimanı AYT</p>
                    <p>Nereye: <?php echo $nereye; ?></p>
                </div>
                <div class="right-infos">
                    <p>Uçak Varış: <?php echo $ucak_inis; ?></p>
                    <p>Uçuş No: <?php echo $ucus_no; ?></p>
                    <p>Otel: <?php echo $otel; ?></p>
                    <p>Ödeme Şekli: <?php echo $paymentOption; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="passengers">
        <h3>Yolcular</h3>
        <div class="passengers-box">
            <?php foreach($yolcular as $index => $y){ ?>
            <div class="passenger-card">
                <div class="passenger-number">Yolcu <?php echo ($index + 1); ?></div>
                <div class="passenger-infos">
                    <p>İsim: <?php echo $y['yolcu_isim']; ?></p>
                    <p>Kimlik: <?php echo $y['kimlik_no']; ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>  
</div>

</body>
</html>
