<?php 

	class mBodega
	{
		private $id_bodega;
		private $nombre;
		private $estatus;
		private $id_municipio;

		public $lista_bodega;

		function consulta_bodega($cnn, $stt)
		{
			$sql = "call sp_consultabodega_wvp ('".$stt."')";
			$mysqli = mysqli_query($cnn,$sql);

			while($row = mysqli_fetch_array($mysqli))
			{
				$this->lista_bodega[] = $row;
			}

			return $this->lista_bodega;
		}
		
		function consulta_bodega2($cnn, $id_bodega)
		{
			$sql = "call sp_consultaidbodega ('".$id_bodega."')";
			$mysqli = mysqli_query($cnn,$sql);

			while($row = mysqli_fetch_array($mysqli))
			{
				$this->lista_bodega[] = $row;
			}

			return $this->lista_bodega;
		}

		function insertar_bodega($cnn,$nom,$dir,$id_muni)
		{
			$sql = "CALL sp_InsertarBodega_ksn ('".$nom."','".$dir."','".$id_muni."');";

			//echo $sql;
			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);
			

			while ($row = mysqli_fetch_array($query)) {
				$this->lista[] = $row;
			}


			//print_r($this->lista);

			foreach ($this->lista as $key) 
			{
				if ($key['0']=='true') 
				{
					return true;
				}
			}

			return false;
		}

		function modificar_bodega($cnn,$nombre,$estatus,$id_municipio)
		{
			$sql = "CALL sp_ModificarBodega_ksnn ('".$nombre."','".$estatus."','".$id_municipio."');";

			//echo $sql;
			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);
			

			while ($row = mysqli_fetch_array($query)) {
				$this->lista[] = $row;
			}


			//print_r($this->lista);

			foreach ($this->lista as $key) 
			{
				if ($key['0']=='true') 
				{
					return true;
				}
			}

			return false;

		}

		/*function consulta_bodega($cnn,$stt)
		{
			$sql = "call sp_consultabodega_wvp('".$stt."');";

			//echo $sql;
			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);
			

			while ($row = mysqli_fetch_array($query)) {
				$this->lista[] = $row;
			}

			return $this->lista;
		}*/
	}


 ?>