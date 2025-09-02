<?php
// Session yönetimi için yardımcı fonksiyonlar

// Çeviri dosyasını yükle
function loadTranslations($lang = 'tr') {
    // Dosya yolunu doğru şekilde belirle
    $base_dir = dirname(__DIR__); // htdocs klasörüne gider
    $lang_file = "{$base_dir}/langs/{$lang}.php";
    
    if (file_exists($lang_file)) {
        return include $lang_file;
    }
    // Varsayılan olarak Türkçe yükle
    $default_file = "{$base_dir}/langs/tr.php";
    if (file_exists($default_file)) {
        return include $default_file;
    }
    
    // Son çare olarak boş array döndür
    return [];
}

// Çeviri fonksiyonu
function translate($key, $lang = null) {
    if ($lang === null) {
        $lang = $_SESSION['language'] ?? 'tr';
    }
    
    static $translations = [];
    
    if (!isset($translations[$lang])) {
        $translations[$lang] = loadTranslations($lang);
    }
    
    return $translations[$lang][$key] ?? $key;
}

// Dil ayarla
function setLanguage($lang) {
    $allowed_languages = ['tr', 'en', 'ru', 'de'];
    if (in_array($lang, $allowed_languages)) {
        $_SESSION['language'] = $lang;
    }
}

// Mevcut dili al
function getCurrentLanguage() {
    return $_SESSION['language'] ?? 'tr';
}

// Session verilerini temizle
function clearReservationSession() {
    $keys = [
        'car_id', 'kisiler', 'nereye', 'fiyat', 'foto_yolu',
        'musteri_isim', 'email', 'telno', 'ucak_inis', 'ucus_no', 'otel'
    ];
    
    foreach ($keys as $key) {
        unset($_SESSION[$key]);
    }
    
    // Yolcu bilgilerini temizle
    for ($i = 1; $i <= 20; $i++) {
        unset($_SESSION["yolcu$i"]);
        unset($_SESSION["passno$i"]);
    }
}

// Session süresini kontrol et (30 dakika)
function checkSessionTimeout() {
    if (isset($_SESSION['last_activity'])) {
        if (time() - $_SESSION['last_activity'] > 1800) { // 30 dakika
            clearReservationSession();
            $_SESSION['session_expired'] = true;
        }
    }
    $_SESSION['last_activity'] = time();
}

// Session başlat ve kontrol et
function initSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    checkSessionTimeout();
}

// Rezervasyon tamamlandığında session'ı temizle
function completeReservation() {
    clearReservationSession();
    $_SESSION['reservation_completed'] = true;
}

// Session verilerini güvenli şekilde al
function getSessionData($key, $default = '') {
    return $_SESSION[$key] ?? $default;
}

// Session verilerini güvenli şekilde kaydet
function setSessionData($key, $value) {
    if (!empty($value)) {
        $_SESSION[$key] = $value;
    }
}
?>
