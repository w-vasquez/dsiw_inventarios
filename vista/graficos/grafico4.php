<?php
//Cargar la libreria
require('jpgraph/src/jpgraph.php');
require('jpgraph/src/jpgraph_line.php');

require ('../../modelo/conexion.php');
//require('../modelo/producto/mProducto.php');

//$pr=new mProducto();

//$consulta=$pr->Cantidad_Pro_v($cnn);
$consulta =mysqli_query($cnn,'CALL sp_Productos_vendidos;');
$dato1=array();
$dato2=array();


while($filas=mysqli_fetch_array($consulta))
{
	$dato1[]=$filas['mas'];
	$dato2[]=$filas['Nombre'];
}

//Crear el objeto grafrico
$grafico=new Graph(900,450);
$grafico->SetScale("textlin");
//Caracteristicas del Grafico
$tema=new GreenTheme;

$grafico->SetTheme($tema);
$grafico->title->Set('Grafico de productos mas vendidos');
$grafico->SetBox(true);

$grafico->xgrid->Show();
$grafico->xgrid->SetLineStyle('solid');
$grafico->xaxis->SettickLabels(array());
$grafico->xgrid->SetColor('green');


//Primera linea de datos
$l1=new LinePlot($dato1);
$l1->SetColor('red');
$grafico->Add($l1);
//Segunda linea de datos
$l2=new LinePlot($dato2);
	
$l2->SetColor('red');
$l2->SetLegend('productos');
$grafico->Add($l2);
//Tercera linea de datos


//Generemos el grafico
$grafico->Stroke();
?>
