<?php
	require ('modelo/conexion.php');	
	require ('modelo/conexionAux.php');
	require ('controlador/usuario/cUsuario.php');
	require ('controlador/rol/cRol.php');
	require ('controlador/bodega/cBodega.php');
	require ('controlador/estante/cEstante.php');
	require ('controlador/nivel/cNivel.php');
	require ('controlador/categoria/cCategoria.php');
	require ('controlador/producto/cProducto.php');
	require ('controlador/municipio/cMunicipio.php');
	require ('controlador/proveedor/cProveedor.php');
	require ('controlador/departamento/cDepartamento.php');
	require ('controlador/concepto/cConcepto.php');


	$cUsuario = new cUsuario();
	$cRol = new cRol();
	$cBodega = new cBodega();
	$cEstante = new cEstante();
	$cNivel = new cNivel();
	$cDepartamento = new cDepartamento();
	$cMunicipio = new cMunicipio();
	$cProveedor = new cProveedor();
	$cCategoria = new cCategoria();
	$cProducto = new cProducto();

	#lista de roles
	
	
	$acc = isset($_GET['acc']) ? $_GET['acc'] : "login";
	$opc = isset($_GET['opc']) ? $_GET['opc'] : 0;
	$idusr = isset($_GET['id']) ? $_GET['id'] : 0;
	
	//$_idProc = isset($_GET['id_producto']) ? $_GET['id_producto'] : 0;
	switch ($acc) 
	{

		case 'inicio':
			session_start();
			require 'vista/master.php';
			break;
		case 'login':
			$cUsuario -> invocar($cnn);
			break;
		case 'cerrar_sesion':
			$cUsuario -> salir($cnn);
			break;
		case 'registro_usuario':
			
			session_start();
			if($opc==0)
			{ 
				$listaRol = $cRol->getRol($cnn);
				require('vista/usuario/registro_usuario.php');
				
			}

			if($opc==1)
			{ 
				$listaRol = $cRol->getRol($cnnAux1);
				$cUsuario->registro_usuario($cnn,$listaRol);
				
			}

			break;
		case 'registro_bodega':
			session_start();
			if($opc==0)
			{ 
				$lista_departamento = $cDepartamento->get_departamento($cnn);
				require('vista/bodega/registro_bodega.php');
			}
			
			if($opc==1)
			{
				$lista_departamento = $cDepartamento->get_departamento($cnnAux1);
				//print_r($lista_departamento);
				$cBodega->registro_bodega($cnn,$lista_departamento);
				
			}	
			
			break;
		case 'lista_bodega':
			session_start();
				$cBodega -> lista_bodega($cnn,"");
			break;
		case 'editar_bodega':
			session_start();
			$idbodega = isset($_GET['idbodega']) ? $_GET['idbodega'] : 0;
			$lista_departamento = $cDepartamento->get_departamento($cnnAux1);
			//print_r($idbodega);
			$cBodega -> editar_bodega ($cnn,$idbodega,$lista_departamento);
				
					
			break;
		case 'actualizar_bodega':
			session_start();
			$lista_departamento = $cDepartamento->get_departamento($cnnAux1);
				$cBodega -> actualizar_bodega($cnn,$lista_departamento);
			break;
		
		case 'lista_usuarios':

			session_start();	
			$cUsuario -> lista_usuarios($cnn);
			break;
		case 'editar_usuario':
			session_start();
			if($idusr>0)
			{
				$listaRol = $cRol->getRol($cnnAux1);
				$cUsuario -> editar_usuario($cnn,$idusr,$listaRol);
			}
			break;

		case 'actualizar_usuario':
			session_start();
			$listaRol = $cRol->getRol($cnnAux1);
			$cUsuario -> actualizar_usuario($cnn,$listaRol);
			break;
		case 'registro_estante':
			session_start();
			if($opc==0)
			{
				$lista_bodega = $cBodega -> get_bodega($cnn);
				require('vista/estante/registro_estante.php');
			}
			if($opc==1)
			{
				$lista_bodega = $cBodega -> get_bodega($cnnAux1);
				
				$cEstante->registro_estante($cnn,$lista_bodega);
			}
			break;
		case 'lista_estantes':
			session_start();	
			$cEstante -> lista_estantes($cnn);
			break;
		case 'editar_estante':
			session_start();
			$idEstante = isset($_GET['idEstante']) ? $_GET['idEstante'] : 0;
			$lista_bodega = $cBodega -> get_bodega($cnnAux1);
			//print_r($lista_bodega);
			$cEstante -> editar_estante($cnn,$idEstante,$lista_bodega);
			
			break;
		case 'actualizar_estante':
			session_start();
			$lista_bodega = $cBodega -> get_bodega($cnnAux1);	
			$cEstante -> actualizar_estante($cnnAux2,$lista_bodega);
			break;
		case 'reporte_estante':
			session_start();
			
			$_SESSION['resp']=$cEstante -> lista_estantes2($cnn);
			header('location: reportes/reporte_estante.php');
			break;

		case 'reporte_productos':
			session_start();
			
			$_SESSION['resp']=$cProducto -> lista_estantes2($cnn);
			header('location: reportes/reporte_producto.php');
			break;
		case 'registro_nivel':
			session_start();
			if ($opc==0) {

				$lista_bodega = $cBodega -> get_bodega($cnn);
				//print_r($lista_bodega);
				
				//var_dump($lista_estantes);
				require ('vista/nivel/registro_nivel.php');
			}
			if ($opc==1) 
			{
				$lista_bodega = $cBodega -> get_bodega($cnnAux1);
				$cNivel -> registro_nivel($cnn,$lista_bodega);
					
			}
			break;
		case 'lista_nivel':
			session_start();
			$cNivel -> listado_nivel($cnn);
			break;
		case 'editar_niveles':
			session_start();
			$idniveles = isset($_GET['idniveles']) ? $_GET['idniveles'] : 0;
			$lista_bodega = $cBodega -> get_bodega($cnnAux1);
			//echo'HOLA dany'.$idniveles;
			$cNivel -> editar_niveles ($cnn,$idniveles,$lista_bodega);
			break;
		case 'registro_producto':
			session_start();
			if($opc==0)
			{ 
				$lista_categoria = $cCategoria -> get_categoria($cnn);
				$lista_proveedor = $cProveedor -> get_proveedor($cnnAux1);
				require('vista/producto/registro_producto.php');
			}

			if($opc==1)
			{
				$lista_categoria = $cCategoria -> get_categoria($cnn);
				$lista_proveedor = $cProveedor -> get_proveedor($cnnAux1);
				$cProducto -> registro_producto($cnnAux2,$lista_categoria,$lista_proveedor);
			}
			break;
		case 'lista_producto';
			session_start();
			$cProducto -> lista_producto($cnn);
			break;
			
			case 'editar_Producto';
			session_start();
    			$id_pro=isset($_GET['id_pro'])?$_GET['id_pro']:0;
			//	echo 'hola mundo'.$id_pro;
				$lista_categoria = $cCategoria->get_categoria($cnn);
				$lista_proveedor = $cProveedor->get_proveedor($cnnAux2);
				$cProducto-> editar_Producto($cnn,$id_pro,$lista_categoria,$lista_proveedor);
			
			break;
		case 'actualizar_Producto':
			session_start();
		$lista_categoria = $cCategoria->get_categoria($cnn);
		$lista_proveedor = $cProveedor->get_proveedor($cnnAux1);
				
		$cProducto->actualizar_Producto($cnnAux2,$lista_categoria,$lista_proveedor);
			break;

		case 'Eliminar Producto':
			$id_producto=$_GET['_id_producto'];
			$consulta=$cProducto -> EliminarProducto($cnn);
        ////Redireccionar al listado de clientes
		    $consulta=$mProducto->consulta_producto($cnn);
			///$mensaje="location:cClientes.php?acc=1";
			require('../vista/producto/lista_producto.php');  
			break; 	
			/*
			case 'r1':
        //Para el reporte de clientes
        $resp=$cliente->ConsultaClientes($cnn);
        //Cargar la vista para mostrar todos los clientes
        //require('../reportes/reporteclientes.php');
        $_SESSION['resp']=$resp->fetch_all(MYSQLI_ASSOC); //mysqli_fetch_all($resp, MYSQLI_ASSOC)
        //Pasando un arreglo asociativo con todos los datos de la consulta
        header('location:../reportes/reporteclientes.php');
        break;  
    case 'g1':
        //Para el reporte de clientes
        //$resp=$cliente->ConsultaClientes($cnn);
        require('../vista/vClientes.php');
        break;
		
			
		case 'r1':
        $resp=$cProducto->lista_producto($cnn);
		 $_SESSION['resp']=$resp->fetch_all(MYSQLI_ASSOC); //mysqli_fetch_all($resp, MYSQLI_ASSOC)
		header('location:../reportes/reporteProductos.php');
        break;
		/*
		case 'g1':
        //Para el reporte de clientes
        //$resp=$cliente->ConsultaClientes($cnn);
        require('../vista/vClientes.php');
        break;
		*/
		case 'registro_bodega':
			session_start();
			if($opc==0)
			{ 
		        $nom = $_POST['nombre'];
				$foto =  $_FILES['img_prodc']['name'];
				$marca = $_POST['marca'];
				$uni = $_POST['uni_medida'];
				$id_categoria = $_POST['id_categoria'];
				$id_proveedor = $_POST['id_proveedor'];
				$min = $_POST['cant_mini'];
				$max = $_POST['cant_max'];
				
		$lista_categoria = $cCategoria -> get_categoria($cnn);
		$lista_proveedor = $cProveedor -> get_proveedor($cnnAux1);
	$cProducto -> Modificar_producto($cnnAux2,$lista_categoria,$lista_proveedor);
		
		require('vista/producto/modificar_producto.php');
		
        	}
			break;
		case 5:
			$id_producto=$_GET['_id_producto'];
			$consulta=$cProducto -> EliminarProducto($cnn);
        ////Redireccionar al listado de clientes
		    $consulta=$mProducto->consulta_producto($cnn);
			///$mensaje="location:cClientes.php?acc=1";
			require('../vista/producto/lista_producto.php');  
			break;
		case 'r1':
        //Para el reporte de clientes
        $resp=$cProducto->lista_producto($cnn);
		 
        //Cargar la vista para mostrar todos los clientes
        //require('../reportes/reporteProductos.php');
        $_SESSION['resp']=$resp->fetch_all(MYSQLI_ASSOC); //mysqli_fetch_all($resp, MYSQLI_ASSOC)
        //Pasando un arreglo asociativo con todos los datos de la consulta
        header('location:../reportes/reporteProductos.php');
        break;
		
		
		case 'registro_proveedor':
		   session_start();
			if($opc==0)
			{ 
				$lista_departamento = $cDepartamento->get_departamento($cnn);
				require('vista/proveedor/registro_proveedor.php');
			}
			
			if($opc==1)
			{
				$lista_departamento = $cDepartamento->get_departamento($cnnAux1);
				$cProveedor->registro_proveedor($cnn,$lista_departamento);
				
			}
			break;
			
		case 'lista_proveedor':
			session_start();	
			$cProveedor -> lista_proveedor($cnn);
			break;
		case 'registro_movimiento':
			session_start();
			$cConcepto = new cConcepto();
			$lista_bodega = $cBodega -> get_bodega($cnn);
			mysqli_close($cnn);
			$lista_concepto = $cConcepto -> get_concepto($cnnAux1,1);
			require 'vista/movimiento/registro_movimiento.php';
			break;
		case 'lista_inventario';
			require 'controlador/inventario/cInventario.php';
			session_start();
			$cInventario = new cInventario();
			$cInventario -> lista_inventario($cnn);
			break;

		case 'grafico_productos':

			$cProducto->llamarConsulta($cnn);
			
			//print_r($lista);
		break;

		case 'graph_pie_preductos':
			require 'controlador/inventario/cInventario.php';
			session_start();
			$cInventario = new cInventario();
			$cInventario->consulta_distribucion_costos();

		case 'graph_barras_preductos':
		require 'controlador/inventario/cInventario.php';
			session_start();
			$cInventario = new cInventario();
			$cInventario->consulta_barras_costos();
			break;
				
		default:
			# code...
			break;
	}
	
	//mysqli_close($this->$cnn);
	
	
 ?>