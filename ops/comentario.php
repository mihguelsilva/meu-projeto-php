<?php
require_once $_SERVER['DOCUMENT_ROOT'] .
    DIRECTORY_SEPARATOR . 'var' .
    DIRECTORY_SEPARATOR . 'global.php';
$COMMENT = new Comentario();
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME'])) {
    header('Location: /');
}
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'comment') {

        if (count($_FILES['fotos-comentario']['name']) > 2) {
            header('Location: /page/anuncio.php?id=' . $_POST['id']);
            exit();
        }

        $COMENTARIO_ID = addslashes($_POST['id']);
        $COMENTARIO_CONTEUDO = addslashes($_POST['ctt']);
        $COMENTARIO_DATA = date('Y-m-d');
        $id_comentario = $COMMENT->cadastrarComentario(
            $COMENTARIO_DATA,
            $COMENTARIO_CONTEUDO,
            $_SESSION['LOGIN'],
            $COMENTARIO_ID
        );
        $dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
            'img' . DIRECTORY_SEPARATOR . 'comment' . DIRECTORY_SEPARATOR .
            $id_comentario;
        $fotosNome = $COMMENT->manipularFotos(
            $_FILES['fotos-comentario'],
            $dir,
            "cadastrar"
        );
        if ($fotosNome == false) {
            header('Location: /page/anuncio.php?id=' . $_POST['id']);
            exit();
        } else {

            $COMMENT->cadastrarFotos(
                array("FK_PHOTOS_COMMENT_ID", "FK_PHOTOS_ANNOUNCEMENT_ID"),
                $fotosNome,
                array($id_comentario, $COMENTARIO_ID)
            );
        }
        header('Location: /page/anuncio.php?id=' . $_POST['id']);
    } 
} else if (isset($_GET['action'])) { 
    if ($_GET['action'] == 'deletar') {
        // ID COMENTARIO = cm
        $DELETAR_ID = addslashes($_GET['id']);
        $fotos = $COMMENT->consultarFotos('FK_PHOTOS_COMMENT_ID', $DELETAR_ID);
        if (count($fotos) > 0) {
            foreach($fotos as $chave => $valor) {
                $DELETAR_FOTOS[$chave] = $valor['URL'];
            }
            $dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
            'img' . DIRECTORY_SEPARATOR . 'comment' . DIRECTORY_SEPARATOR .
            $DELETAR_ID;
            $fotoNome = $COMMENT->manipularFotos(
                $DELETAR_FOTOS, 
                $dir, 
                'deletar'
            );
            $COMMENT->deletarDado(
                'PHOTOS', 
                'FK_PHOTOS_COMMENT_ID', 
                $DELETAR_ID
            );
        }
        $COMMENT->deletarDado(
            'COMMENTS',
            'COMMENTS.ID_COMMENT',
            $DELETAR_ID
        );
        header('Location: /page/anuncio.php?id='.$_GET['an']);
    }
} else {
    header('Location: /');
}
