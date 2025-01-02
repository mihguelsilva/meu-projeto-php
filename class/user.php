<?php
class Usuario
{
    public function cadastrar($foto, $nome, $email, $cpf_cnpj, $genero, $usuario, $senha, $cep, $numero, $rua, $bairro, $cidade, $estado, $residencial, $comercial, $celular)
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT ID FROM USER_REGISTER WHERE EMAIL LIKE :email OR SSN_EIN LIKE :cpf_cnpj OR USERNAME LIKE :usuario');
        $sql->bindValue(':email', $email);
        $sql->bindValue(':cpf_cnpj', $cpf_cnpj);
        $sql->bindValue(':usuario', $usuario);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return false;
        } else {
            $senha = md5($senha);
            $sql = $pdo->prepare('INSERT INTO USER_REGISTER (NAME, EMAIL, SSN_EIN, GENDER, USERNAME, PASS, ZIP_CODE, NUMBER, STREET, NEIGHBORHOOD, CITY, STATE) VALUES (:nome, :email, :cpf_cnpj, :genero, :usuario, :senha, :cep, :numero, :rua, :bairro, :cidade, :estado)');
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':cpf_cnpj', $cpf_cnpj);
            $sql->bindValue(':genero', $genero);
            $sql->bindValue(':usuario', $usuario);
            $sql->bindValue(':senha', $senha);
            $sql->bindValue(':cep', $cep);
            $sql->bindValue(':numero', $numero);
            $sql->bindValue(':rua', $rua);
            $sql->bindValue(':bairro', $bairro);
            $sql->bindValue(':cidade', $cidade);
            $sql->bindValue(':estado', $estado);
            $sql->execute();
            $id_user = $pdo->lastInsertId();
            $PERFIL = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'perfil';
            $ID_DIR = $PERFIL . DIRECTORY_SEPARATOR . $id_user;
            if (!is_dir($ID_DIR)) {
                mkdir($PERFIL . DIRECTORY_SEPARATOR . $id_user);
            }
            if ($foto != NULL) {
                if ($foto['type'] == 'image/jpeg' || $foto['type'] == 'image/png') {
                    $fotoNome = md5(rand(0, 99999) . time() . ".jpg");
                    move_uploaded_file($foto['tmp_name'], $ID_DIR . DIRECTORY_SEPARATOR . $fotoNome);
                    $sql = $pdo->prepare('UPDATE USER_REGISTER SET PHOTO = :foto WHERE ID = :id');
                    $sql->bindValue(':foto', $fotoNome);
                    $sql->bindValue(':id', $id_user);
                    $sql->execute();
                }
            }
            for ($a = 0; $a < count($residencial); $a++) {
                if ($residencial[$a] == NULL && $comercial[$a] == NULL && $celular[$a] == NULL) {
                    // não cadastrar nada
                } else {
                    $sql = $pdo->prepare('INSERT INTO PHONE (HOME, BUSINESS, CELL, FK_PHONE_USER_ID) VALUES(:residencial, :comercial, :celular, :fk_id)');
                    $sql->bindValue(':residencial', $residencial[$a]);
                    $sql->bindValue(':comercial', $comercial[$a]);
                    $sql->bindValue(':celular', $celular[$a]);
                    $sql->bindValue(':fk_id', $id_user);
                    $sql->execute();
                }
            }
            return true;
        }
    }
    public function login($usuario, $senha)
    {
        global $pdo;
        $senha = md5($senha);
        $sql = $pdo->prepare('SELECT ID, PHOTO, NAME FROM USER_REGISTER WHERE USERNAME = :username AND PASS = :password');
        $sql->bindValue(':username', $usuario);
        $sql->bindValue(':password', $senha);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            $_SESSION['LOGIN'] = $data['ID'];
            $_SESSION['NAME'] = $data['NAME'];
            $_SESSION['PHOTO'] = $data['PHOTO'];
            return true;
        } else {
            return false;
        }
    }
    public function ConsultarTudo($id)
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT * FROM USER_REGISTER WHERE ID = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
        }
        return $data;
    }
    public function ConsultarTodosTelefones($id)
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT * FROM PHONE WHERE FK_PHONE_USER_ID = :id');
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = array();
        }
        return $data;
    }
    public function AtualizarUmCampo($bd, $campo, $valor, $id, $campo_id)
    {
        global $pdo;
        if ($campo == 'PHOTO') {
            if ($valor['type'] == 'image/jpeg' || $valor['type'] == 'image/png') {
                $PERFIL = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'perfil';
                $ID_DIR = $PERFIL . DIRECTORY_SEPARATOR . $id;
                $dado = md5(rand(0, 99999) . time() . ".jpg");
                move_uploaded_file($valor['tmp_name'], $ID_DIR . DIRECTORY_SEPARATOR . $dado);
            }
        } else {
            $dado = $valor;
        }
        $sql = $pdo->prepare('UPDATE ' . $bd . ' SET ' . $campo . ' = :campo WHERE ' . $campo_id . ' = :id');
        $sql->bindValue(':campo', $dado);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}
