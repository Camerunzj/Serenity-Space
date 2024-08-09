<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql = 'SELECT * FROM Paquetes';
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Paquetes - Serenity Space</title>
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
                <h1 style="color: #333">Paquetes</h1>
                <a href="agregar_paquete.php" class="button">Agregar Nuevo Paquete</a>
                <a href="detalles_paquetes/detalles_paquetes.php" class="button">Gestionar Detalles Paquetes</a>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID Paquete</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_paquete'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['precio'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['descripcion'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha_creacion'], ENT_QUOTES); ?></td>
                                <td>
                                    <a href="editar_paquete.php?id=<?php echo htmlspecialchars($row['id_paquete'], ENT_QUOTES); ?>" class="btn" style="background-color: #2ba8bd; color: white;">Editar</a>
                                    <a href="eliminar_paquete.php?id=<?php echo htmlspecialchars($row['id_paquete'], ENT_QUOTES); ?>" class="btn" style="background-color: #e74c3c; color: white;">Eliminar</a>
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
