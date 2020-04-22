<?php 
	
	require 'modelo/categoria/mCategoria.php';

	class cCategoria
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mCategoria;
		}

		function __destruct(){
			//mysql_close($this->cnn);
		}


		function get_categoria($cnn)
		{
			return $this->modelo->consulta_categoria($cnn);

		}

		
	}


 ?>