<?php 

	class mMunicipio
	{
		private $idmunicipio;
		private $municipio;

		public $lista_municipio;

		function consultar_municipio($cnn,$id_dpto)
		{
			$sql = "call sp_municipio_ksn ('".$id_dpto."')";
			$mysqli = mysqli_query($cnn,$sql);

			while($row = mysqli_fetch_array($mysqli))
			{
				$this->lista_municipio[] = $row;
			}

			return $this->lista_municipio;
		}
		
	}

 ?>