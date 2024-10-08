<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';

$sql = 'SELECT c.id_cita, c.fecha_hora, te.nombre AS nombre_terapeuta, t.nombre AS nombre_terapia, cl.nombre AS nombre_cliente, ec.estado AS estado_cita
        FROM Citas c
        JOIN Terapias t ON c.id_terapia = t.id_terapia
        JOIN Terapeutas te ON c.id_terapeuta = te.id_terapeuta
        JOIN Usuarios cl ON c.id_cliente = cl.id_usuario
        JOIN Estado_Cita ec ON c.id_estado = ec.id_estado';

if ($estado_filtro === 'activa' || $estado_filtro === 'no_activa') {
    $estado_filtro = $estado_filtro === 'activa' ? 'Activa' : 'No Activa';
    $sql .= ' WHERE ec.estado = "' . $estado_filtro . '"';
}

$sql .= ' ORDER BY c.fecha_hora DESC';

$result = $conn->query($sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error en la consulta: ' . $conn->error . '</div>';
    exit;
}

$sql_estados = 'SELECT DISTINCT ec.estado FROM Estado_Cita ec';
$result_estados = $conn->query($sql_estados);

if (!$result_estados) {
    echo '<div class="alert alert-danger">Error al obtener los estados: ' . $conn->error . '</div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Citas - Serenity Space</title>
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
                <h1 style="color: #333">Citas Agendadas</h1>
                
                <!-- Filtro por Estado -->
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="estado">Filtrar por Estado:</label>
                        <select id="estado" name="estado" class="form-control">
                            <option value="">Todos los Estados</option>
                            <?php while ($row_estado = $result_estados->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_estado['estado'], ENT_QUOTES); ?>"
                                    <?php echo $estado_filtro === $row_estado['estado'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row_estado['estado'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter" style="border-color: #2ba8bd; font-weight: bold; box-shadow: none;">Filtrar</button>
                    <a href="agregar_cita.php" class="button">Agregar Nueva Cita</a>
                </form>
                
                <!-- Tabla de Citas -->
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID Cita</th>
                            <th>Fecha y Hora</th>
                            <th>Terapeuta</th>
                            <th>Tipo de Terapia</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_cita'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha_hora'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre_terapeuta'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre_terapia'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre_cliente'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['estado_cita'], ENT_QUOTES); ?></td>
                                <td>
                                    <a href="editar_cita.php?id=<?php echo htmlspecialchars($row['id_cita'], ENT_QUOTES); ?>" class="btn" style="background-color: #2ba8bd; color: white;">Editar</a>
                                    <a href="eliminar_cita.php?id=<?php echo htmlspecialchars($row['id_cita'], ENT_QUOTES); ?>" class="btn" style="background-color: #e74c3c; color: white;">Eliminar</a>
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
    $result->free();
    $result_estados->free();
    $conn->close();
    ?>
</body>
</html>
