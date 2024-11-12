<?php
// Conexión a la base de datos

$host = "localhost";
$dbname = "integradora";
$username = "root";
$password = "root";
/*
$host = "bhtlxlx3uxmvzfupyjln-mysql.services.clever-cloud.com";
$dbname = "bhtlxlx3uxmvzfupyjln";
$username = "uvtp9j8xhc9jdpqf";
$password = "NVoFCYuUo2zk6Urvlx2y";
*/
//Crear conexion
$conn = new MySQLi($host, $username, $password, $dbname);

//Verificar la conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
?>