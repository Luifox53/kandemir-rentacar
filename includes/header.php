<?php
require_once __DIR__ . '/session_manager.php';
if (session_status() == PHP_SESSION_NONE) {
    initSession();
}
$current_lang = getCurrentLanguage();
?>

<!--WhatsApp button-->
<a href="https://wa.me/905323746253" target="_blank" id="whatsapp-float"><i class="fab fa-whatsapp"></i></a>

<!--Header-->
<header>
    <a href="index.php"><div class="logo"></div></a>
    <h1 class="headertext"><a href="index.php"><?= translate('header_antalya_transfer') ?></a></h1>
    <nav>
      <a class="link" href="sss.php"><?= translate('header_sss') ?></a>
      <a class="link" href="lokasyonlar.php"><?= translate('header_lokasyonlar') ?></a>
      <a class="link" href="iletisim.php"><?= translate('header_iletisim') ?></a>
      <div id="dropdown-toggle">
        <?php
        $lang_icons = ['tr' => 'fi-tr', 'en' => 'fi-gb', 'ru' => 'fi-ru', 'de' => 'fi-de'];
        $lang_names = ['tr' => 'Türkçe', 'en' => 'English', 'ru' => 'Русский', 'de' => 'Deutsch'];
        ?>
        <i class="fi <?= $lang_icons[$current_lang] ?>"></i> <?= $lang_names[$current_lang] ?>
        <div id="dropdown-menu">
          <?php foreach ($lang_names as $code => $name): ?>
            <?php if ($code !== $current_lang): ?>
              <a href="#" data-lang="<?= $code ?>"><i class="fi <?= $lang_icons[$code] ?>"></i><?= $name ?></a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>

    </nav>
</header>

<script src="scripts/language.js"></script>