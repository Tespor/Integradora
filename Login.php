<?php

session_start();
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
            
            $stmt = $conn->prepare("CALL SpLogin(?, ?, @tx_role, @tx_iduser);");
            $stmt->bind_param("ss", $nombre_usuario, $contrasena_hash);
            $stmt->execute();

            // out val
            $resultSelect = $conn->query("SELECT @tx_role AS Rol, @tx_iduser AS IDUsuario;");
            $rowSelect = $resultSelect->fetch_assoc();

            $rol_user = $rowSelect['Rol'];
            $id_user = $rowSelect['IDUsuario'];

            // =========================Comparar datos
            if ($rol_user  == -1) {
                echo json_encode([
                    "status" => "fail",
                    "message" => "Datos incorrectos"
                ]);
                
            } else {
                $response = [
                    "status" => "success",
                    "usuario" => $nombre_usuario
                ];
                
                if ($rol_user == 1) {
                    $response["role"] = "admin";
                    $response["endpoint"] = "Administrador.php";
                } elseif ($rol_user == 2) {
                    $response["role"] = "cliente";
                    $response["endpoint"] = "Inicio.php";
                }
                $_SESSION['id'] = $id_user;
                $_SESSION['nombre'] = $nombre_usuario;
                $_SESSION['rol'] = $rol_user;

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