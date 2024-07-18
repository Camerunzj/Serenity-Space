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
        <h2>Recuperar Contraseña</h2>
        <form action="#">
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

          <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <div class="additional-links">
          <a href="./login.php">Iniciar sesión</a> |
          <a href="./register.php">Registro</a>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php include '../templates/footer.php'; ?>
    
  </body>
</html>
