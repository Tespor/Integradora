<?php
session_start();
include '../conexion.php'; // Conexión a la base de datos
header("Content-Type: application/json; charset=UTF-8");

//decodificar el username
$userNameJson = json_decode(file_get_contents("php://input"), true);
$fk_user = $_SESSION['id'];

// Consulta SQL para obtener todos los datos de la columna deseada
$selectCuentas = "SELECT idCuenta FROM cuentas WHERE fk_usuario = ?;";
$consulta = $conn->prepare($selectCuentas);
$consulta->bind_param("i", $fk_user);
$consulta->execute();

$result = $consulta->get_result();

$cuentasUser = [];

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cuentasUser[] = $row['idCuenta'];
    }
} else {
    $cuentasUser['error'] = 'No se encontraron datos';
}

// Cerrar la conexión
$conn->close();

// Enviar el resultado en formato JSON
echo json_encode($cuentasUser);
?>