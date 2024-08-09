<?php
include '../../../database/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de cita no proporcionado.";
    exit;
}

$id_cita = intval($_GET['id']);

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$deleteSql = 'DELETE FROM Citas WHERE id_cita = ?';
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param('i', $id_cita);

if ($stmt->execute()) {
    header('Location: citas.php');
    exit;
} else {
    echo '<div class="alert alert-danger">Error al eliminar la cita: ' . $conn->error . '</div>';
}

$stmt->close();
$conn->close();
?>
