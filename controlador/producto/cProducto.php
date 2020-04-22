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


		function lista_producto($cnn)
		{
			$lista = $this->modelo->consulta_producto($cnn);
			require('vista/producto/lista_producto.php');
		}


	}


 ?>