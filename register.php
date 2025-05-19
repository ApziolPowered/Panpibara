<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "login_db";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("No hay conexión: " . mysqli_connect_error());
}

$nombreCompleto = $_POST["nombre"];              // Campo del formulario
$nombreUsuario = $_POST["usuario"];              // Campo del formulario
$correo = $_POST["correo"];                      // Campo del formulario
$contrasenia = $_POST["contrasenia"];            // Campo del formulario

// Validación opcional: verificar que no exista el usuario
$verificar = mysqli_query($conn, "SELECT * FROM usuario WHERE nombreUsuario = '$nombreUsuario'");
if (mysqli_num_rows($verificar) > 0) {
    echo "<script>alert('El nombre de usuario ya existe'); window.location = 'login.html';</script>";
    exit();
}

// Insertar nuevo usuario (sin membresía por defecto, se puede poner NULL o un ID si ya hay una)
$sql = "INSERT INTO usuario (nombreUsuario, nombre, correoElectronico, contrasenia, Membresia_idMembresia)
        VALUES ('$nombreUsuario', '$nombreCompleto', '$correo', '$contrasenia', NULL)";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('usuario registrado exitosamente'); window.location = 'login.html';</script>";
} else {
    echo "Error al registrar: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
