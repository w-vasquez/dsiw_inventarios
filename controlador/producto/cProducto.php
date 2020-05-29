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
				$uni = $_POST['uni_medida'];
				$id_proveedor = $_POST['id_proveedor'];
				$max =          $_POST['cant_max'];
				$min =          $_POST['cant_mini'];
				$marca =        $_POST['marca'];
				$esta =         $_POST['estatus'];
				$costo =        $_POST['cto_uni'];
				$id_categoria = $_POST['id_categoria'];

				$result = $this->modelo->insertar_producto($cnn,$nom,$foto,$uni,$id_proveedor,$max,$min,$marca,$esta,$costo,$id_categoria);

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


	 function EliminarProducto($cnn,$id_producto)
	{
		
	 $result = $this->modelo->EliminarUnProducto($cnn,$id_producto);

		$resultado=mysqli_query($cnn,"CALL Sp_EliminarProducto_ksn('".$id_producto."');");
		return $resultado;
	}	



		function lista_producto($cnn)
		{
			$lista = $this->modelo->consultaproducto($cnn);
			$lista=$this->modelo->lista;
			require('vista/producto/lista_producto.php');
		}


	

function editar_Producto($cnn,$id_producto,$lista_categoria,$lista_proveedor)
		{
			
			$this->modelo->consulta_Producto($cnn,$id_producto);
			$registro = $this->modelo->lista;

			if(count($registro)>0)
			{
				foreach ($registro as $key) {
				$id_pro =$key['id_producto'];	
			    $nom = $key['Nombre'];
				//$foto =  $_FILES['foto']['name'];
				$uni = $key['Unidad_medida'];
				$id_proveedor = $key['proveedor'];
				$max = $key['Cantidad_minima'];
				$min = $key['Cantidad_maxima'];
				$marca = $key['Marca'];
				$esta = $key['estatus'];
                $costo = $key['cto_uni'];	
				$id_categoria =$key['categoria'];
				
				
				}
				
				require 'vista/producto/modificar_producto.php';
			}
		}
		
		

		function actualizar_Producto($cnn,$lista_categoria,$lista_proveedor)
		{
			if ($_POST) 
			{
				$id_pro =$_POST['id_producto '];
				$nom = $_POST['nombre'];
				$foto =  $_POST['img_prodc']['name'];
				$uni = $_POST['uni_medida'];
				$id_proveedor = $_POST['id_proveedor'];
				$max = $_POST['cant_max'];
				$min = $_POST['cant_mini'];
				$marca = $_POST['marca'];
				$esta = $_POST['estatus'];
                $costo = $_POST['cto_uni'];	
				$id_categoria =$_POST['id_categoria '];
				
				
		
				$statu_registro = $this->modelo->ModificarProductos($cnn,$nom,$foto,$uni,$id_proveedor,$max,$min,$marca,$esta,$costo,$id_categoria,$_idProc);
		
				if($statu_registro)
				{
					header('location: index.php?acc=lista_producto');
				}
				
		
				if($statu_registro)
				{
					header('location: index.php?acc=lista_producto');
				}
				else
				{
					$id_producto= $id_producto;
					$nom =  $nombre;
					$alert = '<p class="msg_error">Producto ya existe</p>';
					require 'vista/producto/modificar_producto.php';
					
				}	

				header('location: index.php?acc=lista_producto');
			}
			else
			{	header('location: index.php?acc=lista_producto');}
		}
	}

 ?>