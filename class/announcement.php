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
        for($a = 0; $a < count($foto['tmp_name']); $a++) {
            $type = $foto['type'][$a];
            if ($type == 'image/png' || $type == 'image/jpeg' || $type == 'image/jpg') {
                $fotoNome = md5(rand(0,99999).time().'.jpg');
                move_uploaded_file($foto['tmp_name'][$a], $IMG_DIR.DIRECTORY_SEPARATOR.$fotoNome);
                $sql = $pdo->prepare('INSERT INTO PHOTOS (URL, FK_PHOTOS_ANNOUNCEMENT_ID) VALUES (:url, :id_anuncio)');
                $sql->bindValue(':url', $fotoNome);
                $sql->bindValue(':id_anuncio', $id_anuncio);
                $sql->execute();
            }
        }
    }
    public function meusAnuncios($id) {
        global $pdo;
        $sql = $pdo->prepare('SELECT ANNOUNCEMENTS.TITLE, ANNOUNCEMENTS.ANNOUNCEMENT_DATE, ANNOUNCEMENTS.ID_ANNOUNCEMENT,
(SELECT PHOTOS.URL FROM PHOTOS WHERE FK_PHOTOS_ANNOUNCEMENT_ID = ID_ANNOUNCEMENT LIMIT 1) AS PHOTO,
(SELECT CATEGORY.NAME FROM CATEGORY WHERE ID_CATEGORY = FK_ANNOUNCEMENT_CATEGORY_ID) AS CATEGORY
FROM ANNOUNCEMENTS WHERE FK_ANNOUNCEMENT_USER_ID = :id ORDER BY(ID_ANNOUNCEMENT) DESC
	');
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = array();
        }
        return $data;
    }
    public function verAnuncio()
    {
        global $pdo;
    }
    public function verTodosAnuncios()
    {
        global $pdo;
	$sql = $pdo->prepare('SELECT ANNOUNCEMENTS.ID_ANNOUNCEMENT, ANNOUNCEMENTS.TITLE, ANNOUNCEMENTS.QUANTITY, ANNOUNCEMENTS.ANNOUNCEMENT_VALUE,
(SELECT PHOTOS.URL FROM PHOTOS WHERE PHOTOS.FK_PHOTOS_ANNOUNCEMENT_ID = ANNOUNCEMENTS.ID_ANNOUNCEMENT LIMIT 1) AS PHOTO,
(SELECT USER_REGISTER.ID_USER FROM USER_REGISTER WHERE USER_REGISTER.ID_USER = ANNOUNCEMENTS.FK_ANNOUNCEMENT_USER_ID) AS USER_ID,
(SELECT USER_REGISTER.CITY FROM USER_REGISTER WHERE USER_REGISTER.ID_USER = ANNOUNCEMENTS.FK_ANNOUNCEMENT_USER_ID) AS CITY,
(SELECT USER_REGISTER.STATE FROM USER_REGISTER WHERE USER_REGISTER.ID_USER = ANNOUNCEMENTS.FK_ANNOUNCEMENT_USER_ID) AS STATE,
(SELECT CATEGORY.NAME FROM CATEGORY WHERE CATEGORY.ID_CATEGORY = ANNOUNCEMENTS.FK_ANNOUNCEMENT_CATEGORY_ID) AS CATEGORY
 FROM ANNOUNCEMENTS ORDER BY(ANNOUNCEMENTS.ID_ANNOUNCEMENT) DESC');
	$sql->execute();
	if ($sql->rowCount() > 0) {
	    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
	} else {
	    $data = array();
	}
	return $data;
    }
    public function atualizarAnuncio()
    {
        global $pdo;
    }
    public function deletarAnuncio($id_an, $id_user)
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT PHOTOS.URL FROM PHOTOS WHERE FK_PHOTOS_ANNOUNCEMENT_ID = :id');
        $sql->bindValue(':id', $id_an);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $DIR_IMG = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'ads'.DIRECTORY_SEPARATOR.$id_user;
            $fts = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach($fts as $ft) {
                unlink($DIR_IMG.DIRECTORY_SEPARATOR.$ft['URL']);
            }
            $sql = $pdo->prepare('DELETE FROM PHOTOS WHERE FK_PHOTOS_ANNOUNCEMENT_ID = :id');
            $sql->bindValue(':id', $id_an);
            $sql->execute();
        }
        $sql = $pdo->prepare('DELETE FROM ANNOUNCEMENTS WHERE ID_ANNOUNCEMENT = :id');
        $sql->bindValue(':id', $id_an);
        $sql->execute();
    }
}
?>
