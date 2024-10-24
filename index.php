<?php
include 'db.php'; 

try {
    // Consultas para obtener contadores de productos, categorías y proveedores
    $stmtProductos = $pdo->query("SELECT COUNT(*) AS total FROM Productos");
    $totalProductos = $stmtProductos->fetchColumn();

    $stmtCategorias = $pdo->query("SELECT COUNT(*) AS total FROM Categorias");
    $totalCategorias = $stmtCategorias->fetchColumn();

    $stmtProveedores = $pdo->query("SELECT COUNT(*) AS total FROM Proveedores");
    $totalProveedores = $stmtProveedores->fetchColumn();
} catch (PDOException $e) {
    $stmtClientes = $pdo->query("SELECT COUNT(*) AS total FROM Clientes");
    $totalClientes = $stmtClientes->fetchColumn();
    // Manejo de errores en las consultas
    echo "Error en la consulta: " . $e->getMessage();
    $totalProductos = $totalCategorias = $totalProveedores = 0; // Asignar valores por defecto en caso de error
}

// Consulta para obtener los últimos productos agregados
try {
    $stmt = $pdo->query("SELECT Productos.Nombre AS producto, Categorias.Nombre AS categoria, Proveedores.Nombre AS proveedor, Precio, Productos.ID_Productos 
                         FROM Productos
                         JOIN Categorias ON Productos.ID_Categoria = Categorias.ID_Categoria 
                         JOIN Proveedores ON Productos.ID_Proveedor = Proveedores.ID_Proveedor 
                         ORDER BY Productos.ID_Productos DESC LIMIT 5");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejo de errores en la consulta
    echo "Error al obtener los productos: " . $e->getMessage();
    $productos = []; // Asignar un array vacío si la consulta falla
}

// Consulta para obtener el número de productos por categoría (para el gráfico)
try {
    $stmtGrafico = $pdo->query("SELECT 
    Categorias.Nombre AS categoria, 
    SUM(Productos.Cantidad) AS total
FROM 
    Productos
JOIN 
    Categorias ON Productos.ID_Categoria = Categorias.ID_Categoria
GROUP BY 
    Categorias.Nombre;
");
    $productosPorCategoria = $stmtGrafico->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener productos por categoría: " . $e->getMessage();
    $productosPorCategoria = [];
}
try {
    // Consulta para obtener el número total de clientes
    $stmtClientes = $pdo->query("SELECT COUNT(*) AS total FROM Clientes");
    $totalClientes = $stmtClientes->fetchColumn();
} catch (PDOException $e) {
    // Manejo de errores en la consulta
    echo "Error en la consulta: " . $e->getMessage();
    $totalClientes = 0; // Asignar valor por defecto en caso de error
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Inventario</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Mejoras de estilo para tarjetas y secciones */
        .dashboard-card {
            background-color: #f9f9f9;
            border-left: 5px solid #007bff;
        }

        .dashboard-card.total-categorias {
            border-left: 5px solid #28a745;
        }

        .dashboard-card.total-proveedores {
            border-left: 5px solid #ffc107;
        }

        .card-body h3 {
            font-size: 1.8rem;
        }

        .card-body i {
            font-size: 2rem;
            color: #007bff;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
        }

        .stats-container .col-md-4 {
            margin-bottom: 20px;
        }

        .navbar {
            background-color: #007bff !important;
        }

        .navbar-brand {
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: white !important;
        }
    </style>
</head>

<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Inventario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productos.php"><i class="fas fa-box"></i> Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categorias/listar_categorias.php"><i class="fas fa-tags"></i> Categorías</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="proveedores/listar_proveedores.php"><i class="fas fa-truck mb-2"></i>
                            Proveedores</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="clientes/clientes.php"> <i class="fas fa-users mb-2"></i>
                            Clientes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h1 class="text-center mb-5">Sistema de Gestión de Inventario</h1>

        <!-- Secciones con estadísticas rápidas -->
        <div class="row stats-container">
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body text-center">
                        <i class="fas fa-boxes mb-2"></i>
                        <h3>Total Productos</h3>
                        <p><strong><?= $totalProductos ?></strong> productos</p>
                        <a href="productos.php" class="btn btn-primary">Ver Productos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body text-center">
                        <i class="fas fa-tags mb-2"></i>
                        <h3>Total Categorías</h3>
                        <p><strong><?= $totalCategorias ?></strong> categorías</p>
                        <a href="categorias/listar_categorias.php" class="btn btn-primary">Ver Categorías</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body text-center">
                        <i class="fas fa-truck mb-2"></i>
                        <h3>Total Proveedores</h3>
                        <p><strong><?= $totalProveedores ?></strong> proveedores</p>
                        <a href="proveedores/listar_proveedores.php" class="btn btn-primary">Ver Proveedores</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-users mb-2"></i>
                    <h3>Total Clientes</h3>
                    <p><strong><?= $totalClientes ?></strong> clientes</p>
                    <a href="clientes/clientes.php" class="btn btn-primary">Ver Clientes</a>
                </div>
            </div>
        </div>


        <!-- Gráfico de productos por categoría -->
        <div class="mt-5">
            <h2>Productos por Categoría</h2>
            <canvas id="productosPorCategoria"></canvas>
        </div>

        <!-- Tabla resumen de productos -->
        <div class="mt-5">
            <h2>Últimos Productos Agregados</h2>
            <table class="table table-bordered mt-3 table-responsive table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?= $producto['producto'] ?></td>
                                <td><?= $producto['categoria'] ?></td>
                                <td><?= $producto['Precio'] ?> $</td>
                                <td><?= $producto['proveedor'] ?></td>
                                <td>
                                    <a href="editar_producto.php?id=<?= $producto['ID_Productos'] ?>" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="eliminar_producto.php?id=<?= $producto['ID_Productos'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay productos disponibles</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Gráfico de productos por categoría -->
    <script>
        var ctx = document.getElementById('productosPorCategoria').getContext('2d');
        var categorias = <?= json_encode(array_column($productosPorCategoria, 'categoria')) ?>;
        var totales = <?= json_encode(array_column($productosPorCategoria, 'total')) ?>;

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categorias, // Etiquetas de las categorías
                datasets: [{
                    label: 'Productos por categoría',
                    data: totales, // Cantidad de productos por categoría
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>