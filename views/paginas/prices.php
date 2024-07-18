<!DOCTYPE html>
<html lang="es">
  <!-- Head -->
  <?php include '../templates/head.php'; ?>

  <body>
    <!-- Header -->
    <?php include '../templates/header.php'; ?>

    <!-- Mini Header -->
    <section class="mini-header">
      <h2>Precios</h2>
    </section>

    <!-- Contenido principal -->
    <section class="pricing-table">
      <div class="pricing-table-item">
        <div class="pricing-table-item-header" style="background-color: #19A4BF;">
          <h3>Paquete Inicial</h3>
        </div>
        <div class="pricing-table-item-price">
          <p><span class="price-big">$35</span><span class="price-small">.00</span></p>
        </div>
        <ul class="benefits-list">
          <li>Consulta inicial</li>
          <li>Diagnóstico personalizado</li>
          <li>Plan de tratamiento</li>
        </ul>
        <div class="pricing-table-item-footer">
          <button class="btn-contratar">Contratar</button>
        </div>
      </div>
      <div class="pricing-table-item">
        <div class="pricing-table-item-header" style="background-color: #14292D;">
          <h3 style="color: white;">Paquete Profesional</h3>
        </div>
        <div class="pricing-table-item-price">
          <p><span class="price-big">$65</span><span class="price-small">.00</span></p>
        </div>
        <ul class="benefits-list">
          <li>Consultas ilimitadas</li>
          <li>Acceso a especialistas</li>
          <li>Seguimiento continuo</li>
        </ul>
        <div class="pricing-table-item-footer">
          <button class="btn-contratar">Contratar</button>
        </div>
      </div>
      <div class="pricing-table-item">
        <div class="pricing-table-item-header" style="background-color: #D3ADA7;">
          <h3>Paquete Premium</h3>
        </div>
        <div class="pricing-table-item-price">
          <p><span class="price-big">$125</span><span class="price-small">.00</span></p>
        </div>
        <ul class="benefits-list">
          <li>Atención prioritaria</li>
          <li>Consultas a domicilio</li>
          <li>Asesoría integral</li>
        </ul>
        <div class="pricing-table-item-footer">
          <button class="btn-contratar">Contratar</button>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php include '../templates/footer.php'; ?>
  </body>
</html>
