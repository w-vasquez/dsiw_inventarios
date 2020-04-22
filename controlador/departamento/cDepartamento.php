<?php 
	require 'modelo/departamento/mDepartamento.php';

	class cDepartamento
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mDepartamento;
		}

		function __destruct(){
			//mysql_close($this->cnn);
		}

		function get_departamento($cnn)
		{
			$this->modelo->consultar_departamento($cnn);
			return $this->modelo->lista_departamento;
		}
	}


 ?>