<?php
require_once $_SERVER['DOCUMENT_ROOT']
    . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR
    . 'global.php';
require CL_OPERATION;
class Usuario extends Operacao
{
    public function cadastrar(
        $nome,
        $email,
        $cpf_cnpj,
        $genero,
        $usuario,
        $senha,
        $cep,
        $numero,
        $rua,
        $bairro,
        $cidade,
        $estado,
        $residencial,
        $comercial,
        $celular
    ) {
        global $pdo;
        $sql = $pdo->prepare('SELECT ID_USER FROM USER_REGISTER
    WHERE USER_REGISTER.EMAIL = :email OR
    USER_REGISTER.SSN_EIN = :cpf_cnpj OR
    USER_REGISTER.USERNAME = :usuario');
        $sql->bindValue(':email', $email);
        $sql->bindValue(':cpf_cnpj', $cpf_cnpj);
        $sql->bindValue(':usuario', $usuario);
        if ($sql->rowCount() > 0) {
            return array('status' => 'error', 'msg' => 'Cadastro já existe!');
        } else {
            $sql = $pdo->prepare('INSERT INTO USER_REGISTER
    (NAME, EMAIL, SSN_EIN, GENDER, USERNAME, PASSWORD, ZIP_CODE,
    NUMBER, STREET, NEIGHBORHOOD, CITY, STATE) VALUES (:nome,
    :email, :cpf_cnpj, :genero, :usuario, :senha, :cep, :numero,
    :rua, :bairro, :cidade, :estado)');
            $senha = md5($senha);
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
            $id_usuario = $pdo->lastInsertId();
            for ($a = 0; $a < count($residencial); $a++) {
                $sql = $pdo->prepare('INSERT INTO PHONE (PHONE.HOME,
    PHONE.BUSINESS, PHONE.CELL, FK_PHONE_USER_ID) VALUES (:residencial, :comercial, :celular, :fk_id_user)');
                $sql->bindValue(':residencial', $residencial[$a]);
                $sql->bindValue(':comercial', $comercial[$a]);
                $sql->bindValue(':celular', $celular[$a]);
                $sql->bindValue(':fk_id_user', $id_usuario);
                $sql->execute();
            }
            return array("status" => "success", "msg" => $id_usuario);
        }
    }
    public function login($usuario, $senha)
    {
        global $pdo;
        $senha = md5($senha);
        $sql = $pdo->prepare('SELECT USER_REGISTER.ID_USER, USER_REGISTER.PHOTO, 
        USER_REGISTER.NAME, USER_REGISTER.GENDER, USER_REGISTER.ACTIVE FROM 
        USER_REGISTER WHERE USERNAME = :username AND PASSWORD = :password');
        $sql->bindValue(':username', $usuario);
        $sql->bindValue(':password', $senha);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            if ($data['ACTIVE'] == true) {
                $_SESSION['LOGIN'] = $data['ID_USER'];
                $_SESSION['NAME'] = $data['NAME'];
                $_SESSION['PHOTO'] = $data['PHOTO'];
                $_SESSION['GENDER'] = $data['GENDER'];
                return true;
            } else {
                return "Sua conta está desativada";
            }
        } else {
            return "Credenciais incorretas";
        }
    }
    public function ConsultarTudo($id)
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT * FROM USER_REGISTER WHERE ID_USER = :id');
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
    public function atualizarAcesso($usuario, $senha, $id)
    {
        global $pdo;
        $senha = md5($senha);
        $sql = $pdo->prepare('UPDATE USER_REGISTER SET USERNAME = :username, PASSWORD = :senha WHERE ID_USER = :id');
        $sql->bindValue(':username', $usuario);
        $sql->bindValue(':senha', $senha);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
    public function atualizarPessoais($nome, $email, $cpf_cnpj, $genero, $id)
    {
        global $pdo;
        $sql = $pdo->prepare('UPDATE USER_REGISTER SET NAME = :nome, EMAIL = :email, SSN_EIN = :cpf_cnpj, GENDER = :genero WHERE ID_USER = :id');
        $sql->bindValue('nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':cpf_cnpj', $cpf_cnpj);
        $sql->bindValue(':genero', $genero);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
    public function atualizarEndereco($cep, $numero, $rua, $bairro, $cidade, $estado, $id)
    {
        global $pdo;
        $sql = $pdo->prepare('UPDATE USER_REGISTER SET ZIP_CODE = :cep, NUMBER = :numero, STREET = :rua, NEIGHBORHOOD = :bairro, CITY = :cidade, STATE = :estado WHERE ID_USER = :id');
        $sql->bindValue(':cep', $cep);
        $sql->bindValue(':numero', $numero);
        $sql->bindValue(':rua', $rua);
        $sql->bindValue(':bairro', $bairro);
        $sql->bindValue(':cidade', $cidade);
        $sql->bindValue(':estado', $estado);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
    public function desativarConta($id)
    {
        global $pdo;
        // $sql = $pdo->prepare('UPDATE USER_REGISTER SET ACTIVE = :desativar WHERE ID_USER = :id');
        // $sql->bindValue(':desativar', false);
        // $sql->bindValue(':id', $id);
        // $sql->execute();
    }
    public function ativarConta($email_cpf_cnpj)
    {
        global $pdo;
        // $sql = $pdo->prepare('SELECT ID FROM USER_REGISTER WHERE EMAIL = :email OR SSN_EIN = :cpf_cnpj');
        // $sql->bindValue(':email', $email_cpf_cnpj);
        // $sql->bindValue(':cpf_cnpj', $email_cpf_cnpj);
        // $sql->execute();
        // if ($sql->rowCount() > 0) {
        // $sql = $pdo->prepare('UPDATE USER_REGISTER SET ACTIVE = :ativar WHERE EMAIL = :email OR SSN_EIN = :cpf_cnpj');
        // $sql->bindValue(':ativar', true);
        // $sql->bindValue(':email', $email_cpf_cnpj);
        // $sql->bindValue(':cpf_cnpj', $email_cpf_cnpj);
        // $sql->execute();
        // return true;
        // } else {
        // return false
        // }
    }
}
