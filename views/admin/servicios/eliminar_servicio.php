<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "ID de servicio inválido.";
    exit;
}

$sql_verificar = 'SELECT * FROM Servicios WHERE id = ?';
$stmt = $conn->prepare($sql_verificar);

if (!$stmt) {
    echo "Error al preparar la consulta de verificación: " . $conn->error;
    exit;
}

$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Servicio no encontrado.";
    exit;
}

$stmt->close();

$sql_delete = 'DELETE FROM Servicios WHERE id = ?';
$stmt = $conn->prepare($sql_delete);

if (!$stmt) {
    echo "Error al preparar la consulta de eliminación: " . $conn->error;
    exit;
}

$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo "Servicio eliminado exitosamente.";
    header('Location: servicios.php');
    exit;
} else {
    echo "Error al eliminar el servicio: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
