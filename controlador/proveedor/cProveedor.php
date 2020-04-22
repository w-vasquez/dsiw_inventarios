<?php 

	require 'modelo/proveedor/mProveedor.php';

	class cproveedor
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mProveedor;
		}

		function registro_proveedor($cnn,$lista_departamento)
		{
			
			if ($_POST) 
			{
				$bandera = true;
				
				//$_id_proveedor = $_POST['id_proveedor'];
				$nom = $_POST['nombre'];
				$email = $_POST['correo'];
				$dir = $_POST['direccion'];
				$id_muni = $_POST['municipio'];
				

				//verifica si usuario existe
				$statu_registro = $this->modelo->registro_proveedor($cnn,$nom,$email,$dir,$id_muni);

				if($statu_registro)
				{
					$alert = '<p class="msg_save">Usuario registrado con exito</p>';
				}
				else
				{
					$alert = '<p class="msg_error">Usuario existe</p>';
				}

				
				require 'vista/proveedor/registro_proveedor.php';
			}
		
		}

		function lista_proveedor($cnn)
		{

			$lista = $this->modelo->consulta_proveedores($cnn);
			require 'vista/proveedor/lista_proveedor.php';
		}

		function get_proveedor($cnn)
		{

			return $this->modelo->consulta_proveedores($cnn);
			
		}
	}

?>