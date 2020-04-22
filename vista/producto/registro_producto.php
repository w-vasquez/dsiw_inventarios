<?php
 include ('vista/includes/header.php');  ?>

	<section id="container">
		<div class="form_register">
			<h1>Registro productos</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : "" ; ?></div>

			<form action="index.php?acc=registro_producto&opc=1" method="POST" enctype="multipart/form-data">
			
				<label for="Nombre">Nombre del producto</label>
				<input type="text" name="nombre" id="Nombre" placeholder="Nombre completo" required="required">

				<label for="Marca">Marca </label>
				<input type="text" name="marca" id="Marca" placeholder="Marca" required="required">

				<label for="uni_medida">Unidad de medida</label>
				<input type="text" name="uni_medida" id="uni_medida" placeholder=" Unidad de medida del producto" required="required">

				<label for="id_categoria">Categoría</label>
				<select name="id_categoria" id="id_categoria">	
				<?php 
					//print_r($listaRol);
					foreach ($lista_categoria as $key) 
					{
						echo '<option value='.$key['id_categoria'].'>'.$key['nombre'].'</option>';
					}

				 ?>
				</select>

				<label for="id_proveedor">Nombre proveedor</label>
				<select name="id_proveedor" id="id_proveedor">	
				<?php 
					//print_r($listaRol);
					foreach ($lista_proveedor as $key) 
					{
						echo '<option value='.$key['ID'].'>'.$key['Nombre'].'</option>';
					}

				 ?>
				</select>

				<label for="cant_mini">Cantidad mínima</label>
				<input type="text" name="cant_mini" id="cant_mini" placeholder="Cantidad mínima" required="required">

				<label for="cant_max">Cantidad máxima </label>
				<input type="text" name="cant_max" id="cant_max" placeholder="Cantidad máxima" required="required">

				<label for="img_prodc">Imagen</label>
				<input type="file" name="img_prodc" size="25">

				<input type="submit" value="Ingresar productos" class="btn_save">
			</form>

		</div>
	</section>
	
<?php include ('vista/includes/footer.php');  ?> 