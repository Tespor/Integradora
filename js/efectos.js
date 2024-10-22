const btnLogin = document.getElementById("btnLogin");
const btnRegistrar = document.getElementById("btnRegistrar");
const cajaFondo = document.getElementById("cajaFondo");
const formRegistrar = document.getElementById("formRegistrar");
const formLogin = document.getElementById("formLogin");
const txtIngresar = document.getElementById("txtIngresar");
const txtRegistrar = document.getElementById("txtRegistrar");
const ContenedorForms = document.getElementById("contenedorForms");
let rotacion = 185;

btnLogin.addEventListener('click', function(){
    txtIngresar.style.display = "grid";
    
    formRegistrar.style.display = "none";
    formLogin.style.display = "block";
    ContenedorForms.style.animation = "moveL 0.6s forwards";
    //Aparecer o desaparecer textos
    txtIngresar.style.animation = "Aparecer 0.4s forwards";
    txtRegistrar.style.animation = "Desaparecer 0.4s forwards";
    
    //Rotacion
    rotacion -= 180;
    cajaFondo.style.transform = `rotate(${rotacion}deg)`
});
btnRegistrar.addEventListener('click', function(){

    formRegistrar.style.display = "block";
    formLogin.style.display = "none";
    ContenedorForms.style.animation = "moveR 0.6s forwards";
    //Aparecer o desaparecer textos
    txtIngresar.style.animation = "Desaparecer 0.4s forwards";
    txtRegistrar.style.animation = "Aparecer 0.4s forwards";

    //Rotacion
    rotacion += 180;
    cajaFondo.style.transform = `rotate(${rotacion}deg)`

    formLogin.style.zIndex = "0";
    formRegistrar.style.zIndex = "2";

    txtIngresar.style.display = "none";
});

