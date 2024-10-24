<?php
include '../db.php';

$id = $_GET['id'];

if (isset($id)) {
    try {
        $stmt = $pdo->prepare("DELETE FROM Clientes WHERE ID_Cliente = :id");
        $stmt->execute(['id' => $id]);
        header("Location: clientes.php"); // Redirigir a la lista de clientes después de eliminar
    } catch (PDOException $e) {
        echo "Error al eliminar el cliente: " . $e->getMessage();
    }
}
?>
