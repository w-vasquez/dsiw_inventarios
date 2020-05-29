<?php include ('vista/includes/header.php');  ?>
	
	<section id="container">
		<h1>Lista de Productos</h1><br>
		<?php 

			if ($_SESSION['idRol']==1)
			{
				echo '<a href="index.php?acc=registro_producto" class="btn_new">Crear nuevo</a>';
	        echo '<a href="index.php?acc=r1" target="_blank">Imprimir</a></br>';
		
			}  

		?>
		

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Unidad de medida</th>
				<th>Proveedor</th>
				<th>Cant. Mínima</th>
				<th>Cant. Máxima</th>
				<th>Marca</th>		
				<th>Estatus</th>
				<th>Costo Unitario</th>
				<th>Categoría</th>
				<th>Acción</th>
				<th>Eliminar   </th>
			   <th>Modificar </th>
			</tr>
			<tr>

			<?php foreach ($lista as $key) {
				echo '<td>'.$key['id_producto'].'</td>';
				echo '<td>'.$key['Nombre'].'</td>';
				//echo '<td>'.$key['foto'].'</td>';
				echo '<td>'.$key['Nombre'].'</td>';
				echo '<td>'.$key['Unidad_medida'].'</td>';
				echo '<td>'.$key['proveedor'].'</td>';
				echo '<td>'.$key['Cantidad_minima'].'</td>';
				echo '<td>'.$key['Cantidad_maxima'].'</td>';
				echo '<td>'.$key['Marca'].'</td>';
				echo '<td>'.$key['estatus'].'</td>';
				echo '<td>'.$key['cto_uni'].'</td>';
				echo '<td>'.$key['categoria'].'</td>';
				echo '<td>';
				
			$confirmar="return confirm('Estas seguro de Eliminar el registro?');";
			echo '<td><a href="index.php?acc=5&id='.$key['id_producto'].'" onclick="'.$confirmar.'">Eliminar</a></td>';
						
			echo '<td><a href="index.php?acc=editar_Producto&id_pro='.$key['id_producto'].'">Modificar</a></td>';		
					
						
		   ?>   
				</td>
			</tr>

			<?php } ?>
	
				
		</table>

	</section>

<?php include ('vista/includes/footer.php');  ?> 