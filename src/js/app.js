let paso=1;
const pasoMin=1;
const pasoMax=3;


document.addEventListener('DOMContentLoaded',()=>{
    IniciarApp();
});

function IniciarApp(){
    MostrarSeccion();
    Tabs();
    BotonesPaginador();
    PaginaSiguiente();
    PaginaAnterior();
    ConsultarAPi();
};

function MostrarSeccion(){


    let SeccionAnterior=document.querySelector('.mostrar');
    if(SeccionAnterior){
        SeccionAnterior.classList.remove('mostrar');
    }
    const seccion= document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    let tabAnterior=document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }
    const tab=document.querySelector(`[data-paso="${paso}"]`);
        tab.classList.add('actual');
};

function Tabs(){
    const Botones=document.querySelectorAll('.tabs button');
    Botones.forEach(boton=>{
        boton.addEventListener('click',function(e){
            paso = parseInt(e.target.dataset.paso);
            MostrarSeccion();
            BotonesPaginador();
            
        })
    })
    console.log(paso);
}
function BotonesPaginador(){
    const botonAnterior=document.querySelector('#anterior');
    const botonSiguiente=document.querySelector('#siguiente');

    if(paso ===1){
        botonAnterior.classList.add('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }
    else if(paso ===3){
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.add('ocultar');
    }
    else{
        
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }

}
function PaginaAnterior(){
    const botonAnterior=document.querySelector('#anterior');
    botonAnterior.addEventListener('click',function(){
        if(paso <=pasoMin) return;
        paso--;
        BotonesPaginador();
        MostrarSeccion();
         
    });
};
function PaginaSiguiente(){
    const botonSiguiente=document.querySelector('#siguiente');
    botonSiguiente.addEventListener('click',function(){
        if(paso >= pasoMax) return;
        paso++;
        MostrarSeccion();
        BotonesPaginador();
         
    });
};  
async function ConsultarAPi() {
   try{
    const Url="http://localhost:3000/api/servicios";
    const Resultado=await fetch(Url);

    const Servicios= await Resultado.json();
    MostrarServicio(Servicios);
    }
    catch(error){
        console.log(error);

    }
}
function MostrarServicio(Servicios){
    Servicios.forEach(servicio => {
        const{id,nombre,precio}=servicio;
        console.log(id);

        const nombreServicio=document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent=nombre;

        const precioServicio=document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent=`$ ${precio}`;

        const serviciosDiv=document.createElement('DIV');
        serviciosDiv.classList.add('servicio');
        serviciosDiv.dataset.idServicio=id;

        serviciosDiv.appendChild(nombreServicio);
        serviciosDiv.appendChild(precioServicio);

        console.log(serviciosDiv);
        const servicioSeccion=document.querySelector('#servicios');
        servicioSeccion.appendChild(serviciosDiv);
    });
} 