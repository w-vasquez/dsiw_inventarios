<?php 

	require 'modelo/usuario/mUsuario.php';

	class cUsuario
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mUsuario;
		}

		function invocar($cnn)
		{
			session_start();
			$usu = isset($_POST['usuario']) ? $_POST['usuario'] : "";
			$pwd = isset($_POST['clave']) ? $_POST['clave'] : "";


			$usu2 = mysqli_real_escape_string($cnn,$usu); //'wilfredo';
			$pwd2 = md5(mysqli_real_escape_string($cnn,$pwd)); //
			
				

			$result = $this->modelo->getLogin($cnn,$usu2,$pwd2);
			
			$idrol = isset($_SESSION['idRol']) ? $_SESSION['idRol'] : 0; 
			if ($result=='login') 
			{
				switch ($idrol) 
				{
					case 1:
						include 'vista/master.php';
						break;
					
					case 2:
						include 'vista/master_usuario.php';
						break;
				}
				
			}else{
				empty($usu) ? "" : $alert = $result;
				include "vista/usuario/login.php";
			}	
		}

		
		function salir($cnn)
		{
			session_start();
			session_destroy();
			mysqli_close($cnn);
			require 'vista/usuario/cerrar.php';
			header("refresh:1, url=index.php");
		}

		function registro_usuario($cnn, $listaRol)
		{
			
			if ($_POST) 
			{
				$bandera = true;
				$usu = $_POST['usuario'];
				$nom = $_POST['nombre'];
				$pwd = md5($_POST['contraseña']);
				$rol = $_POST['rol'];
				$rpwd = md5($_POST['contraseñaConfirmar']);
				$nom_img = $_FILES['img_perfil']['name'];

				//verifica si usuario existe
				$statu_registro = $this->modelo->registroUsuario($cnn,$nom,$usu,$pwd,$nom_img,$rol);

				if($statu_registro)
				{
					$alert = '<p class="msg_save">Usuario registrado con exito</p>';
				}
				else
				{
					$alert = '<p class="msg_error">Usuario existe</p>';
					$bandera = false;
				}

				
				if ($pwd == $rpwd && $bandera = true) 
				{
					//$nom_img = $_FILES['img_perfil']['name'];
					$tipo_img = $_FILES['img_perfil']['type'];
					$tamano_img = $_FILES['img_perfil']['size'];
					$tmp_img = $_FILES['img_perfil']['tmp_name'];

					//verifica el tamaño y formato de la imagen a cargar.
					if(!empty($nom_img))
					{
						if ($tamano_img<=100000000) 
						{
							if ($tipo_img == "image/jpeg" || $tipo_img == "imagen/jpg" || $tipo_img == "imagen/png")
							{
								$statu_archivo = $this->modelo->cargarImagen($usu, $nom_img, $tmp_img);
								
								if($statu_archivo == 0)
								{
									$alert = '<p class="msg_error">Imagen no se ha podio cargar</p>';
								}
							}
							else
							{
								$alert = '<p class="msg_error">Formatos permitidos jpg, jpeg, png</p>';
							}
						}
						else
						{
							$alert = '<p class="msg_error">El tamaño es demasiado grande</p>';
						}
					}
				}
				else
				{
					$alert = '<p class="msg_error">Contraseña no coincide</p>';
				}
				
				
				
				
				require 'vista/usuario/registro_usuario.php';
			}
			else
			{
				echo 'no hay post';
			}
		}

		function lista_usuarios($cnn)
		{

			$this->modelo->consultaUsuario($cnn);
			$lista = $this->modelo->lista;
			require 'vista/usuario/lista_usuarios.php';
		}

		function editar_usuario($cnn,$id,$listaRol)
		{
			$this->modelo->consulta_Usuario($cnn,$id);
			$registro = $this->modelo->lista;
			//var_dump($registro);
			if(count($registro)>0)
			{
				foreach ($registro as $key) {
					$nombre = $key['nombre'];
					$usr = $key['usr'];
					$stt = $key['estatus'];
					$idrol = $key['idrol'];
					$rol3 = $key['rol'];
				}
				
				require 'vista/usuario/editar_usuario.php';
			}
		}

		function actualizar_usuario($cnn,$listaRol)
		{
			if ($_POST) 
			{
				$idusr = $_POST['id'];
				$bandera = true;
				$usu = $_POST['usuario'];
				$nom = $_POST['nombre'];
				$pwd = empty($_POST['contraseña']) ? "" : md5($_POST['contraseña']);
				$rol = $_POST['rol2'];
				$rol_nom = $_POST['rol_nom'];
				$rpwd = empty($_POST['contraseñaConfirmar']) ? "" : md5($_POST['contraseñaConfirmar']);
				$nom_img = $_FILES['img_perfil']['name'];
				$st = $_POST['status'];
				

				if($pwd != $rpwd)
				{
					$id = $idusr;
					$nombre = $nom;
					$usr = $usu;
					$idrol = $rol;
					$rol = $rol_nom;
					
					$alert = '<p class="msg_error">Contraseña no coincide</p>';
					require 'vista/usuario/editar_usuario.php';
				}
				
				$statu_registro = $this->modelo->modificar_usuario($cnn,$nom,$usu,$pwd,$nom_img,$rol,$idusr,$st);

				if($statu_registro)
				{
					header('location: index.php?acc=lista_usuarios');
				}
				else
				{
					$id = $idusr;
					$nombre = $nom;
					$usr = $usu;
					$idrol = $rol;
					$rol = $rol_nom;
					$alert = '<p class="msg_error">Usuario ya existe</p>';
					require 'vista/usuario/editar_usuario.php';
					
				}

				header('location: index.php?acc=lista_usuarios');
			}
		}

	}



	

?>