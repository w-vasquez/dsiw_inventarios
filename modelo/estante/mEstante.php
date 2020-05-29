<?php 
	
	class mEstante
	{

		private $id_estante;
		private $nombre;
		private $estatus;
		private $id_bodega;
		public $lista;


		function __construct()
		{
			$this -> lista = array();
		}



		function insertar_estante($cnn,$nom,$stt,$id_bodega)
		{

			$sql = "CALL sp_insertarestante_ksn ('".$nom."','".$stt."','".$id_bodega."');";

			
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

		function consulta_estante($cnn)
		{
			$sql = "CALL sp_consultaEstantesSP_wvp;";
			
			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);
			

			while ($row = mysqli_fetch_array($query)) {
				$this->lista[] = $row;
			}
		}

		function consulta_select_estante($cnn,$id_bodega,$stt)
		{
			$sql = "call sp_estantegralcp_wvp (".$id_bodega.",'".$stt."');";
			//echo $sql;
			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);
			

			while ($row = mysqli_fetch_array($query)) {
				$this->lista[] = $row;
			}

			return $this->lista;
		}

		function consulta_estante_id($cnn,$id_estante)
		{
			$sql = "CALL sp_consultaEstanteCP_wvp (".$id_estante.");";
			//echo $sql;
			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);
			

			while($row = mysqli_fetch_array($query))
			{
				$this->lista[] = $row;
			}
			
		}

		function modificar_estante($cnn,$id_estante,$estante,$status,$id_bodega)
		{
			  
			$sql = "CALL sp_ModificarEstante_ksn (".$id_estante.",'".$estante."','".$status."',".$id_bodega.");";
			echo $sql;
			$query = mysqli_query($cnn,$sql);
			$row = mysqli_fetch_array($query);
			return $row['RS'];
		}


	}

 ?>