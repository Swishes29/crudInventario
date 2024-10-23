<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM Productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Productos</h1>
    <a href="crear_producto.php" class="btn btn-primary mb-3">Agregar Producto</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Categoría</th>
            <th>Proveedor</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $producto) : ?>
            <tr>
                <td><?= $producto['ID_Productos'] ?></td>
                <td><?= $producto['Nombre'] ?></td>
                <td><?= $producto['Precio'] ?></td>
                <td><?= $producto['Cantidad'] ?></td>
                <td><?= $producto['ID_Categoria'] ?></td>
                <td><?= $producto['ID_Proveedor'] ?></td>
                <td>
                    <a href="editar_producto.php?id=<?= $producto['ID_Productos'] ?>" class="btn btn-warning">Editar</a>
                    <a href="eliminar_producto.php?id=<?= $producto['ID_Productos'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
