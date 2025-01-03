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
    public function verCategoria($id) {
	global $pdo;
	$sql = $pdo->prepare('SELECT CATEGORY.NAME FROM CATEGORY WHERE ID_CATEGORY = :id');
	$sql->bindValue(':id', $id);
	$sql->execute();
	if ($sql->rowCount() > 0) {
	    $data = $sql->fetch();
	} else {
	    $data = NULL;
	}
	return $data;
    }
}
?>
