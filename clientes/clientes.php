<?php
include '../db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    $stmt = $pdo->prepare("SELECT * FROM Clientes WHERE Nombre LIKE :search OR Direccion LIKE :search");
    $stmt->execute(['search' => '%' . $search . '%']);
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los clientes: " . $e->getMessage();
    $clientes = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Gestión de Clientes</h1>

        <!-- Barra de búsqueda mejorada -->
        <form method="GET" action="clientes.php" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Buscar clientes por nombre o dirección" class="form-control" value="<?= $search ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Botón para agregar cliente -->
        <div class="text-right mb-3">
            <a href="agregar_cliente.php" class="btn btn-success">Agregar Cliente</a>
        </div>

        <!-- Tabla de clientes -->
        <table class="table table-bordered table-responsive table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($clientes)): ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= $cliente['ID_Cliente'] ?></td>
                            <td><?= $cliente['Nombre'] ?></td>
                            <td><?= $cliente['Direccion'] ?></td>
                            <td><?= $cliente['Telefono'] ?></td>
                            <td>
                                <a href="editar_cliente.php?id=<?= $cliente['ID_Cliente'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="eliminar_cliente.php?id=<?= $cliente['ID_Cliente'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No se encontraron clientes</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
