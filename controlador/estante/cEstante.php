<?php 
	
	require 'modelo/estante/mEstante.php';

	class cEstante
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mEstante;
		}

		function __destruct(){
			//mysql_close($this->cnn);
		}

		function registro_estante($cnn,$lista_bodega)
		{
			if ($_POST) 
			{
				$nom = $_POST['nombre'];
				$stt = $_POST['status'];
				$id_bodega = $_POST['id_bodega'];

				$result = $this->modelo->insertar_estante($cnn,$nom,$stt,$id_bodega);

				if($result)
				{
					$alert = '<p class="msg_save">Estante registrado con exito</p>';
					require 'vista/estante/registro_estante.php';
				}
				else
				{
					$alert = '<p class="msg_error">Estante existe</p>';
					require 'vista/estante/registro_estante.php';
				}
			}
		}

		function lista_estantes($cnn)
		{
			$this->modelo->consulta_estante($cnn);
			$lista = $this->modelo->lista;
			require 'vista/estante/lista_estante.php';
		}

		function lista_select_estantes($cnn,$id_bodega,$stt)
		{
			return $this->modelo->consulta_select_estante($cnn,$id_bodega,$stt);
		}
	}


 ?>

