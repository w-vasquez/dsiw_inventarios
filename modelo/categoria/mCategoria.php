<?php 

	class mCategoria
	{
		private $id_categoria;
		private $nombre;
		private $estatu;
		private $decripcion;

		public $lista_categoria;

		function consulta_categoria($cnn)
		{
			$sql = "call sp_consultaCategoriaSP_wvp";
			$mysqli = mysqli_query($cnn,$sql);

			while($row = mysqli_fetch_array($mysqli))
			{
				$this->lista_categoria[] = $row;
			}

			return $this->lista_categoria;
		}

		
	}


 ?>