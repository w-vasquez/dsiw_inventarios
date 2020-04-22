
<?php $rol = $_SESSION['idRol'];  ?>

<nav>
	<ul>
		<li><a href="index.php?acc=inicio">Inicio</a></li>
		<?php 
			if($rol == 1)
			{
				echo '<li class="principal">';
				echo 	'<a href="#">Usuarios</a>';
				echo 	'<ul>';
				echo 		'<li><a href="index.php?acc=registro_usuario&opc=0">Nuevo Usuario</a></li>';
				echo 		'<li><a href="index.php?acc=lista_usuarios&opc=0">Lista de Usuarios</a></li>';
				echo 	'</ul>';
				echo '</li>';
			}
			else
			{
				echo '';	
			} 
		?>
		<li class="principal">
			<a href="#">Bodega</a>
			<ul>	
				<?php 
					if ($rol == 1) 
					{
					 	echo '<li><a href="index.php?acc=registro_bodega&opc=0">Nueva Bodega</a></li>';
					} 
					else
					{
						echo '';
					}
						
				?>
				<li><a href="index.php?acc=lista_bodega">Lista de Bodega</a></li>
			</ul>
		</li>
		<li class="principal">
			<a href="#">Proveedores</a>
			<ul>
				<?php 
					if ($rol == 1) 
					{
						echo '<li><a href="index.php?acc=registro_proveedor&opc=0">Nuevo Proveedor</a></li>';
					}
					else
					{
						echo '';
					}
				?>
				<li><a href="index.php?acc=lista_proveedor">Lista de Proveedores</a></li>
			</ul>
		</li>
		<li class="principal">
			<a href="#">Productos</a>
			<ul>
				<?php 
					if ($rol == 1) 
					{
						echo '<li><a href="index.php?acc=registro_producto&opc=0">Nuevo Producto</a></li>';
					}
					else
					{
						echo '';
					}
				?>
				
				<li><a href="index.php?acc=lista_producto">Lista de Productos</a></li>
			</ul>
		</li>
		<li class="principal">
			<a href="#">Estantes</a>
			<ul>
				<?php 
					if ($rol == 1) 
					{
						echo '<li><a href="index.php?acc=registro_estante&opc=0">Nuevo estante</a></li>';
					}
					else
					{
						echo '';
					}
				?>
				<li><a href="index.php?acc=lista_estantes">Lista de estantes</a></li>
			</ul>
		</li>
		<li class="principal">
			<a href="#">Niveles</a>
			<ul>
				<?php 
					if ($rol == 1) 
					{
						echo '<li><a href="index.php?acc=registro_nivel">Nuevo nivel</a></li>';
					}
					else
					{
						echo '';
					}
				?>
				
				<li><a href="index.php?acc=lista_nivel">Lista de niveles</a></li>
			</ul>
		</li>
	</ul>
</nav>

