<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/EstilosGenerales.css">
    <link rel="stylesheet" href="css/estilosMenu.css">
    <link rel="stylesheet" href="css/estilosPopUp.css">
    <title>Administrador</title>
</head>

<body>
    <div id="bloqueoVentana" class="bloqueoVentana">
        <div>
            <h1>
                Ventana bloqueda
            </h1>
            <p>Multiples ventanas del mismo tipo estan activas</p>
            <p>Cierra o recarga esta ventana para continua</p>
        </div>
    </div>

    <div class="MyContainer">
        <nav>
            <div class="ContentFluid LogoContent">
                <img class="IconCompany" id="IconCompany" src="img/LogosEmpresa/LOGO-LINE.png" alt="">
                <div id="headMenu">
                    <img src="img/LogosEmpresa/TEXTO-LOGO.png" class="img-titulo-head"></img>
                </div>
            </div>
            <a class="perfil" id="LogOut">
                <img class="IconUser" src="img/Icono Usuario.png" alt="">
                <p class="userText">
                    <?php session_start();
                    echo $_SESSION['nombre'] ?? 'No disponible'; ?>
                </p>
            </a>
        </nav>
    </div>

    <div class="menu-lateral">
        <div class="main-row">
            <div class="card">
                <img src="img/Iconos/icon_fire.png" alt="Gas icon">
                <p>GAS</p>
            </div>
            <div class="card">
                <img src="img/Iconos/gota.png" alt="Agua icon">
                <p>AGUA</p>
            </div>
            <div class="card">
                <img src="img/Iconos/rayo.png" alt="Luz icon">
                <p>LUZ</p>
            </div>
        </div>
        <div class="separador"></div>
        <div class="search-container">
            <div class="search-wrapper">
                <img class="icon" src="img/Iconos/icon_search.png" alt="">
                <input type="search" class="search-input" placeholder="Buscar un usuario">
            </div>

            <div class="separador"></div>
            <!-- Primer select para los nombres de usuario -->
            <select multiple size="5" class="boxSelect" id="selectDDL"></select>



        </div>
    </div>
    <!--Datos del lado izquierdo-->
    <div class="container datosCuentas">

        <div class="separador-lg"></div><!--Para dar espacio TOP-->

        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4" id="columnaGuia"></div>
            <div class="col-sm-12 col-md-6 col-lg-8 position-relative">
                <div class="row position-relative">
                    <div class="col-md-12 col-lg-6">
                        <h4>DATOS DE USUARIO</h4>
                        <br>
                        <div class="input-box">
                            <label for="ddlCuenta">Numero de cuenta</label>
                            <select class="custom-spinner" name="cuentaDDL" id="cuentaDDL">
                                <option value="">Seleccionar numero de cuenta</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <label>Mensualidad</label>
                            <input class="editText" placeholder="7 meses vencidos" id="txtMesesVencidos"
                                name="txtMesesVencidos" disabled>
                        </div>
                        <div class="input-box">
                            <label>Tipo de contrato</label>
                            <input class="editText" placeholder="Comercial/domestico" id="txtTipoContrato"
                                name="txtTipoContrato" disabled>
                        </div>
                        <div class="input-box">
                            <label>Proximo Vencimiento</label>
                            <input class="editText" placeholder="Contraseña" id="txtProxVencimiento"
                                name="txtProxVencimiento" disabled>
                        </div>
                        <div class="pTotal">
                            <h3>ADEUDO TOTAL</h3>
                            <h1>1,736</h1>
                        </div>
                    </div>
                    <!--Parte derecha-->
                    <div class="col-md-12 col-lg-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="btnBox" onclick="bajaCuenta()">
                                    <img src="img/Iconos/icon_baja.png">
                                    <p>DAR DE BAJA CUENTA</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="btnBox" onclick="actualizarDatos()">
                                    <img src="img/Iconos/icon_update.png">
                                    <p>ACTUALIZAR DATOS</p>
                                </div>
                            </div>
                        </div>
                        <input id="btn-menu" type="button" value="SUSPENDER SERVICIO">
                        <input id="btn-menu" type="button" value="APLICAR DESCUENTO">
                        <input id="btn-menu" type="button" value="HISTORIAL DE PAGOS">
                        <input id="btn-menu" type="button" value="GENERAR RECIBO DE PAGO">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="js/comportamientos.js"></script>
    <script src="js/animationMenu.js"></script>

    <script src="js/services/logout.js"></script>
</body>

</html>