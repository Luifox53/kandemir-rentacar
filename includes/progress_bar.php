<?php
// Hangi sayfada olduğumuzu alalım
$currentPage = basename($_SERVER['PHP_SELF']); 

// Adımları tanımla
$steps = [
    'arabalar.php'     => 1, // Araç Seçimi
    'rezervasyon.php'  => 2, // Rezervasyon Detayları
    'odeme.php'        => 3, // Ödeme Yöntemi
    'sonuc.php'        => 4  // Sonuçlandır
];

// Şu anki adım
$currentStep = $steps[$currentPage] ?? 0;
?>
<!-- Progress Bar -->
<div class="progress-container">
  <?php
  $stepNames = [
    translate('progress_arac_secimi'), 
    translate('progress_rez_detaylari'), 
    translate('progress_odeme_yontemi'), 
    translate('progress_sonuclandir')
  ];

  foreach ($stepNames as $index => $name):
      $stepNumber = $index + 1;
      $isActive = $stepNumber <= $currentStep;
  ?>
    <div class="item">
      <div class="progress-lines">
        <div class="progress-line left <?= $isActive ? 'active' : '' ?>"></div>
        <div class="waypoint <?= $isActive ? 'active' : '' ?>"></div>
        <div class="progress-line right <?= ($stepNumber < $currentStep) ? 'active' : '' ?>"></div>
      </div>
      <h4 class="stepname"><?= $name ?></h4>
    </div>
  <?php endforeach; ?>
</div>
