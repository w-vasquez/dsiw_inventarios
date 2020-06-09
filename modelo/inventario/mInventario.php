<?php 
	class mInventario
	{
        public $lista;

		function __construct()
		{
			$this -> lista = array();
        }
        
        function insertar_inventario($cnn,$nom,$stt,$id_bodega)
		{

			$sql = "CALL sp_insertarestante_ksn ('".$nom."','".$stt."','".$id_bodega."');";
			$query = mysqli_query($cnn,$sql);

		}

		function consulta_inventario($cnn)
		{
			$sql = "CALL sp_consultainventario_de;";

			$query = mysqli_query($cnn,$sql);

			while ($row = mysqli_fetch_array($query)) {
				$this->lista[] = $row;
			}
		}

    }
?>
