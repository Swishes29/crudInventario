<?php
include 'db.php';
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM Productos WHERE ID_Productos = ?");
$stmt->execute([$id]);

header("Location: index.php");
?>
