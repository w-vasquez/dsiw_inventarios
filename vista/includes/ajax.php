<?php 
	session_start();
	require '../../modelo/conexionAux.php';

	// print_r($_POST);exit;//comprobar si lee

	if(!empty($_POST))
	{
		//para obtener bodegas
		if( $_POST['action'] == 'addNewProdc' )
		{
			$opc = $_POST['stt'];
			switch ($opc) //ejecuta la consula según stt
			{
				case 'producto':
					$sql = "CALL sp_consultaproductosSP_de ();";
				break;
				case 'bodega':
					$sql = "CALL sp_consultaBodegaSP_wvp ();";
				break;
				case 'estante':
					$bodega_id = $_POST['bodega_id'];
					$sql = "CALL sp_consultaEstanteCP_wvp ($bodega_id);";
				break;
				case 'nivel':
					$bodega_id = $_POST['bodega_id'];
					$estante_id = $_POST['estante_id'];
					$sql = "CALL sp_consultaNivelBodegaEstante_wvp ($bodega_id,$estante_id);";
				break;
				case 'addProdc': 
					//cuando los componentes se son disabled el post no envía datos

					$bodega_id = !empty($_POST['bodega_id']) ? $_POST['bodega_id'] : 0;
					$estante_id = !empty($_POST['estante_id']) ? $_POST['estante_id'] : 0;
					$nivel_id = !empty($_POST['nivel_id']) ? $_POST['nivel_id'] : 0;

					//var_dump($_POST);
					if( ($_POST['producto_id']!=0) && ($bodega_id!=0) && ($estante_id!=0) && ($nivel_id!=0) && !empty($_POST['cantidad']) && !empty($_POST['precio']))
					{
						
						$producto_id = $_POST['producto_id'];	
					// 	$bodega_id = $_POST['bodega_id'];	
					//  $estante_id = $_POST['estante_id'];	
					// 	$nivel_id = $_POST['nivel_id'];	
						$cantidad = $_POST['cantidad'];	
						$precio = $_POST['precio'];	
						$usuario_id = $_SESSION['idUsu'];
						//$sql = "CALL sp_consultaNivelBodegaEstante_wvp ($bodega_id,$estante_id);";
						$sql = "call sp_entradaMovimiento_wvp ($cantidad,$precio,$producto_id,$nivel_id,$bodega_id,$usuario_id)";
					}else{
						echo 'error';
						exit;
					}
				break;
			}
			
			$query = mysqli_query($cnnAux1,$sql);
			$result = mysqli_num_rows($query);
			if($result > 0)
			{
				switch($opc) //ordena los datos para enviar al modal
				{
					case 'producto':
						while($row = mysqli_fetch_assoc($query)) 
						{
							$html = "<option value='".$row['id_producto']."'>".$row['Nombre']."</option>";
							echo $html;
						}
					break;
					case 'bodega':
						while($row = mysqli_fetch_assoc($query)) 
						{
							$html = "<option value='".$row['id_bodega']."'>".$row['Nombre']."</option>";
							echo $html;
						}
					break;
					case 'estante':
						while($row = mysqli_fetch_assoc($query)) 
						{
							$html = "<option value='".$row['id_estante']."'>".$row['estante']."</option>";
							echo $html;
						}
					break;
					case 'nivel':
						while($row = mysqli_fetch_assoc($query)) 
						{
							$html = "<option value='".$row['id_nivel']."'>".$row['Nivel']."</option>";
							echo $html;
						}
					break;
					case 'addProdc':
						$data = mysqli_fetch_assoc($query);
						//print_r($data);
						//$data['producto_id'] = $producto_id; //agregamos otro campo a data otra forma es modificar el sp
						echo json_encode($data,JSON_UNESCAPED_UNICODE);
					break;
				}
			}else{
				echo 'error';
			}
			exit;
		}

		//agregar productos desde el modal
		if( $_POST['action'] == 'addProdc' )
		{
			//echo 'Agregar producto'; //comprobar si lee
			if( !empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST['producto_id']) )
			{
				$cantidad = $_POST['cantidad'];
				$precio = $_POST['precio'];
				$producto_id = $_POST['producto_id'];
				$usuario_id = $_SESSION['idUsu'];
				$nivel_id = $_POST['nivel_id'];
				$bodega_id = $_POST['bodega_id'];

				$sql = "call sp_entradaMovimiento_wvp ($cantidad,$precio,$producto_id,$nivel_id,$bodega_id,$usuario_id)";
				$query = mysqli_query($cnnAux1,$sql);

				//var_dump($query);
				//$result = !empty($query) ? 0 : mysqli_num_rows($query);
				$result = mysqli_num_rows($query);
				
				if( $result > 0 ){
					$data = mysqli_fetch_assoc($query);
					//print_r($data);
					//$data['producto_id'] = $producto_id; //agregamos otro campo a data otra forma es modificar el sp
					echo json_encode($data,JSON_UNESCAPED_UNICODE);
					exit;
				}else{
					echo 'error';
				}
				mysqli_close($cnnAux);
			}else{
				echo 'error';
			}
			exit;
		}

		//buscar producto para ingresar
		if($_POST['action'] == 'infoProducto')
		{
			// print_r($_POST);
			
			$producto = $_POST['producto'];
			$user = $_POST['user'];
			$nivel = $_POST['nivel'];
			$sql = "CALL sp_consultaInventarioCP_wvp ($producto, $nivel)";
			//$sql = "CALL sp_consultaproductosCP_de ($producto)";
			$query = mysqli_query($cnnAux,$sql);
			mysqli_close($cnnAux);
			$result = mysqli_num_rows($query);
			$data = '';
				if ($result>0) 
				{
					$data = mysqli_fetch_assoc($query);
					//print_r($data);
					echo json_encode($data,JSON_UNESCAPED_UNICODE);
					exit;
				}
				echo 'error';
				exit;
		}

		//buscar producto
		if($_POST['action'] == 'searchProdc')
		{
			
			if (!empty($_POST['producto'])) 
			{
				$cod=$_POST['producto'];
				$sql = "CALL sp_consultaProductosCP_wvp ($cod)";
				$query = mysqli_query($cnnAux,$sql);
				mysqli_close($cnnAux);
				$result = mysqli_num_rows($query);
				$data = '';
				if ($result>0) 
				{

					$data = mysqli_fetch_assoc($query);
					//print_r($data);
					//mysqli_fetch_assoc
					//mysqli_fetch_array
				}
				else
				{
					$data = 0;
				}
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}
			//echo 'buscar producto';
			exit;
		}

		//validar formulario de orden mediante addOrden en el formulario
		if($_POST['action'] == 'addOrden')
		{
			//print_r($_POST);
			$id_bodega = $_POST['principal_bodega'];
			$id_concepto = $_POST['select_concepto_entrada'];
			$comentario = $_POST['comentario'];
			$id_usuario = $_POST['idUsuario'];

			if($id_bodega == 0 && $id_concepto == 0){
				echo 0;
			}else{
				echo 'insert';
			}


			exit;
		}

		if ($_POST['action'] == 'searchTipo') 
		{	
			//comprobar si tiene contacto
			// echo "ejecutar concepto";
			// exit;

			// //$cod=$_POST['tipo'];
			$sql = "CALL sp_consultaConcepto_wvp (1)";
			// echo $sql;
			$query = mysqli_query($cnnAux,$sql);
			mysqli_close($cnnAux);
			
			$data = array();
			while ($data = mysqli_fetch_array($query)){
				echo "<option value=".$data['id_concepto'].">".$data['concepto']."</option>";
				//array_push($info_array,$data);
			}
			//mysqli_fetch_assoc
			//mysqli_fetch_array
		}

		if ($_POST['action'] == 'searchBodega') 
		{
			$cod=$_POST['producto'];
			$sql = "select distinct(id_bodega), bodega from vw_inventario_wvp where id_producto = $cod";
			$query = mysqli_query($cnnAux1,$sql);
			$result = mysqli_num_rows($query);

			if($result >0)
			{
				//print_r(mysqli_fetch_assoc($query));
				while ($row = mysqli_fetch_assoc($query)) 
				{
					$html = "<option value='".$row['id_bodega']."'>".$row['bodega']."</option>";
					echo $html;
				}
			}
			else
			{
				echo 'error';
			}
			
		}

		if ($_POST['action'] == 'searchEstante') 
		{
			$cod=$_POST['producto_id'];
			$bodega_id = $_POST['bodega_id'];

			$sql = "select distinct(id_estante), estante from vw_inventario_wvp where id_producto = $cod and id_bodega = $bodega_id;";
			$query = mysqli_query($cnnAux1,$sql);
			$result = mysqli_num_rows($query);

			if($result >0)
			{
				
				while ($row = mysqli_fetch_assoc($query)) 
				{
					$html = "<option value='".$row['id_estante']."'>".$row['estante']."</option>";
					echo $html;
				}
			}
			else
			{
				echo 'error';
			}
		}

		if ($_POST['action'] == 'searchNivel') 
		{
			$cod=$_POST['producto_id'];
			$bodega_id=$_POST['bodega_id'];
			$estante_id=$_POST['estante_id'];

			$sql = "select distinct(id_nivel), nivel from vw_inventario_wvp where id_producto = $cod and id_bodega = $bodega_id and id_estante = $estante_id;";
			$query = mysqli_query($cnnAux1,$sql);
			$result = mysqli_num_rows($query);

			if($result >0)
			{
				
				while ($row = mysqli_fetch_assoc($query)) 
				{
					$html = "<option value='".$row['id_nivel']."'>".$row['nivel']."</option>";
					echo $html;
				}
			}
			else
			{
				echo 'error';
			}
		}

		if ($_POST['action'] == 'searchExistencia') 
		{
			$cod = $_POST['producto_id'];
			$bodega_id = $_POST['bodega_id'];
			$estante_id = $_POST['estante_id'];
			$nivel_id = $_POST['nivel_id'];

			$sql = "select cantidad_existencia from vw_inventario_wvp where id_producto = $cod and id_bodega = $bodega_id and id_estante = $estante_id and id_nivel = $nivel_id;";

			$query = mysqli_query($cnnAux1,$sql);
			$result = mysqli_num_rows($query);
			
			if($result >0)
			{
				$row = mysqli_fetch_assoc($query);
				//print_r($row);
				echo $row['Cantidad_existencia'];
			}else{
				echo 'error';
			}
		}


		//crear la tabla detalle
		if ($_POST['action'] == 'addProductoDetalle') 
		{
			// print_r($_POST); //para verificar que datos estoy enviado
			// exit;
			$producto_id = $_POST['producto_id'];
			$cantidad = $_POST['cantidad'];
			$costo = $_POST['costo'];
			$nivel_id = $_POST['nivel_id'];
			$orden_id = $_POST['orden_id'];
			$usuario_id = $_SESSION['idUsu'];

			$detalleTabla = ''; 
			$sql = "call sp_insertarTempMovimiento_wvp ($producto_id,$nivel_id,$cantidad,$costo,$usuario_id,$orden_id)";
			$query = mysqli_query($cnnAux1,$sql);
			$result = mysqli_num_rows($query);
			$sub_total = 0;
			$total = 0;
			if($result >0)
			{

				while ( $data = mysqli_fetch_assoc($query) ) 
				{
					$precioTotal = round($data['cantidad'] * $data['costo'], 2 );
					$sub_total = round($sub_total + $precioTotal,2);
					$total = round($total + $precioTotal,2);

					$detalleTabla .= '
										<tr>
											<td>'.$data['id_producto'].'</td>
											<td colspan="2">'.$data['producto'].'</td>
											<td>'.$data['bodega'].'</td>
											<td>'.$data['estante'].'</td>
											<td>'.$data['nivel'].'</td>
											<td>'.$data['cantidad'].'</td>
											<td>'.$data['costo'].'</td>
											<td class="">
												<a href="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['id_producto'].');"><i class="far fa-trash-alt">borrar</i></a>
											</td>
										</tr>
						';
				}

				$detalleTotal = '

									<tr>
										<td colspan="7" class="textleft">COSTO</td>
										<td class="textright">'.$total.'</td>
									</tr>

								';
				//print_r($row);
				$arrayData['detalle'] = $detalleTabla;
				$arrayData['totales'] = $detalleTotal;

				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

			}else{
				echo 'error';
			}
			exit;

		}

		//tabla detalle
		if ($_POST['action'] == 'searchForDetalle') 
		{
			// print_r($_POST); //para verificar que datos estoy enviado
			// exit;
			
			$usuario_id = $_SESSION['idUsu'];

			$detalleTabla = ''; 
			$sql = "SELECT p.id_producto, p.Nombre as producto, b.Nombre as bodega, e.Nombre as estante, n.Nivel as nivel, t.cantidad, t.costo, t.id_orden, t.id_usuario  FROM temp_movimientos t INNER JOIN
			productos p ON p.id_producto = t.id_producto INNER JOIN
		    nivel n ON n.id_nivel = t.id_nivel INNER JOIN
		    estante e ON e.id_estante = n.id_estante INNER JOIN
		    bodega b ON b.id_bodega = e.id_bodega
			WHERE t.id_usuario = '$usuario_id';";


			//$sql = "call sp_insertarTempMovimiento_wvp ($producto_id,$nivel_id,$cantidad,$costo,$usuario_id,$orden_id)";
			$query = mysqli_query($cnnAux1,$sql);
			$result = mysqli_num_rows($query);
			$sub_total = 0;
			$total = 0;
			if($result >0)
			{

				while ( $data = mysqli_fetch_assoc($query) ) 
				{
					$precioTotal = round($data['cantidad'] * $data['costo'], 2 );
					$sub_total = round($sub_total + $precioTotal,2);
					$total = round($total + $precioTotal,2);

					$detalleTabla .= '
										<tr>
											<td>'.$data['id_producto'].'</td>
											<td colspan="2">'.$data['producto'].'</td>
											<td>'.$data['bodega'].'</td>
											<td>'.$data['estante'].'</td>
											<td>'.$data['nivel'].'</td>
											<td>'.$data['cantidad'].'</td>
											<td>'.$data['costo'].'</td>
											<td class="">
												<a href="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['id_producto'].');"><i class="far fa-trash-alt">borrar</i></a>
											</td>
										</tr>
						';
				}

				$detalleTotal = '

									<tr>
										<td colspan="7" class="textleft">COSTO</td>
										<td class="textright">'.$total.'</td>
									</tr>

								';
				//print_r($row);
				$arrayData['detalle'] = $detalleTabla;
				$arrayData['totales'] = $detalleTotal;

				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);

			}else{
				echo 'error';
			}
			exit;

		}

		
	}//fin POST

	function unique_multidim_array($array, $key) 
	{
		    $temp_array = array();
		    $i = 0;
		    $key_array = array();
		   
		    foreach($array as $val) {
		        if (!in_array($val[$key], $key_array)) {
		            $key_array[$i] = $val[$key];
		            $temp_array[$i] = $val;
		        }
		        $i++;
		    }
		    return $temp_array;
	}


 ?>