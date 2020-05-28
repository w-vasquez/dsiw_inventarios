<?php
	//model de conexión
	class Conexion
	{
		private $servidor="localhost"; 
		private $usuario="root"; 
		private $clave=""; 
		private $base="dsiw_inventarios"; 
		public $conex="";
		public $conexAux1="";
		public $conexAux2="";

		public function conectar()
		{
			$mysqli = @new mysqli($this->servidor, $this->usuario, $this->clave,$this->base);

			if ($mysqli->connect_errno)
			{
				//printf("Connect failed: %s\n", mysqli_connect_error());
				die("Mensaje de conexión: ". $mysqli->connect_errno." - ".$mysqli->connect_error);

			}
			
			mysqli_set_charset( $mysqli, 'utf8');
			$this->conex = $mysqli;

			return $mysqli;
		}

		public function cerrar()
		{
			mysqli_close($this->conex);
		}

		//myqls
	}


	class ConexionAux1
	{
		private $servidor="localhost"; 
		private $usuario="root"; 
		private $clave=""; 
		private $base="dsiw_inventarios"; 
		public $conexAux1="";

		public function conectarAux1()
		{
			$mysqli = @new mysqli($this->servidor, $this->usuario, $this->clave,$this->base);

			if ($mysqli->connect_errno)
			{
				//printf("Connect failed: %s\n", mysqli_connect_error());
				die("Mensaje de conexión: ". $mysqli->connect_errno." - ".$mysqli->connect_error);

			}
			mysqli_set_charset( $mysqli, 'utf8');
			$this->conexAux1 = $mysqli;
			return $mysqli;
		}

	}

	class ConexionAux2
	{
		private $servidor="localhost"; 
		private $usuario="root"; 
		private $clave=""; 
		private $base="dsiw_inventarios"; 
		public $conexAux1="";

		public function conectarAux2()
		{
			$mysqli = @new mysqli($this->servidor, $this->usuario, $this->clave,$this->base);

			if ($mysqli->connect_errno)
			{
				//printf("Connect failed: %s\n", mysqli_connect_error());
				die("Mensaje de conexión: ". $mysqli->connect_errno." - ".$mysqli->connect_error);

			}
			mysqli_set_charset( $mysqli, 'utf8');
			$this->conexAux2 = $mysqli;
			return $mysqli;
		}

	}

	$con = new Conexion();
	$con -> conectar();
	$cnn = $con->conex;

	$conAux1 = new ConexionAux1();
	$conAux1 -> conectarAux1();
	$cnnAux1 = $conAux1->conexAux1;

	$conAux2 = new ConexionAux2();
	$conAux2 -> conectarAux2();
	$cnnAux2 = $conAux2->conexAux2;

	//$cnnAux = $con->conex;


	/*if ($cnnAux1) {
		echo 'conexion ok';//die("Connection failed: " . mysqli_connect_error());
	}*/

?>