<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "login_db";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Validar conexión
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "No hay conexión: " . mysqli_connect_error()]);
    exit;
}

// Establecer codificación UTF-8
mysqli_set_charset($conn, "utf8");

// Consulta SQL
$sql = "SELECT producto.idProducto, producto.nombre, producto.precio, producto.descripcion, producto.imagen_url, categoria.nombre AS categoria
        FROM producto
        JOIN categoria ON producto.Categoria_idCategoria = categoria.idCategoria";

$resultado = $conn->query($sql);

// Validar resultado
if (!$resultado) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
    exit;
}

// Procesar resultados
$productos = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

// Devolver resultados en formato JSON
echo json_encode($productos);
?>
