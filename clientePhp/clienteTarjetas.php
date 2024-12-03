<?php

session_start();
include '../conexion.php'; // Archivo para la conexión a la base de datos

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decodificar los datos JSON enviados
    $data = json_decode(file_get_contents("php://input"));
    //file_put_contents('debug.log', print_r($data, true), FILE_APPEND);


    //Solo si va a borrar
    if (isset($data->tnum)) {
        $consult = "delete from tarjetas where numeroTarjeta = ? and fk_usuario = ?;";

        if ($stmt = $conn->prepare($consult)) {

            $stmt->bind_param("si", $data->tnum, $_SESSION['id']);

            if ($stmt->execute()) {
                echo json_encode(['status' => 1, 'message' => 'Tarjeta eliminada']);
            } else {
                echo json_encode(['status' => 0, 'message' => 'Error al eliminar la tarjeta']);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 3, 'message' => 'Error en la consulta']);
        }

        $conn->close();
    } 
    //Para sacar los datos
    elseif (isset($data->tarjeta)) {
        $numTarjeta = $data->tarjeta;
        $nombreTitular = $data->titular;
        $banco = $data->banco;
        $cvv = $data->CVV;
        $fechaVencimiento = $data->vencimiento;
        $fk_user = 0;

        //Validar usuario
        if (isset($_SESSION['id'])) {
            $fk_user = $_SESSION['id'];
        } elseif (isset($data->userID)) {
            $fk_user = $data->userID;
        } else {
            // Error si no se encuentra el userID
            echo json_encode(['status' => 0, 'message' => 'No se proporcionó un identificador de usuario']);
            exit;
        }
        
        $query = "CALL Sp_guardarTarjeta(?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($query)) {

            $stmt->bind_param("sssssi", $numTarjeta, $nombreTitular, $banco, $cvv, $fechaVencimiento, $fk_user);

            if ($stmt->execute()) {
                echo json_encode(['status' => 1, 'message' => 'Tarjeta registrada con éxito']);
            } else {
                echo json_encode(['status' => 0, 'message' => 'Error al registrar la tarjeta', 'error' => $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 3, 'message' => 'Error al preparar la consulta']);
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_SESSION['id']) || isset($_GET['id'])) {

        if (isset($_SESSION['id'])) {
            $fk_user = $_SESSION['id'];
        } elseif (isset($_GET['id'])) {
            $fk_user = $_GET['id'];
        } else {
            // Si no se encuentra ni en la sesión ni en el JSON, responde con un error
            echo json_encode(['error' => 'No se proporcionó un identificador de usuario']);
            exit;
        }

        $query = "SELECT * FROM tarjetas WHERE fk_usuario = ?;";

        if ($consulta = $conn->prepare($query)) {
            $consulta->bind_param("i", $fk_user);
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
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
