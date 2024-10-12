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
        <h2 class="text-uppercase">Ingresar</h2>
        <form action="verificar_login.php" method="POST">
            <div class="input-field text-uppercase">
                <label for="correo">Correo:</label>
                <input type="text" id="correo" name="correo" required>
            </div>
            <div class="input-field text-uppercase">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Entrar</button>
            <div class="register-link text-center mt-3">
                <p>¿Aún no tiene cuenta? <a href="registro.php">Regístrese aquí</a></p>
            </div>

            <div class="error-message" id="error-message"></div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
