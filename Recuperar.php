<?php
// Recuperar.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo'] ?? '';
    $codigo = $_POST['codigo'] ?? '';

    if (empty($correo) || empty($codigo)) {
        die("Faltan datos");
    }

    $conn = new mysqli("localhost", "root", "", "login_db");
    if ($conn->connect_error) {
        die("Error de conexión");
    }

    $stmt = $conn->prepare("SELECT nombre FROM usuario WHERE correoElectronico = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'axjoheal@gmail.com';
            $mail->Password = 'iyon ezni lhdy ojzf';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;


            // Remitente y destinatario
            $mail->setFrom('axjoheal@gmail.com', 'Soporte');
            $mail->addAddress($correo, $usuario['nombre']);

            // Contenido del correo
            $mail->isHTML(false);
            $mail->Subject = 'Tu codigo de recuperacion';
            $mail->Body    = "Hola " . $usuario['nombre'] . ", tu código de recuperación es: $codigo";

            $mail->send();
            echo 'Correo enviado';
        } catch (Exception $e) {
            echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Correo no encontrado";
    }

    $stmt->close();
    $conn->close();
}
?>

