<?php
// login.php
header('Content-Type: application/json');

$usuario = $_POST['txtusername'] ?? '';
$contrasenia = $_POST['txtpassword'] ?? '';

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "login_db");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión"]);
    exit;
}

$sql = "SELECT id, nombre FROM usuarios WHERE usuario = ? AND contrasenia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $contrasenia);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuarioData = $result->fetch_assoc();
    echo json_encode(["success" => true, "id" => $usuarioData['id'], "nombre" => $usuarioData['nombre']]);
} else {
    echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos"]);
}

$conn->close();
?>
