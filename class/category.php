<?php
class Categoria {
    public function verTodasCategorias()
    {
        global $pdo;
        $sql = $pdo->prepare('SELECT * FROM CATEGORY');
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = array();
        }
        return $data;
    }
}
?>
