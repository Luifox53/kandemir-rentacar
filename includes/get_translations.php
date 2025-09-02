<?php
require_once 'session_manager.php';
initSession();

header('Content-Type: application/json');

$translations = loadTranslations(getCurrentLanguage());

// Sadece ihtiyaç duyulan çevirileri gönder
$needed_translations = [
    'odeme_eft',
    'odeme_nakit', 
    'odeme_eft_aciklama',
    'odeme_nakit_aciklama'
];

$result = [];
foreach ($needed_translations as $key) {
    $result[$key] = $translations[$key] ?? $key;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
