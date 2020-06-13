<?php // content="text/plain; charset=utf-8"
require('jpgraph/src/jpgraph.php');
require('jpgraph/src/jpgraph_bar.php');



require_once ('../../modelo/conexion.php');
$sql = "CALL sp_consultaCostos_wvp;";
$query = mysqli_query($cnn,$sql);

$costo = array();
$etiquetas = array();

while ($data = mysqli_fetch_assoc($query)) 
{
	array_push($costo, $data['Costo_total']);
	array_push($etiquetas, $data['producto']);
}

//print_r($costo);
//Craer el objeto del grafico
$grafico=new Graph(1000,400,'auto');
$grafico->SetScale("textint");
$tema=new RoseTheme;
$grafico->SetTheme($tema);
$grafico->title->Set("Grafico costo por producto");


//Agrego titulo y los valores en el eje X
$grafico->xaxis->title->Set("productos");
$grafico->xaxis->SetTickLabels($etiquetas);
$grafico->yaxis->title->Set("costo");


$bar1=new BarPlot($costo);
$bar1->SetLegend("costo");

$bar1->value->Show();

$bar1->SetFillGradient("#d1d1d1", "#85929e", GRAD_HOR);
$grupo=new GroupBarPlot(array($bar1));
//Asignamos la barra al grafico
$grafico->Add($grupo);


$grafico->Stroke();

?>