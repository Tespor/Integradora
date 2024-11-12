<?php
include 'conexion.php';

// Obtener el idCuenta desde la solicitud
$idCuenta = $_GET['idCuenta'];

// Consulta para obtener los datos necesarios
$sql = "
    SELECT 
        c.tipoContrato, 
        m.adeudo, 
        m.consumo, 
        m.mensualidad, 
        (m.adeudo + m.consumo) AS total
    FROM cuentas c
    LEFT JOIN mensualidad m ON c.idCuenta = m.fkCuenta
    WHERE c.idCuenta = ?";
    
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCuenta);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($row = $result->fetch_assoc()) {
    $data = [
        'tipoContrato' => $row['tipoContrato'],
        'adeudo' => $row['adeudo'],
        'consumo' => $row['consumo'],
        'mensualidad' => $row['mensualidad'],
        'total' => $row['total']
    ];
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
