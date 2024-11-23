<?php

session_start();
include '../conexion.php'; // Archivo para la conexión a la base de datos

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decodificar los datos JSON enviados
    $data = json_decode(file_get_contents("php://input"));

    $numTarjeta = $data->tarjeta;
    $nombreTitular = $data->titular;
    $banco = $data->banco;
    $cvv = $data->CVV;
    $fechaVencimiento = $data->vencimiento;
    $fkCliente = $_SESSION['id'];

    $query = "CALL Sp_guardarTarjeta(?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        
        $stmt->bind_param("sssssi", $numTarjeta, $nombreTitular, $banco, $cvv, $fechaVencimiento, $fkCliente);

        if ($stmt->execute()) {
            echo json_encode(['status' => 1, 'message' => 'Tarjeta registrada con éxito']);
        } else {
            echo json_encode(['status' => 0, 'message' => 'Error al registrar la tarjeta']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 3, 'message' => 'Error al preparar la consulta']);
    }

    $conn->close();
} elseif($_SERVER["REQUEST_METHOD"] == "GET"){

    if (isset($_SESSION['id'])) {

        $query = "SELECT * FROM tarjetas WHERE fk_usuario = ?;";

        if ($consulta = $conn->prepare($query)) {
            $consulta->bind_param("i", $_SESSION['id']);
            $consulta->execute();
            
            $resultado = $consulta->get_result();
            
            // Mientras existan datos
            if ($resultado->num_rows > 0) {
                $tarjetas = [];
                
                // Recorrer los resultados y almacenarlos en un arreglo
                while ($fila = $resultado->fetch_assoc()) {
                    $tarjetas[] = $fila;
                }
                
                echo json_encode($tarjetas);
            } else {
                echo json_encode(["consulta" => 0]);
            }
            $consulta->close();

        } else {
            echo json_encode(["error" => "Error en la consulta"]);
        }
    } else {
        echo json_encode(["error" => "Usuario no autenticado"]);
    } 
}
else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
