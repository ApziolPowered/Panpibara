<?php
$conn = new mysqli("localhost", "root", "", "login_db");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$contrasenia = $_POST['contrasenia'];  // Se recomienda encriptar

// Dirección
$calle = $_POST['calle'];
$numero = $_POST['numero'];
$colonia = $_POST['colonia'];
$ciudad = $_POST['ciudad'];
$estado = $_POST['estado'];
$codigoPostal = $_POST['codigoPostal'];
$descripcion = $_POST['descripcion'] ?? '';

// Asumimos membresia basica
$idMembresia = 1;

$conn->begin_transaction();

try {
    // Insertar usuario
    $stmtUsuario = $conn->prepare("INSERT INTO usuario (nombreUsuario, nombre, correoElectronico, contrasenia, Membresia_idMembresia) VALUES (?, ?, ?, ?, ?)");
    $stmtUsuario->bind_param("ssssi", $usuario, $nombre, $correo, $contrasenia, $idMembresia);
    $stmtUsuario->execute();

    $idUsuario = $conn->insert_id;

    // Insertar dirección
    $stmtDireccion = $conn->prepare("INSERT INTO direccion (calle, numero, colonia, ciudad, estado, codigoPostal, descripcion, Usuario_idUsuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtDireccion->bind_param("sssssssi", $calle, $numero, $colonia, $ciudad, $estado, $codigoPostal, $descripcion, $idUsuario);
    $stmtDireccion->execute();

    $conn->commit();

    echo "<script>
        alert('Usuario registrado exitosamente');
        window.location.href = 'login.html';
    </script>";

} catch (Exception $e) {
    $conn->rollback();
    echo "Error al registrar usuario: " . $e->getMessage();
}

$conn->close();
?>

