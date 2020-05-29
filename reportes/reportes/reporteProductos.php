<?php
session_start();
if(!isset($_SESSION['vsTipo']))
{
	header('location:../index.php');
}
$resp=$_SESSION['resp'];
require('fpdf/fpdf.php');

$pdf=new FPDF('P','mm','LETTER');
$pdf->addpage('P');
$pdf->setfont('Arial','B',18);
$pdf->image('../fotos/producto.png',10,10,20,20);
$pdf->cell(200,10,'Listado de Productos',0,0,'C');
$pdf->ln(20);
//Encabezado
$pdf->setfont('Arial','B',8);
$pdf->cell(10,10,'id_producto',1,0,'C');
$pdf->cell(10,10,'Nombre',1,0,'C');
$pdf->cell(50,10,'Unidad_medida',1,0,'C');
$pdf->cell(20,10,'proveedor',1,0,'C');
$pdf->cell(50,10,'Cantidad_minima',1,0,'C');
$pdf->cell(50,10,'Cantidad_maxima',1,0,'C');
$pdf->cell(20,10,'Marca',1,0,'C');
$pdf->cell(20,10,'estatus',1,0,'C');
$pdf->cell(20,10,'cto_uni',1,0,'C');
$pdf->cell(20,10,'categoria',1,0,'C');

$pdf->ln(10);
//Mostrar los datos
$pdf->setfont('Arial','',8);
foreach($resp as $columnas=>$filas)
{
	$pdf->cell(10,10,$filas['id_producto'],0,0,'L');
	$pdf->cell(50,10,$filas['Nombre'],0,0,'L');
	$pdf->cell(20,10,$filas['Unidad_medida'],0,0,'L');
	$pdf->cell(50,10,$filas['proveedor'],0,0,'L');
	$pdf->cell(50,10,$filas['Cantidad_minima'],0,0,'L');
	$pdf->cell(20,10,$filas['Cantidad_maxima'],0,0,'L');
	$pdf->cell(20,10,$filas['Marca'],0,0,'L');
	$pdf->cell(20,10,$filas['estatus'],0,0,'L');
	$pdf->cell(20,10,$filas['cto_uni'],0,0,'L');
	$pdf->cell(20,10,$filas['categoria'],0,0,'L');
	$pdf->ln(10);
}
////Aqui queda el cursor
//Pie de pagina
$pdf->line(10,235,210,235);
$posicionY=(235-$pdf->GetY());
$pdf->ln($posicionY);
$pdf->output();
?>