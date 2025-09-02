<?php
require 'includes/session_manager.php';
initSession();

require 'includes/db_connect.php';

// Session süresi dolmuşsa uyarı ver
if (isset($_SESSION['session_expired'])) {
    unset($_SESSION['session_expired']);
    echo "<script>alert('Oturum süresi doldu. Lütfen baştan başlayın.'); window.location.href='index.php';</script>";
    exit;
}

$foto_yolu = '';
// POST verilerini kontrol et ve session'a kaydet
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'] ?? '';
    $kisiler = $_POST["kisiler"] ?? '';
    $nereden = $_POST['nereden'] ?? '';
    $nereye = $_POST['nereye'] ?? '';
    $fiyat = $_POST['fiyat'] ?? '';
    
    // Session'a kaydet
    setSessionData('car_id', $car_id);
    setSessionData('kisiler', $kisiler);
    setSessionData('nereden', $nereden);
    setSessionData('nereye', $nereye);
    setSessionData('fiyat', $fiyat);
    
    // POST sonrası yönlendirme (PRG pattern)
    header("Location: rezervasyon.php");
    exit;
}

// GET isteği - session'dan verileri al
$car_id = getSessionData('car_id');
$kisiler = getSessionData('kisiler');
$nereden = getSessionData('nereden');
$nereye = getSessionData('nereye');
$fiyat = getSessionData('fiyat');

// Form verilerini session'dan al
$musteri_isim = getSessionData('musteri_isim');
$email = getSessionData('email');
$telno = getSessionData('telno');
$ucak_inis = getSessionData('ucak_inis');
$ucus_no = getSessionData('ucus_no');
$otel = getSessionData('otel');

// Yolcu bilgilerini session'dan al
$yolcu_bilgileri = [];
for($i = 1; $i <= intval($kisiler); $i++){
    $yolcu_bilgileri[$i] = [
        'isim' => getSessionData("yolcu$i"),
        'kimlik' => getSessionData("passno$i")
    ];
}

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
    <link rel="stylesheet" href="assets/css/progress-bar.css">
    
    <!-- International Telephone Input -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <style>
       .iti {
            width: 100% !important;
            min-width: 0;
        }
        .iti__country-list {
            z-index: 9999;
            max-height: 200px;
            overflow-y: auto;
        }
        .iti__flag-container {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            padding: 1px;
        }
        .iti__selected-flag {
            z-index: 4;
            position: relative;
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0 8px 0 6px;
            
        }
        .iti input[type="tel"] {
            width: 100% !important;
            box-sizing: border-box;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">
</head>
<body>

<!-- Header -->
<?php include 'includes/header.php'; ?>

<!--Progress Bar-->
<?php include 'includes/progress_bar.php'; ?>

<!--Forms-->
<div class="main">
  <div class="Bbutton-box" style="margin-right: auto; margin-left: 30px;">
    <a href="arabalar.php" class="back-button">
        <i class="fas fa-arrow-left"></i>
        <?= translate('btn_geri_don') ?>
    </a>
  </div>
  <div class="forms">
    <!--Personel-->
    <form id="reservation" action="odeme.php" method="POST">
      <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_id) ?>">
      <input type="hidden" name="kisiler" value="<?= htmlspecialchars($kisiler) ?>">
      <input type="hidden" name="nereye" value="<?= htmlspecialchars($nereye) ?>">
      <input type="hidden" name="fiyat" value="<?= htmlspecialchars($fiyat) ?>">
      <input type="hidden" name="foto_yolu" value="<?= htmlspecialchars($foto_yolu) ?>">
      <h3><?= translate('sayfa_kisisel_bilgiler') ?></h3>
      <div class="personelForms">
        <div class="column">
          <label for="musteri_isim"><?= translate('iletisim_ad') ?> <br></label>
          <input id="musteri_isim" type="text" name="musteri_isim" placeholder="<?= translate('iletisim_ad') ?>" value="<?= htmlspecialchars($musteri_isim) ?>" required>
        </div>
        <div class="column">
          <label for="email"><?= translate('iletisim_email') ?> <br></label>
          <input id="email" type="email" name="email" placeholder="<?= translate('iletisim_email') ?>" value="<?= htmlspecialchars($email) ?>" required>
        </div>  
        <div class="column">
          <label for="telno"><?= translate('iletisim_tel') ?> <br></label>
          <input id="telno" type="tel" name="telno" placeholder="<?= translate('iletisim_tel') ?>"  value="<?= htmlspecialchars($telno) ?>" required>
        </div>
      </div>
      <!--About Arrive-->
          <h3><?= translate('sayfa_varis_bilgileri') ?></h3>
          <div class="About-Arrive">
            <div class="column">
              <label for="ucak_inis"><?= translate('sayfa_ucak_inis') ?> <br></label>
              <input id="ucak_inis" type="datetime-local" name="ucak_inis" value="<?= htmlspecialchars($ucak_inis) ?>" required>
            </div>
            <div class="column">
             <label for="ucus_no"><?= translate('sayfa_ucus_numarası') ?> <br></label>
             <input id="ucus_no" type="text" name="ucus_no" value="<?= htmlspecialchars($ucus_no) ?>">
            </div>
            <div class="column">
              <label for="otel"><?= translate('sayfa_otel_adi') ?> <br></label>
             <input id="otel" type="text" placeholder="<?= translate('placeholder_otel_adi') ?>" name="otel" value="<?= htmlspecialchars($otel) ?>">
            </div>
          </div>  
      <!--Passengers-->
      <?php for($i = 1;$i<=$kisiler;$i++){?>

      <h4><?= translate('sayfa_yolcu') ?> <?php echo "$i";?></h4>
      <div class="passengerİnfo">
        <div class="column"> 
          <label><?= translate('sayfa_ad_soyad') ?> <br></label>
          <input type="text" name="yolcu<?php echo "$i";?>" placeholder="<?= translate('placeholder_ad_soyad') ?>" value="<?= htmlspecialchars($yolcu_bilgileri[$i]['isim']) ?>" required>
        </div>
        <div class="column"> 
          <label><?= translate('sayfa_kimlik_pasaport') ?> <br></label>
          <input type="number" name="passno<?php echo "$i";?>" value="<?= htmlspecialchars($yolcu_bilgileri[$i]['kimlik']) ?>" required>
        </div>
      </div>
      <?php }?>
    </form>
  </div>
