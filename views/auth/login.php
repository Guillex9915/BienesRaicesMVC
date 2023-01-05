<main class="contenedor seccion contenido-centrado separacion-vertical">
        <h1 class="titulos">Iniciar Sesión</h1>

        <?php foreach($errores as $error) : ?>
            <div class="alerta error">
                <?php echo $error;?>
            </div>
        
        <?php endforeach;?>

        <form class="formulario" action="/login" method="POST">
        <fieldset>
            <legend>Correo Electrónico y Contraseña</legend>

            <label for="email">E-mail</label>
            <input name="email" type="email" placeholder="Tú E-mail" id="email" required>

            <label for="password">Contraseña</label>
            <input name="password" type="password" placeholder="Tú contraseña" id="password" required>

        </fieldset>

        <input type="submit" class="boton boton-verde separacion-vertical alinear-derecha" value="Iniciar Sesión">
        </form>
    </main>