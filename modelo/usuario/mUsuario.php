<?php 
	class mUsuario
	{

		private $idUsuario;
		private $nombre;
		private $usuario;
		private $contrasenia;
		private $foto;
		private $estatus;
		private $idRol;

		public $lista;
		public $img;
		private $bandera=true;

		function __construct()
		{
			$this -> lista = array();
		}

		
		function getLogin($cnn,$usu,$pwd)
		{

			//session_start();

			if(empty($usu) || empty($pwd))
			{
				return 'invalid user';
			}
			else
			{
				$query = mysqli_query($cnn,"CALL sp_consultaUsuariosCP_wvp ('".$usu."','".$pwd."');");
				$result = mysqli_num_rows($query);

				//$this->consultarUsuario($cnn,$usu,$pwd);
				if ($result>0) 
				{
					//session_start();
					$data = mysqli_fetch_array($query);
					$_SESSION['active'] = true;
					$_SESSION['idUsu'] = $data['idUsuario'];
					$_SESSION['nombre'] = $data['nombre'];
					$_SESSION['usuario'] = $data['usuario'];
					$_SESSION['pwd'] = $data['contrasenia'];
					$_SESSION['foto'] = $data['foto'];
					$_SESSION['estatus'] = $data['estatus'];
					$_SESSION['idRol'] = $data['idRol'];
					return 'login';
				}
				else
				{
					return 'invalid user';
					session_destroy();
				}
			}
		}

		function cargarImagen($usu, $nombre,$tmp)
		{
			
			$carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/dsiw1/si/img/profile/'.$usu.'/';
			
			if(!file_exists($carpeta_destino)) //verificar existenia directorio
			{
				if(mkdir($carpeta_destino, 0777, true)) //crear carpeta
				{
					$resultado =  move_uploaded_file($tmp, $carpeta_destino.$nombre);
					
				}
			}
			else
			{
				$resultado = move_uploaded_file($tmp, $carpeta_destino.$nombre);
			}
			
			return $resultado;
		}

		function registroUsuario($cnn,$nom,$usu,$pwd,$nom_img,$rol)
		{

			$sql = "CALL sp_insertarYverficarUsuario_wvp ('".$nom."','".$usu."','".$pwd."','".$nom_img."','".$rol."');";

			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);
			

			while ($row = mysqli_fetch_array($query)) {
				$this->lista[] = $row;
			}


			//print_r($this->lista);

			foreach ($this->lista as $key) 
			{
				if ($key['0']=='true') 
				{
					return true;
				}
			}

			return false;
		}

		function consultaUsuario($cnn)
		{
			
			$query = mysqli_query($cnn,"call sp_listaUsuarioSP_wvp;");
			
			while($row = mysqli_fetch_array($query))
			{
				$this->lista[] = $row;
			}
		}

		function consulta_Usuario($cnn,$id)
		{
			$query = mysqli_query($cnn,"call sp_listausuarioCP_wvp ('".$id."');");
			while($row = mysqli_fetch_array($query))
			{
				$this->lista[] = $row;
			}
		}

		function modificar_usuario($cnn,$nom,$usu,$pwd,$nom_img,$rol,$idusr,$st)
		{

			$sql = "CALL sp_actualizarYverficarUsuario_wvp ('".$nom."','".$usu."','".$pwd."','".$nom_img."','".$rol."','".$idusr."','".$st."');";
			//echo $sql;
			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);

			//guardar valores desde el SP
			while ($row = mysqli_fetch_array($query)) 
			{
				$this->lista[] = $row;
			}

			foreach ($this->lista as $key) 
			{
				
				if ($key['0']=='true') 
				{
					return true;
					//$this->$img = $key['1']; 
				}
			}

			//guardar archivo
			$carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/dsiw1/si/img/profile/'.$usu.'/';
			$carpeta_origen = $_SERVER['DOCUMENT_ROOT'].'/dsiw1/si/img/user.png';
			
			if(!file_exists($carpeta_destino)) //verificar existenia directorio
			{
				mkdir($carpeta_destino, 0777, true);
				copy($carpeta_origen, $carpeta_destino.'user.png');

			}

			return false;
		}

	}

 ?>