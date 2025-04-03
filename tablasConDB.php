<!DOCTYPE html>
<html lang="es">
<head> 
    <script src="Registro_Participantes.js"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PhpToHtml</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

    <script>
        
    </script>
</head>
<body>
<header>
  <h1>Base de datos almacén</h1>
</header>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "almacen";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, nombre, color, talla, precio, stock FROM producto";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table><tr><th>ID</th><th>Nombre</th><th>Color</th><th>Talla</th><th>Precio</th><th>Stock</th><th>Cantidad a escoger</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["id"]."</td><td>".$row["nombre"]."</td><td>".$row["color"]."</td><td>".$row["talla"]."</td><td>".$row["precio"]."</td><td>".$row["stock"]."</td><td>". "<input type='number_format'>"."</td></tr>";
  }
  echo "</table>";
} else {
  echo "<p>No hay resultados</p>";
}
$conn->close();
?>

</body>
</html>

<!--poner comentarios///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "almacen";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, nombre, color, talla, precio, stock FROM producto";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table><tr><th>ID</th><th>Nombre</th><th>Color</th><th>Talla</th><th>Precio</th><th>Stock</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["id"]."</td><td>".$row["nombre"]."</td><td>".$row["color"]."</td><td>".$row["talla"]."</td><td>".$row["precio"]."</td><td>".$row["stock"]."</td></tr>";
  }
  echo "</table>";
} else {
  echo "<p>No hay resultados</p>";
}
$conn->close();
?>



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "almacen";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO producto (nombre, color, talla, precio, stock)
  VALUES ('Pony sudadera', 'rojo y blanco', 'G', '500 ', '10')";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>