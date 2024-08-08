<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

// Consulta para obtener los usuarios
$sql = 'SELECT u.*, t.nombre AS tipo_usuario_nombre 
        FROM Usuarios u 
        JOIN TipoUsuario t ON u.id_tipo_usuario = t.id_tipo_usuario';

$result = $conn->query($sql);

// Verifica si la consulta tuvo éxito
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
                <a href="agregar_usuario.php" class="button">Agregar Nuevo Usuario</a>
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
                                    <a href="editar_usuario.php?id=<?php echo htmlspecialchars($row['id_usuario'], ENT_QUOTES); ?>" class="btn" style="background-color: #013e6a; color: white;">Editar</a>
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
    $conn->close();
    ?>
</body>
</html>
