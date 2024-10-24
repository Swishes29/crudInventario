<?php
include '../db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    // Consulta con búsqueda por nombre o dirección
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
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table th {
            cursor: pointer;
        }
        .table th.sort-asc::after {
            content: "\f0de"; /* Icono FontAwesome para ascendente */
            font-family: 'FontAwesome';
            margin-left: 5px;
        }
        .table th.sort-desc::after {
            content: "\f0dd"; /* Icono FontAwesome para descendente */
            font-family: 'FontAwesome';
            margin-left: 5px;
        }
        .btn-sm i {
            margin-right: 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Gestión de Clientes</h1>

        <!-- Barra de búsqueda -->
        <form method="GET" action="clientes.php" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Buscar clientes por nombre o dirección" class="form-control" value="<?= htmlspecialchars($search) ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Botón para agregar cliente -->
        <div class="text-right mb-3">
            <a href="agregar_cliente.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Agregar Cliente
            </a>
        </div>

        <!-- Tabla de clientes con ordenación -->
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th onclick="sortTable(0)">ID</th>
                    <th onclick="sortTable(1)">Nombre</th>
                    <th onclick="sortTable(2)">Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="clientesTable">
                <?php if (!empty($clientes)): ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= $cliente['ID_Cliente'] ?></td>
                            <td><?= $cliente['Nombre'] ?></td>
                            <td><?= $cliente['Direccion'] ?></td>
                            <td><?= $cliente['Telefono'] ?></td>
                            <td class="text-center">
                                <a href="editar_cliente.php?id=<?= $cliente['ID_Cliente'] ?>" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="eliminar_cliente.php?id=<?= $cliente['ID_Cliente'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                    <i class="fas fa-trash"></i>
                                </a>
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

        <!-- Paginación -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        // Ordenar tabla por columnas
        function sortTable(n) {
            const table = document.getElementById("clientesTable");
            let switching = true, rows, i, x, y, shouldSwitch, dir = "asc", switchCount = 0;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 0; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if ((dir === "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) || 
                        (dir === "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase())) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchCount++;
                } else if (switchCount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }

        // Paginación (simple ejemplo)
        const rowsPerPage = 5;
        const rows = [...document.querySelectorAll("#clientesTable tr")];
        const pagination = document.getElementById("pagination");
        let currentPage = 1;

        function displayPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? "" : "none";
            });
            updatePagination();
        }

        function updatePagination() {
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            pagination.innerHTML = "";
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement("li");
                li.classList.add("page-item");
                li.innerHTML = `<a class="page-link" href="#" onclick="displayPage(${i})">${i}</a>`;
                if (i === currentPage) li.classList.add("active");
                pagination.appendChild(li);
            }
        }

        displayPage(currentPage);
    </script>
</body>
</html>
