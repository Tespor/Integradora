<?php
include '../conexion.php';
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['estadoServicio']) || !isset($data['tipoContrato']) || !isset($data['direccion'])) {
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

// Asignar valores
$estadoServicio = $data['estadoServicio'];
$tipoContrato = $data['tipoContrato'];
$direccion = $data['direccion'];
$fk_usuario = $_SESSION['id'];

// Preparar y ejecutar el procedimiento almacenado
$stmt = $conn->prepare("CALL Sp_InsertarServicio(?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("sssi", $estadoServicio, $tipoContrato, $direccion, $fk_usuario);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Servicio insertado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al insertar el servicio: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Error en la preparación del statement: " . $conn->error]);
}

$conn->close();
?>
