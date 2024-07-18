<!DOCTYPE html>
<html lang="es">

<!-- Head -->
<?php include '../templates/head.php'; ?>

<body>

  <!-- Header -->
  <?php include '../templates/header.php'; ?>

  <!-- Contenido principal -->
  <section class="login-section">
    <div class="login-form">
      <h2>Iniciar sesión</h2>
      <form action="#">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required />

        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
      </form>
      <div class="additional-links">
        <a href="./register.php">Registrarse</a> |
        <a href="./forgot_password.php">Olvidé mi contraseña</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include '../templates/footer.php'; ?>

</body>
</html>
