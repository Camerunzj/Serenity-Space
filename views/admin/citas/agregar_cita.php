<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$terapeutas = $conn->query('SELECT id_terapeuta, nombre FROM Terapeutas');
$terapias = $conn->query('SELECT id_terapia, nombre FROM Terapias');
$clientes = $conn->query('SELECT id_usuario, nombre FROM Usuarios');
$estados = $conn->query('SELECT id_estado, estado FROM Estado_Cita');

if (!$terapeutas || !$terapias || !$clientes || !$estados) {
    echo "Error al obtener datos para los selects: " . $conn->error;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_hora = $_POST['fecha_hora'];
    $id_terapeuta = $_POST['id_terapeuta'];
    $id_terapia = $_POST['id_terapia'];
    $id_cliente = $_POST['id_cliente'];
    $id_estado = $_POST['id_estado'];

    $sql = "INSERT INTO Citas (fecha_hora, id_terapeuta, id_terapia, id_cliente, id_estado) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiii", $fecha_hora, $id_terapeuta, $id_terapia, $id_cliente, $id_estado);

    if ($stmt->execute()) {
        echo "Cita agregada con éxito.";
        header('Location: citas.php');
        exit;
    } else {
        echo "Error al agregar la cita: " . $stmt->error;
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
    <title>Agregar Cita - Serenity Space</title>
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
                <h1 style="color: #333">Agregar Nueva Cita</h1>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="fecha_hora">Fecha y Hora</label>
                        <input type="datetime-local" id="fecha_hora" name="fecha_hora" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="id_terapeuta">Terapeuta</label>
                        <select id="id_terapeuta" name="id_terapeuta" class="form-control" required>
                            <?php while ($row = $terapeutas->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id_terapeuta'], ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_terapia">Terapia</label>
                        <select id="id_terapia" name="id_terapia" class="form-control" required>
                            <?php while ($row = $terapias->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id_terapia'], ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_cliente">Cliente</label>
                        <select id="id_cliente" name="id_cliente" class="form-control" required>
                            <?php while ($row = $clientes->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id_usuario'], ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_estado">Estado</label>
                        <select id="id_estado" name="id_estado" class="form-control" required>
                            <?php while ($row = $estados->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id_estado'], ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($row['estado'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Agregar Cita</button>
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
