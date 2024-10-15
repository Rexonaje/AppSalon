<h1 class="nombre-pagina" >Crear nueva cita</h1>
<p  class="descripcion-pagina">Elige tus servicios a continuacion</p>

<div id="app">
    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion de la cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h1>Servicios</h1>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h1>Tus Datos y Cita</h1>
        <p class="text-center" >Coloca tus datos y fecha para tu cita</p >
        <form  class="formulario">
            <div class="campo">
                <label for="nombre">Tu nombre</label>
                <input 
                type="text"
                id="nombre"
                placeholder="Tu nombre"
                value="<?php echo $nombre;?>"
                disabled
                />
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                type="date"
                id="fecha"
                />
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                type="time"
                id="hora"
                />
            </div>
        </form>  
    </div>
    <div id="paso-3" class="seccion">
        <h1>Resumen:</h1>
        <p class="text-center" >Verifica que la informacion sea correcta. </p >
 
    </div>
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo; </button>
    </div>
</div>

<?php
    $script="
        <script src='build/js/app.js'></script>
    ";
?>