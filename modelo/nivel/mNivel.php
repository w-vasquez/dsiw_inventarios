<?php 

	class mNivel
	{
		private $id_nivel;
		private $nivel;
		private $estatus;
		private $id_estante;
		public $lista;

		function __construct()
		{
			$this -> lista = array();
		}

		function insertar_nivel($cnn,$nom,$stt,$id_estante)
		{

			$sql = "CALL sp_InsertarNivel_ksn ('".$nom."','".$stt."','".$id_estante."');";

			
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

		function consulta_nivel ($cnn)
		{
			$sql = "call sp_consultanivelSP_de;";
			$query = mysqli_query($cnn,$sql);
			while($row = mysqli_fetch_array($query))
			{
				$this->lista[]=$row;
			}
			return $this->lista;
		}
		function consulta_nivel2 ($cnn,$id_nivel)
		{
			$sql = "call sp_consultanivelSP_de('".$id_nivel."')";
			$query = mysqli_query($cnn,$sql);
			while($row = mysqli_fetch_array($query))
			{
				$this->lista[]=$row;
			}
			return $this->lista;
		}
	}

 ?>