<?php 
	class mProveedor
	{
		private $id_proveedor;
		private $Nombre;
		private $correo;
		private $direccion;
		private $id_municipio;
	
		private $bandera=true;

		function __construct()
		{
			$this -> lista = array();
		}

	    function registro_proveedor($cnn,$nom,$email,$dir,$id_mun)
		{
		  	$sql = "CALL sp_agregarProveedor_de ('".$nom."','".$email."','".$dir."','".$id_mun."');";
		  	//echo $sql;
			//$query = $cnn->query($sql);
			$query = mysqli_query($cnn,$sql);

			while($row = mysqli_fetch_array($query))
			{
				$this->lista[] = $row;
			}



			foreach ($this->lista as $key) 
			{
				if ($key['0']=='true') 
				{
					return true;
				}
			}

			return false;
		}


		function consulta_proveedores($cnn)
		{
			
			$query = mysqli_query($cnn,"call sp_consultaProveedorSP_wvp;");
			
			while($row = mysqli_fetch_array($query))
			{
				$this->lista[] = $row;
			}

			return $this->lista;
		}


	}

 ?>