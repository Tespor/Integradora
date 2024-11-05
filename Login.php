<?php

include 'conexion.php';

// Configurar las cabeceras para recibir y enviar JSON
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leer el JSON desde el cuerpo de la solicitud
    $input = json_decode(file_get_contents("php://input"), true);
    
    // Verificar si los datos JSON se recibieron correctamente
    if (isset($input['nombre_usuario']) && isset($input['contrasena'])) {
        $nombre_usuario = $input['nombre_usuario'];
        $contrasena = $input['contrasena'];

        // Hasheo de contraseña
        $contrasena_hash = hash('sha256', $contrasena);

        try {
            // Procedimiento almacenado
            $stmt = $conn->prepare("CALL SpLogin(?, ?, @tx_role)");

            // Pasar los parámetros a la consulta
            $stmt->bind_param("ss", $nombre_usuario, $contrasena_hash);
            $stmt->execute();

            // Obtener el valor de salida (rol de usuario)
            $result = $conn->query("SELECT @tx_role AS fk_id_rol");
            $row = $result->fetch_assoc();

            $id_rol_user = $row['fk_id_rol'];

            // Preparar la respuesta JSON según el rol del usuario
            if ($id_rol_user == -1) {
                echo json_encode([
                    "status" => "fail",
                    "message" => "Datos incorrectos"
                ]);
            } else {
                $response = ["status" => "success"];

                if ($id_rol_user == 1) {
                    $response["role"] = "admin";
                    $response["redirect"] = "Administrador.html";
                } elseif ($id_rol_user == 2) {
                    $response["role"] = "client";
                    $response["redirect"] = "Inicio.html";
                }

                echo json_encode($response);
            }

            // Cerrar la declaración
            $stmt->close();

        } catch (Exception $e) {
            // Responder con un mensaje de error en JSON
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Faltan parámetros en la solicitud."
        ]);
    }
}

?>