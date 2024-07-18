<?php
include '../../database/database.php';

$registroExitoso = false;
$errorCorreoEnUso = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['fullname'];
    $correo = $_POST['email'];
    $contrasena = password_hash($_POST['password'], PASSWORD_BCRYPT); 

    try {
        $stmt = $conn->prepare("INSERT INTO Usuarios (nombre, correo, contrasena, tipo_usuario) VALUES (?, ?, ?, 'usuario')");
        
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración SQL: ' . $conn->error);
        }

        $stmt->bind_param("sss", $nombre, $correo, $contrasena);
        if ($stmt->execute()) {
            $registroExitoso = true;
        } else {
            if ($conn->errno == 1062) {
                $errorCorreoEnUso = true;
            } else {
                throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
            }
        }

        $stmt->close();
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

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
        <?php if ($registroExitoso): ?>
        <div class="alert alert-success" role="alert">
          Registro exitoso.
          <a href="login.php" class="alert-link">Iniciar sesión</a>
        </div>
        <?php elseif ($errorCorreoEnUso): ?>
        <div class="alert alert-danger" role="alert">
          Correo en uso, prueba con otro.
        </div>
        <?php endif; ?>
        <form action="register.php" method="POST">
          <label for="fullname">Nombre completo:</label>
          <input type="text" id="fullname" name="fullname" required />
          <label for="email">Correo electrónico:</label>
          <input type="email" id="email" name="email" required />
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
