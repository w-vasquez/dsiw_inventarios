<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_pie.php');
require_once ('jpgraph/src/jpgraph_pie3d.php');



require_once ('../../modelo/conexion.php');
$sql = "CALL sp_consultaCostos_wvp;";
$query = mysqli_query($cnn,$sql);

$data_arr = array();
$label_arr = array();
// Some data
//$data = array(40,60,21,33);

while ($data = mysqli_fetch_assoc($query)) 
{
	array_push($data_arr, $data['Costo_total']);
	array_push($label_arr, $data['producto']);
}

// Create the Pie Graph. 
$graph = new PieGraph(650,550,'auto');

$theme_class= new VividTheme;
$graph->SetTheme($theme_class);

// Set A title for the plot
$graph->title->Set("Distribución de costos");

// Create
$p1 = new PiePlot3D($data_arr);
$p1->SetLegends($label_arr);
$p1->ExplodeSlice(0,20);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('blue');
//$p1->ExplodeSlice(1);
$graph->Stroke();

?>