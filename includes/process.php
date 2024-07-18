<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $to = "josuebrenes3005@gmail.com"; 
    $subject = "Nuevo mensaje de contacto";
    $body = "Nombre: $name\nCorreo: $email\nMensaje:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "Correo enviado exitosamente.";
    } else {
        echo "Error al enviar el correo.";
    }

    $file = 'contact_messages.txt';
    $current = file_get_contents($file);
    $current .= "Nombre: $name\nCorreo: $email\nMensaje:\n$message\n\n";
    file_put_contents($file, $current);

    header('Location: ../views/paginas/thank_you.php');
    exit();
} else {
    echo "Método de solicitud no válido.";
}
?>
