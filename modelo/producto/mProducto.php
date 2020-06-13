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

	public function setNombre($n)
	{
		$this->Nombre=$n;
	}
	public function getNombre()
	{
		return $this->Nombre;
	}
	public function setfoto($n)
	{
		$this->foto=$n;
	}
	public function getfoto()
	{
		return $this->foto;
	}
	public function setUnidad_medida($n)
	{
		$this->Unidad_medida=$n;
	}
	public function getUnidad_medida()
	{
		return $this->Unidad_medida;
	}
	public function setId_proveedor($n)
	{
		$this->Id_proveedor=$n;
	}
	public function getId_proveedor()
	{
		return $this->Id_proveedor;
	}
	public function setCantidad_minima($n)
	{
		$this->Cantidad_minima=$n;
	}
	public function getCantidad_minima()
	{
		return $this->Cantidad_minima;
	}
	public function setCantidad_maxima($n)
	{
		$this->Cantidad_maxima=$n;
	}
	public function getCantidad_maxima()
	{
		return $this->Cantidad_maxima;
	}
	public function setMarca($n)
	{
		$this->Marca=$n;
	}
	public function getMarca()
	{
		return $this->Marca;
	}
	public function setestatus($n)
	{
		$this->estatus=$n;
	}
	public function getestatus()
	{
		return $this->estatus;
	}
	public function setcto_uni($n)
	{
		$this->cto_uni=$n;
	}
	public function getcto_uni()
	{
		return $this->cto_uni;
	}
	public function setid_categoria($n)
	{
		$this->id_categoria=$n;
	}
	public function getid_categoria()
	{
		return $this->id_categoria;
	}
	

	public $lista;

	function __construct()
	{
		$this -> lista = array();
	}

	public function consultaGraficio($cnn)
	{
		$sql = "call sp_Productos_vendidos";
		$query = mysqli_query($cnn,$sql);
		return $query;
	}
		
	public function ConsultaUnProducto($cnn,$_id_producto)
	{
		$resultado=mysqli_query($cnn,"CALL ConsultaUnProducto('".$_id_producto."');");
		$cliente=mysqli_fetch_array($resultado);
		$this->setNombre($mProducto['Nombre']);
		$this->setfoto($mProducto['foto']);
		$this->setUnidad_medida($mProducto['Unidad_medida']);
		$this->setId_proveedor($mProducto['Id_proveedor']);
		$this->setCantidad_maxima($mProducto['Cantidad_maxima']);
		$this->setCantidad_minima($mProducto['Cantidad_minima']);
		$this->setMarca($mProducto['Marca']);
		$this->setid_categoria($mProducto['id_categoria ']);
		$this->setestatus($mProducto['estatus']);
		$this->setcto_uni($mProducto['cto_uni']);
		
	}

		function insertar_producto($cnn,$nom,$foto,$uni,$id_proveedor,$max,$min,$marca,$esta,$costo,$id_categoria)
		{

			$sql = "CALL sp_InsertarProducto_wvp ('".$nom."','".$foto."','".$uni."','".$id_proveedor."','".$max."','".$min."','".$marca."','".$esta."','".$costo."','".$id_categoria."');";

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
		
		/*
		
		public function ModificarProductos($cnn,$nom,$uni,$id_proveedor,$max,$min,$marca,$esta,$costo,$id_categoria,$id_pro)
		{
		   echo $sql ="CALL sp_modificarProductos_wvps('".$nom."','".$uni."','".$id_proveedor."','".$max."','".$min."','".$marca."','".$esta."','".$costo."','".$id_categoria."','".$id_pro."');";

            $query = mysqli_query($cnn,$sql);
            $rs = mysqli_fetch_array($query);
            return $rs;
				
		}
		*/
		public function ModificarProductos($cnnAux2,$nom,$uni,$id_proveedor,$max,$min,$marca,$esta,$costo,$id_categoria,$id_pro)
		{
		   echo $sql="CALL sp_modificarProductos_wvp('".$nom."','".$uni."','".$id_proveedor."','".$max."','".$min."','".$marca."','".$esta."','".$costo."','".$id_categoria."','".$id_pro."');";

            $query = mysqli_query($cnnAux2,$sql);
            $rs = mysqli_fetch_array($query);
            return $rs;
				
		}


	public function EliminarUnProducto($cnn,$id_producto)
	{
		$resultado=mysqli_query($cnn,"CALL Sp_EliminarProducto_ksn('".$id_producto."');");
		return $resultado;
	}	
	
	/*	function consulta_Usuario($cnn,$id)
		{
			$query = mysqli_query($cnn,"call sp_listausuarioCP_wvp ('".$id."');");
			while($row = mysqli_fetch_array($query))
			{
				$this->lista[] = $row;
			}
		}
	*/	

		function consulta_producto($cnn,$id_producto)
		{
			$sql = "call sp_consultaproductosCP_de ('".$id_producto."');";
			$query = mysqli_query($cnn,$sql);
			while($row = mysqli_fetch_array($query))
			{
				$this->lista[]=$row;
			}
			return $this->lista;

		}
		
		function consultaproducto($cnn)
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