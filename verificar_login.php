<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Recibir los datos del formulario
$correo = $_POST['correo'];
$contraseña = $_POST['password'];

// Verificar si los campos no están vacíos
if (!empty($correo) && !empty($contraseña)) { 
    // Usar consultas preparadas para evitar inyecciones SQL
    $stmt = $conn->prepare("SELECT contraseña FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el correo en la base de datos
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash = $row['contraseña'];  // Obtener el hash de la contraseña almacenada

        // Hashear la contraseña ingresada por el usuario
        $hashedInputPassword = hash('sha256', $contraseña);

        // Verificar si la contraseña ingresada coincide con el hash almacenado
        if ($hashedInputPassword === $hash) {
            // Redirigir a la página de inicio si las credenciales son correctas
            header("Location: Inicio.html");
            exit();
        } else {
            // Si la contraseña es incorrecta
            echo "<script>
                    alert('Credenciales incorrectas');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        // Si el correo no se encuentra en la base de datos
        echo "<script>
                alert('Credenciales incorrectas');
                window.location.href = 'login.php';
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
