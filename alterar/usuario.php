<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_USER;
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME']) && !isset($_SESSION['PHOTO'])) {
    header('location: /login');
}
$USER = new Usuario();
if ($_FILES['perfil']) {
    $USER->AtualizarUmCampo('USER_REGISTER', 'PHOTO', $_FILES['perfil'], $_SESSION['LOGIN'], 'ID');
    echo '<script>window.location.href = "/page/conta.php"</script>';
}
if (isset($_GET['action'])) {
    if ($action == 'atualizar') {
        if ($_GET['type'] == 'CELL' || $_GET['type'] == 'BUSINESS' || $_GET['type'] == 'HOME') {
            $USER->AtualizarUmCampo('PHONE', $_GET['type'], $_GET['new'], $_SESSION['LOGIN'], 'ID_PHONE');
            echo '<script>window.location.href = "/page/conta.php"</script>';
        }
    } else if ($action == 'deletar') {
        // asdf
    }
}
?>