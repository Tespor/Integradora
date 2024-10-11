<?php
// Datos de conexión a la base de datos
$host = 'bnmstfskxzmmhvxnsxds-mysql.services.clever-cloud.com';  // Cambia si es necesario
$dbname = 'bnmstfskxzmmhvxnsxds';
$username = 'uhehyetbgkef06a6';  // Cambia si es necesario
$password = 'xif0S2h2zAhuunek1CM5';  // Contraseña de la base de datos
// Crear la conexión con MySQL
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

echo "Conectado exitosamente a la base de datos";

?>

