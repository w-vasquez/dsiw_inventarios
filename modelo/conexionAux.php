<?php
	//model de conexión
	class ConexionAux
	{
		private $servidor="localhost"; 
		private $usuario="root"; 
		private $clave=""; 
		private $base="dsiw_inventarios"; 
		public $conexAux="";
		public $conexAux1="";
		public $conexAux2="";
		public $conexAux3="";

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

		public function conectarAux1()
		{
			$mysqli = @new mysqli($this->servidor, $this->usuario, $this->clave,$this->base);

			if ($mysqli->connect_errno)
			{
				//printf("Connect failed: %s\n", mysqli_connect_error());
				die("Mensaje de conexión: ". $mysqli->connect_errno." - ".$mysqli->connect_error);

			}
			
			$this->conexAux1 = $mysqli;
			return $mysqli;
		}

		public function conectarAux2()
		{
			$mysqli = @new mysqli($this->servidor, $this->usuario, $this->clave,$this->base);

			if ($mysqli->connect_errno)
			{
				//printf("Connect failed: %s\n", mysqli_connect_error());
				die("Mensaje de conexión: ". $mysqli->connect_errno." - ".$mysqli->connect_error);

			}
			
			$this->conexAux2 = $mysqli;
			return $mysqli;
		}

		public function conectarAux3()
		{
			$mysqli = @new mysqli($this->servidor, $this->usuario, $this->clave,$this->base);

			if ($mysqli->connect_errno)
			{
				//printf("Connect failed: %s\n", mysqli_connect_error());
				die("Mensaje de conexión: ". $mysqli->connect_errno." - ".$mysqli->connect_error);

			}
			
			$this->conexAux3 = $mysqli;
			return $mysqli;
		}

	}

	$con = new ConexionAux();
	$con -> conectarAux();
	$con -> conectarAux1();
	$con -> conectarAux2();
	$con -> conectarAux3();

	$cnnAux = $con->conexAux;
	$cnnAux1 = $con->conexAux1;
	$cnnAux2 = $con->conexAux2;
	$cnnAux3 = $con->conexAux3;




	/*if ($cnnAux) {
		echo 'conexion ok';//die("Connection failed: " . mysqli_connect_error());
	}*/

?>