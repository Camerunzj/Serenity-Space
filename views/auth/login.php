<?php
include '../../database/database.php';

$errorLogin = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $contrasena = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT id_usuario, contrasena, id_tipo_usuario FROM Usuarios WHERE correo = ?");
        
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración SQL: ' . $conn->error);
        }

        $stmt->bind_param("s", $correo);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id_usuario, $hashed_password, $id_tipo_usuario);
                $stmt->fetch();
                
                if (password_verify($contrasena, $hashed_password)) {
                    session_start();
                    $_SESSION['correo'] = $correo;
                    $_SESSION['id_usuario'] = $id_usuario;
                    $_SESSION['id_tipo_usuario'] = $id_tipo_usuario; 

                    header("Location: ../../public/index.php");
                    exit();
                } else {
                    $errorLogin = true;
                }
            } else {
                $errorLogin = true;
            }
        } else {
            throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
        }

        $stmt->close();
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include '../templates/head.php'; ?>
</head>
<body>

    <?php include '../templates/header.php'; ?>

    <section class="login-section">
      <div class="login-form">
        <h2>Iniciar Sesión</h2>
        <?php if ($errorLogin): ?>
        <div class="alert alert-danger" role="alert">
          Correo o contraseña incorrectos.
        </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
          <label for="email">Correo electrónico:</label>
          <input type="email" id="email" name="email" required />
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required />
          <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        <div class="additional-links">
          <a href="./register.php">Registrarse</a> |
          <a href="./forgot_password.php">Olvidé mi contraseña</a>
        </div>
      </div>
    </section>

    <?php include '../templates/footer.php'; ?>
    
</body>
</html>
