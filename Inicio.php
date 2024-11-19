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
                
                <?php
                    session_start();
                    echo $_SESSION['nombre'] ?? 'No disponible';
                ?>

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

            <input popovertarget="registroCuentas" id="btn-menu" type="button" value="REGISTRAR UNA CUENTA">
            <div class="contentModal">
                <div class="modalX" id="registroCuentas" popover>
                    <h2>agrega una cuenta a tu sevicio</h2>
                    <div class="divider"></div>
                    <form id="formCuenta">
                        <label for="cardNumber">Tipo de contrato</label>
                        <select class="custom-spinner" name="ddlCuentas" id="ddlTipoContrato">
                            <option value="Comercial">Comercial</option>
                            <option value="Domestico">Domestico</option>
                        </select>
                        <br>
                        <br>
                        <label for="cardHolder">Direccion</label>
                        <input class="editText2" type="text" id="cardHolder" name="cardHolder" placeholder="Numero, Calle, Colonia" required>

                        <div class="row">
                            <div class="col-sm-12 col-md 6">
                                <label for="CuentaActiva">Activo</label>
                                <input type="radio" name="grupo" value="Activo" id="CuentaActiva" required>                       
                            </div>
                            <div class="col-sm-12 col-md 6">
                                <label for="CuentaInactiva">Inactivo</label>
                                <input type="radio" name="grupo" value="Inactivo" id="CuentaInactiva">                       
                            </div>
                        </div>

                        <button type="submit">CREAR</button>
                    </form>
                </div>
            </div>

            <div class="divider"></div>
            <label for="ddlCuenta">Numero de cuenta</label>
            <select class="custom-spinner" name="ddlCuentas" id="ddlCuentas">
            </select>
        </div>
    </div>
    <!--Datos del lado izquierdo-->
    <div class="container datosCuentas">

        <div class="separador-lg"></div><!--Para dar espacio TOP-->

        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4" id="columnaGuia"></div>
            <div class="col-sm-12 col-md-6 col-lg-8" id="DatosDinamicos">

                <h4>DATOS DE LA CUENTA</h4>
                <br>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="cardServ">
                            <div class="text-icon">
                                <img src="img/Iconos/icon_calendario.png" alt="Icono">
                                <h2>Estados del servicio</h2>
                            </div>
                            <hr>
                            <p id="EstadoServicio"></p>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="cardServ">
                            <div class="text-icon">
                                <img src="img/Iconos/icon_calendario.png" alt="Icono">
                                <h2>Proximo Vencimiento</h2>
                            </div>
                            <hr>
                            <p id="ProxVencimiento"></p>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="cardServ">
                            <div class="text-icon">
                                <img src="img/Iconos/icon_calendario.png" alt="Icono">
                                <h2>Tipo de contrato</h2>
                            </div>
                            <hr>
                            <p id="TipoContrato"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="cardServ">
                            <div class="text-icon">
                                <img src="img/Iconos/icon_calendario.png" alt="Icono">
                                <h2>Consumo del mes</h2>
                            </div>
                            <hr>
                            <p id="ConsumoMes"></p>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="cardServ">
                            <div class="text-icon">
                                <img src="img/Iconos/icon_calendario.png" alt="Icono">
                                <h2>Consumo Promedio</h2>
                            </div>
                            <hr>
                            <p id="ConsumoProm"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="cardServ">
                            <div class="text-icon">
                                <img src="img/Iconos/icon_calendario.png" alt="Icono">
                                <h2>Direccion</h2>
                            </div>
                            <hr>
                            <p id="Direccion"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="pTotal">
                            <h3>ADEUDO TOTAL</h3>
                            <h1 id="adeudoTotalH1"></h1>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <input popovertarget="PopHistorial" id="btn-menu" type="button" value="HISTORIAL DE PAGOS">
                        <input popovertarget="PopPagar" id="btn-menu" type="button" value="PAGAR">
                        <input popovertarget="PopQR" id="btn-menu" type="button" value="GENERAR QR DE PAGO">
                    </div>
                </div>
        </div>
        <!--Modal historial de pago-->
        <div class="contentModal">
            <div class="modalX" id="PopHistorial" popover>
                <h2>historial de pagos</h2>
                <div class="divider"></div>
                <p id="ProxVencimiento">Cantidad</p>
                <p id="ProxVencimiento">Cantidad</p>
                <p id="ProxVencimiento">Cantidad</p>
                <p id="ProxVencimiento">Cantidad</p>
                <p id="ProxVencimiento">Cantidad</p>
            </div>
        </div>

        <!--Modal historial de pago-->
        <div class="contentModal">
            <div class="modalX" id="PopPagar" popover>
                <h2>agrega una tarjeta para pagar</h2>
                <div class="divider"></div>
                <form id="cardForm">
                    <label for="cardNumber">Número de Tarjeta</label>
                    <input class="editText2" type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9101 1121" maxlength="19" required>
              
                    <label for="cardHolder">Nombre del Titular</label>
                    <input class="editText2" type="text" id="cardHolder" name="cardHolder" placeholder="Nombre Completo" required>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md 6">
                            <label for="expiryDate">Fecha de Vencimiento</label>
                            <input class="editText2" type="number" id="expiryDate" name="expiryDate" placeholder="MM/AA" maxlength="5" required>
                        </div>
                        <div class="col-sm-12 col-md 6">
                            <label for="cvv">CVV</label>
                            <input class="editText2" type="password" id="cvv" name="cvv" placeholder="123" maxlength="3" required>
                        </div>
                    </div>
              
                    <button type="submit">PAGAR</button>
                </form>
            </div>
        </div>

        <!--Modal QR-->
        <div class="contentModal">
            <div class="modalX" id="PopQR" popover>
                <h2>escanea el QR</h2>
                <div class="divider"></div>
                <center>
                    <img src="img/Iconos/icon_qr.JPG" alt="">
                </center>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/animationMenu.js"></script>
    <script src="js/services/axiosCliente.js"></script>
    <script src="js/services/logout.js"></script>
</body>

</html>