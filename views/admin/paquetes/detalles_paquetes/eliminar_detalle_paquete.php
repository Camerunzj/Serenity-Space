<?php
include '../../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID del detalle no especificado.";
    exit;
}

$id_detalle = intval($_GET['id']);

$stmt = $conn->prepare('DELETE FROM Detalles_Paquete WHERE id_detalle = ?');
$stmt->bind_param('i', $id_detalle);

if ($stmt->execute()) {
    header('Location: detalles_paquetes.php');
    exit;
} else {
    echo "Error al eliminar el detalle: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
