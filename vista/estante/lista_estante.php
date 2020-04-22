<?php include ('vista/includes/header.php');  ?>
	
	<section id="container">
		<h1>Lista de estantes</h1><br>
		<?php 

			if ($_SESSION['idRol']==1)
			{
				echo '<a href="index.php?acc=registro_estante"class="btn_new">Crear nuevo</a>';

			}  

		?>
		

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre bodega</th>
				<th>Nombre estante</th>
				<th>Estatus	</th>	
				<th>Numero de niveles</th>
				<th>Acción</th>
			</tr>
			<tr>

			<?php foreach ($lista as $key) {
				echo '<td>'.$key['ID'].'</td>';
				echo '<td>'.$key['bodega'].'</td>';
				echo '<td>'.$key['estante'].'</td>';
				echo '<td>'.$key['estatus'].'</td>';
				echo '<td>'.$key['num_niveles'].'</td>';
				echo '<td>';
				echo '<a class="link_edit" href="#"> Editar</a> | ';
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