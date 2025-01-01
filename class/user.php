<?php
class Usuario {
    public function cadastrar($foto, $nome, $email, $cpf_cnpj, $genero, $usuario, $senha, $cep, $numero, $rua, $bairro, $cidade, $estado, $residencial, $comercial, $celular) {
        global $pdo;
        $sql = $pdo->prepare('SELECT ID_USER FROM USER_REGISTER WHERE EMAIL LIKE :email OR SSN_EIN LIKE :cpf_cnpj OR USERNAME LIKE :usuario');
        $sql->bindValue(':email', $email);
        $sql->bindValue(':cpf_cnpj', $cpf_cnpj);
        $sql->bindValue(':usuario', $usuario);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return false;
        } else {
            $senha = md5($senha);
            $sql = $pdo->prepare('INSERT INTO USER_REGISTER (USERNAME, EMAIL, SSN_EIN, GENDER, USERNAME, PASS, ZIP_CODE, NUMBER, STREET, NEIGHBORHOOD, CITY, STATE) VALUES (:foto, :nome, :email, :cpf_cnpj, :genero, :usuario, :senha, :cep, :numero, :rua, :bairro, :cidade, :estado)');
            
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
            $id_user = $pdo->lastInsertId();
            $PERFIL = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'perfil';
            mkdir($PERFIL.DIRECTORY_SEPARATOR.$id_user);
            $ID_DIR = $PERFIL.DIRECTORY_SEPARATOR.$id_user;
            
        }
    }
}
?>
