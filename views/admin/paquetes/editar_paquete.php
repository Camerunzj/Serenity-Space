<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de paquete no válido.";
    exit;
}

$id_paquete = (int)$_GET['id'];

$sql = "SELECT * FROM Paquetes WHERE id_paquete = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_paquete);
$stmt->execute();
$result = $stmt->get_result();
$paquete = $result->fetch_assoc();

if (!$paquete) {
    echo "Paquete no encontrado.";
    exit;
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE Paquetes SET nombre = ?, precio = ?, descripcion = ? WHERE id_paquete = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $nombre, $precio, $descripcion, $id_paquete);

    if ($stmt->execute()) {
        echo "Paquete actualizado con éxito.";
        header('Location: paquetes.php');
        exit;
    } else {
        echo "Error al actualizar el paquete: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Paquete - Serenity Space</title>
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
                <h1 style="color: #333">Editar Paquete</h1>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($paquete['nombre'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" class="form-control" value="<?php echo htmlspecialchars($paquete['precio'], ENT_QUOTES); ?>" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="5" required><?php echo htmlspecialchars($paquete['descripcion'], ENT_QUOTES); ?></textarea>
                    </div>
                    <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Actualizar Paquete</button>
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
</body>
</html>
