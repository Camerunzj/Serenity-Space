<?php
include '../../../database/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de cita no proporcionado.";
    exit;
}

$id_cita = intval($_GET['id']);

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql = 'SELECT c.id_cita, c.fecha_hora, c.id_terapia, c.id_terapeuta, c.id_cliente, c.id_estado,
        t.nombre AS nombre_terapia, te.nombre AS nombre_terapeuta, cl.nombre AS nombre_cliente, ec.estado AS estado_cita
        FROM Citas c
        JOIN Terapias t ON c.id_terapia = t.id_terapia
        JOIN Terapeutas te ON c.id_terapeuta = te.id_terapeuta
        JOIN Usuarios cl ON c.id_cliente = cl.id_usuario
        JOIN Estado_Cita ec ON c.id_estado = ec.id_estado
        WHERE c.id_cita = ?';

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_cita);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No se encontró la cita.";
    exit;
}

$cita = $result->fetch_assoc();

$therapiesQuery = 'SELECT id_terapia, nombre FROM Terapias';
$therapistsQuery = 'SELECT id_terapeuta, nombre FROM Terapeutas';
$clientsQuery = 'SELECT id_usuario, nombre FROM Usuarios';
$statesQuery = 'SELECT id_estado, estado FROM Estado_Cita';

$therapies = $conn->query($therapiesQuery);
$therapists = $conn->query($therapistsQuery);
$clients = $conn->query($clientsQuery);
$states = $conn->query($statesQuery);

if (!$therapies || !$therapists || !$clients || !$states) {
    echo "Error al recuperar las opciones: " . $conn->error;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha_hora = $_POST['fecha_hora'];
    $id_terapia = intval($_POST['id_terapia']);
    $id_terapeuta = intval($_POST['id_terapeuta']);
    $id_cliente = intval($_POST['id_cliente']);
    $id_estado = intval($_POST['id_estado']);

    $updateSql = 'UPDATE Citas SET fecha_hora = ?, id_terapia = ?, id_terapeuta = ?, id_cliente = ?, id_estado = ? WHERE id_cita = ?';
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param('siiiii', $fecha_hora, $id_terapia, $id_terapeuta, $id_cliente, $id_estado, $id_cita);

    if ($updateStmt->execute()) {
        header('Location: citas.php');
        exit;
    } else {
        echo "Error al actualizar la cita: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Cita - Serenity Space</title>
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
                <h1 style="color: #333">Editar Cita</h1>
                <form action="editar_cita.php?id=<?php echo htmlspecialchars($id_cita, ENT_QUOTES); ?>" method="post">
                    <div class="form-group">
                        <label for="fecha_hora">Fecha y Hora</label>
                        <input type="datetime-local" id="fecha_hora" name="fecha_hora" class="form-control" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($cita['fecha_hora'])), ENT_QUOTES); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_terapia">Tipo de Terapia</label>
                        <select id="id_terapia" name="id_terapia" class="form-control" required>
                            <?php while ($row = $therapies->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id_terapia'], ENT_QUOTES); ?>" <?php echo $row['id_terapia'] == $cita['id_terapia'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_terapeuta">Terapeuta</label>
                        <select id="id_terapeuta" name="id_terapeuta" class="form-control" required>
                            <?php while ($row = $therapists->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id_terapeuta'], ENT_QUOTES); ?>" <?php echo $row['id_terapeuta'] == $cita['id_terapeuta'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_cliente">Cliente</label>
                        <select id="id_cliente" name="id_cliente" class="form-control" required>
                            <?php while ($row = $clients->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id_usuario'], ENT_QUOTES); ?>" <?php echo $row['id_usuario'] == $cita['id_cliente'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_estado">Estado</label>
                        <select id="id_estado" name="id_estado" class="form-control" required>
                            <?php while ($row = $states->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['id_estado'], ENT_QUOTES); ?>" <?php echo $row['id_estado'] == $cita['id_estado'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($row['estado'], ENT_QUOTES); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Actualizar</button>
                    <a href="citas.php" class="btn btn-secondary">Cancelar</a>
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
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
