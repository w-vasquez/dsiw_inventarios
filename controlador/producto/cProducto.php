<?php 
	
	require 'modelo/producto/mProducto.php';

	class cProducto
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mProducto;
		}

		function registro_producto($cnn,$lista_categoria,$lista_proveedor)
		{
			if ($_POST) 
			{
				$nom = $_POST['nombre'];
				$foto =  $_FILES['img_prodc']['name'];
				$marca = $_POST['marca'];
				$uni = $_POST['uni_medida'];
				$id_categoria = $_POST['id_categoria'];
				$id_proveedor = $_POST['id_proveedor'];
				$min = $_POST['cant_mini'];
				$max = $_POST['cant_max'];

				$result = $this->modelo->insertar_producto($cnn,$nom,$foto,$uni,$id_proveedor,$max,$min,$marca,$id_categoria);

				if($result)
				{
					$alert = '<p class="msg_save">Producto registrado con exito</p>';
					require 'vista/producto/registro_producto.php';
				}
				else
				{
					$alert = '<p class="msg_error">Producto existe</p>';
					require 'vista/producto/registro_producto.php';
				}
			}
		}

		function Modificar_producto($cnn,$lista_categoria,$lista_proveedor)
		{
			if ($_POST) 
			{
				$_id_producto =$_POST['id_producto '];
				$nom = $_POST['nombre'];
				$foto =  $_FILES['img_prodc']['name'];
				$marca = $_POST['marca'];
				$uni = $_POST['uni_medida'];
				$id_categoria = $_POST['id_categoria'];
				$id_proveedor = $_POST['id_proveedor'];
				$min = $_POST['cant_mini'];
				$max = $_POST['cant_max'];
				$result = $this->modelo->ModificarProductos($cnn,$_nom,$_foto,$_uni,$_idProv,$_max,$_min,$_marca,$_status,$_cto,$_idCat,$_idProc);

				if($result)
				{
					$alert = '<p class="msg_save">Producto modificado con exito</p>';
					require 'vista/producto/registro_producto.php';
				}
				else
				{
					$alert = '<p class="msg_error">Producto existe</p>';
					require 'vista/producto/registro_producto.php';
				}
			}
		}

	 function EliminarProducto($cnn,$id_producto)
	{
		
	 $result = $this->modelo->EliminarUnProducto($cnn,$id_producto);

		$resultado=mysqli_query($cnn,"CALL Sp_EliminarProducto_ksn('".$id_producto."');");
		return $resultado;
	}	



		function lista_producto($cnn)
		{
			$lista = $this->modelo->consulta_producto($cnn);
			require('vista/producto/lista_producto.php');
		}


	}


 ?>