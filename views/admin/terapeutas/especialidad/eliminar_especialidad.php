<?php
include '../../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de especialidad no válido.";
    exit;
}

$id_especialidad = (int)$_GET['id'];

$sql = "DELETE FROM Especialidades WHERE id_especialidad = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_especialidad);

if ($stmt->execute()) {
    $message = "Especialidad eliminada con éxito.";
} else {
    $message = "Error al eliminar la especialidad: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Location: especialidades.php?message=' . urlencode($message));
exit;
?>
