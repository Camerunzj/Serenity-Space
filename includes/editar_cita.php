<?php
include '../database/database.php';

$id_cita = isset($_GET['id_cita']) ? intval($_GET['id_cita']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_hora = $_POST['fecha_hora'];
    $id_terapeuta = $_POST['id_terapeuta'];
    $id_terapia = $_POST['id_terapia'];

    $sqlUpdate = "UPDATE Citas SET fecha_hora = ?, id_terapeuta = ?, id_terapia = ? WHERE id_cita = ?";

    $stmt = $conn->prepare($sqlUpdate);
    if ($stmt === false) {
        die('Error al preparar la declaración SQL: ' . $conn->error);
    }

    $stmt->bind_param("siii", $fecha_hora, $id_terapeuta, $id_terapia, $id_cita);

    if ($stmt->execute()) {
        header("Location: ../views/paginas/quotes.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error al actualizar la cita: ' . $stmt->error . '</div>';
    }

    $stmt->close();
}

$sqlSelect = "SELECT fecha_hora, id_terapeuta, id_terapia FROM Citas WHERE id_cita = ?";
$stmt = $conn->prepare($sqlSelect);
if ($stmt === false) {
    die('Error al preparar la declaración SQL: ' . $conn->error);
}

$stmt->bind_param("i", $id_cita);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Cita no encontrada.');
}

$cita = $result->fetch_assoc();
$stmt->close();

include '../views/templates/head.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <?php include '../views/templates/header.php'; ?>

  <div class="container mt-4">
    <div class="card">
      <div class="card-header" style="background-color: #16292D; color: white;">
        <h2 class="mb-0">Editar Cita</h2>
      </div>
      <div class="card-body">
        <form action="editar_cita.php?id_cita=<?php echo $id_cita; ?>" method="POST">
          <div class="form-group">
            <label for="fecha_hora">Fecha y Hora</label>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora" class="form-control" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($cita['fecha_hora']))); ?>" required>
          </div>
          <div class="form-group">
            <label for="id_terapeuta">Terapeuta</label>
            <select id="id_terapeuta" name="id_terapeuta" class="form-control" required>
              <?php
              $sqlTerapeutas = "SELECT id_terapeuta, nombre FROM Terapeutas";
              $resultTerapeutas = $conn->query($sqlTerapeutas);

              while ($terapeuta = $resultTerapeutas->fetch_assoc()) {
                $selected = ($terapeuta['id_terapeuta'] == $cita['id_terapeuta']) ? 'selected' : '';
                echo '<option value="' . $terapeuta['id_terapeuta'] . '" ' . $selected . '>' . htmlspecialchars($terapeuta['nombre']) . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="id_terapia">Tipo de Terapia</label>
            <select id="id_terapia" name="id_terapia" class="form-control" required>
              <?php
              $sqlTerapias = "SELECT id_terapia, nombre FROM Terapias";
              $resultTerapias = $conn->query($sqlTerapias);

              while ($terapia = $resultTerapias->fetch_assoc()) {
                $selected = ($terapia['id_terapia'] == $cita['id_terapia']) ? 'selected' : '';
                echo '<option value="' . $terapia['id_terapia'] . '" ' . $selected . '>' . htmlspecialchars($terapia['nombre']) . '</option>';
              }
              ?>
            </select>
          </div>
          <button type="submit" class="btn" style="background-color: #2ba8bd; color: white;">Actualizar Cita</button>
          <a href="quotes.php" class="btn btn-danger">Cancelar</a>
        </form>
      </div>
    </div>
  </div>

  <?php include '../views/templates/footer.php'; ?>

</body>
</html>

<?php
$conn->close();
?>
