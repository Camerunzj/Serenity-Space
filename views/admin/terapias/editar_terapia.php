<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de terapia no válido.";
    exit;
}

$id_terapia = (int)$_GET['id'];

$sql = "SELECT * FROM Terapias WHERE id_terapia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_terapia);
$stmt->execute();
$result = $stmt->get_result();
$terapia = $result->fetch_assoc();

if (!$terapia) {
    echo "Terapia no encontrada.";
    exit;
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $sql = "UPDATE Terapias SET nombre = ?, descripcion = ?, precio = ? WHERE id_terapia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id_terapia);

    if ($stmt->execute()) {
        echo "Terapia actualizada con éxito.";
        header('Location: terapias.php');
        exit;
    } else {
        echo "Error al actualizar la terapia: " . $stmt->error;
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
    <title>Editar Terapia - Serenity Space</title>
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
                <h1 style="color: #333">Editar Terapia</h1>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($terapia['nombre'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo htmlspecialchars($terapia['descripcion'], ENT_QUOTES); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" class="form-control" step="0.01" value="<?php echo htmlspecialchars($terapia['precio'], ENT_QUOTES); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Terapia</button>
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
