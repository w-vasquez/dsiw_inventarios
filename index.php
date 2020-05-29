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
		case 'registro_nivel':
			session_start();
			if ($opc==0) {

				$lista_bodega = $cBodega -> get_bodega($cnnAux1);
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
			if($opc==0)
			{
				require 'vista/movimiento/registro_movimiento.php';
			}
			
			break;
		default:
			# code...
			break;
	}
	
	//mysqli_close($this->$cnn);
	
	
 ?>