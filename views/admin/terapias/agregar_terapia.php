<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO Terapias (nombre, descripcion, precio) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $nombre, $descripcion, $precio);

    if ($stmt->execute()) {
        $message = "Terapia agregada exitosamente.";
    } else {
        $message = "Error al agregar la terapia: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar Terapia - Serenity Space</title>
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
                <h1 style="color: #333">Agregar Nueva Terapia</h1>
                <?php if (isset($message)): ?>
                    <div class="alert <?php echo strpos($message, 'exitosamente') !== false ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo htmlspecialchars($message, ENT_QUOTES); ?>
                    </div>
                <?php endif; ?>
                <form action="agregar_terapia.php" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
                    </div>
                    <button type="submit" class="btn" style="background-color: #013e6a; color: white;">Agregar Terapia</button>
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
    $conn->close();
    ?>
</body>
</html>
