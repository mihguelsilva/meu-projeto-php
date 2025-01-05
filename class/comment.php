<?php
class Comentario extends Operacao
{
    public function cadastrarComentario(
        $data,
        $conteudo,
        $fk_id_usuario,
        $fk_id_anuncio
    ) {
        global $pdo;
        $sql = $pdo->prepare('INSERT INTO COMMENTS 
        (COMMENTS.COMMENT_DATE, COMMENTS.CONTENT, COMMENTS.FK_COMMENTS_USER_ID, 
        COMMENTS.FK_COMMENTS_ANNOUNCEMENT_ID)
        VALUES (:data, :conteudo, :fk_id_usuario, :fk_id_anuncio)');
        $sql->bindValue(':data', $data);
        $sql->bindValue(':conteudo', $conteudo);
        $sql->bindValue(':fk_id_usuario', $fk_id_usuario);
        $sql->bindValue(':fk_id_anuncio', $fk_id_anuncio);
        $sql->execute();
        $id_comentario = $pdo->lastInsertId();
        return $id_comentario;
    }
    public function cadastrarFotos(
        $campo_fk,
        $valor_url,
        $valor_fk
    ) {
        global $pdo;
        for ($a = 0; $a < count($valor_url); $a++) {
            $sql = $pdo->prepare('INSERT INTO PHOTOS 
            (PHOTOS.URL, PHOTOS.' . $campo_fk[0] . ', PHOTOS.' . $campo_fk[1] . ') VALUES
            (:url, :fk_id_comentario, :fk_id_anuncio)');
            $sql->bindValue(':url', $valor_url[$a]);
            $sql->bindValue(':fk_id_comentario', $valor_fk[0]);
            $sql->bindValue(':fk_id_anuncio', $valor_fk[1]);
            $sql->execute();
        }
    }
    public function consultarComentarios($id) {
        global $pdo;
        $sql = $pdo->prepare('SELECT COMMENTS.ID_COMMENT, COMMENTS.COMMENT_DATE,
        COMMENTS.CONTENT, COMMENTS.FK_COMMENTS_USER_ID, USER_REGISTER.USERNAME 
        FROM COMMENTS INNER JOIN USER_REGISTER ON 
        USER_REGISTER.ID_USER = COMMENTS.FK_COMMENTS_USER_ID 
        WHERE COMMENTS.FK_COMMENTS_ANNOUNCEMENT_ID = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = array();
        }
        return $data;
    }
}
