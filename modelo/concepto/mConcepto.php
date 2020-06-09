<?php 

	class mConcepto
	{
		private $id_concepto;
        private $concepto;
        private $id_tipo_concepto;
        private $tipo_concepto;

		public $lista = array();

		function consultar_concepto($cnn,$tipo)
		{
			$sql = "CALL sp_consultaConcepto_wvp (".$tipo.")";
            
            $mysqli = mysqli_query($cnn,$sql);
			mysqli_close($cnn);
			while($row = mysqli_fetch_array($mysqli))
			{
				$this->lista[] = $row;
            }
            
		}
		
	}

 ?>