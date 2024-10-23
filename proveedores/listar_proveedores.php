<?php
include '../db.php';

$stmt = $pdo->query("SELECT * FROM Proveedores");
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Proveedores</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Proveedores</h1>
    <a href="crear_proveedor.php" class="btn btn-primary mb-3">Agregar Proveedor</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($proveedores as $proveedor): ?>
            <tr>
                <td><?= $proveedor['ID_Proveedor'] ?></td>
                <td><?= $proveedor['Nombre'] ?></td>
                <td><?= $proveedor['Direccion'] ?></td>
                <td>
                    <a href="editar_proveedor.php?id=<?= $proveedor['ID_Proveedor'] ?>" class="btn btn-warning">Editar</a>
                    <a href="eliminar_proveedor.php?id=<?= $proveedor['ID_Proveedor'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
