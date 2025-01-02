<?php
session_start();
if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
    unset($_SESSION['LOGIN']);
    unset($_SESSION['NAME']);
    unset($_SESSION['PHOTO']);
}
header('Location: /');
?>
