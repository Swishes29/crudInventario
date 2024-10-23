<?php
include '../db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM Proveedores WHERE ID_Proveedor = ?");
$stmt->execute([$id]);

header("Location: listar_proveedores.php");
?>
