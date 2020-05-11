<?php 

	require '../../modelo/conexionAux.php';

	if(!empty($_POST))
	{
		//buscar producto
		if($_POST['action'] == 'searchProdc')
		{
			//print_r($_POST);
			if (!empty($_POST['producto'])) 
			{
				$cod=$_POST['producto'];
				$sql = "CALL sp_consultaProductosCP_wvp ($cod)";
				$query = mysqli_query($cnnAux1,$sql);
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