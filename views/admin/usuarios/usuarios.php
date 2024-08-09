<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql_tipos_usuario = 'SELECT * FROM TipoUsuario';
$result_tipos_usuario = $conn->query($sql_tipos_usuario);

if (!$result_tipos_usuario) {
    echo "Error en la consulta de tipos de usuario: " . $conn->error;
    exit;
}

$selected_tipo_usuario = isset($_GET['tipo_usuario']) ? intval($_GET['tipo_usuario']) : 0;

$sql = 'SELECT u.*, t.nombre AS tipo_usuario_nombre 
        FROM Usuarios u 
        JOIN TipoUsuario t ON u.id_tipo_usuario = t.id_tipo_usuario';

if ($selected_tipo_usuario > 0) {
    $sql .= ' WHERE u.id_tipo_usuario = ' . $selected_tipo_usuario;
}

$sql .= ' ORDER BY u.nombre';

$result = $conn->query($sql);

if (!$result) {
    echo "Error en la consulta SQL: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Usuarios - Serenity Space</title>
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
                <h1 style="color: #333">Usuarios</h1>
                
                <!-- Filtro por Tipo de Usuario -->
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="tipo_usuario">Filtrar por Tipo de Usuario:</label>
                        <select id="tipo_usuario" name="tipo_usuario" class="form-control">
                            <option value="">Todos los Tipos</option>
                            <?php while ($row_tipo_usuario = $result_tipos_usuario->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_tipo_usuario['id_tipo_usuario'], ENT_QUOTES); ?>"
                                    <?php echo $selected_tipo_usuario == $row_tipo_usuario['id_tipo_usuario'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row_tipo_usuario['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter" style="border-color: #2ba8bd; font-weight: bold; box-shadow: none;">Filtrar</button>
                    <a href="agregar_usuario.php" class="button">Agregar Nuevo Usuario</a>
                </form>
                
                <!-- Tabla de Usuarios -->
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID Usuario</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Tipo de Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_usuario'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['correo'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['tipo_usuario_nombre'], ENT_QUOTES); ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?php echo htmlspecialchars($row['id_usuario'], ENT_QUOTES); ?>" class="btn" style="background-color: #2ba8bd; color: white;">Editar</a>
                                    <a href="eliminar_usuario.php?id=<?php echo htmlspecialchars($row['id_usuario'], ENT_QUOTES); ?>" class="btn" style="background-color: #e74c3c; color: white;">Eliminar</a>
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
    $result_tipos_usuario->free();
    $conn->close();
    ?>
</body>
</html>
