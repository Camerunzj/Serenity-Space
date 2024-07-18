<!DOCTYPE html>
<html lang="es">
<head>
  <?php include '../templates/head.php'; ?>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

        if (isset($_SESSION['correo'])) {
          $correo = $_SESSION['correo'];

          include '../../database/database.php';

          $sqlCitas = "SELECT * FROM Citas WHERE id_cliente = ?";

          $stmt = $conn->prepare($sqlCitas);
          if (!$stmt) {
            echo '<div class="alert alert-danger">Error al preparar la consulta: ' . $conn->error . '</div>';
          } else {
            $stmt->bind_param("s", $correo);
            $stmt->execute();

            if ($stmt->error) {
              echo '<div class="alert alert-danger">Error en la consulta: ' . $stmt->error . '</div>';
            }

            $resultCitas = $stmt->get_result();

            if ($resultCitas->num_rows > 0) {
              while ($row = $resultCitas->fetch_assoc()) {
                echo '
                <div class="card">
                  <div class="card-body">
                    <p class="card-text"><strong>Fecha y Hora:</strong> ' . htmlspecialchars($row['fecha_hora']) . '</p>
                    <p class="card-text"><strong>Cliente:</strong> ' . htmlspecialchars($row['id_cliente']) . '</p>
                    <p class="card-text"><strong>Terapeuta:</strong> ' . htmlspecialchars($row['id_terapeuta']) . '</p>
                    <p class="card-text"><strong>Tipo de Terapia:</strong> ' . htmlspecialchars($row['id_terapia']) . '</p>
                    <a href="#" class="btn btn-primary">Editar Cita</a>
                  </div>
                </div>';
              }
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