<!--Transport İnfos-->

  <div class="transport-info">
    <div class="car-img" style="background-image: url('<?= htmlspecialchars($foto_yolu) ?>');"></div>
    <h3><?= translate('anasayfa_nereden') ?></h3>
    <p><?php echo "{$nereden}"; ?></p>
    <h3><?= translate('anasayfa_nereye') ?></h3>
    <p><?php echo "{$nereye}"; ?></p>
    <h3><?= translate('anasayfa_kisi_sayisi') ?></h3>
    <p><?php echo "{$kisiler} " . translate('kisi_birimi'); ?></p>
    <div class="price-box">
      <h4 class="price"><?php echo "{$fiyat} €"; ?></h4>
    </div>
    <button class="submit-button" type="submit" form="reservation"><?= translate('btn_rezervasyon_yap') ?></button>
  </div>

</div>


<!--Footer-->
<?php include 'includes/footer.php'; ?>

<!-- International Telephone Input JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector('#telno');
    
    const iti = window.intlTelInput(phoneInput, {
        // Tercih edilen ülkeler (Türkiye, Almanya, Rusya, İngiltere)
        preferredCountries: ['tr', 'de', 'ru', 'gb'],
        
        // Başlangıç ülkesi (Türkiye)
        initialCountry: 'tr',
        
        // Placeholder göster
        autoPlaceholder: 'off',
        
        // Sadece ülke kodları
        separateDialCode: true,
        
        // Ülke arama özelliği
        searchCountries: true,
        
        // Geçerli ülkeler (müşteri kitlen göre)
        onlyCountries: ['tr', 'de', 'ru', 'gb', 'us', 'fr', 'es', 'it', 'nl', 'be', 'ch', 'at', 'se', 'no', 'dk', 'fi'],
        
        // Utility script (otomatik format)
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
    });
    
    // Form gönderildiğinde tam numarayı al
    const form = document.getElementById('reservation');
    if (form) {
        form.addEventListener('submit', function() {
            const fullNumber = iti.getNumber();
            phoneInput.value = fullNumber;
        });
    }
    
    // Gerçek zamanlı validasyon
    phoneInput.addEventListener('input', function() {
        if (iti.isValidNumber()) {
            phoneInput.style.border = '2px solid #28a745';
        } else {
            phoneInput.style.border = '2px solid #dc3545';
        }
    });
});
</script>

<script src="scripts/script.js"></script>

</body>
</html>