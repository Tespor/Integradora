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

            <!--Modal registrar cuenta-->
            <div class="popover-container">
                <input popovertargetaction="show" class="open-popover" popovertarget="registroCuentas" id="btn-menu" type="button" value="REGISTRAR UNA CUENTA">
                <div class="modalX" id="registroCuentas" popover>
                    <h2>Agrega una cuenta a tu sevicio</h2>
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
                        <input class="editText2" type="text" id="cardHolder" name="cardHolder" placeholder="Numero - Calle - Colonia" required>

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
                        <!--Modal de pago-->
                        <div class="popover-container">
                            <button popovertargetaction="show" class="open-popover" popovertarget="PopPagar" id="PagarPopUp">PAGAR</button>
                            <div class="contentModal">
                                <div class="modalX" id="PopPagar" popover>
                                    <h2>Pagos de servicio</h2>
                                    <div class="divider"></div>
                                    <div class="d-flex">
                                        <button id="btnBorrarTarjeta" class="btnRounded">
                                            <img src="img/Iconos/icon_delete.png" alt="">
                                        </button>
                                        <!--Alerta de borrar tarjeta-->
                                        <div id="popup" class="popup">
                                            <div class="popup-content">
                                                <p>¿Estás seguro de que deseas eliminar este registro?</p>
                                                <div class="content-btn">
                                                    <button id="confirmar" class="popup-btn">OK</button>
                                                    <button id="cancelar" class="popup-btn">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>

                                        <button id="btnNewTarjeta" class="btnRounded">
                                            <img src="img/Iconos/icon_+.png" alt="">
                                        </button>
                                        <button id="btnOldTarjeta" class="btnTransparent">
                                            tarjetas registradas
                                        </button>
                                    </div>

                                    <form id="formCrearTarjetas" style="display: none;">
                                        <label for="cardNumber">Número de Tarjeta:</label>
                                        <input class="editText2" type="text" id="Tarjeta" name="Tarjeta" placeholder="1234 5678 9101 1121" maxlength="19" minlength="16" required>

                                        <label for="cardHolder">Nombre del Titular:</label>
                                        <input class="editText2" type="text" id="Titular" name="Titular" placeholder="Nombre Completo" required>

                                        <label for="banco">Tipo de banco:</label>
                                        <select id="Banco" name="Banco" required>
                                            <option value="" disabled selected>Seleccione un banco</option>
                                            <option value="bancomer">BBVA Bancomer</option>
                                            <option value="banamex">Citibanamex</option>
                                            <option value="santander">Santander</option>
                                            <option value="banorte">Banorte</option>
                                            <option value="hsbc">HSBC</option>
                                            <option value="scotiabank">Scotiabank</option>
                                            <option value="inbursa">Banco Inbursa</option>
                                            <option value="bajio">Banco del Bajío</option>
                                            <option value="azteca">Banco Azteca</option>
                                            <option value="banregio">Banregio</option>
                                            <option value="intercam">Nu Mexico</option>
                                            <option value="banco-famsa">Banco Famsa</option>
                                            <option value="afirme">Afirme</option>
                                            <option value="ci-bank">Ci Banco</option>
                                            <option value="banco-finterra">Banco Finterra</option>
                                            <option value="bancoppel">Bancoppel</option>
                                            <option value="compartamos-banco">Compartamos Banco</option>
                                        </select>
                                        <br><br>

                                        <div class="row">
                                            <div class="col-sm-12 col-md 6">
                                                <label for="expiryDate">Fecha de Vencimiento:</label>
                                                <input class="editText2" type="text" id="FechaVencimiento" name="FechaVencimiento" placeholder="MM/AA" maxlength="5" required>
                                            </div>
                                            <div class="col-sm-12 col-md 6">
                                                <label for="cvv">CVV:</label>
                                                <input class="editText2" type="password" id="CVV" name="CVV" placeholder="123" maxlength="3" required>
                                            </div>
                                        </div>

                                        <button type="submit">GUARDAR</button>
                                    </form>
                                    <form id="formPagar">
                                        <select name="ddlTarjeta" id="ddlTarjeta" class="select2"></select>
                                        <div class="tarjeta" id="tarjeta" style="display: none;">
                                            <div class="chip"></div>
                                            <div class="nombreBanco" id="tBanco">Banco</div>
                                            <div class="numTarjeta" id="tNum">0014 6721 3422 1789</div>
                                            <div class="expiracion">
                                                <span id="tFV">12/28</span>
                                            </div>
                                            <div class="nomTitular" id="tTitular">Name Sure Name</div>
                                            <div class="tipoTarjeta">Debito</div>
                                            <div class="logo"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="popover-container">
                            <input popovertargetaction="show" class="open-popover" popovertarget="PopQR" id="btnQR" type="button" value="GENERAR QR DE PAGO">
                            <!--Modal QR-->
                            <div class="modalX" id="PopQR" popover>
                                <h2>escanea el QR</h2>
                                <div class="divider"></div>
                                <center>
                                    <div id="imgQR"></div>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="fondoPop" class="fondoPop"></div>

        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!--CDN para QR-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <!--mis js-->
        <script src="js/qr_generar.js"></script>
        <script src="js/animationMenu.js"></script>
        <script src="js/services/axiosCliente.js"></script>
        <script src="js/services/logout.js"></script>
        <script src="js/PopUp.js"></script>
</body>

</html>