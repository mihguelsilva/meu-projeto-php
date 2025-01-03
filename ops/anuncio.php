<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_ANNOUNCEMENT;
$ANUNCIO = new Anuncio();
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME'])) {
    header('Location: /');
} else if (isset($_POST['action'])) {
    if ($_POST['action'] == 'criar-anuncio') {
        if (isset($_FILES['fotos'])) {
            $AN_FOTOS = $_FILES['fotos'];
        } else {
            $AN_FOTOS = array();
        }
        $AN_TITULO = addslashes($_POST['titulo']);
        $AN_CATEGORIA = addslashes($_POST['categoria']);
        $AN_DESCRICAO = addslashes($_POST['descricao']);
        $AN_VALOR = addslashes($_POST['valor']);
        $AN_DATA = date('Y-m-d');
        $AN_FICHA = addslashes($_POST['ficha-tecnica']);
        echo count($AN_FOTOS);
        print_r($AN_FOTOS);
        $ANUNCIO->criarAnuncio($AN_FOTOS, $AN_TITULO, $AN_CATEGORIA, $AN_DESCRICAO, $AN_VALOR, $AN_DATA, $AN_FICHA, $_SESSION['LOGIN']);
        header('Location: /page/meus-anuncios.php');
    }
} else if (isset($_GET['action'])) {
    if ($_GET['action'] == 'deletar') {
        if ($_GET['fld'] == 'anuncio') {
            $ANUNCIO->deletarAnuncio($_GET['id'], $_SESSION['LOGIN']);
            header('Location: /page/meus-anuncios.php');
        }
    }
} else {
    header('Location: /');
}
?>
