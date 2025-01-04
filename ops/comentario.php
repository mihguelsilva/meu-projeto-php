<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
if (!isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
    header('Location: /');
}
if (isset($_POST['action'])) {
    
} else {
    header('Location: /');
}
?>
