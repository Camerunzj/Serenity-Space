<?php
include '../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$sql_servicios = 'SELECT s.id, s.nombre, s.descripcion, s.caracteristicas, p.nombre AS paquete
                  FROM Servicios s
                  JOIN Paquetes p ON s.id_paquete = p.id_paquete';
$result_servicios = $conn->query($sql_servicios);

if (!$result_servicios) {
    echo '<div class="alert alert-danger">Error en la consulta: ' . $conn->error . '</div>';
    exit;
}

$servicios = [];
while ($row = $result_servicios->fetch_assoc()) {
    $servicios[] = $row;
}

$conn->close();

function getPaqueteColor($nombre_paquete) {
    $colors = [
        'Paquete Inicial' => '#19A4BF',
        'Paquete Profesional' => '#14292D',
        'Paquete Premium' => '#D3ADA7'
    ];
    return $colors[$nombre_paquete] ?? '#19A4BF'; 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <?php include '../templates/head.php'; ?>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include '../templates/header.php'; ?>

  <header class="mini-header2">
    <div class="mini-header-content">
      <h1>Servicios</h1>
    </div>
  </header>

  <!-- Servicios -->
  <section class="services container mt-5">
    <div class="row">
      <?php foreach ($servicios as $servicio): ?>
        <div class="col-lg-4 mb-4">
          <div class="card h-100 shadow">
            <div class="card-header" style="background-color: <?php echo getPaqueteColor($servicio['paquete']); ?>;">
              <h2 class="card-title mb-0" style="color: white;"><?php echo htmlspecialchars($servicio['nombre'], ENT_QUOTES); ?></h2>
            </div>
            <div class="card-body">
              <p class="card-text"><?php echo htmlspecialchars($servicio['descripcion'], ENT_QUOTES); ?></p>
              <ul class="list-unstyled">
                <?php
                $caracteristicas = explode(',', $servicio['caracteristicas']);
                foreach ($caracteristicas as $caracteristica):
                ?>
                  <li><?php echo htmlspecialchars(trim($caracteristica), ENT_QUOTES); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="card-footer">
              <p class="mb-0">Paquete: <?php echo htmlspecialchars($servicio['paquete'], ENT_QUOTES); ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <?php include '../templates/footer.php'; ?>
</body>
</html>
