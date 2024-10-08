<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>
<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input
         type="email" 
         name="email" 
         id="email"
         placeholder="Tu email"
        >
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input
         type="password" 
         name="password" 
         id="password"
         placeholder="Tu contraseña"
        >
    </div>
    <input type="submit" class="boton" value="iniciar sesion">
    </form>
    <div class="acciones">
        <a href="/crear-cuenta">¿Aun no tienes una cuenta?Crear una. </a>
        <a href="/olvide">¿Olvidaste tu contraseña?</a>

    </div>