<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    if (!empty($nombre) && !empty($direccion) && !empty($telefono)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Clientes (Nombre, Direccion, Telefono) VALUES (:nombre, :direccion, :telefono)");
            $stmt->execute(['nombre' => $nombre, 'direccion' => $direccion, 'telefono' => $telefono]);
            header("Location: clientes.php"); // Redirigir a la lista de clientes
        } catch (PDOException $e) {
            echo "Error al agregar el cliente: " . $e->getMessage();
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Agregar Cliente</h1>

        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <button type="submit" class="btn btn-success">Agregar Cliente</button>
        </form>
    </div>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
