<?php
    require 'modelo/inventario/mInventario.php';

	class cInventario
	{
		private $modelo;

		function __construct()
		{
			$this -> modelo = new mInventario;
        }

        function lista_inventario($cnn)
		{
			$this->modelo->consulta_inventario($cnn);
			$lista = $this->modelo->lista;
			require 'vista/inventario/lista_inventario.php';
		}
        

    }
?>