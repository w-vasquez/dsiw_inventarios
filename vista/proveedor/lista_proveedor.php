<?php include ('vista/includes/header.php');  ?>
	
	<section id="container">
		<h1>Lista de Proveedor</h1><br>
		

		<?php 

			if ($_SESSION['idRol']==1)
			{
				echo '<a href="index.php?acc=registro_proveedor"class="btn_new">Crear nuevo</a>';

			}  

		?>
		

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre completo</th>
				<th>Dirección</th>
				<th>Correo</th>
				<th>Municipio</th>
				<th>Departamento</th>
			</tr>
			<tr>

			<?php foreach ($lista as $key) {
			
				echo '<td>'.$key['ID'].'</td>';
				echo '<td>'.$key['Nombre'].'</td>';
				echo '<td>'.$key['direccion'].'</td>';
				echo '<td>'.$key['correo'].'</td>';
				echo '<td>'.$key['municipio'].'</td>';
				echo '<td>'.$key['departamento'].'</td>';
				//echo '<td>';
				

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