<!DOCTYPE html>
<html lang="es">
<head>
  <?php include '../templates/head.php'; ?>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../public/build/css/styles.css" />
  <style>
    .card-custom {
      width: 100%;
      max-width: 18rem; /* Ajusta el ancho máximo del card */
    }
  </style>
</head>
<body>

  <?php include '../templates/header.php'; ?>

  <div class="container mt-4">
    <div class="card">
      <div class="card-header" style="background-color: #16292D; color: white;">
        <h2 class="mb-0">Citas Agendadas</h2>
      </div>
      <div class="card-body">
        <a href="agenda_cita.php" class="btn btn-primary mb-3" style="background-color: #23A6BE; border-color: #23A6BE;">Agendar Cita</a>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['id_usuario'])) {
          $id_usuario = $_SESSION['id_usuario'];

          include '../../database/database.php';

          $sqlCitas = "SELECT c.id_cita, c.fecha_hora, te.nombre AS nombre_terapeuta, t.nombre AS nombre_terapia
              FROM Citas c
              JOIN Terapias t ON c.id_terapia = t.id_terapia
              JOIN Terapeutas te ON c.id_terapeuta = te.id_terapeuta
              WHERE c.id_cliente = ? AND c.id_estado != 2";

          $stmt = $conn->prepare($sqlCitas);
          if (!$stmt) {
            echo '<div class="alert alert-danger">Error al preparar la consulta: ' . $conn->error . '</div>';
          } else {
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();

            if ($stmt->error) {
              echo '<div class="alert alert-danger">Error en la consulta: ' . $stmt->error . '</div>';
            }

            $resultCitas = $stmt->get_result();

            if ($resultCitas->num_rows > 0) {
              echo '<div class="row">';
              while ($row = $resultCitas->fetch_assoc()) {
                echo '
                <div class="col-md-4 mb-3">
                  <div class="card card-custom">
                    <div class="card-body">
                      <p class="card-text"><strong>Fecha y Hora:</strong> ' . htmlspecialchars($row['fecha_hora']) . '</p>
                      <p class="card-text"><strong>Terapeuta:</strong> ' . htmlspecialchars($row['nombre_terapeuta']) . '</p>
                      <p class="card-text"><strong>Tipo de Terapia:</strong> ' . htmlspecialchars($row['nombre_terapia']) . '</p>
                      <a href="../../includes/editar_cita.php?id_cita=' . htmlspecialchars($row['id_cita']) . '" class="btn btn-primary">Editar Cita</a>
                      <a href="../../includes/cancelar_cita.php?id_cita=' . htmlspecialchars($row['id_cita']) . '" class="btn btn-danger">Cancelar Cita</a>
                    </div>
                  </div>
                </div>';
              }
              echo '</div>';
            } else {
              echo '<div class="alert alert-info">No hay citas agendadas para este usuario.</div>';
            }

            $stmt->close();
          }

          mysqli_close($conn);
        } else {
          echo '<div class="alert alert-danger">Debe iniciar sesión para ver sus citas.</div>';
        }
        ?>
      </div>
    </div>
  </div>

  <?php include '../templates/footer.php'; ?>

</body>
</html>
