<?php
include '../database/database.php';

$id_cliente = $_POST['id_cliente'];
$id_terapeuta = $_POST['id_terapeuta'];
$fecha_hora = $_POST['fecha_hora'];
$id_terapia = $_POST['id_terapia'];

$fecha_hora = date('Y-m-d H:i:s', strtotime($fecha_hora));

$id_estado = 1;

$sqlInsertCita = "INSERT INTO Citas (id_cliente, id_terapeuta, fecha_hora, id_terapia, id_estado)
                  VALUES ('$id_cliente', '$id_terapeuta', '$fecha_hora', '$id_terapia', '$id_estado')";

if (mysqli_query($conn, $sqlInsertCita)) {
    header("Location: ../views/paginas/quotes.php");
    exit();
} else {
    echo "Error al guardar la cita: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
