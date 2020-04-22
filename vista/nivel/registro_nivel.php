<?php include ('vista/includes/header.php');  ?>

	<section id="container">
		<div class="form_register">
			<h1>Registro niveles</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : "" ; ?></div>

			<form action="index.php?acc=registro_nivel&opc=1" method="POST" enctype="multipart/form-data">

				<label for="nombre">Identificar nivel</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre del nivel" required="required">
				
				<label for="bodega">Bodega origen</label>
				<select name="bodega" id="bodega">	
						<option value="">Seleccionar un bodega</option>
				<?php 

					foreach ($lista_bodega as $key): 
				?>
						<option value="<?php echo $key['id_bodega'] ?> "> <?php  echo $key['Nombre'] ?> </option>
				<?php 
					endforeach;
				?>
				</select>
			

				<label for="estante">Estante origen</label>
				<select name="estante" id="estante">
					<option value="0">Selecciona un estante</option>
				</select>
				
				<input type="submit" value="Crear nivel" class="btn_save">
			</form>
			
		</div>
	</section>
	
<?php include ('vista/includes/footer.php');  ?> 