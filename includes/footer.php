<?php
require_once __DIR__ . '/session_manager.php';
if (session_status() == PHP_SESSION_NONE) {
    initSession();
}
?>
<!--Footer-->
<footer>
    <div class="footer-container">
        <div class="footer-column">
            <h3><?= translate('footer_iletisim') ?></h3>
            <ul>
                <li><a href="#">📞 +90 534 017 28 15</a></li>
                <li><a href="#">📮 antalya.transfer.tr@gmail.com</a></li>
                <li><a href="#">📍 <?= translate('footer_istanbul') ?></a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3><?= translate('footer_kurumsal') ?></h3>
            <ul>
                <li><a href="hakkimizda.php"><?= translate('footer_hakkimizda') ?></a></li>
                <li><a href="kanun.php"><?= translate('footer_gizlilik_politikasi') ?></a></li>
                <li><a href="iletisim.php"><?= translate('footer_iletisim') ?></a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3><?= translate('footer_bizi_takip') ?></h3>
            <ul class="socials">
                <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                <li><a href="#"><i class="fab fa-youtube"></i> Youtube</a></li>
                <li><a href="https://www.instagram.com/antalya_rentakar/"><i class="fab fa-instagram"></i> Instagram</a></li>
            </ul>
        </div>
    </div>
</footer>