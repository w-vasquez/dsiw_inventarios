<?php 
	require 'modelo/concepto/mConcepto.php';

	class cConcepto
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mConcepto;
		}

		function __destruct(){
			//mysql_close($this->cnn);
		}

		function get_concepto($cnn,$tipo)
		{
			$this->modelo->consultar_concepto($cnn,$tipo);
			return $this->modelo->lista;
		}
	}


 ?>