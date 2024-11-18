<?php
include 'conexion.php'; // Incluye el archivo de conexión a la base de datos

// Consulta para obtener los nombres de usuario y las cuentas correspondientes
$sqlUsuarios = "SELECT username, idCuenta
                FROM users
                LEFT JOIN cuentas ON users.id_user = cuentas.fk_usuario";
$result = $conn->query($sqlUsuarios);

$usuarios = [];
$cuentasPorUsuario = [];

// Procesa cada resultado para agrupar cuentas por usuario
while ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $idCuenta = $row['idCuenta'];

    // Añade el usuario a la lista si no existe ya
    if (!in_array($username, $usuarios)) {
        $usuarios[] = $username;
    }

    // Añade las cuentas al mapeo de cuentas por usuario
    if (!isset($cuentasPorUsuario[$username])) {
        $cuentasPorUsuario[$username] = [];
    }

    // Solo agrega una cuenta si no es NULL (para evitar usuarios sin cuentas)
    if ($idCuenta !== null) {
        $cuentasPorUsuario[$username][] = $idCuenta;
    }
}

// Enviar los resultados como JSON, incluyendo usuarios y sus cuentas
echo json_encode([
    'usernames' => $usuarios,
    'cuentasPorUsuario' => $cuentasPorUsuario
]);

// Cierra la conexión
$conn->close();
?>