<main class="contenedor seccion">
    <a href="/admin" class="boton boton-verde">
        Volver
    </a>
    <h1 class="titulos">Registrar Vendedor</h1>


    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" action="/vendedores/crear" method="POST">

        <?php include __DIR__ . "/formulario.php"; ?>

        <input type="submit" value="Registrar Vendedor" class="boton boton-verde separacion-vertical sombra">
    </form>

</main>