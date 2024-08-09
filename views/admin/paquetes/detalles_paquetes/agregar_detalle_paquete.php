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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_paquete = $_POST['id_paquete'];
    $detalle = $_POST['detalle'];

    if (empty($id_paquete) || empty($detalle)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conn->prepare('INSERT INTO Detalles_Paquete (id_paquete, detalle) VALUES (?, ?)');
        $stmt->bind_param('is', $id_paquete, $detalle);

        if ($stmt->execute()) {
            header('Location: detalles_paquetes.php');
            exit;
        } else {
            $error = "Error al agregar el detalle: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar Detalle de Paquete - Serenity Space</title>
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
                <h1 style="color: #333">Agregar Nuevo Detalle de Paquete</h1>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></div>
                <?php endif; ?>
                <form method="post" action="agregar_detalle_paquete.php">
                    <div class="form-group">
                        <label for="id_paquete">Paquete</label>
                        <select id="id_paquete" name="id_paquete" class="form-control" required>
                            <option value="">Selecciona un paquete</option>
                            <?php while ($row_paquete = $result_paquetes->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_paquete['id_paquete'], ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($row_paquete['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="detalle">Detalle</label>
                        <input type="text" id="detalle" name="detalle" class="form-control" required>
                    </div>
                    <button type="submit" class="btn"  style="background-color: #2ba8bd; color: white;">Agregar Detalle</button>
                    <a href="detalles_paquetes.php" class="btn btn-danger">Cancelar</a>
                </form>
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
    $conn->close();
    ?>
</body>
</html>
