<?php include ('vista/includes/header.php');  ?>

	

	<section id="container">
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Nuevo movimiento</h1>
		</div>
		<div class="datos_cliente">
			<div class="action_cliente">
				<h4>Datos de la orden</h4>
				<a href="#" class="btn_new btn_new_cliente"><i class="fas fa-plus">Nuevo Producto</i></a>
				
			</div>
		</div>
		<table class="tbl_venta">
			<thead>
				<tr>
					<th width="100px">Código</th>
					<th>Producto</th>
					<th>Bodega</th>
					<th>Estante</th>
					<th>Nivel</th>
					<th>Existencia</th>
					<th width="100px">Cantidad</th>
					<th class="textright">Costo</th>
					<th class="textright">Acción</th>
				</tr>
					
				<tr>
					<td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
					<input type="hidden" name="cod_producto" id="cod_producto" value="">
					<input type="hidden" name="cto_uni" id="cto_uni" value="">
					<input type="hidden" name="orden" id="orden_id" value="">
					<td id="txt_producto"> -- </td>
					<td><select name="select_bodega" id="select_bodega_add" disabled></select></td>
					<td><select name="select_bodega" id="select_estante_add" disabled></select></td>
					<td><select name="select_nivel" id="select_nivel_add" disabled></select></td>
					<td id="txt_existencia"> -- </td>
					<td><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
					<td name="txt_precio" id="txt_precio" class="textright">0.00</td>
					<!-- <td id="txt_precio_total" class="textright">0.00</td> -->
					<td><a href="#" id="add_product_venta" class="link_add"><i class="fas fa-plus"></i>Agregar</a></td>
				</tr>
				<tr>
					<th>Código</th>
					<th colspan="2">Producto</th>
					<th>Bodega</th>
					<th>Estante</th>
					<th>Nivel</th>
					<th width="100px">Cantidad</th>
					<th class="textright">Costo</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">
				<!-- contenido ajax -->
			</tbody>
			<tfoot id="detalle_total">
				<!-- ajax -->
			</tfoot>
		</table>
	</section>





<?php include ('vista/includes/footer.php');  ?> 