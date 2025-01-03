<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_USER;
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME']) && !isset($_SESSION['PHOTO'])) {
    header('location: /login');
}
$USER = new Usuario();
if (isset($_FILES['perfil'])) {
    $USER->atualizarUmCampo('USER_REGISTER', 'PHOTO', $_FILES['perfil'], $_SESSION['LOGIN'], 'ID');
    echo '<script>window.location.href = "/page/conta.php"</script>';
} else if (isset($_POST['action'])) {
    if ($_POST['action'] == 'atualizar') {
        if ($_POST['fld'] == 'telefone') {
            $USER->atualizarUmCampo('PHONE', $_POST['type'], $_POST['ctt'], $_POST['id'], 'ID_PHONE');
            echo '<script>window.location.href = "/page/conta.php"</script>';
        }
    } else if ($_POST['action'] == 'deletar') {
        if ($_POST['fld'] == 'foto') {
            $FOTO = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'perfil'.DIRECTORY_SEPARATOR.$_SESSION['LOGIN'].DIRECTORY_SEPARATOR.$_POST['ctt'];
            unlink($FOTO);
            $_SESSION['PHOTO'] = NULL;
            $USER->atualizarUmCampo('USER_REGISTER', 'PHOTO', NULL, $_SESSION['LOGIN'], 'ID');
            echo '<script>window.location.href = "/page/conta.php"</script>';
        }
    } else if ($_POST['action'] == 'acesso') {
        $USUARIO = addslashes($_POST['usuario']);
        $SENHA = addslashes($_POST['senha']);
        $USER->atualizarAcesso($USUARIO, $SENHA, $_SESSION['LOGIN']);
        header('Location:/page/conta.php');
    } else if ($_POST['action'] == 'pessoais') {
        $NOME = addslashes($_POST['nome']);
        $EMAIL = addslashes($_POST['email']);
        $CPF_CNPJ = addslashes($_POST['cpf-cnpj']);
        $CPF_CNPJ = preg_replace('/(\.){0,}(\-){0,}(\/){0,}/i', "", $CPF_CNPJ);
        $GENERO = addslashes($_POST['genero']);
        $USER->atualizarPessoais($NOME, $EMAIL, $CPF_CNPJ, $GENERO, $_SESSION['LOGIN']);
        header('Location: /page/conta.php');
    } else if ($_POST['action'] == 'endereco') {
        $CEP = addslashes($_POST['cep']);
        $NUMERO = addslashes($_POST['numero']);
        $RUA = addslashes($_POST['rua']);
        $BAIRRO = addslashes($_POST['bairro']);
        $CIDADE = addslashes($_POST['cidade']);
        $ESTADO = addslashes($_POST['estado']);
        $USER->atualizarEndereco($CEP, $NUMERO, $RUA, $BAIRRO, $CIDADE, $ESTADO, $_SESSION['LOGIN']);
        header('Location: /page/conta.php');
    }
} else if (isset($_GET['action'])) {
    if ($_GET['fld'] == 'telefone') {
        $USER->atualizarUmCampo('PHONE', $_GET['type'], NULL, $_GET['id'], 'ID_PHONE');
    } else if ($_GET['fld'] == 'foto') {
        $FOTO = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'perfil'.DIRECTORY_SEPARATOR.$_SESSION['LOGIN'].DIRECTORY_SEPARATOR.$_GET['ctt'];
        unlink($FOTO);
        $_SESSION['PHOTO'] = NULL;
        $USER->atualizarUmCampo('USER_REGISTER', 'PHOTO', NULL, $_SESSION['LOGIN'], 'ID');
    }
    echo '<script>window.location.href = "/page/conta.php"</script>';
}else {
    header('Location: /');
}
?>
