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

		function lista_estantes2($cnn)
		{
			$this->modelo->consulta_estante($cnn);
			$lista = $this->modelo->lista;
			return $lista;
			
		}

		function lista_select_estantes($cnn,$id_bodega,$stt)
		{
			return $this->modelo->consulta_select_estante($cnn,$id_bodega,$stt);
		}

		function editar_estante($cnn,$id_estante,$lista_bodega)
		{
			$this->modelo->consulta_estante_id($cnn,$id_estante);
			$registro = $this->modelo->lista;

			
			if(count($registro)>0)
			{
				foreach ($registro as $key) {
					//echo $key['id_estante'];
					$id_estante = $key['id_estante'];
					$ID = $key['ID'];
					$bodega_nom = $key['bodega'];
					$estante_nom = $key['estante'];
					$estatus = $key['estatus'];
					$num_niveles = $key['num_niveles'];
				}
				
				require 'vista/estante/editar_estante.php';
			}
		}

		function actualizar_estante($cnn,$lista_bodega)
		{
			$id_estante = $_POST['id'];
			$estante = $_POST['nombre'];
			$status = $_POST['status'];
			$id_bodega = $_POST['id_bodega'];
			
			$statu_registro = $this->modelo->modificar_estante($cnn,$id_estante,$estante,$status,$id_bodega);
			mysqli_close($cnn);

			//var_dump ($statu_registro);


			if($statu_registro==1)
			{
				//echo 'bien';
				header('location: index.php?acc=lista_estantes');
			}else
			{
				//echo 'error';
				
				$alert = '<p class="msg_error">Nombre de estante ya ha sido asignado</p>';
				require 'vista/estante/editar_estante.php';
			}


		}
	}


 ?>

