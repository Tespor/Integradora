<?php
include 'conexion.php';

// Configurar las cabeceras para recibir y enviar JSON
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leer los datos del JSON enviado por Axios
    $data = json_decode(file_get_contents("php://input"));

    $nombre_usuario = $data->username;
    $nombre_completo = $data->fullname;
    $correo = $data->correo;
    $contrasena = $data->password;

    // Hasheo de la contraseña
    $contrasena_hash = hash('sha256', $contrasena); // Usar SHA-256 para el hash de la contraseña

    try {
        // Procedimiento almacenado para registrar el usuario
        $stmt = $conn->prepare("CALL SpRegistro1(?, ?, ?, ?, @result)");

        // Pasar los parámetros a la consulta
        $stmt->bind_param("ssss", $nombre_usuario, $nombre_completo, $correo, $contrasena_hash);
        $stmt->execute();

        // Obtener el valor de salida (resultado de la operación)
        $result = $conn->query("SELECT @result AS result");
        $row = $result->fetch_assoc();
        
        // Verificar el resultado del procedimiento almacenado
        if ($row['result'] == 1) {
            echo json_encode([
                "status" => "success",
                "message" => "Usuario registrado con éxito"
            ]);
        } else {
            echo json_encode([
                "status" => "fail",
                "message" => "Error al registrar el usuario"
            ]);
        }

        // Cerrar la declaración
        $stmt->close();

    } catch (Exception $e) {
        // Responder con un mensaje de error en JSON si ocurre una excepción
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
}
?>
