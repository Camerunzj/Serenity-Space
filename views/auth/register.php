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
        <h2>Registro</h2>
        <form action="#">
          <label for="fullname">Nombre completo:</label>
          <input type="text" id="fullname" name="fullname" required />

          <label for="email">Correo electrónico:</label>
          <input
            type="email"
            id="email"
            name="email"
            required
            style="
              padding: 10px;
              margin-bottom: 15px;
              border: 1px solid #ccc;
              border-radius: 3px;
              font-size: 16px;
              width: 100%;
              box-sizing: border-box;
            "
          />

          <label for="username">Usuario:</label>
          <input type="text" id="username" name="username" required />

          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required />

          <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        <div class="additional-links">
          <a href="./login.php">Iniciar sesión</a> |
          <a href="./forgot_password.php">Olvidé mi contraseña</a>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php include '../templates/footer.php'; ?>
    
  </body>
</html>
