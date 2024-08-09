<?php
include '../../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql_paquetes = 'SELECT id_paquete, nombre FROM Paquetes';
$result_paquetes = $conn->query($sql_paquetes);

if (!$result_paquetes) {
    echo "Error en la consulta de paquetes: " . $conn->error;
    exit;
}

$selected_paquete = isset($_GET['paquete']) ? intval($_GET['paquete']) : 0;

$sql_detalles = 'SELECT d.id_detalle, d.id_paquete, d.detalle, p.nombre AS nombre_paquete
        FROM Detalles_Paquete d
        JOIN Paquetes p ON d.id_paquete = p.id_paquete';

if ($selected_paquete > 0) {
    $sql_detalles .= ' WHERE d.id_paquete = ' . $selected_paquete;
}

$result_detalles = $conn->query($sql_detalles);

if (!$result_detalles) {
    echo "Error en la consulta de detalles: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detalles de Paquetes - Serenity Space</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../../../public/build/css/stylesDash.css" />
    <link rel="icon" href="../../../../public/build/img/icon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../../../../public/build/img/icon.png" type="image/x-icon" />
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <h2>Opciones</h2>
        <a href="../../usuarios/usuarios.php">Usuarios</a>
        <a href="../../terapeutas/terapeutas.php">Terapeutas</a>
        <a href="../../terapias/terapias.php">Terapias</a>
        <a href="../../citas/citas.php">Citas</a>
        <a href="../../paquetes/paquetes.php">Paquetes</a>
        <div class="sidebar-footer">
            <a href="../../../../../../public/index.php" class="btn btn-danger btn-logout">Salir</a>
        </div>
    </nav>

    <!-- Content -->
    <div class="content">
        <!-- Header -->
        <header class="header_area">
            <a href="../../dashboard.php" class="header_link">
                <h1>Serenity Space</h1>
            </a>
        </header>

        <!-- Main Content -->
        <section class="options_area">
            <div class="container mt-5">
                <h1 style="color: #333">Detalles de Paquetes</h1>
                
                <!-- Filtro por Paquete -->
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="paquete">Filtrar por Paquete:</label>
                        <select id="paquete" name="paquete" class="form-control">
                            <option value="">Todos los Paquetes</option>
                            <?php while ($row_paquete = $result_paquetes->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_paquete['id_paquete'], ENT_QUOTES); ?>"
                                    <?php echo $selected_paquete == $row_paquete['id_paquete'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row_paquete['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter" style="border-color: #2ba8bd; font-weight: bold; box-shadow: none;">Filtrar</button>
                    <a href="agregar_detalle_paquete.php" class="button">Agregar Nuevo Detalle</a>
                    <a href="../paquetes.php" class="button" style="background-color: #DA2843">Regresar</a>
                </form>
                
                <!-- Tabla de Detalles -->
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID Detalle</th>
                            <th>Paquete</th>
                            <th>Detalle</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_detalle = $result_detalles->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row_detalle['id_detalle'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row_detalle['nombre_paquete'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row_detalle['detalle'], ENT_QUOTES); ?></td>
                                <td>
                                    <a href="editar_detalle_paquete.php?id=<?php echo htmlspecialchars($row_detalle['id_detalle'], ENT_QUOTES); ?>" class="btn" style="background-color: #2ba8bd; color: white;">Editar</a>
                                    <a href="eliminar_detalle_paquete.php?id=<?php echo htmlspecialchars($row_detalle['id_detalle'], ENT_QUOTES); ?>" class="btn" style="background-color: #e74c3c; color: white;">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer_area">
            <p class="footer_text">
                &copy; 2024 Serenity Space. Todos los derechos reservados.
            </p>
        </footer>
    </div>

    <?php
    $result_paquetes->free();
    $result_detalles->free();
    $conn->close();
    ?>
</body>
</html>
