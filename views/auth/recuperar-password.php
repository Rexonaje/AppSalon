<h1 class="nombre-pagina">Reestablecer Constraseña</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuacion</p>
<?php @include_once __DIR__ ."/../templates/alertas.php"  ;?>
<?php if(!$error): ?>
<form  method="POST" class="formulario">
    
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu nuevo Password">
    </div>
    <input type="submit" class="boton" value="Guardar">
</form>
<?php endif; ?>
<div class="acciones">
        <a href="/crear-cuenta">¿Aun no tienes una cuenta?Crear una. </a>
        <a href="/">¿ya tienes una cuenta? Iniciar sesion . </a>

</div>