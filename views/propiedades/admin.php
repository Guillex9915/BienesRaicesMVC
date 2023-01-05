<main class="contenedor seccion contenido-centrado">
    <h1 class="titulos">Administrador de bienes raices</h1>
    <?php
    if($resultado) {
        $mensaje = mostrarNotificacion(intval($resultado));
        if ($mensaje) { ?>
            <p class="alerta exito"> <?php echo s($mensaje) ?> </p>
        <?php } 
    }
    ?>



    <a href="/propiedades/crear" class="boton boton-amarillo">Nueva propiedad</a>

    <h3 class="titulos">Lista de propiedades</h3>

    <!--Creando la tabla para listar los datos-->
    <table class="propiedades  contenedor separacion-vertical">
        <thead>
            <tr class="">
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!--Mostrar la base de datos-->
            <?php foreach ($propiedades as $propiedad) : ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="../imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla contenido-centrado"></td>
                    <td> $ <?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100" action="/propiedades/eliminar">

                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton boton-rojo-block separacion-vertical" value="Eliminar"></input>
                        </form>

                        <a href="/propiedades/actualizar?id=<?php echo $propiedad->id; ?> " class="boton boton-actualizar-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="titulos">Vendedores</h3>

    <a href="/vendedores/crear" class="boton boton-amarillo">Registrar Vendedor</a>

    <!--Creando la tabla para listar los vendedores-->
    <table class="propiedades contenedor separacion-vertical">
        <thead>
            <tr class="">
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!--Mostrar la base de datos-->
            <?php foreach ($vendedores as $vendedor) : ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100" action="/vendedores/eliminar">

                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton boton-rojo-block separacion-vertical" value="Eliminar"></input>
                        </form>

                        <a href="/vendedores/actualizar?id=<?php echo $vendedor->id; ?> " class="boton boton-actualizar-block">Actualizar</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

    

</main>