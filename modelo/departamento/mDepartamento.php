<?php 

	class mDepartamento
	{
		private $id_departamento;
		private $departamento;

		public $lista_departamento;

		function consultar_departamento($cnn)
		{
			$sql = "call sp_consultarDepartamento_wvp;";
			$mysqli = mysqli_query($cnn,$sql);

			while($row = mysqli_fetch_array($mysqli))
			{
				$this->lista_departamento[] = $row;
			}
		}
		
	}

 ?>