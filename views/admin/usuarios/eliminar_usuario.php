<?php
include '../../../database/database.php';

if (!$conn) {
    echo "No se pudo conectar a la base de datos.";
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de usuario no válido.";
    exit;
}

$id_usuario = (int)$_GET['id'];

$sql = "DELETE FROM Usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);

if ($stmt->execute()) {
    echo "Usuario eliminado con éxito.";
} else {
    echo "Error al eliminar el usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Location: usuarios.php');
exit;
?>
