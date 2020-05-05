<?php include ('vista/includes/header.php');  ?>
	
	<section id="container">
		<h1>Lista de usuarios</h1><br>
		<?php 

		if ($_SESSION['idRol']==1)
		{
			echo '<a href="index.php?acc=registro_usuario"class="btn_new">Crear nuevo</a>';
		}  

		?>

		<table>
			<tr>
				<th>Foto</th>
				<th>ID</th>
				<th>Usuario</th>
				<th>Nombre completo</th>
				<th>Estatus</th>
				<th>Rol</th>
				<th>Acciones</th>

			</tr>
			<tr>

			<?php foreach ($lista as $key) {
				echo '<td><img class="photouser" src="img/profile/'.$key['usr'].'/'.$key['imagen'].'" alt='.$key['nombre'].'></td>';
				echo '<td>'.$key['ID'].'</td>';
				echo '<td>'.$key['usr'].'</td>';
				echo '<td>'.$key['nombre'].'</td>';
				echo '<td>'.$key['estatus'].'</td>';
				echo '<td>'.$key['rol'].'</td>';
				echo '<td>';
				echo '<a class="link_edit" href="index.php?acc=editar_usuario&id='.$key['ID'].'"> Editar</a> | ';
				echo '<a class="link_delete" href="#">Eliminar</a>';

			?>
				</td>
			</tr>

			<?php } ?>

			
				<!-- <td><img class="photouser" src="img/user.png" alt="Usuario"></td>
						<td>1</td>
						<td>Wilfredo Vásquez</td>
						<td>Activo</td>
						<td>Rol</td>
						<td>
							<a class="link_edit" href="#">Editar</a>
							|
							<a class="link_delete" href="#">Eliminar</a>	 -->		
				
		</table>

	</section>

<?php include ('vista/includes/footer.php');  ?> 