<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de terapeuta no válido.";
    exit;
}

$id_terapeuta = (int)$_GET['id'];

$sql = "SELECT * FROM Terapeutas WHERE id_terapeuta = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_terapeuta);
$stmt->execute();
$result = $stmt->get_result();
$terapeuta = $result->fetch_assoc();

if (!$terapeuta) {
    echo "Terapeuta no encontrado.";
    exit;
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $especialidad = $_POST['especialidad'];
    $correo = $_POST['correo'];

    $sql = "UPDATE Terapeutas SET nombre = ?, especialidad = ?, correo = ? WHERE id_terapeuta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $especialidad, $correo, $id_terapeuta);

    if ($stmt->execute()) {
        echo "Terapeuta actualizado con éxito.";
        header('Location: terapeutas.php');
        exit;
    } else {
        echo "Error al actualizar el terapeuta: " . $stmt->error;
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
    <title>Editar Terapeuta - Serenity Space</title>
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
                <h1 style="color: #333">Editar Terapeuta</h1>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($terapeuta['nombre'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="especialidad">Especialidad</label>
                        <input type="text" id="especialidad" name="especialidad" class="form-control" value="<?php echo htmlspecialchars($terapeuta['especialidad'], ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" class="form-control" value="<?php echo htmlspecialchars($terapeuta['correo'], ENT_QUOTES); ?>" required>
                    </div>
                    <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Actualizar Terapeuta</button>
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
