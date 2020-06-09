<?php
	//session_start();
	if(!isset($_SESSION['idRol']))
	{
		header('location:../index.php');
	}
?>




<!DOCTYPE html>
<html lang="ES">
<head>
	<meta charset="UTF-8">

	<?php include 'vista/includes/script.php'; ?> 
	
	<title>Sisteme Ventas</title>
	<header>
		<div class="header">
			
			<h1>Sistema de inventarios</h1>
			<div class="optionsBar">
				<p>El Salvador, <?php echo fecha(); ?></p>
				<span>|</span>
				
				<a href="index.php?acc=editar_usuario&id=<?php echo $_SESSION['idRol'] ?>">
					<span class="user">
						<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "" ; ?>
					</span>
				</a>
				
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="index.php?acc=cerrar_sesion"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div> 
		
		<?php include 'nav.php'; ?>

	</header>
	
	<!-- modal se diseña desde el css y se controla desde el function.js -->
	<div class="modal"> 
		<div class="bodyModal">
			<form action="" method="POST" name="form_add_product" id="form_add_product" onSubmit="event.preventDefault(); sendDataProduct();">
				<h1>Agregar producto</h1><br>
				<h2 class="nameProducto"></h2>
				<label for="bodega_id">Bodega:</label>
				<select name="bodega_id" id="bodega_id"></select>
				<label for="estante_id">Estante:</label>
				<select name="estante_id" id="estante_id" ></select>
				<label for="nivel_id">Nivel:</label>
				<select name="nivel_id" id="nivel_id" ></select>
				
				<label for="txtCantidad">Cantidad:</label>
				<input type="number" min="0" name="cantidad" id="txtCantidad" placeholder="cantidad requerida" required>
				
				<label for="txtPrecio">Costos total:</label>
				<input type="text" name="precio" id="txtPrecio" placeholder="costo total producto" required>
				
				<input type="hidden" name="producto_id" id="producto_id">
				<input type="hidden" name="action" id="addProdc" value="addProdc">
				<div class="alert alertAddProduct"></div>
				<button type="submit" class="btn_new">Agregar</button>
				<a href="#" class="btn_ok closeModal" onclick="closeModal();">Cerrar</a>
			</form>	
		</div>
	</div>	
	
	<div class="modalNewProduct"> 
		<div class="bodyModal">
			<form action="" method="POST" name="form_add_NewProduct" id="form_add_NewProduct" onSubmit="event.preventDefault(); sendDataNewProduct();">
				<h1>Agregar producto</h1><br>
				<h2 class="nameProducto"></h2>
				<label for="producto_id">Producto:</label>
				<select name="producto_id" id="producto_id_new"></select>
				<label for="bodega_id">Bodega:</label>
				<select name="bodega_id" id="bodega_id_new" disabled></select>
				<label for="estante_id">Estante:</label>
				<select name="estante_id" id="estante_id_new" disabled></select>
				<label for="nivel_id">Nivel:</label>
				<select name="nivel_id" id="nivel_id_new" disabled></select>
				
				<label for="txtCantidad">Cantidad:</label>
				<input type="number" min="0" name="cantidad" id="txtCantidad" placeholder="cantidad requerida" required>
				
				<label for="txtPrecio">Costos total:</label>
				<input type="text" name="precio" id="txtPrecio" placeholder="costo total producto" required>
				
				<input type="hidden" name="action" id="action" value="addNewProdc">
				<input type="hidden" name="stt" id="stt" value="addProdc">
				<div class="alert alertAddProduct"></div>
				<button type="submit" class="btn_new">Agregar</button>
				<a href="#" class="btn_ok closeModal" onclick="closeModal();">Cerrar</a>
			</form>
		</div>
	</div>

	<body>