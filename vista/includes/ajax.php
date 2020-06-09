<?php 
	session_start();
	require '../../modelo/conexionAux.php';

	//print_r($_POST);exit;//comprobar si lee

	if(!empty($_POST))
	{
		//para obtener bodegas
		if( $_POST['action'] == 'addNewProdc' )
		{
			$opc = $_POST['stt'];
			switch ($opc)
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
					if(!empty($_POST['producto_id']) || !empty($_POST['bodega_id']) || !empty($_POST['estante_id']) || !empty($_POST['nivel_id']) || !empty($_POST['cantidad']) || !empty($_POST['precio']))
					{
						$producto_id = $_POST['producto_id'];	
						$bodega_id = $_POST['bodega_id'];	
						//$estante_id = $_POST['estante_id'];	
						$nivel_id = $_POST['nivel_id'];	
						$cantidad = $_POST['cantidad'];	
						$precio = $_POST['precio'];	
						$usuario_id = $_SESSION['idUsu'];
						$sql = "CALL sp_consultaNivelBodegaEstante_wvp ($bodega_id,$estante_id);";
						$sql = "call sp_entradaMovimiento_wvp ($cantidad,$precio,$producto_id,$nivel_id,$bodega_id,$usuario_id)";
					}
				break;
			}
			
			$query = mysqli_query($cnnAux1,$sql);
			$result = mysqli_num_rows($query);
			if($result > 0)
			{
				switch($opc)
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
			//print_r($_POST);
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
			$sql = "CALL sp_consultaProductosCP_wvp ($cod)";
			$query = mysqli_query($cnnAux1,$sql);
			$detalle = mysqli_fetch_all($query);
			$arr = unique_multidim_array($detalle,9);
			//var_dump($detalle);
			//print_r($arr);

			foreach ($arr as $value) 
			{
				$html = "<option value='".$value[9]."'>".$value[12]."</option>";
				echo $html;
			}
		}

		if ($_POST['action'] == 'searchEstante') 
		{
			$cod=$_POST['producto'];
			$sql = "CALL sp_consultaProductosCP_wvp ($cod)";
			$query = mysqli_query($cnnAux1,$sql);
			$detalle = mysqli_fetch_all($query);
			$arr = unique_multidim_array($detalle,10);
			//var_dump($detalle);
			//print_r($arr);

			foreach ($arr as $value) 
			{
				$html = "<option value='".$value[10]."'>".$value[13]."</option>";
				echo $html;
			}
		}

		if ($_POST['action'] == 'searchNivel') 
		{
			$cod=$_POST['producto'];
			$sql = "CALL sp_consultaProductosCP_wvp ($cod)";
			$query = mysqli_query($cnnAux1,$sql);
			$detalle = mysqli_fetch_all($query);
			$arr = unique_multidim_array($detalle,11);
			//var_dump($detalle);
			//print_r($arr);

			foreach ($arr as $value) 
			{
				$html = "<option value='".$value[11]."'>".$value[14]."</option>";
				echo $html;
			}
		}

		if ($_POST['action'] == 'searchExistencia') 
		{
			$p=$_POST['producto'];
			$b=$_POST['bodega'];
			$e=$_POST['estante'];
			$n=$_POST['nivel'];

			$sql = "CALL sp_consultaProductosCP_wvp ($p)";
			$query = mysqli_query($cnnAux1,$sql);
			$detalle = mysqli_fetch_all($query);
			
			//var_dump($detalle);
			//print_r($detalle);

			
				foreach ($detalle as $nivel_dos) {
					if ($nivel_dos[9]==$b && $nivel_dos[10] == $e && $nivel_dos[11] == $n) {
						echo $existenica = $nivel_dos[15];
					}
				}
			
		}

		
	}

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