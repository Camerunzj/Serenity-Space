<!DOCTYPE html>
<html lang="es">
  <!-- Head -->
  <?php include '../templates/head.php'; ?>

  <body>
    <!-- Header -->
    <?php include '../templates/header.php'; ?>

    <!-- Contenido principal -->
    <section class="contact-me">
      <div class="container">
        <h2>Contáctanos</h2>
        <p>En Bienestar y Salud Mental, nos comprometemos a ofrecerte el mejor servicio. Si tienes alguna pregunta o deseas obtener más información, por favor, completa el formulario a continuación.</p>
        <form action="../../includes/process.php" method="POST" onsubmit="return validateForm()">
          <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="message">Mensaje:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
          </div>
          <button type="submit" class="btn-submit">Enviar</button>
        </form>
      </div>
    </section>

    <!-- Footer -->
    <?php include '../templates/footer.php'; ?>

    <!-- JavaScript -->
    <script src="../../public/build/js/script.js"></script>
  </body>
</html>
