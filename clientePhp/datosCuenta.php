<?php
include '../conexion.php';

header("Content-Type: application/json; charset=UTF-8");




if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $data = json_decode(file_get_contents("php://input"));

    $idCuenta = $data->idCuenta;

    $SelectCuenta = "
    SELECT * 
    FROM VistaCuentasMensualidades
    WHERE idCuenta = ?;
    ";

    // Preparar y ejecutar la consulta
    $consulta = $conn->prepare($SelectCuenta);
    $consulta->bind_param("i", $idCuenta);
    $consulta->execute();

    // Obtener el resultado de la consulta
    $resultado = $consulta->get_result();

    // Fragment result
    if ($row = $resultado->fetch_assoc()) {
        $datos = [
            'estado_servicio' => $row['estado_servicio'],
            'adeudo_mes' => $row['adeudo_mes'],
            'tipo_contrato' => $row['tipo_contrato'],
            'direccion' => $row['direccion'],
            'consumo_promedio' => $row['consumo_promedio'],
            'consumo_mes_reciente' => $row['consumo_mes_reciente'],
            'proximo_vencimiento' => $row['proximo_vencimiento'],
            'adeudo_total' => $row['adeudo_total'],
            'meses_adeudo' => $row['meses_adeudo'],
            'nombre_completo' => $row['nombre_completo']
        ];
    } else {
        $datos = ['error' => 'No se encontraron datos para la cuenta seleccionada'];
    }

    // Enviar el resultado como json
    echo json_encode($datos);

    $consulta->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'idCuenta no valido']);
}
?>