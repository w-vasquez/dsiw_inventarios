
<?php $rol = $_SESSION['idRol'];  ?>

<nav>
	<ul>
		<li><a href="index.php?acc=inicio">Inicio</a></li>
<?php 
	switch ($rol) {
		case 1: ?>

			<li class="principal">
			<a href="#">Usuarios</a>
			<ul>
				<li><a href="index.php?acc=registro_usuario&opc=0">Nuevo Usuario</a></li>
				<li><a href="index.php?acc=lista_usuarios&opc=0">Lista de Usuarios</a></li>
			</ul>
			</li>
			<li class="principal">
				<a href="#">Bodega</a>
				<ul>
					<li><a href="index.php?acc=registro_bodega&opc=0">Nueva Bodega</a></li>
					<li><a href="index.php?acc=lista_bodega">Lista de Bodega</a></li>
				</ul>
			</li>
			<li class="principal">
				<a href="#">Proveedores</a>
				<ul>
					<li><a href="index.php?acc=registro_proveedor&opc=0">Nuevo Proveedor</a></li>
					<li><a href="index.php?acc=lista_proveedor">Lista de Proveedores</a></li>
				</ul>
			</li>
			<li class="principal">
				<a href="#">Productos</a>
				<ul>
					<li><a href="index.php?acc=registro_producto&opc=0">Nuevo Producto</a></li>
					<li><a href="index.php?acc=lista_producto">Lista de Productos</a></li>
					<a href="reportes/reporteProductos.php?" >Imprimir</a> |
					
				</ul>
			</li>
			<li class="principal">
				<a href="#">Estantes</a>
				<ul>
					<li><a href="index.php?acc=registro_estante&opc=0">Nuevo estante</a></li>
					<li><a href="index.php?acc=lista_estantes">Lista de estantes</a></li>
					<li><a href="index.php?acc=reporte_estante">Reporte de estantes</a></li>
				</ul>
			</li>
			<li class="principal">
				<a href="#">Niveles</a>
				<ul>
					<li><a href="index.php?acc=registro_nivel">Nuevo nivel</a></li>
					<li><a href="index.php?acc=lista_nivel">Lista de niveles</a></li>
				</ul>
			</li>
			<li class="principal">
				<a href="">Movimientos</a>
				<ul>
					<li><a href="index.php?acc=registro_movimiento">Movimiento de inventario</a></li>
					<li><a href="index.php?acc=lista_movimiento">Lista de movimientos</a></li>
				</ul>
			</li>
			
		<?php	break;
		case 2: ?>

			<li class="principal">
			<a href="#">Usuarios</a>
			<ul>
				<li><a href="index.php?acc=lista_usuarios&opc=0">Lista de Usuarios</a></li>
			</ul>
			</li>
			<li class="principal">
				<a href="#">Bodega</a>
				<ul>
					
					<li><a href="index.php?acc=lista_bodega">Lista de bodega</a></li>
				</ul>
			</li>
			<li class="principal">
				<a href="#">Proveedores</a>
				<ul>
					
					<li><a href="index.php?acc=lista_proveedor">Lista de Proveedores</a></li>
				</ul>
			</li>
			<li class="principal">
				<a href="#">Productos</a>
				<ul>
					
					<li><a href="index.php?acc=lista_producto">Lista de Productos</a></li>
				</ul>
			</li>
			<li class="principal">
				<a href="#">Estantes</a>
				<ul>
					
					<li><a href="index.php?acc=lista_estantes">Lista de estantes</a></li>
				</ul>
			</li>
			<li class="principal">
				<a href="#">Niveles</a>
				<ul>
					
					<li><a href="index.php?acc=lista_nivel">Lista de niveles</a></li>
				</ul>
			</li>

		<?php	break;
		default:
			# code...
			break;
	}

?>


	</ul>
</nav>




		

