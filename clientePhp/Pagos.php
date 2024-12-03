<?php
session_start();
include '../conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));


if (isset($data->monto) && isset($data->meses_pagados) && isset($data->fk_cuenta) && isset($data->fk_tarjeta)) {
    // Asignar las variables
    $p_monto = $data->monto;
    $p_meses_pagados = $data->meses_pagados;
    $p_fk_cuenta = $data->fk_cuenta;
    $p_fk_tarjeta = $data->fk_tarjeta;
    
    // Llamar al procedimiento almacenado
    $stmt = $conn->prepare("CALL SpInsertarPago(?, ?, ?, ?, @p_result)");
    $stmt->bind_param("diis", $p_monto, $p_meses_pagados, $p_fk_cuenta, $p_fk_tarjeta);
    
    if ($stmt->execute()) {
        // Obtener el resultado de la variable de salida
        $result = $conn->query("SELECT @p_result AS result");
        $row = $result->fetch_assoc();

        // Verificar el resultado
        if ($row['result'] > 0) {
            echo json_encode(['status' => 1, 'message' => 'Pago registrado exitosamente', 'transaccion' => $row['result']]);
        } else {
            echo json_encode(['status' => 0, 'message' => 'Error al registrar el pago']);
        }
    } else {
        echo json_encode(['status' => 0, 'message' => 'Error al ejecutar la consulta']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 0, 'message' => 'Datos incompletos']);
}

$conn->close();
?>
