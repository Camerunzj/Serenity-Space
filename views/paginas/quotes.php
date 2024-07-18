<!DOCTYPE html>
<html lang="es">
<head>
  <?php include '../templates/head.php'; ?>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- La funcionalidad casi esta lo que queda pendiente es el sistema de inicio de sesion para 
que solo se muestren las citas del usuario logueado pero ya se muestran las citas que hay en la base de datos  -->

  <?php include '../templates/header.php'; ?>

  <div class="container mt-4">
    <div class="card">
      <div class="card-header" style="background-color: #23A6BE; color: white;">
        <h2 class="mb-0">Citas Agendadas</h2>
      </div>
      <div class="card-body">
        <a href="agenda_cita.php" class="btn btn-primary mb-3" style="background-color: #23A6BE; border-color: #23A6BE;">Agendar Cita</a>
        <?php
        include '../../database/database.php';

        $sqlCitas = "SELECT * FROM Citas";
        $resultCitas = mysqli_query($conn, $sqlCitas);

        if ($resultCitas && mysqli_num_rows($resultCitas) > 0) {
          while ($row = mysqli_fetch_assoc($resultCitas)) {
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
          mysqli_free_result($resultCitas);
        } else {
          echo '<div class="alert alert-info">No hay citas agendadas.</div>';
        }

        mysqli_close($conn);
        ?>
      </div>
    </div>
  </div>

  <?php include '../templates/footer.php'; ?>

</body>
</html>
