<?php
class Anuncio {
    public function criarAnuncio($foto, $titulo, $categoria, $descricao, $valor, $data, $ficha, $fk_id_user)
    {
        global $pdo;
        $sql = $pdo->prepare('INSERT INTO ANNOUNCEMENTS (TITLE, DESCRIPTION, PAY_VALUE, DATE_ANNOUNCEMENT, TECHNICAL_SHEET, FK_ANNOUNCEMENT_USER_ID, FK_ANNOUNCEMENT_CATEGORY_ID) VALUES (:titulo, :descricao, :valor, :data, :ficha, :fk_id_user, :fk_id_category)');
        $sql->bindValue(':titulo', $titulo);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':valor', $valor);
        $sql->bindValue(':data', $data);
        $sql->bindValue(':ficha', $ficha);
        $sql->bindValue(':fk_id_user', $fk_id_user);
        $sql->bindValue(':fk_id_category', $categoria);
        $sql->execute();
        $id_anuncio = $pdo->lastInsertId();
        $IMG_DIR = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'ads'.DIRECTORY_SEPARATOR.$fk_id_user;
        if (!is_dir($IMG_DIR)) {
            mkdir($IMG_DIR);
        }
        if (count($foto) > 0) {
            for($a = 0; $a < count($foto['tmp_name']); $a++) {
                $type = $foto['type'][$a];
                if ($type == 'image/png' || $type == 'image/jpg') {
                    $fotoNome = md5(rand(0,99999).time().'.jpg');
                    move_uploaded_file($foto['tmp_name'][$a], $IMG_DIR.DIRECTORY_SEPARATOR.$fotoNome);
                    $sql = $pdo->prepare('INSERT INTO PHOTOS (URL, FK_PHOTOS_ANNOUNCEMENT_ID) VALUES (:url, :id_anuncio)');
                    $sql->bindValue(':url', $fotoNome);
                    $sql->bindValue(':id_anuncio', $id_anuncio);
                    $sql->execute();
                }
            }
        }
    }
    public function verAnuncio()
    {
        global $pdo;
    }
    public function verTodosAnuncios()
    {
        global $pdo;
    }
    public function atualizarAnuncio()
    {
        global $pdo;
    }
}
?>
