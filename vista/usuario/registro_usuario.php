<?php include ('vista/includes/header.php');  ?>

	<section id="container">
		<div class="form_register">
			<h1>Registro usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : "" ; ?></div>

			<form action="index.php?acc=registro_usuario&opc=1" method="POST" enctype="multipart/form-data">

				<label for="nombre">Nombre completo</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre completo" required="required">

				<label for="usuario">Usuario </label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" required="required">

				<label for="contraseña">Contraseña</label>
				<input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" required="required">

				<label for="contraseñaConfirmar">Confirmar contraseña</label>
				<input type="password" name="contraseñaConfirmar" id="contraseñaConfirmar" placeholder="Confirmar contraseña" required="required">
				
				<label for="rol">Tipo Usuario</label>
				<select name="rol" id="rol">	
				<?php 
					//print_r($listaRol);
					foreach ($listaRol as $key) 
					{
						echo '<option value='.$key['idRol'].'>'.$key['rol'].'</option>';
					}

				 ?>
				</select>

				<label for="img_perfil">Imagen</label>
				<input type="file" name="img_perfil" size="25">
				
				<input type="submit" value="Crear usuario" class="btn_save">
			</form>
			
		</div>
	</section>
	
<?php include ('vista/includes/footer.php');  ?> 