document.addEventListener('DOMContentLoaded', function () {
    const btnQR = document.getElementById('btnQR');
    const QRcode = document.getElementById('imgQR');

    btnQR.addEventListener('click', function () {
        //Eliminar qr
        const qrContent = document.getElementById('imgQR');
        qrContent.innerHTML = '';

        const DatosCuenta = [
            nom_recibo.textContent,
            dir_recibo.textContent,
            cuenta_recibo.textContent,
            mesespagados_recibo.textContent,
            total_recibo.textContent
        ]

        const datosLlenos = DatosCuenta.every(dato => dato.trim() !== "");

        if (datosLlenos) {
            new QRCode(QRcode, {
                //text: `${EstadoServicio.textContent},${TipoContrato.textContent},${Direccion.textContent},${ConsumoProm.textContent},${ConsumoMes.textContent},${ProxVencimiento.textContent},${AdeudoTotal.textContent}`,
                text: DatosCuenta.join(","),
                width: 256,
                height: 256,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            QRcode.style.padding = "10px";
            QRcode.style.background = "#fff"
            QRcode.style.display = "inline-block"
            QRcode.style.borderRadius = "8px"

        } else {
            QRcode.style.padding = "0";
            QRcode.style.background = "#00000000"
            QRcode.textContent = "Seleccione una cuenta para poder generar un QR"
        }
    });
})


