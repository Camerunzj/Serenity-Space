<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de terapia no válido.";
    exit;
}

$id_terapia = (int)$_GET['id'];

$sql = "DELETE FROM Terapias WHERE id_terapia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_terapia);

if ($stmt->execute()) {
    echo "Terapia eliminada con éxito.";
} else {
    echo "Error al eliminar la terapia: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Location: terapias.php');
exit;
?>
