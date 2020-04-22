<?php include ('vista/includes/header.php');  ?>
	
	<section id="container">
		<h1>Lista de estantes</h1><br>
		<?php 

			if ($_SESSION['idRol']==1)
			{
				echo '<a href="index.php?acc=registro_nivel"class="btn_new">Crear nuevo</a>';

			}  

		?>
		

		<table>
			<tr>
				<th>ID</th>
				<th>Nivel</th>
				<th>Estante</th>
				<th>Bodega</th>	
				<th>Acción</th>
			</tr>
			<tr>

			<?php foreach ($lista as $key) {
				echo '<td>'.$key['id_nivel'].'</td>';
				echo '<td>'.$key['Nivel'].'</td>';
				echo '<td>'.$key['estante'].'</td>';
				echo '<td>'.$key['bodega'].'</td>';
				echo '<td>';
				echo '<a class="link_edit" href="#"> Editar</a> | ';
				echo '<a class="link_delete" href="#">Eliminar</a>';

			?>
				</td>
			</tr>

			<?php } ?>
	
				
		</table>

	</section>

<?php include ('vista/includes/footer.php');  ?> 