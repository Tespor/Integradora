<?php
// Conexión a la base de datos
$host = "localhost";
$dbname = "Integradora";
$username = "root";
$password = "root";

//Crear conexion
$conn = new MySQLi($host, $username, $password, $dbname);

//Verificar la conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
?>