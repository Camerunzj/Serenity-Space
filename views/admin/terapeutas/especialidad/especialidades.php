<?php
include '../../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql = 'SELECT * FROM Especialidades';
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
    <title>Especialidades - Serenity Space</title>
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
            <a href="../dashboard.php" class="header_link">
                <h1>Serenity Space</h1>
            </a>
        </header>

        <!-- Main Content -->
        <section class="options_area">
            <div class="container mt-5">
                <h1 style="color: #333">Especialidades</h1>
                <a href="agregar_especialidad.php" class="btn" style="background-color: #2ba8bd; color: white;">Agregar Nueva Especialidad</a>
                <a href="../terapeutas.php" class="btn btn-danger">Regresar</a>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID Especialidad</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_especialidad'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?></td>
                                <td>
                                    <a href="editar_especialidad.php?id=<?php echo htmlspecialchars($row['id_especialidad'], ENT_QUOTES); ?>" class="btn" style="background-color: #2ba8bd; color: white;">Editar</a>
                                    <a href="eliminar_especialidad.php?id=<?php echo htmlspecialchars($row['id_especialidad'], ENT_QUOTES); ?>" class="btn" style="background-color: #e74c3c; color: white;">Eliminar</a>
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
