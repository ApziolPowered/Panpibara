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

$sql = "SELECT idUsuario, nombre, Membresia_idMembresia FROM usuario WHERE nombreUsuario = ? AND contrasenia = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Error en la preparación: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("ss", $usuario, $contrasenia);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuarioData = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "id" => $usuarioData['idUsuario'],
        "nombre" => $usuarioData['nombre'],
        "membresia" => $usuarioData['Membresia_idMembresia']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos"]);
}

$conn->close();
?>

