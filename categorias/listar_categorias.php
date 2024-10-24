<?php
include '../db.php';

// Consulta para obtener las categorías
$stmt = $pdo->query("SELECT * FROM categorias");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Categorías</title>
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
<div class="container">
    <h1 class="mt-5">Categorías</h1>
    <a href="crear_categoria.php" class="btn btn-outline-primary mb-3">
        <i class="fas fa-plus"></i> Agregar Categoría
    </a>

    <!-- Tabla mejorada con ordenación -->
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th onclick="sortTable(0)">ID</th>
            <th onclick="sortTable(1)">Nombre</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody id="categoriasTable">
        <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?= $categoria['ID_Categoria'] ?></td>
                <td><?= $categoria['Nombre'] ?></td>
                <td class="text-center">
                    <a href="editar_categoria.php?id=<?= $categoria['ID_Categoria'] ?>" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="eliminar_categoria.php?id=<?= $categoria['ID_Categoria'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    // Ordenar tabla por columna
    function sortTable(n) {
        const table = document.getElementById("categoriasTable");
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
    const rows = [...document.querySelectorAll("#categoriasTable tr")];
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
