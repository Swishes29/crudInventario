<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];

    $stmt = $pdo->prepare("INSERT INTO Proveedores (Nombre, Direccion) VALUES (?, ?)");
    $stmt->execute([$nombre, $direccion]);

    header("Location: listar_proveedores.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proveedor</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Crear Proveedor</h1>
    <form action="crear_proveedor.php" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Proveedor</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección del Proveedor</label>
            <input type="text" name="direccion" id="direccion" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Crear Proveedor</button>
    </form>
</div>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
