<?php 
	
	require 'modelo/bodega/mBodega.php';

	class cBodega
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mBodega;
		}

		function __destruct(){
			//mysql_close($this->cnn);
		}


		function get_bodega($cnn)
		{
			return $this->modelo->consulta_bodega($cnn,'A');

		}

		function registro_bodega($cnn, $lista_departamento)
		{
			if ($_POST) 
			{
				$nom = $_POST['nombre'];
				$dir = $_POST['dir'];
				$id_muni = $_POST['municipio'];

				
				$result = $this->modelo->insertar_bodega($cnn,$nom,$dir,$id_muni);
				//var_dump($cnn);

				if($result)
				{
					$alert = '<p class="msg_save">Registrado con exito</p>';
					require 'vista/bodega/registro_bodega.php';
				}
				else
				{
					$alert = '<p class="msg_error">Registro existe</p>';
					require 'vista/bodega/registro_bodega.php';
				}
			}
		}

		function lista_bodega($cnn,$stt)
		{
			$lista = $this->modelo->consulta_bodega($cnn,$stt);
			require 'vista/bodega/lista_bodega.php';
		}
	}


 ?>