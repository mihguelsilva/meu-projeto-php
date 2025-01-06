<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_ANNOUNCEMENT;
$ANUNCIO = new Anuncio();
function fotos($foto, $dir, $id)
{
    global $ANUNCIO;
    $fotos = $ANUNCIO->manipularFotos(
        $foto,
        $dir,
        'cadastrar'
    );
    if ($fotos != false) {
        $ANUNCIO->cadastrarFotos(
            'FK_PHOTOS_ANNOUNCEMENT_ID',
            $fotos,
            $id
        );
    }
}
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME'])) {
    header('Location: /');
} else if (isset($_POST['action'])) {
    if ($_POST['action'] == 'criar-anuncio') {
        $AN_TITULO = addslashes($_POST['titulo']);
        $AN_CATEGORIA = addslashes($_POST['categoria']);
        $AN_ESTADO = addslashes($_POST['estado']);
        $AN_QUANTIDADE = addslashes($_POST['quantidade']);
        $AN_DESCRICAO = addslashes($_POST['descricao']);
        $AN_VALOR = addslashes($_POST['valor']);
        $AN_DATA = date('Y-m-d');
        $AN_FICHA = addslashes($_POST['ficha-tecnica']);
        $id_anuncio = $ANUNCIO->criarAnuncio(
            $AN_TITULO,
            $AN_CATEGORIA,
            $AN_ESTADO,
            $AN_QUANTIDADE,
            $AN_DESCRICAO,
            $AN_VALOR,
            $AN_DATA,
            $AN_FICHA,
            $_SESSION['LOGIN']
        );
        if ($_FILES['fotos']['name'] <= 2) {
            $fotos = $ANUNCIO->manipularFotos(
                $_FILES['fotos'], 
                DIR_ADS.$id_anuncio, 
                'cadastrar'
            );
            if ($fotos != false) {
                $ANUNCIO->cadastrarFotos(
                    'FK_PHOTOS_ANNOUNCEMENT_ID', 
                    $fotos, 
                    $id_anuncio
                );
            }
        }
        header('Location: /page/meus-anuncios.php');
    } else if ($_POST['action'] == 'editar-anuncio') {
        echo '<pre>' . print_r($_POST) . '</pre>';
        $ATUALIZAR_TITULO = addslashes($_POST['titulo']);
        $ATUALIZAR_CATEGORIA = addslashes($_POST['categoria']);
        $ATUALIZAR_ESTADO = addslashes($_POST['estado']);
        $ATUALIZAR_QUANTIDADE = addslashes($_POST['quantidade']);
        $ATUALIZAR_DESCRICAO = addslashes($_POST['descricao']);
        $ATUALIZAR_VALOR = addslashes($_POST['valor']);
        $ATUALIZAR_FICHA = addslashes($_POST['ficha-tecnica']);
        $ATUALIZAR_ID = addslashes($_POST['id']);
        $ANUNCIO->atualizarAnuncio(
            $ATUALIZAR_TITULO,
            $ATUALIZAR_CATEGORIA,
            $ATUALIZAR_ESTADO,
            $ATUALIZAR_QUANTIDADE,
            $ATUALIZAR_DESCRICAO,
            $ATUALIZAR_VALOR,
            $ATUALIZAR_FICHA,
            $ATUALIZAR_ID
        );
        if (isset($_POST['count'])) {
            if ((count($_POST['count']) + count($_FILES['fotos']['name'])) <= 2) {
                fotos(
                    $_FILES['fotos'],
                    DIR_ADS . $ATUALIZAR_ID,
                    $ATUALIZAR_ID
                );
            }
        } else {
            if (count($_FILES['fotos']['name']) <= 2) {
                fotos(
                    $_FILES['fotos'],
                    DIR_ADS . $ATUALIZAR_ID,
                    $ATUALIZAR_ID
                );
            }
        }
        header('Location: /page/meus-anuncios.php');
    }
} else if (isset($_GET['action'])) {
    if ($_GET['action'] == 'deletar') {
        if ($_GET['fld'] == 'anuncio') {
            $fotos = $ANUNCIO->consultarFotos(
                'FK_PHOTOS_ANNOUNCEMENT_ID',
                $_GET['id']
            );
            if (count($fotos) > 0) {
                $dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'img'
                    . DIRECTORY_SEPARATOR . 'ads' . DIRECTORY_SEPARATOR . $_GET['id'];
                foreach ($fotos as $chave => $valor) {
                    $DELETAR_FOTOS[$chave] = $valor['URL'];
                }
                $ANUNCIO->manipularFotos(
                    $DELETAR_FOTOS,
                    $dir,
                    'deletar'
                );
                rmdir($dir);
                $ANUNCIO->deletarDado(
                    'PHOTOS',
                    'FK_PHOTOS_ANNOUNCEMENT_ID',
                    $_GET['id']
                );
            }
            $ANUNCIO->deletarDado(
                'ANNOUNCEMENTS',
                'ID_ANNOUNCEMENT',
                $_GET['id']
            );
            header('Location:/page/meus-anuncios.php');
        } else if ($_GET['fld'] == 'foto') {
            echo '<pre>' . $_GET . '</pre>';
        }
    }
} else {
    header('Location: /');
}
