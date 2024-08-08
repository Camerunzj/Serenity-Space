<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql = 'SELECT * FROM Terapeutas';
$result = $conn->query($sql);
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
                <a href="agregar_terapeuta.php" class="button">Agregar Nuevo Terapeuta</a>
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
                                <td><?php echo htmlspecialchars($row['especialidad'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['correo'], ENT_QUOTES); ?></td>
                                <td>
                                    <a href="editar_terapeuta.php?id=<?php echo htmlspecialchars($row['id_terapeuta'], ENT_QUOTES); ?>" class="btn" style="background-color: #013e6a; color: white;">Editar</a>
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
    $conn->close();
    ?>
</body>
</html>
