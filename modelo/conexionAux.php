<?php
	//model de conexión
	class ConexionAux
	{
		private $servidor="localhost"; 
		private $usuario="root"; 
		private $clave=""; 
		private $base="dsiw_inventarios"; 
		public $conexAux="";

		public function conectarAux()
		{
			$mysqli = @new mysqli($this->servidor, $this->usuario, $this->clave,$this->base);

			if ($mysqli->connect_errno)
			{
				//printf("Connect failed: %s\n", mysqli_connect_error());
				die("Mensaje de conexión: ". $mysqli->connect_errno." - ".$mysqli->connect_error);

			}
			
			$this->conexAux = $mysqli;
			return $mysqli;
		}

		public function cerrarAux()
		{
			mysqli_close($this->conex);
		}
	}

	$con = new ConexionAux();
	$con -> conectarAux();

	$cnnAux = $con->conexAux;




	/*if ($cnnAux) {
		echo 'conexion ok';//die("Connection failed: " . mysqli_connect_error());
	}*/

?>