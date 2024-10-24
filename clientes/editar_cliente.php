<?php
include '../db.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    if (!empty($nombre) && !empty($direccion) && !empty($telefono)) {
        try {
            $stmt = $pdo->prepare("UPDATE Clientes SET Nombre = :nombre, Direccion = :direccion, Telefono = :telefono WHERE ID_Cliente = :id");
            $stmt->execute(['nombre' => $nombre, 'direccion' => $direccion, 'telefono' => $telefono, 'id' => $id]);
            header("Location: clientes.php"); // Redirigir a la lista de clientes
        } catch (PDOException $e) {
            echo "Error al actualizar el cliente: " . $e->getMessage();
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    $stmt = $pdo->prepare("SELECT * FROM Clientes WHERE ID_Cliente = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Editar Cliente</h1>

        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $cliente['Nombre'] ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $cliente['Direccion'] ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $cliente['Telefono'] ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Actualizar Cliente</button>
        </form>
    </div>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
