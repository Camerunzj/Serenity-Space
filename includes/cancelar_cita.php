<?php
include '../database/database.php';

if (isset($_GET['id_cita'])) {
    $id_cita = $_GET['id_cita'];

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("UPDATE Citas SET id_estado = (SELECT id_estado FROM Estado_Cita WHERE estado = 'cancelada') WHERE id_cita = ? AND id_cliente = ?");
        
        if ($stmt === false) {
            throw new Exception('Error al preparar la declaración SQL: ' . $conn->error);
        }

        $id_usuario = $_SESSION['id_usuario'];
        $stmt->bind_param("ii", $id_cita, $id_usuario);
        
        if ($stmt->execute()) {
            header("Location: ../views/paginas/quotes.php");
            exit();
        } else {
            throw new Exception('Error al ejecutar la declaración: ' . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($conn);
} else {
    echo "No se ha especificado el ID de la cita.";
}
?>
