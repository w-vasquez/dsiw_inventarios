<?php 

	class mRol
	{
		private $idRol;
		private $rol;

		public $listaRol;

		function consultarRol($cnn)
		{
			$sql = "call sp_consultaRoles_wvp";
			$mysqli = mysqli_query($cnn,$sql);

			while($row = mysqli_fetch_array($mysqli))
			{
				$this->listaRol[] = $row;
			}
		}
	}

 ?>