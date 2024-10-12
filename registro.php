<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/EstilosGenerales.css">
    <link rel="stylesheet" href="css/Login.css">
    <title>Pago En Linea</title>
</head>
<body>
    <div class="login-container">
        <h2 class="text-uppercase">Registrarse</h2>
        <form action="procesar_registro.php" method="POST">
            <div class="input-field text-uppercase">
                <label for="ID_usuario">Nombre de Usuario:</label>
                <input type="text" id="ID_usuario" name="ID_usuario" required>
            </div>
            <div class="input-field text-uppercase">
                <label for="correo">Correo:</label>
                <input type="text" id="correo" name="correo" required>
            </div>
            <div class="input-field text-uppercase">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Registrar</button>
            <div class="register-link text-center mt-3">
                <p>¿Ya tienes cuenta? <a href="Login.php">Ingresa aquí</a></p>
            </div>
        </form>

        <!-- Mostrar el mensaje de error si el usuario ya existe -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'usuario_existente'): ?>
            <div class="alert alert-danger text-center mt-3">
                El nombre de usuario ya está registrado. Por favor, elige otro.
            </div>
        <?php endif; ?>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
