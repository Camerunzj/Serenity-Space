<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql_paquetes = 'SELECT * FROM Paquetes';
$result_paquetes = $conn->query($sql_paquetes);

if (!$result_paquetes) {
    echo "Error en la consulta de paquetes: " . $conn->error;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $caracteristicas = $_POST['caracteristicas'] ?? '';
    $id_paquete = $_POST['id_paquete'] ?? 0;

    if (empty($nombre) || empty($descripcion) || empty($caracteristicas) || $id_paquete <= 0) {
        echo "Por favor, complete todos los campos.";
        exit;
    }

    $stmt = $conn->prepare('INSERT INTO Servicios (nombre, descripcion, caracteristicas, id_paquete) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('sssi', $nombre, $descripcion, $caracteristicas, $id_paquete);

    if ($stmt->execute()) {
        echo "Servicio agregado exitosamente.";
        header('Location: servicios.php');
        exit;
    } else {
        echo "Error al agregar el servicio: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar Servicio - Serenity Space</title>
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
                <h1 style="color: #333">Agregar Nuevo Servicio</h1>
                
                <!-- Formulario para Agregar Servicio -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="caracteristicas">Características:</label>
                        <textarea id="caracteristicas" name="caracteristicas" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="id_paquete">Paquete:</label>
                        <select id="id_paquete" name="id_paquete" class="form-control" required>
                            <option value="">Seleccione un Paquete</option>
                            <?php while ($row_paquete = $result_paquetes->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_paquete['id_paquete'], ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($row_paquete['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Agregar Servicio</button>
                    <a href="servicios.php" class="btn btn-danger">Cancelar</a>
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

    <?php $conn->close(); ?>
</body>
</html>
