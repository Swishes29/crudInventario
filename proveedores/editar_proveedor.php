<?php
include '../db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM Proveedores WHERE ID_Proveedor = ?");
$stmt->execute([$id]);
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];

    $stmt = $pdo->prepare("UPDATE Proveedores SET Nombre = ?, Direccion = ? WHERE ID_Proveedor = ?");
    $stmt->execute([$nombre, $direccion, $id]);

    header("Location: listar_proveedores.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Editar Proveedor</h1>
    <form action="editar_proveedor.php?id=<?= $id ?>" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Proveedor</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $proveedor['Nombre'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección del Proveedor</label>
            <input type="text" name="direccion" id="direccion" class="form-control" value="<?= $proveedor['Direccion'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
