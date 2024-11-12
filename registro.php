<?php
include 'conexion.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $nombre_usuario = $data->username;
    $nombre_completo = $data->fullname;
    $correo = $data->correo;
    $contrasena = $data->password;

    try {
        // Preparar y ejecutar el procedimiento almacenado
        $stmt = $conn->prepare("CALL SpRegistro2(?, ?, ?, ?, @result)");
        $stmt->bind_param("ssss", $nombre_usuario, $nombre_completo, $correo, $contrasena);
        $stmt->execute();

        // Obtener el resultado del procedimiento almacenado
        $result = $conn->query("SELECT @result AS result");
        $row = $result->fetch_assoc();

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

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
}
?>
