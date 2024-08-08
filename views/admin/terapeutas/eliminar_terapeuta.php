<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de terapeuta no válido.";
    exit;
}

$id_terapeuta = (int)$_GET['id'];

$sql = "DELETE FROM Terapeutas WHERE id_terapeuta = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_terapeuta);

if ($stmt->execute()) {
    echo "Terapeuta eliminado con éxito.";
} else {
    echo "Error al eliminar el terapeuta: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Location: terapeutas.php');
exit;
?>
