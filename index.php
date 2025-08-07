<?php
session_start();

// Dil seçildi mi kontrol et
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Varsayılan Türkçe olsun
$lang_code = $_SESSION['lang'] ?? 'tr';
include "lang/$lang_code.php";
?>
<!DOCTYPE html>
<html lang="<?= $lang_code ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $lang["title"] ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">
</head>
<body>
<!-- Header -->
<header>
  <div class="logo"></div>
  <div class="headeryazi"><?= $lang["title"] ?></div>

  <nav>
    <li><a href="#">SSS</a></li>
    <li><a href="#">İletişim</a></li>
    <li><a href="#">Lokasyonlar</a></li>

    <div class="languages">
      <a href="#" id="changelang"><i class="fi fi-<?= $lang_code ?>"></i>&nbsp;Dil</a>
      <div id="dropdown-menu">
        <a href="?lang=tr"><i class="fi fi-tr"></i>&nbsp;Türkçe</a>
        <a href="?lang=en"><i class="fi fi-us"></i>&nbsp;English</a>
        <a href="?lang=ru"><i class="fi fi-ru"></i>&nbsp;Русский</a>
      </div>
    </div>
  </nav>
</header>


<!-- Rezervasyon formu -->
<form action="arabalar.php" method="GET" class="reservation-form">
  <div class="form-group">
    <label for="kisiler"><?= $lang["person_count"] ?></label>
    <select name="kisiler" id="kisiler">
      <?php for ($i = 1; $i <= 10; $i++): ?>
        <option value="<?= $i ?>"><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="nereden"><?= $lang["pickup_location"] ?></label>
    <input type="text" id="nereden" name="nereden" required />
  </div>

  <div class="form-group">
    <label for="nereye"><?= $lang["dropoff_location"] ?></label>
    <input type="text" id="nereye" name="nereye" required />
  </div>

  <button type="submit"><?= $lang["find_car"] ?></button>
</form>



</body>
</html>
