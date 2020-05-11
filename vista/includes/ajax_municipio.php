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

		require('../../modelo/municipio/mMunicipio.php');
		


		$mMunicipio = new mMunicipio();

		$lista = $mMunicipio -> consultar_municipio($cnnAux,$_POST['id']);

		//var_dump($lista);
		foreach ($lista as $value) 
		{
			$html = "<option value='".$value['id_municipio']."'>".$value['municipio']."</option>";
			echo $html;
		}
	}
	else
	{
		echo "no hay post";
	}


 ?>