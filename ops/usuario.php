<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_USER;
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME']) && !isset($_SESSION['PHOTO'])) {
    header('location: /login');
}
$USER = new Usuario();



if (isset($_POST['action'])) {
    if ($_POST['action'] == 'atualizar') {
        if (isset($_POST['fld'])) {
            if ($_POST['fld'] == 'telefone') {
                $ATUALIZAR_CAMPO = addslashes($_POST['type']);
                $ATUALIZAR_CONTEUDO = addslashes($_POST['ctt']);
                $ATUALIZAR_VALOR = addslashes($_POST['id']);
                $USER->atualizarDado('PHONE', $ATUALIZAR_CAMPO, $ATUALIZAR_CONTEUDO, 'ID_PHONE', $ATUALIZAR_VALOR);
            }
        }
        if (isset($_FILES['perfil'])) {
            $dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'img'
                . DIRECTORY_SEPARATOR . 'perfil' . DIRECTORY_SEPARATOR . $_SESSION['LOGIN'];
            $fotos = $USER->manipularFotos($_FILES['perfil'], $dir, 'atualizar');
            $USER->atualizarDado('USER_REGISTER', 'PHOTO', $fotos[0], 'ID_USER', $_SESSION['LOGIN']);
            $_SESSION['PHOTO'] = $fotos[0];
        }
        header('Location: /page/conta.php');
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
    } else if ($_POST['action'] == 'cadastrar') {
        $REG_NOME = addslashes($_POST['nome']);
        $REG_EMAIL = addslashes($_POST['email']);
        $REG_CPF_CNPJ = addslashes($_POST['cpf-cnpj']);
        $REG_CPF_CNPJ = preg_replace('/(\.){0,}(\-){0,}(\/){0,}/i', "", $REG_CPF_CNPJ);
        $REG_GENERO = addslashes($_POST['genero']);
        $REG_USUARIO = addslashes($_POST['usuario']);
        $REG_SENHA = addslashes($_POST['senha']);
        $REG_CEP = addslashes($_POST['cep']);
        $REG_NUMERO = addslashes($_POST['numero']);
        $REG_RUA = addslashes($_POST['rua']);
        $REG_BAIRRO = addslashes($_POST['bairro']);
        $REG_CIDADE = addslashes($_POST['cidade']);
        $REG_ESTADO = addslashes($_POST['estado']);
        function preencher(&$TEL)
        {
            if (count($TEL) == 0) {
                array_push($TEL, NULL, NULL, NULL);
            } else if (count($TEL) == 1) {
                array_push($TEL, NULL, NULL);
            } else if (count($TEL) == 2) {
                array_push($TEL, NULL);
            }
        }
        if (isset($_POST['residencial'])) {
            $REG_RESIDENCIAL = $_POST['residencial'];
        } else {
            $REG_RESIDENCIAL = array();
        }
        if (isset($_POST['comercial'])) {
            $REG_COMERCIAL = $_POST['comercial'];
        } else {
            $REG_COMERCIAL = array();
        }
        if (isset($_POST['celular'])) {
            $REG_CELULAR = $_POST['celular'];
        } else {
            $REG_CELULAR = array();
        }
        preencher($REG_RESIDENCIAL);
        preencher($REG_COMERCIAL);
        preencher($REG_CELULAR);
        $id_usuario = $USER->cadastrar(
            $REG_NOME,
            $REG_EMAIL,
            $REG_CPF_CNPJ,
            $REG_GENERO,
            $REG_USUARIO,
            $REG_SENHA,
            $REG_CEP,
            $REG_NUMERO,
            $REG_RUA,
            $REG_BAIRRO,
            $REG_CIDADE,
            $REG_ESTADO,
            $REG_RESIDENCIAL,
            $REG_COMERCIAL,
            $REG_CELULAR
        );
        if ($id_usuario['status'] == 'erro') {
            echo '<script>window.alert("' . $id_usuario['msg'] . '");</script>';
        } else if ($id_usuario['status'] = 'sucesso') {
            $id_dir = (string) $id_usuario['msg'];
            $dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'perfil' . DIRECTORY_SEPARATOR . $id_dir;
            if (!is_dir($dir)) mkdir($dir);
            $fotos = $USER->manipularFotos($_FILES['foto-perfil'], $dir, 'cadastrar');
            $USER->atualizarDado('USER_REGISTER', 'PHOTO', $fotos[0], 'ID_USER', $id_usuario['msg']);
        }
    }
} else if (isset($_GET['action'])) {
    if ($_GET['action'] == 'deletar') {
        if ($_GET['fld'] == 'telefone') {
            $DEL_CAMPO = addslashes($_GET['type']);
            $DEL_ID = addslashes($_GET['id']);
            $USER->atualizarDado('PHONE', $DEL_CAMPO, NULL, 'ID_PHONE', $DEL_ID);
        } else if ($_GET['fld'] == 'foto') {
            $FOTO = $_SERVER['DOCUMENT_ROOT']
                . DIRECTORY_SEPARATOR . 'img'
                . DIRECTORY_SEPARATOR . 'perfil'
                . DIRECTORY_SEPARATOR . $_SESSION['LOGIN']
                . DIRECTORY_SEPARATOR . $_GET['ctt'];
            unlink($FOTO);
            $_SESSION['PHOTO'] = NULL;
            $USER->atualizarDado('USER_REGISTER', 'PHOTO', NULL, 'ID_USER', $_SESSION['LOGIN']);
        }
        header('Location: /page/conta.php');
    }
} else {
    header('Location: /');
}
