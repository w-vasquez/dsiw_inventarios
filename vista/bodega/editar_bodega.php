<?php include ('vista/includes/header.php');  ?>

	<section id="container">
		<div class="form_register">
			<h1>Editar  Bodega</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : "" ; ?></div>

			<form action="index.php?acc=actualizar_bodega" method="POST" enctype="multipart/form-data">

				<label for="nombre">Nombre bodega</label>
				<input type="text" name="nombre" id="nombre"  value="<?php echo $Nombre; ?>" placeholder="Identificar bodega" required="required">

				<label for="dir">Ubicación</label>
				<textarea name="dir" id="dir"  required="required" rows="8" cols="38" placeholder="Escriba una ubicación física"></textarea>
				
				<label for="departamento">Departamento</label>
				<select name="dartamento" id="departamento">
					<option value="">Seleccionar una opción</option>
				<?php 
					foreach ($lista_departamento as $key) {
						echo "<option value=".$key['id_departamento'].">".$key['departamento']."</option>";
					}
				 ?>

				</select>
				<label for="municipio">Municipio</label>
				<select name="municipio" id="municipio">
						<option value="0">Selecciona un opción</option>
				</select>
				
				<input type="submit" value="ACTUALIZAR BODEGA" class="btn_save">
			</form>
			
		</div>
	</section>
	
<?php include ('vista/includes/footer.php');  ?> 