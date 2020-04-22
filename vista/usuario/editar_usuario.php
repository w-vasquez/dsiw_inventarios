<?php include ('vista/includes/header.php'); ?>

	<section id="container">
		<div class="form_register">
			<h1>Editar usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : "" ; ?></div>

			<form action="index.php?acc=actualizar_usuario"  method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<label for="nombre">Nombre completo</label>
				<input type="text" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre completo" required="required">

				<label for="usuario">Usuario </label>
				<input type="text" name="usuario" value="<?php echo $usr; ?>" placeholder="Usuario" required="required">

				<label for="contraseña">Contraseña</label>
				<input type="password" name="contraseña" id="contraseña" placeholder="Contraseña">

				<label for="contraseñaConfirmar">Confirmar contraseña</label>
				<input type="password" name="contraseñaConfirmar" id="contraseñaConfirmar" placeholder="Confirmar contraseña">
				
				<?php 

					if ($_SESSION['idRol'] == 1)
					{
						echo '<label for="rol2">Tipo Usuario</label>';
						echo '<select name="rol2" id="rol2" class="notItemOne">';
						$opcion = '';

						if ($idrol==1) {
							$opcion	= '<option value="'.$idrol.'" select>'.$rol3.'</option>';
						}
						if ($idrol==2) {
							$opcion	= '<option value="'.$idrol.'" select>'.$rol3.'</option>';
						} 
						
						echo $opcion;

						foreach ($listaRol as $key) 
						{
							echo '<option value='.$key['idRol'].'>'.$key['rol'].'</option>';
						}

						echo '</select>';				 
					
						echo '<input type="hidden" name="rol_nom" value=".$rol.">';
					
						echo '<label for="status">Estatus</label>';
					
						echo '<select name="status" id="status" class="notItemOne">';
					
							$opcion2 = '<option value="I" select>Inactivo</option>';
							
							if($stt == 'Activo')
							{
								$opcion2 = '<option value="A" select>Activo</option>';
							}

							echo $opcion2;
							echo '<option value="A">Activo</option>';
							echo '<option value="I">Inactivo</option>';

						echo '</select>';					
					}
				?>
				<label for="img_perfil">Imagen</label>

				<input type="file" name="img_perfil" size="25">
				<input type="submit" value="Actualizar usuario" class="btn_save">
			</form>
		</div>
	</section>
	
<?php include ('vista/includes/footer.php');  ?> 