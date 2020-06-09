<?php include ('vista/includes/header.php');  ?>
	
	<section id="container">
		<h1>Lista de inventario</h1><br>
        <?php  
            // echo '<pre>';
            // print_r ($lista);
            // echo '</pre>';

			if ($_SESSION['idRol']==1)
			{
				echo '<a href="#" class="btn_new add_NewProduct">Agregar Stock Inventario</a>';

			}  

		?>
		

		<table>
			<tr>
                <th>ID</th>
				<th>Código</th>
				<th>Producto</th>
				<th>Marca</th>
				<th>Medida</th>	
                <th>Proveedor</th>
				<th>Bodega</th>
                <th>Estante</th>
                <th>Nivel</th>
                <th>Existencias</th>
                <th>Costo Total</th>
                <th>Costo unitario</th>
                <th>Accion</th>
			</tr>

		<?php foreach ($lista as $key) {
			echo '<tr class="row'.$key['id_inventario'].'">';

			
                echo '<td>'.$key['id_inventario'].'</td>';
				echo '<td>'.$key['id_producto'].'</td>';
				echo '<td>'.$key['producto'].'</td>';
				echo '<td>'.$key['Marca'].'</td>';
                echo '<td>'.$key['Unidad_medida'].'</td>';
                echo '<td>'.$key['nom_provee'].'</td>';
                echo '<td>'.$key['bodega'].'</td>';
                echo '<td>'.$key['estante'].'</td>';
                echo '<td class="celNivel">'.$key['nivel'].'</td>';
                echo '<td class="celExistencia">'.$key['Cantidad_existencia'].'</td>';
                echo '<td class="celCostoTotal">'.$key['Costo_total'].'</td>';
                echo '<td class="celCostoUni">'.$key['costo_unitario'].'</td>';
                echo '<td>';
            ?>
				<a class="link_edit add_product" product="<?php echo $key['id_producto'] ?>"  nivel="<?php echo $key['id_nivel'] ?>"  usuario="<?php echo $_SESSION['idUsu'] ?>" href="#">Agregar</a>
				
			
				</td>
			</tr>

			<?php } ?>
	
				
		</table>

	</section>

<?php include ('vista/includes/footer.php');  ?> 