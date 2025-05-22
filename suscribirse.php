<?php
// suscribirse.php

// Configura tu conexión
$host = "localhost";
$db = "login_db";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

$username = strtolower(trim($_POST['username']));
$membresia = intval($_POST['membresia']);

if (!empty($username) && in_array($membresia, [2, 3, 4])) {
    $stmt = $conn->prepare("UPDATE usuario SET membresia = ? WHERE nombreUsuario = ?");
    $stmt->bind_param("is", $membresia, $username);

    if ($stmt->execute()) {
        echo "✅ Suscripción actualizada correctamente.";
    } else {
        echo "❌ Error al actualizar suscripción.";
    }

    $stmt->close();
} else {
    echo "❌ Datos inválidos.";
}

$conn->close();
?>
