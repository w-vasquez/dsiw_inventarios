<?php 
	
	require 'modelo/nivel/mNivel.php';

	class cNivel
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mNivel;
		}

		function registro_nivel($cnn,$lista_bodega)
		{
			if ($_POST) 
			{
				$nom = $_POST['nombre'];
				$bodega = $_POST['bodega'];
				$id_estante = $_POST['estante'];

				$result = $this->modelo->insertar_nivel($cnn,$nom,'A',$id_estante);

				if($result)
				{
					$alert = '<p class="msg_save">Estante registrado con exito</p>';
					require 'vista/nivel/registro_nivel.php';
				}
				else
				{
					$alert = '<p class="msg_error">Estante existe</p>';
					require 'vista/nivel/registro_nivel.php';
				}
			}
		}

		function listado_nivel($cnn)
		{
			$lista = $this->modelo->consulta_nivel($cnn);
			require('vista/nivel/lista_nivel.php');
		}
	}


 ?>