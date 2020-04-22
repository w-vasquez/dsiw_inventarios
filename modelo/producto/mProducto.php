<?php 

	class mProducto
	{
		private $id_producto;
		private $Nombre;
		private $foto;
		private $Unidad_medida;
		private $Id_proveedor;
		private $Cantidad_minima;
		private $Cantidad_maxima;
		private $Marca;
		private $estatus;
		private $cto_uni;
		private $id_categoria;


		public $lista;

		function __construct()
		{
			$this -> lista = array();
		}

		function insertar_producto($cnn,$nom,$foto,$uni,$id_proveedor,$max,$min,$marca,$id_categoria)
		{

			$sql = "CALL sp_InsertarProductos_wvp ('".$nom."','".$foto."','".$uni."','".$id_proveedor."','".$max."','".$min."','".$marca."','".$id_categoria."');";

			//echo $sql;
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

		function consulta_producto($cnn)
		{
			$sql = "call sp_consultaproductosSP_de;";
			$query = mysqli_query($cnn,$sql);
			while($row = mysqli_fetch_array($query))
			{
				$this->lista[]=$row;
			}
			return $this->lista;

		}

	}

 ?>