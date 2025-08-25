<?php
session_start();

require 'includes/db_connect.php';

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
<title>Rezervasyon Onayı</title>
<link rel="stylesheet" href="assets/css/rez_done.css">
</head>
<body>

<div class="card">
    <h2>Rezervasyonunuz Başarıyla Oluşturuldu!</h2>

    <div class="section">
        <h4>Müşteri Bilgileri</h4>
        <p><strong>İsim:</strong> <?php echo $musteri_isim; ?></p>
        <p><strong>E-posta:</strong> <?php echo $email; ?></p>
        <p><strong>Telefon:</strong> <?php echo $telno; ?></p>
    </div>

    <div class="section">
        <h4>Rezervasyon Detayları</h4>
        <p><strong>Araç ID:</strong> <?php echo $araba_ismi; ?></p>
        <p><strong>Kişi Sayısı:</strong> <?php echo $kisiler; ?></p>
        <p><strong>Fiyat:</strong> <?php echo $fiyat; ?> TL</p>
        <p><strong>Nereden:</strong> Antalya Havalimanı AYT</p>
        <p><strong>Nereye:</strong> <?php echo $nereye; ?></p>
        <p><strong>Uçak Varış:</strong> <?php echo $ucak_inis; ?></p>
        <p><strong>Uçuş No:</strong> <?php echo $ucus_no; ?></p>
        <p><strong>Otel:</strong> <?php echo $otel; ?></p>
        <p><strong>Ödeme şekli: <?php echo $paymentOption; ?> </strong></p>
    </div>

    <div class="section">
        <h4>Yolcular</h4>
        <?php foreach($yolcular as $y){ ?>
            <p><strong>İsim:</strong> <?php echo $y['yolcu_isim']; ?> | <strong>Kimlik:</strong> <?php echo $y['kimlik_no']; ?></p>
        <?php } ?>
    </div>
</div>

</body>
</html>
