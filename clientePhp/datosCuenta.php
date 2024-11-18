<?php
include '../conexion.php';
// Configurar las cabeceras para recibir y enviar JSON
header("Content-Type: application/json; charset=UTF-8");




if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $data = json_decode(file_get_contents("php://input"));

    $idCuenta = $data->idCuenta;

    $SelectCuenta = "
    SELECT 
    cuentas.EstadoServicio AS estado_servicio,
    cuentas.tipoContrato AS tipo_contrato,
    cuentas.direccion,
    ROUND(AVG(mensualidad.consumo), 2) AS consumo_promedio,
    (SELECT consumo 
     FROM mensualidad 
     WHERE fkCuenta = cuentas.idCuenta 
     ORDER BY mensualidad DESC 
     LIMIT 1) AS consumo_mes_reciente,
    DATE_ADD((SELECT mensualidad 
              FROM mensualidad 
              WHERE fkCuenta = cuentas.idCuenta 
              ORDER BY mensualidad DESC 
              LIMIT 1), INTERVAL 1 MONTH) AS proximo_vencimiento
    FROM 
        cuentas
    JOIN 
        mensualidad ON cuentas.idCuenta = mensualidad.fkCuenta
    WHERE 
        cuentas.idCuenta = ?
    GROUP BY 
        cuentas.idCuenta;
    ";

    // Preparar y ejecutar la consulta
    $consulta = $conn->prepare($SelectCuenta);
    $consulta->bind_param("i", $idCuenta);
    $consulta->execute();

    // Obtener el resultado de la consulta
    $resultado = $consulta->get_result();

    // Procesar el resultado
    if ($row = $resultado->fetch_assoc()) {
        $datos = [
            'estado_servicio' => $row['estado_servicio'],
            'tipo_contrato' => $row['tipo_contrato'],
            'direccion' => $row['direccion'],
            'consumo_promedio' => $row['consumo_promedio'],
            'consumo_mes_reciente' => $row['consumo_mes_reciente'],
            'proximo_vencimiento' => $row['proximo_vencimiento']
        ];
    } else {
        $datos = ['error' => 'No se encontraron datos para el idCuenta proporcionado'];
    }

    // Enviar el resultado como json
    echo json_encode($datos);

    $consulta->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'idCuenta no valido']);
}
?>