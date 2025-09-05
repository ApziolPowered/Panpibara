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

$userId = isset($_POST['userId']) ? intval($_POST['userId']) : 0;
$membresia = isset($_POST['membresia']) ? intval($_POST['membresia']) : 0;

// Validar que los datos sean válidos
if ($userId > 0 && in_array($membresia, [2, 3, 4])) {
    $stmt = $conn->prepare("UPDATE usuario SET membresia = ? WHERE id = ?");
    $stmt->bind_param("ii", $membresia, $userId);

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
