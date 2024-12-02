<?php
include '../conexion.php';
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['estadoServicio']) || !isset($data['tipoContrato']) || !isset($data['direccion'])) {
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

if (isset($_SESSION['id'])) {
    $fk_user = $_SESSION['id'];
} elseif (isset($data['id'])) {
    $fk_user = $data['id'];
} else {
    // Si no se encuentra ni en la sesión ni en el JSON, responde con un error
    echo json_encode(['error' => 'No se proporcionó un identificador de usuario']);
    exit;
}

// Asignar valores
$estadoServicio = $data['estadoServicio'];
$tipoContrato = $data['tipoContrato'];
$direccion = $data['direccion'];
$fk_usuario = $fk_user;

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
