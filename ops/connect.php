<?php
session_start();
global $pdo;
try {
    $pdo = new PDO('mysql:host=localhost;dbname=PROJETO_FINAL', 'projeto_final', 'pR0j&70F1na7@!');
} catch (Exception $e) {
    echo 'Erro do Servidor ' . $e->getMessage();
    }
?>
