<?php
// CambiarContrasenia.php

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "login_db");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$correo = $_POST['correo'] ?? '';
$nuevaContrasenia = $_POST['contrasenia'] ?? '';

// Validar que se proporcionaron ambos datos
if (empty($correo) || empty($nuevaContrasenia)) {
    echo "Faltan datos necesarios";
    exit;
}

// Hashear la nueva contraseña por seguridad
$hash = $nuevaContrasenia

// Actualizar la contraseña en la base de datos
$stmt = $conn->prepare("UPDATE usuario SET contrasenia = ? WHERE correoElectronico = ?");
$stmt->bind_param("ss", $hash, $correo);

if ($stmt->execute()) {
    echo "Contraseña actualizada exitosamente";
} else {
    echo "Error al actualizar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
