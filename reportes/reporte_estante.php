<?php
session_start();
if(!isset($_SESSION['idRol']))
{
	header('location:../index.php');
}
$resp=$_SESSION['resp'];
require('fpdf/fpdf.php');

$pdf=new FPDF('P','mm','LETTER');
$pdf->addpage('P');
$pdf->setfont('Arial','B',18);
//$pdf->image('../images/domain.png',10,10,20,20);
$pdf->cell(200,10,'Listado de estantes',0,0,'C');
$pdf->ln(20);
//Encabezado
$pdf->setfont('Arial','B',8);
$pdf->cell(10,10,'Codigo',1,0,'C');
$pdf->cell(50,10,'Bodega',1,0,'C');
$pdf->cell(20,10,'Estante',1,0,'C');
$pdf->cell(50,10,'Estatus',1,0,'C');
$pdf->cell(50,10,'Correo',1,0,'C');
//$pdf->cell(20,10,'Telefono',1,0,'C');
$pdf->ln(10);
//Mostrar los datos
$pdf->setfont('Arial','',8);
foreach($resp as $columnas=>$filas)
{
	$pdf->cell(10,10,$filas['id_estante'],0,0,'L');
	$pdf->cell(50,10,$filas['bodega'],0,0,'L');
	$pdf->cell(20,10,$filas['estante'],0,0,'L');
	$pdf->cell(50,10,$filas['estatus'],0,0,'L');
	$pdf->cell(50,10,$filas['num_niveles'],0,0,'L');
	//$pdf->cell(20,10,$filas['telefono'],0,0,'L');
	$pdf->ln(10);
}
////Aqui queda el cursor
//Pie de pagina
$pdf->line(10,235,210,235);
$posicionY=(235-$pdf->GetY());
$pdf->ln($posicionY);
$pdf->cell(0,10,'Total Clientes:'.count($resp),0,1,'R');
$pdf->cell(0,10,'Num Pagina: '.$pdf->PageNo(),0,0,'C');
$pdf->output();
?>