<?php
include '../db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM Categorias WHERE ID_Categoria = ?");
$stmt->execute([$id]);

header("Location: listar_categorias.php");
?>
