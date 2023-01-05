<fieldset>
            <legend>Información General</legend>
            <label for="nombre">Nombre</label>
            <input type="text" name="vendedor[nombre]" id="nombre" placeholder="Inserta el nombre del vendedor" 
            value="<?php echo s($vendedor->nombre) ; ?>" required>
            <label for="apellido">Apellido</label>
            <input type="text" name="vendedor[apellido]" id="apellido" placeholder="Inserta el apellido del vendedor" 
            value="<?php echo s($vendedor->apellido) ; ?>" required>
            <label for="telefono">Teléfono</label>
            <input type="number" name="vendedor[telefono]" id="telefono" placeholder="Agrega el número de teléfono" 
            value="<?php echo s($vendedor->telefono) ; ?>" required>

</fieldset>