<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$especialidad_filtro = isset($_GET['especialidad']) ? $_GET['especialidad'] : '';

$sql = 'SELECT t.*, e.nombre AS especialidad_nombre 
        FROM Terapeutas t 
        LEFT JOIN Especialidades e ON t.id_especialidad = e.id_especialidad';

if ($especialidad_filtro) {
    $sql .= ' WHERE e.nombre = ?';
}

$sql .= ' ORDER BY t.nombre ASC';

$stmt = $conn->prepare($sql);

if ($especialidad_filtro) {
    $stmt->bind_param('s', $especialidad_filtro);
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo '<div class="alert alert-danger">Error en la consulta: ' . $conn->error . '</div>';
    exit;
}

$sql_especialidades = 'SELECT DISTINCT e.nombre FROM Especialidades e';
$result_especialidades = $conn->query($sql_especialidades);

if (!$result_especialidades) {
    echo '<div class="alert alert-danger">Error al obtener las especialidades: ' . $conn->error . '</div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Terapeutas - Serenity Space</title>
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
                <h1 style="color: #333">Terapeutas</h1>
                
                <!-- Filtro por Especialidad -->
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="especialidad">Filtrar por Especialidad:</label>
                        <select id="especialidad" name="especialidad" class="form-control">
                            <option value="">Todas las Especialidades</option>
                            <?php while ($row_especialidad = $result_especialidades->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_especialidad['nombre'], ENT_QUOTES); ?>"
                                    <?php echo $especialidad_filtro === $row_especialidad['nombre'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row_especialidad['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter" style="border-color: #2ba8bd; font-weight: bold; box-shadow: none;">Filtrar</button>
                    <a href="agregar_terapeuta.php" class="button">Agregar Nuevo Terapeuta</a>
                </form>
                
                <!-- Tabla de Terapeutas -->
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID Terapeuta</th>
                            <th>Nombre</th>
                            <th>Especialidad</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_terapeuta'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['especialidad_nombre'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['correo'], ENT_QUOTES); ?></td>
                                <td>
                                    <a href="editar_terapeuta.php?id=<?php echo htmlspecialchars($row['id_terapeuta'], ENT_QUOTES); ?>" class="btn" style="background-color: #2ba8bd; color: white;">Editar</a>
                                    <a href="eliminar_terapeuta.php?id=<?php echo htmlspecialchars($row['id_terapeuta'], ENT_QUOTES); ?>" class="btn" style="background-color: #e74c3c; color: white;">Eliminar</a>
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
    $result_especialidades->free();
    $conn->close();
    ?>
</body>
</html>
