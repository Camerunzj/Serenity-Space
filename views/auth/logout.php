<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Head -->
  <?php include '../templates/head.php'; ?>
  <link rel="stylesheet" href="../public/build/css/styles.css">
</head>

<body>
  <!-- Header -->
  <?php include '../templates/header.php'; ?>

  <!-- Contenido principal -->
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Cierre de sesión exitoso</h2>
            <p class="card-text text-center">¡Has cerrado sesión correctamente!</p>
            <div class="text-center mt-4">
              <a href="../../public/index.php" class="btn btn-primary btn-lg">Volver al inicio</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include '../templates/footer.php'; ?>
</body>
</html>
