<?php include ('vista/includes/header.php');  ?>
	
	<section id="container">
		<h1>Lista De Bodega</h1><br>
		
		<?php 

			if ($_SESSION['idRol']==1)
			{
				echo '<a href="index.php?acc=registro_bodega"class="btn_new">Crear nuevo</a>';

			}  

		?>
		<table>
			<tr>
				<th>ID</th>
				<th>Bodega</th>
				<th>Estatus</th>
				<th>Estantes habilitados</th>	
				<th>Municipio</th>
				<th>Departamento</th>
				<th>Accion</th>
			</tr>
			<tr>

			<?php foreach ($lista as $key) {
				echo '<td>'.$key['id_bodega'].'</td>';
				echo '<td>'.$key['Nombre'].'</td>';
				echo '<td>'.$key['status2'].'</td>';
				echo '<td>'.$key['cant_estantes'].'</td>';
				echo '<td>'.$key['municipio'].'</td>';
				echo '<td>'.$key['departamento'].'</td>';
				echo '<td>';
				echo '<a class="link_edit" href="index.php?acc=editar_bodega&idbodega='.$key['id_bodega'].'"> Editar</a> | ';
				echo '<a class="link_delete" href="#">Eliminar</a>';
				/*echo '<td>';
				echo '<a class="link_edit" href="#"> Editar</a> | ';
				echo '<a class="link_delete" href="#">Eliminar</a>';*/

			?>
				</td>
			</tr>

			<?php } ?>
	
				
		</table>

	</section>

<?php include ('vista/includes/footer.php');  ?> 