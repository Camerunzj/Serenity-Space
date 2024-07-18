<!DOCTYPE html>
<html lang="es">

<?php include '../templates/head.php'; ?>

<body>

  <?php include '../templates/header.php'; ?>

  <div class="container mt-4 mb-4">
    <div class="card">
      <div class="card-header" style="background-color: #16292D; color: white;">
        <h2 class="mb-0">Agendar Cita</h2>
      </div>
      <div class="card-body">
        <form action="../../includes/guardar_cita.php" method="POST">
          <div class="form-group">
          <label for="id_cliente">Cliente:</label>
          <select id="id_cliente" name="id_cliente" class="form-control" required>
            <?php
            include '../../database/database.php';

            if (isset($_SESSION['correo'])) {
              $correo = $_SESSION['correo'];
              $sqlClienteLogueado = "SELECT id_usuario, nombre FROM Usuarios WHERE correo = ?";
              
              $stmt = $conn->prepare($sqlClienteLogueado);
              $stmt->bind_param("s", $correo);
              $stmt->execute();
              $resultClienteLogueado = $stmt->get_result();

              if ($resultClienteLogueado->num_rows > 0) {
                while ($row = $resultClienteLogueado->fetch_assoc()) {
                  echo '<option value="' . $row['id_usuario'] . '">' . $row['nombre'] . '</option>';
                }
              } else {
                echo '<option value="">No se encontró al cliente logueado</option>';
              }

              $stmt->close();
            } else {
              echo '<option value="">No se ha iniciado sesión</option>';
            }

            mysqli_close($conn);
            ?>
          </select>
          </div>
          <div class="form-group">
            <label for="id_terapeuta">Terapeuta:</label>
            <select id="id_terapeuta" name="id_terapeuta" class="form-control" required>
              <?php
              include '../../database/database.php';

              $sqlTerapeutas = "SELECT id_terapeuta, nombre FROM Terapeutas";
              $resultTerapeutas = mysqli_query($conn, $sqlTerapeutas);

              if ($resultTerapeutas && mysqli_num_rows($resultTerapeutas) > 0) {
                while ($row = mysqli_fetch_assoc($resultTerapeutas)) {
                  echo '<option value="' . $row['id_terapeuta'] . '">' . $row['nombre'] . '</option>';
                }
              } else {
                echo '<option value="">No hay terapeutas disponibles</option>';
              }

              mysqli_free_result($resultTerapeutas);
              mysqli_close($conn);
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="fecha_hora">Fecha y Hora:</label>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="id_terapia">Tipo de Terapia:</label>
            <select id="id_terapia" name="id_terapia" class="form-control" required>
              <?php
              include '../../database/database.php';

              $sqlTerapias = "SELECT id_terapia, nombre FROM Terapias";
              $resultTerapias = mysqli_query($conn, $sqlTerapias);

              if ($resultTerapias && mysqli_num_rows($resultTerapias) > 0) {
                while ($row = mysqli_fetch_assoc($resultTerapias)) {
                  echo '<option value="' . $row['id_terapia'] . '">' . $row['nombre'] . '</option>';
                }
              } else {
                echo '<option value="">No hay terapias disponibles</option>';
              }

              mysqli_free_result($resultTerapias);
              mysqli_close($conn);
              ?>
            </select>
          </div>
          <button id="save-event" type="submit" class="btn btn-primary" style="background-color: #23A6BE; border-color: #23A6BE;">Agendar Cita</button>
        </form>
      </div>
    </div>
  </div>

  <?php include '../templates/footer.php'; ?>
</body>
</html>
