<?php
include 'conexion.php'; // Archivo de conexión a la base de datos

// Verifica que el parámetro 'username' esté presente en la solicitud
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Consulta para obtener los ID de cuentas del usuario seleccionado
    $sql = "SELECT cuentas.idCuenta 
            FROM cuentas 
            INNER JOIN users ON cuentas.fk_usuario = users.id_user 
            WHERE users.username = ?";
    
    // Preparar la declaración
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $cuentas = [];

    // Agregar los ID de cuentas al array
    while ($row = $result->fetch_assoc()) {
        $cuentas[] = $row;
    }

    // Retornar el resultado en JSON
    echo json_encode($cuentas);
} else {
    echo json_encode([]); // Retorna un array vacío si no hay 'username'
}

// Cierra la conexión
$conn->close();
?>
