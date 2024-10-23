<?php
include '../db.php';

$stmt = $pdo->query("SELECT * FROM Categorias");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Categorías</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Categorías</h1>
    <a href="crear_categoria.php" class="btn btn-primary mb-3">Agregar Categoría</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?= $categoria['ID_Categoria'] ?></td>
                <td><?= $categoria['Nombre'] ?></td>
                <td>
                    <a href="editar_categoria.php?id=<?= $categoria['ID_Categoria'] ?>" class="btn btn-warning">Editar</a>
                    <a href="eliminar_categoria.php?id=<?= $categoria['ID_Categoria'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
