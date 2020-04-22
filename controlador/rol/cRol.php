<?php 
	require 'modelo/rol/mRol.php';

	class cRol
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mRol;
		}

		function __destruct(){
			//mysql_close($this->cnn);
		}

		function getRol($cnn)
		{
			$this->modelo->consultarRol($cnn);
			return $this->modelo->listaRol;
		}
	}


 ?>