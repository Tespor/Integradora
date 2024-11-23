<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/EstilosGenerales.css">
    <link rel="stylesheet" href="css/estilosMenu.css">
    <link rel="stylesheet" href="css/estilosPopUp.css">
    <title>Inicio</title>
</head>

<body>
    <div id="bloqueoVentana" class="bloqueoVentana" style="display: none;">
        <div>
            <h1>
                Ventana bloqueda
            </h1>
            <p>Multiples ventanas del mismo tipo estan activas</p>
            <p>Cierra o recarga esta ventana para continuar</p>
        </div>
    </div>

    <div class="MyContainer">
        <nav>
            <div class="ContentFluid LogoContent">
                <img class="IconCompany" id="IconCompany" src="img/LogosEmpresa/1-BLNCO.png" alt="">
                <div id="headMenu">
                    <img src="img/LogosEmpresa/TEXTO-LOGO.png" class="img-titulo-head"></img>
                </div>
            </div>
            <div class="perfil" id="perfil">
                <img class="IconUser" src="img/Icono Usuario.png" alt="">
            </div>
            <div id="menuUser" class="menuUser">
                <div>
                    <?php session_start();
                    echo $_SESSION['nombre'] ?? 'No disponible'; ?>
                </div>
                <hr>
                <a class="btnMenuUser" href="Inicio.php">
                    Inicio
                </a>
                <a class="btnMenuUser" href="PagosMensualidades.php">
                    Pagos y mensualidades
                </a>
                <a id="LogOut" class="btnMenuUser">
                    Cerrar session
                </a>
            </div>
        </nav>
    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!--CDN para QR-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!--mis js
    <script src="js/qr_generar.js"></script>
    <script src="js/animationMenu.js"></script>
    <script src="js/services/axiosCliente.js"></script>
    <script src="js/services/logout.js"></script>-->
    <script>
        //Menu usuario lateral
        const menuUser = document.getElementById('menuUser');
        const btnToMenuser = document.getElementById('perfil');
        var menuUserAbierto = false;
        btnToMenuser.addEventListener('click', function() {
            if (menuUserAbierto) {
                menuUser.style.right = "-200px";
                menuUser.style.opacity = "0";
            } else {
                menuUser.style.right = "5px";
                menuUser.style.opacity = "1";
            }
            menuUserAbierto = !menuUserAbierto;
        });
    </script>
</body>

</html>