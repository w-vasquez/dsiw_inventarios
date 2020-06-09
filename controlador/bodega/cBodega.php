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
			//var_dump($lista);
			require 'vista/bodega/lista_bodega.php';
		}

		function editar_bodega($cnn,$id_bodega,$lista_departamento)
		{
			$this->modelo->consulta_bodega2($cnn,$id_bodega);
			$lista = $this->modelo->lista_bodega;
			//var_dump($lista);

			
			
				foreach ($lista as $key) {
					$id_bodega = $key['id_bodega'];
					$Nombre = $key['Nombre'];
					$estatus=$key['estatus'];
					$cant_estantes = $key['cant_estantes'];
					$municipio = $key['municipio'];
					$departamento = $key['departamento'];
					
				}
				
				require 'vista/bodega/editar_bodega.php';
			
		}

		function actualizar_bodega($cnn,$lista_departamento)
		{
			if ($_POST) 
			{
				//$id_bodega = $_POST['id_bodega'];
				$nombre = $_POST['nombre'];
				$estatus = $_POST['estatus'];
				//$dartamento = $_POST['dartamento'];
				$id_municipio = $_POST['municipio'];
				//echo $id_bodega;

				$statu_registro = $this->modelo->modificar_bodega($cnn,$nombre,$estatus,$id_municipio);
				mysqli_close($cnn);
				header('location:index.php?acc=lista_bodega');
				
				

				

				
			}else
			{
			
				header('location:index.php?acc=lista_bodega');
				
			}
		}

	}


 ?>