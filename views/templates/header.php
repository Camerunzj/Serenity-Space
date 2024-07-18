<?php
session_start();
$loggedIn = isset($_SESSION['correo']);
?>

<header class="navbar">
  <a href="../../public/index.php">
    <img src="../../public/build/img/logo.png" alt="Logo" />
  </a>
  <nav class="menu">
    <a href="../../public/index.php">Inicio</a>
    <a href="../../views/paginas/services.php">Servicios</a>
    <a href="../../views/paginas/prices.php">Precios</a>
    <?php if ($loggedIn): ?>
      <a href="../../views/paginas/quotes.php">Citas</a>
      <a href="../../views/auth/logout.php" class="btn-login">Cerrar sesión</a>
    <?php else: ?>
      <a href="../../views/auth/login.php" class="btn-login">Iniciar sesión</a>
    <?php endif; ?>
    <a href="../../views/paginas/contact_me.php" class="btn-contact" style="background-color: #19a4bf">Contáctenos</a>
  </nav>
</header>
