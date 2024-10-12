<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Recibir los datos del formulario
$ID_usuario = $_POST['ID_usuario'];  // Capturar 'ID_usuario'
$correo = $_POST['correo'];
$contraseña = $_POST['password'];

// Verificar si los campos no están vacíos
if (!empty($ID_usuario) && !empty($correo) && !empty($contraseña)) {
    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT ID_usuario FROM usuarios WHERE ID_usuario = ?");
    $stmt->bind_param("s", $ID_usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El usuario ya existe, redirigir con un mensaje de error
        header("Location: registro.php?error=usuario_existente");
        exit();
    }

    // Si el usuario no existe, hashear la contraseña
    $hashedPassword = hash('sha256', $contraseña);

    // Definir el valor de FK_ID_rol como 2
    $FK_ID_rol = 2;

    // Preparar la consulta para insertar el nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (ID_usuario, correo, contraseña, FK_ID_rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $ID_usuario, $correo, $hashedPassword, $FK_ID_rol);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>
                alert('Registro exitoso');
                window.location.href = 'Login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al registrar el usuario');
                window.location.href = 'registro.php';
              </script>";
    }

    // Cerrar el statement
    $stmt->close();
} else {
    echo "Por favor, complete todos los campos";
}

// Cerrar la conexión
$conn->close();
?>
