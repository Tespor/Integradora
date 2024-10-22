<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Estilosgenerales.css">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Login</title>
</head>
<body>
    <div id="videoBox">
        <video id="videoLogin" src="videos/animationLogin.mp4" muted></video>
    </div>

    <div class="txtRegistrarIngresar">
        <div id="txtRegistrar">
            <h1>R<span class="second-letter">e</span>gistrar</h1>
        </div>
        <div id="txtIngresar">
            <h1>I<span class="second-letter">n</span>gresar</h1>
        </div>
    </div>
    <div id="cajaFondo" class="box">
        <div class="mini-box"></div>
        <div class="ball"></div>
    </div>
    <div id="contenedorForms">
        <div id="formLogin">
            <form action="Login.php" method="post">
                <img class="logoText" src="img/LogosEmpresa/LOGO-Y-TEXTO.png" alt="">
                <div class="input-box">
                    <input class="editText" placeholder="Usuario" type="text" id="nombre_usuario" name="nombre_usuario" required>
                </div>
                <div class="input-box">
                    <input class="editText" placeholder="Contraseña" id="contrasena" name="contrasena" required>
                </div>
                <button type="submit">INGRESAR</button>
                <div id="btnRegistrar">
                    <p>¿No tienes cuenta?</p>
                </div>
            </form>
        </div>
        <div id="formRegistrar">
            <form>
                <img class="logoText2" src="img/LogosEmpresa/LOGO-Y-TEXTO.png" alt="">
                <div class="input-box">
                    <input class="editText" placeholder="Nombre" type="text" id="correo" name="correo" required>
                </div>
                <div class="input-box">
                    <input class="editText" placeholder="Apellido" type="text" id="correo" name="correo" required>
                </div>
                <div class="input-box">
                    <input class="editText" placeholder="Correo" type="text" id="correo" name="correo" required>
                </div>
                <div class="input-box">
                    <input class="editText" placeholder="Contraseña" type="password" id="password" name="password"
                        required>
                </div>
                <div class="input-box">
                    <input class="editText" placeholder="Confirmar contraseña" type="password" id="password" name="password"
                        required>
                </div>
                <button type="submit">REGISTRARME</button>
                <div id="btnLogin">
                    <p>Regresar al inicio sesion</p>
                </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/efectos.js"></script>
<?php

include 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Hasheo de contraseña
    $contrasena_hash = hash('sha256', $contrasena);

    try {
        // Procedimiento almacenado
        $stmt = $conn->prepare("CALL SpLogin(?, ?, @tx_role)");

        // Pasar los parámetros a la consulta
        $stmt->bind_param("ss", $nombre_usuario, $contrasena_hash); // 'ss' indica dos parámetros de tipo string
        $stmt->execute(); // Ejecutar la consulta

        // Obtener el valor de salida (rol de usuario)
        $result = $conn->query("SELECT @tx_role AS fk_id_rol");
        $row = $result->fetch_assoc();
        
        $id_rol_user = $row['fk_id_rol'];

        if ($id_rol_user == -1) {
            echo "Nombre de usuario o contraseña incorrectos.";
        } else {
            if ($id_rol_user == 1) {

                echo "<script>
                    const videoBox = document.getElementById('videoBox');
                    const videoLogin = document.getElementById('videoLogin');

                    videoBox.style.transform = 'translate(0%)';
                    videoLogin.play();

                    setTimeout(function() {
                        window.location.href = 'Administrador.html';
                    }, 3000);
                </script>";

            } elseif ($id_rol_user == 2) {
                // Redirigir al panel de cliente
                echo "<script>
                    const videoBox = document.getElementById('videoBox');
                    const videoLogin = document.getElementById('videoLogin');

                    videoBox.style.transform = 'translate(0%)';
                    videoLogin.play();

                    setTimeout(function() {
                        window.location.href = 'Inicio.html';
                    }, 3000);
                </script>";
            }
        }

        // Cerrar la declaración
        $stmt->close();

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

</body>
</html>
