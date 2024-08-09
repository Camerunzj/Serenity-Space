<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

// Consultar los paquetes
$sql_paquetes = 'SELECT * FROM Paquetes';
$result_paquetes = $conn->query($sql_paquetes);

if (!$result_paquetes) {
    echo "Error en la consulta de paquetes: " . $conn->error;
    exit;
}

$paquete_id = isset($_GET['paquete_id']) ? intval($_GET['paquete_id']) : 0;

// Consultar los servicios
$sql_servicios = 'SELECT s.id, s.nombre, s.descripcion, p.nombre AS paquete_nombre 
                  FROM Servicios s 
                  JOIN Paquetes p ON s.id_paquete = p.id_paquete';

if ($paquete_id > 0) {
    $sql_servicios .= ' WHERE s.id_paquete = ' . $paquete_id;
}

$sql_servicios .= ' ORDER BY s.nombre';

$result_servicios = $conn->query($sql_servicios);

if (!$result_servicios) {
    echo "Error en la consulta de servicios: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Servicios - Serenity Space</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../../public/build/css/stylesDash.css" />
    <link rel="icon" href="../../../public/build/img/icon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="../../../public/build/img/icon.png" type="image/x-icon" />
</head>
<body>
    <!-- Sidebar -->
    <?php include '../../templates/sidebar.php'; ?>

    <!-- Content -->
    <div class="content">
        <!-- Header -->
        <header class="header_area">
            <a href="../dashboard.php" class="header_link">
                <h1>Serenity Space</h1>
            </a>
        </header>

        <!-- Main Content -->
        <section class="options_area">
            <div class="container mt-5">
                <h1 style="color: #333">Servicios</h1>
                
                <!-- Filtro por Paquete -->
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="paquete_id">Filtrar por Paquete:</label>
                        <select id="paquete_id" name="paquete_id" class="form-control">
                            <option value="">Todos los Paquetes</option>
                            <?php while ($row_paquete = $result_paquetes->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_paquete['id_paquete'], ENT_QUOTES); ?>"
                                    <?php echo $paquete_id == $row_paquete['id_paquete'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row_paquete['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter" style="border-color: #2ba8bd; font-weight: bold; box-shadow: none;">Filtrar</button>
                    <a href="agregar_servicio.php" class="button">Agregar Nuevo Servicio</a>
                </form>
                
                <!-- Tabla de Servicios -->
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID Servicio</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Paquete</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_servicios->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['descripcion'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['paquete_nombre'], ENT_QUOTES); ?></td>
                                <td>
                                <a href="editar_servicio.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?>" class="btn" style="background-color: #2ba8bd; color: white;">Editar</a>
                                <a href="eliminar_servicio.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?>" class="btn" style="background-color: #e74c3c; color: white;">Eliminar</a>
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
    $result_servicios->free();
    $result_paquetes->free();
    $conn->close();
    ?>
</body>
</html>
