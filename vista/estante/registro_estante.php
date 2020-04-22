<?php include ('vista/includes/header.php');  ?>

	<section id="container">
		<div class="form_register">
			<h1>Registro estantes</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : "" ; ?></div>

			<form action="index.php?acc=registro_estante&opc=1" method="POST" enctype="multipart/form-data">

				<label for="nombre">Identificar estante</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre del estante" required="required">

				<label for="status">Estatus</label>				
				<select name="status" id="status">
					<option value="A">Activo</option>
					<option value="I">Inactivo</option>
				</select>
				
				<label for="id_bodega">Bodega a asignadar</label>
				<select name="id_bodega" id="id_bodega">	
				<?php 
					//print_r($listaRol);
					foreach ($lista_bodega as $key) 
					{
						echo '<option value='.$key['id_bodega'].'>'.$key['nombre'].'</option>';
					}

				 ?>
				</select>
				
				<input type="submit" value="Crear nivel" class="btn_save">
			</form>
			
		</div>
	</section>
	
<?php include ('vista/includes/footer.php');  ?> 