<?php
include 'db.php';
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM Productos WHERE ID_Productos = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

$categorias = $pdo->query("SELECT * FROM Categorias")->fetchAll(PDO::FETCH_ASSOC);
$proveedores = $pdo->query("SELECT * FROM Proveedores")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['categoria'];
    $proveedor = $_POST['proveedor'];

    $stmt = $pdo->prepare("UPDATE Productos SET Nombre = ?, Precio = ?, Cantidad = ?, ID_Categoria = ?, ID_Proveedor = ? WHERE ID_Productos = ?");
    $stmt->execute([$nombre, $precio, $cantidad, $categoria, $proveedor, $id]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Editar Producto</h1>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del producto</label>
            <input type="text" name="nombre" class="form-control" value="<?= $producto['Nombre'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['Precio'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" value="<?= $producto['Cantidad'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" class="form-control" required>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['ID_Categoria'] ?>" <?= $categoria['ID_Categoria'] == $producto['ID_Categoria'] ? 'selected' : '' ?>><?= $categoria['Nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="proveedor" class="form-label">Proveedor</label>
            <select name="proveedor" class="form-control" required>
                <?php foreach ($proveedores as $proveedor): ?>
                    <option value="<?= $proveedor['ID_Proveedor'] ?>" <?= $proveedor['ID_Proveedor'] == $producto['ID_Proveedor'] ? 'selected' : '' ?>><?= $proveedor['Nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
