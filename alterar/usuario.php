<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_USER;
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME']) && !isset($_SESSION['PHOTO'])) {
    header('location: /login');
}
$USER = new Usuario();
if (isset($_FILES['perfil'])) {
    $USER->AtualizarUmCampo('USER_REGISTER', 'PHOTO', $_FILES['perfil'], $_SESSION['LOGIN'], 'ID');
    echo '<script>window.location.href = "/page/conta.php"</script>';
} else if (isset($_GET['action'])) {
    if ($_GET['action'] == 'atualizar') {
        if ($_GET['fld'] == 'telefone') {
            $USER->AtualizarUmCampo('PHONE', $_GET['type'], $_GET['ctt'], $_GET['id'], 'ID_PHONE');
            echo '<script>window.location.href = "/page/conta.php"</script>';
        }
    } else if ($_GET['action'] == 'deletar') {
        if ($_GET['fld'] == 'foto') {
            $FOTO = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'perfil'.DIRECTORY_SEPARATOR.$_SESSION['LOGIN'].DIRECTORY_SEPARATOR.$_GET['ctt'];
            unlink($FOTO);
            $_SESSION['PHOTO'] = NULL;
            $USER->AtualizarUmCampo('USER_REGISTER', 'PHOTO', NULL, $_SESSION['LOGIN'], 'ID');
            echo '<script>window.location.href = "/page/conta.php"</script>';
        } else if ($_GET['fld'] == 'telefone') {
            $USER->AtualizarUmCampo('PHONE', $_GET['type'], NULL, $_GET['id'], 'ID_PHONE');
            echo '<script>window.location.href = "/page/conta.php"</script>';
        }
    }
} else {
    header('Location: /');
}
?>
