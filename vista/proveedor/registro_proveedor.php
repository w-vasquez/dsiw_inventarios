<?php include ('vista/includes/header.php'); ?>

	<section id="container">
		<div class="form_register">
		
			<h1>Registro de Proveedores</h1>
			<br>
		
			<div class="alert"><?php echo isset($alert) ? $alert : "" ; ?></div>
			
			<form action="index.php?acc=registro_proveedor&opc=1" method="POST" enctype="multipart/form-data">
				
				
				<input type="hidden" name="id_proveedor" placeholder="id_proveedor " required="required">
				
				
				<label for="Nombre">Nombre  </label>
				<input type="text" name="nombre" placeholder="Nombre " required="required">
				
				<label for="Correo">Correo  </label>
				<input type="text" name="correo"  placeholder="Correo" required="required">
				
				<label for="Direccion">	Direccion </label>
				<input type="text" name="direccion" id="Direccion" placeholder="Direccion" required="required">
				
				
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
						
					
				<input type="submit" value="Crear Proveedor" class="btn_save">
			</form>
			
		</div>
	</section>
	
<?php include ('vista/includes/footer.php');  ?> 