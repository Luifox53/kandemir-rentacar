<?php
require_once 'session_manager.php';
initSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lang'])) {
    setLanguage($_POST['lang']);
    echo 'success';
} else {
    echo 'error';
}
?>
