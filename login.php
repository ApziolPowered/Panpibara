<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "login_db";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) 
{
	die("No hay conexión: ".mysqli_connect_error());
}

$nombre = $_POST["txtusername"];
$contrasenia = $_POST["txtpassword"];

$query = mysqli_query($conn,"SELECT * FROM usuario WHERE nombreUsuario = '".$nombre."' and contrasenia = '".$contrasenia."'");
$nr = mysqli_num_rows($query);

if($nr == 1)
{
	header("Location: principal.html");
	echo "Bienvenido:" .$nombre;
}
else if ($nr == 0) 
{
	header("Location: login.html");
	echo "No ingreso"; 
	echo "<script> alert('Error');window.location= 'login.html' </script>";
}
	


?>