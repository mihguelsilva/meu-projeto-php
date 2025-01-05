<?php
require_once $_SERVER['DOCUMENT_ROOT']
    . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR
    . 'global.php';
class Anuncio extends Operacao
{
    public function criarAnuncio(
        $titulo, 
        $categoria, 
        $estado, 
        $quantidade, 
        $descricao, 
        $valor, 
        $data, 
        $ficha, 
        $fk_id_user)
    {
        global $pdo;
        $sql = $pdo->prepare('INSERT INTO ANNOUNCEMENTS (TITLE, DESCRIPTION, STATUS, QUANTITY, ANNOUNCEMENT_VALUE, ANNOUNCEMENT_DATE , TECHNICAL_SHEET, FK_ANNOUNCEMENT_USER_ID, FK_ANNOUNCEMENT_CATEGORY_ID) VALUES (:titulo, :descricao, :estado, :quantidade, :valor, :data, :ficha, :fk_id_user, :fk_id_category)');
        $sql->bindValue(':titulo', $titulo);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':estado', $estado);
        $sql->bindValue(':quantidade', $quantidade);
        $sql->bindValue(':valor', $valor);
        $sql->bindValue(':data', $data);
        $sql->bindValue(':ficha', $ficha);
        $sql->bindValue(':fk_id_user', $fk_id_user);
        $sql->bindValue(':fk_id_category', $categoria);
        $sql->execute();
        $id_anuncio = $pdo->lastInsertId();
        return $id_anuncio;
    }
    public function meusAnuncios($id)
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT ANNOUNCEMENTS.TITLE, ANNOUNCEMENTS.QUANTITY, 
        ANNOUNCEMENTS.ANNOUNCEMENT_VALUE, ANNOUNCEMENTS.ANNOUNCEMENT_DATE, 
        ANNOUNCEMENTS.ID_ANNOUNCEMENT, CATEGORY.NAME AS CATEGORY, 
        (SELECT PHOTOS.URL FROM PHOTOS WHERE FK_PHOTOS_ANNOUNCEMENT_ID = 
        ID_ANNOUNCEMENT LIMIT 1) AS PHOTO FROM ANNOUNCEMENTS INNER JOIN CATEGORY ON 
        ANNOUNCEMENTS.FK_ANNOUNCEMENT_CATEGORY_ID = CATEGORY.ID_CATEGORY 
        ORDER BY(ID_ANNOUNCEMENT) DESC; ');
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = array();
        }
        return $data;
    }
    public function verAnuncio($id)
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT ANNOUNCEMENTS.TITLE, 
        ANNOUNCEMENTS.STATUS, ANNOUNCEMENTS.DESCRIPTION, 
        ANNOUNCEMENTS.QUANTITY, ANNOUNCEMENTS.ANNOUNCEMENT_VALUE,
        ANNOUNCEMENTS.ANNOUNCEMENT_DATE, ANNOUNCEMENTS.TECHNICAL_SHEET, 
        USER_REGISTER.NAME, USER_REGISTER.EMAIL, USER_REGISTER.ID_USER FROM 
        ANNOUNCEMENTS INNER JOIN USER_REGISTER ON
        ANNOUNCEMENTS.FK_ANNOUNCEMENT_USER_ID = USER_REGISTER.ID_USER WHERE
        ANNOUNCEMENTS.ID_ANNOUNCEMENT = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $sql = $pdo->prepare('SELECT PHONE.HOME, PHONE.BUSINESS, PHONE.CELL
            FROM PHONE WHERE PHONE.FK_PHONE_USER_ID = :id');
            $sql->bindValue(':id', $data['ID_USER']);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $data['PHONE'] = $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $data['PHONE'] = array();
            }
            $sql = $pdo->prepare('SELECT PHOTOS.URL FROM PHOTOS WHERE
            PHOTOS.FK_PHOTOS_ANNOUNCEMENT_ID = :id');
            $sql->bindValue(':id', $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $data['PHOTOS'] = $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $data['PHOTOS'] = array();
            }
        } else {
            $data = NULL;
        }
        return $data;
    }
    public function verTodosAnuncios()
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT ANNOUNCEMENTS.ID_ANNOUNCEMENT, ANNOUNCEMENTS.TITLE, 
        ANNOUNCEMENTS.QUANTITY, ANNOUNCEMENTS.ANNOUNCEMENT_VALUE, USER_REGISTER.ID_USER, 
        USER_REGISTER.CITY, USER_REGISTER.STATE, CATEGORY.NAME AS CATEGORY, 
        (SELECT PHOTOS.URL FROM PHOTOS WHERE PHOTOS.FK_PHOTOS_ANNOUNCEMENT_ID = 
        ANNOUNCEMENTS.ID_ANNOUNCEMENT LIMIT 1) AS PHOTO FROM ANNOUNCEMENTS INNER JOIN 
        USER_REGISTER ON ANNOUNCEMENTS.FK_ANNOUNCEMENT_USER_ID = USER_REGISTER.ID_USER 
        INNER JOIN CATEGORY ON ANNOUNCEMENTS.FK_ANNOUNCEMENT_CATEGORY_ID = CATEGORY.ID_CATEGORY 
        ORDER BY(ANNOUNCEMENTS.ID_ANNOUNCEMENT) DESC');
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
}