<?php 
	
	if (isset($_POST['id'])) {
		require ('../../modelo/conexionAux.php');
		/*$sql = "call sp_estantegralcp_wvp (".$_POST['id'].",'A')";
		$query = mysqli_query($cnnAux,$sql);
		$lista = array();
		$html = "";
		while ($row = mysqli_fetch_array($query)) 
		{
				$lista[] = $row;
		}*/

		require('../../modelo/estante/mEstante.php');
		//require('../../controlador/estante/cEstante.php');


		$mEstante = new mEstante();

		$lista = $mEstante -> consulta_select_estante($cnnAux,$_POST['id'],'A');

		foreach ($lista as $value) 
		{
			$html = "<option value='".$value['id_estante']."'>".$value['Nombre']."</option>";
			echo $html;
		}
	}
	else
	{
		echo "no hay post";
	}


 ?>