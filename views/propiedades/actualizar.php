<main class="seccion contenedor">
<a href="/admin" class="boton boton-verde">Volver</a>
    <h1 class="titulos">Actualizar Propiedad</h1>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST" class="formulario" enctype="multipart/form-data">
        <?php include __DIR__ . "/formulario.php"; ?>   
        <input type="submit" class="boton boton-verde separacion-vertical" value="Actualizar">
    </form>
    
</main>

