<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hash de la contraseña
    $id_tipo_usuario = $_POST['tipo_usuario'];

    // Preparar la consulta SQL para insertar datos
    $sql = "INSERT INTO Usuarios (nombre, correo, contrasena, tipo_usuario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $correo, $contrasena, $id_tipo_usuario);

    if ($stmt->execute()) {
        $message = "Usuario agregado exitosamente.";
    } else {
        $message = "Error al agregar el usuario: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener tipos de usuario
$sql_tipo_usuario = 'SELECT * FROM TipoUsuario';
$result_tipo_usuario = $conn->query($sql_tipo_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agregar Usuario - Serenity Space</title>
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
                <h1 style="color: #333">Agregar Nuevo Usuario</h1>
                <?php if ($message): ?>
                    <div class="alert <?php echo strpos($message, 'exitosamente') !== false ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo htmlspecialchars($message, ENT_QUOTES); ?>
                    </div>
                <?php endif; ?>
                <form action="agregar_usuario.php" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_usuario">Tipo de Usuario</label>
                        <select id="tipo_usuario" name="tipo_usuario" class="form-control" required>
                            <?php while ($row_tipo_usuario = $result_tipo_usuario->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row_tipo_usuario['id_tipo_usuario'], ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($row_tipo_usuario['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn" style="background-color: #013e6a; color: white;">Agregar Usuario</button>
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
    $result_tipo_usuario->free();
    $conn->close();
    ?>
</body>
</html>
