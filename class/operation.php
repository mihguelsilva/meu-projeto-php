<?php
abstract class Operacao
{
    public function atualizarDado(
        $tabela,
        $campo,
        $conteudo,
        $chave,
        $valor
    ) {
        global $pdo;
        $sql = $pdo->prepare('UPDATE ' . $tabela . ' SET '
            . $campo . ' = :conteudo WHERE '
            . $chave . ' = :valor');
        $sql->bindValue(':conteudo', $conteudo);
        $sql->bindValue(':valor', $valor);
        $sql->execute();
    }
    public function manipularFotos($fotos, $dir, $acao)
    {
        function adicionar($foto, $pasta)
        {
            if (!is_dir($pasta)) {
                mkdir($pasta);
            }
            for ($a = 0; $a < count($foto['name']); $a++) {
                if (
                    $foto['type'][$a] == 'image/png' ||
                    $foto['type'][$a] == 'image/jpeg'
                ) {
                    $fotoNome[$a] = md5(rand(0, 99999) . time() . '.jpg');
                    move_uploaded_file($foto['tmp_name'][$a], $pasta . DIRECTORY_SEPARATOR . $fotoNome[$a]);
                }
            }
            return $fotoNome;
        }
        if ($acao == 'deletar') {
            if (!is_array($fotos)) {
                $picture[0] = $fotos;
            } else {
                $picture = $fotos;
            }
            for ($a = 0; $a < count($picture); $a++) {
                unlink($dir . DIRECTORY_SEPARATOR . $picture[$a]);
            }
            return true;
        } else if ($acao == 'atualizar' || $acao == 'cadastrar') {
            if ($fotos['error'] == 0 || $fotos['error'][0] == 0) {
                if (is_array($fotos['error']) == false) {
                    $picture['name'][0] = $fotos['name'];
                    $picture['type'][0] = $fotos['type'];
                    $picture['tmp_name'][0] = $fotos['tmp_name'];
                    $picture['error'][0] = $fotos['error'];
                    $picture['size'][0] = $fotos['size'];
                } else {
                    $picture = $fotos;
                }
                $ft = adicionar($picture, $dir);
                return $ft;
            } else {
                return false;
            }
        }
    }
    public function consultarFotos(
        $campo,
        $valor
    )
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT PHOTOS.URL, PHOTOS.FK_PHOTOS_COMMENT_ID 
        FROM PHOTOS WHERE '.$campo.' = :valor');
        $sql->bindValue(':valor', $valor);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = array();
        }
        return $data;
    }
    public function cadastrarFotos(
        $campo_fk,
        $valor_url,
        $valor_fk
    ) {
        global $pdo;
        for ($a = 0; $a < count($valor_url); $a++) {
            $sql = $pdo->prepare('INSERT INTO PHOTOS 
            (URL, ' . $campo_fk . ') VALUES (:url, :fk)');
            $sql->bindValue(':url', $valor_url[$a]);
            $sql->bindValue(':fk', $valor_fk);
            $sql->execute();
        }
    }
    public function deletarDado($tabela, $chave, $valor)
    {
        global $pdo;
        $sql = $pdo->prepare('DELETE FROM ' . $tabela . ' 
        WHERE ' . $chave . ' = :valor');
        $sql->bindValue(':valor', $valor);
        $sql->execute();
    }
    public function consultarTabela(
        $tabela,
        $campo,
        $valor
    )
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT * FROM '.$tabela.'
        WHERE '.$campo.' = :valor');
        $sql->bindValue(':valor', $valor);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = array();
        }
        return $data;
    }
}
