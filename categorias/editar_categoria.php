<?php
include '../db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM Categorias WHERE ID_Categoria = ?");
$stmt->execute([$id]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];

    $stmt = $pdo->prepare("UPDATE Categorias SET Nombre = ? WHERE ID_Categoria = ?");
    $stmt->execute([$nombre, $id]);

    header("Location: listar_categorias.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Editar Categoría</h1>
    <form action="editar_categoria.php?id=<?= $id ?>" method="post">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Categoría</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $categoria['Nombre'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
