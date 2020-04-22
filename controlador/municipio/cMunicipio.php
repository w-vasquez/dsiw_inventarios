<?php 
	require 'modelo/municipio/mMunicipio.php';

	class cMunicipio
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mMunicipio;
		}

		function __destruct(){
			//mysql_close($this->cnn);
		}

		function get_municipio($cnn,$iddpto)
		{
			$this->modelo->consultar_municipio($cnn,$iddpto);
			return $this->modelo->lista_municipio;
		}
	}


 ?>