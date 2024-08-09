<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de paquete no válido.";
    exit;
}

$id_paquete = (int)$_GET['id'];

$sql = "DELETE FROM Paquetes WHERE id_paquete = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_paquete);

if ($stmt->execute()) {
    echo "Paquete eliminado con éxito.";
    header('Location: paquetes.php');
    exit;
} else {
    echo "Error al eliminar el paquete: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
