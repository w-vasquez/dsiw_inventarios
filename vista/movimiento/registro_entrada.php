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
			<form name ="form_orden" id="form_orden" class="datos">
				<input type="hidden" name="action" value="addOrden">
				<input type="hidden" name="idUsuario" value="<?php echo $_SESSION['idUsu'] ?>">
				<div class="wd30">
					<label>Bodega</lable>
					<select name="principal_bodega" id="principal_bodega">
						<option value=0>Seleccionar bodega</option>
						<?php 
						foreach($lista_bodega as $key){
							echo "<option value=".$key['id_bodega'].">".$key['Nombre']."</option>";
						}
						?>
					</select>
				</div>
				<div class="wd30">
					<label>Concepto</lable>
					<select name="select_concepto_entrada" id="select_concepto_entrada">
						<option value=0>Seleccionar concepto</option>
						<?php 
						foreach($lista_concepto as $key){
							echo "<option value=".$key['id_concepto'].">".$key['concepto']."</option>";
						}
						?>
					</select>
				</div>
				<div class="wd30">
					<label>Comentario</lable>
					<input type="text" name="comentario" id="comentario">
				</div>
				<div class="wd100">
					<button type="submit" class="btn_save" name="btn_orden" id="btn_orden">Crear factura</button>
				</div>
				<div class="wd30">
					<label id="mensaje"></lable>
				</div>
			</form>
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
					<td id="txt_producto"> -- </td>
					<td><select name="select_bodega" id="select_bodega" disabled></select></td>
					<td><select name="select_estante" id="select_estante" disabled></select></td>
					<td></select></td>
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
			<tbody>
				<tr>
					<td>1</td>
					<td colspan="2">martillo</td>
					<td>Bodega A</td>
					<td>Estante A</td>
					<td>Nivel 2</td>
					<td>12</td>
					<td>9</td>
					<td class="">
						<a href="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle(1);"><i class="far fa-trash-alt">borrar</i></a>
					</td>
				</tr>
				<tr>
					<td>10</td>
					<td colspan="2">serrucho</td>
					<td>Bodega A</td>
					<td>Estante B</td>
					<td>Nivel 2</td>
					<td>12</td>
					<td>9</td>
					<td class="">
						<a href="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle(1);"><i class="far fa-trash-alt">borrar</i></a>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7" class="textleft">COSTO</td>
					<td class="textright">18</td>
				</tr>
			</tfoot>
		</table>
	</section>


<?php include ('vista/includes/footer.php');  ?> 
