<?php
include '../../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de especialidad no válido.";
    exit;
}

$id_especialidad = (int)$_GET['id'];

$sql = "SELECT * FROM Especialidades WHERE id_especialidad = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_especialidad);
$stmt->execute();
$result = $stmt->get_result();
$especialidad = $result->fetch_assoc();

if (!$especialidad) {
    echo "Especialidad no encontrada.";
    exit;
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    if (empty($nombre)) {
        $message = "El campo nombre es obligatorio.";
    } else {
        $sql = "UPDATE Especialidades SET nombre = ? WHERE id_especialidad = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id_especialidad);

        if ($stmt->execute()) {
            $message = "Especialidad actualizada con éxito.";
            header('Location: especialidades.php');
            exit;
        } else {
            $message = "Error al actualizar la especialidad: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Especialidad - Serenity Space</title>
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
                <h1 style="color: #333">Editar Especialidad</h1>
                <?php if (isset($message)): ?>
                    <div class="alert <?php echo strpos($message, 'éxito') !== false ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo htmlspecialchars($message, ENT_QUOTES); ?>
                    </div>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($especialidad['nombre'], ENT_QUOTES); ?>" required>
                    </div>
                    <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Actualizar Especialidad</button>
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
