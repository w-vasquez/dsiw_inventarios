<?php include ('vista/includes/header.php');  ?>

	<section id="container">
		<div class="form_register">
			<h1>Editar estante</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : "" ; ?></div>

			<form action="index.php?acc=actualizar_estante&opc=1" method="POST" enctype="multipart/form-data">

				<label for="nombre">Identificar estante</label>
				<input type="hidden" name="id" value="<?php echo $id_estante; ?>">
				<input type="text" name="nombre" value="<?php echo $estante_nom; ?>"  required="required">

				<label for="status">Estatus</label>				
				<select name="status" id="status" class="notItemOne">

				<?php 
					
					
							$opcion = '<option value="I" select>Inactivo</option>';
							
							if($estatus == 'Activo')
							{
								$opcion = '<option value="A" select>Activo</option>';
							}

							echo $opcion;
							echo '<option value="A">Activo</option>';
							echo '<option value="I">Inactivo</option>';
					?>
				</select>
				
				<label for="id_bodega">Bodega a asignadar</label>
				<select name="id_bodega" id="id_bodega" class="notItemOne">	
				<?php 

					echo '<option value='.$ID.'>'.$bodega_nom.'</option>';
					
					foreach ($lista_bodega as $key) 
					{
						echo '<option value='.$key['id_bodega'].'>'.$key['Nombre'].'</option>';
					}

				 ?>
				</select>
				
				<input type="submit" value="Actualizar nivel" class="btn_save">
			</form>
			
		</div>
	</section>
	
<?php include ('vista/includes/footer.php');  ?> 