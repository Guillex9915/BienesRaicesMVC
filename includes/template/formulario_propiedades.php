<fieldset>
            <legend>Información General</legend>
            <label for="titulo">Título</label>
            <input type="text" name="propiedad[titulo]" id="titulo" placeholder="Inserta el título de la propiedad" value="<?php echo s($propiedad->titulo) ; ?>" required>

            <label for="precio">Precio</label>
            <input required type="number" name="propiedad[precio]" id="precio" placeholder="Inserta el precio de la propiedad" min="1" value="<?php echo s($propiedad->precio); ?>">

            <label for="imagen">Imagen</label>
            <input type="file" accept="image/jpeg, image/png" id="imagen" name="propiedad[imagen]">

            <?php if ($propiedad->imagen): ?>
                <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
            <?php endif; ?>

            <label for="descripcion">Descripción</label>
            <textarea required id="descripcion" placeholder="Inserta un breve resumen de la propiedad..." name="propiedad[descripcion]"><?php echo s($propiedad->descripcion) ; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información de la propiedad</legend>
            <label for="habitaciones">Habitaciones</label>
            <input required type="number" name="propiedad[habitaciones]" id="habitaciones" placeholder="Inserta la cantidad de habitaciones" min="1" max="9" value="<?php echo s($propiedad->habitaciones) ; ?>">

            <label for="wc">Baños</label>
            <input required type="number" name="propiedad[wc]" id="wc" placeholder="Inserta la cantidad de baños" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

            <label for="estacionamiento">Estacionamiento</label>
            <input required type="number" name="propiedad[estacionamiento]" id="estacionamiento" placeholder="Inserta la cantidad de estacionamientos" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select name="propiedad[vendedorId]" id="vendedor">
                <option disabled selected>--Selecciona un vendedor--</option>
                <!--Agrega los vendedores segun el id en la tabla vendedores en la DB y hace que quede seleccionado si fue ingresado correctamente-->
                <?php foreach ($vendedores as $vendedor) { ?>
                    <option 
                    <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?>
                    value="<?php  echo  s($vendedor->id);  ?>" 
                    >
                        <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
                    </option>
                <?php } ?>

            </select>
        </fieldset>