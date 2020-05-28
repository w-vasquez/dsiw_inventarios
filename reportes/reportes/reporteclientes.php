<?php
session_start();
if ($_SESSION['idRol']==1)
			{
		
			}  

$resp=$_SESSION['resp'];
require('fpdf/fpdf.php');

$pdf=new FPDF('P','mm','LETTER');
$pdf->addpage('P');
$pdf->setfont('Arial','B',18);
$pdf->image('../images/domain.png',10,10,20,20);
$pdf->cell(200,10,'Listado de Clientes',0,0,'C');
$pdf->ln(20);
//Encabezado
$pdf->setfont('Arial','B',8);
$pdf->cell(10,10,'Codigo',1,0,'C');
$pdf->cell(50,10,'Nombre',1,0,'C');
$pdf->cell(20,10,'Dui',1,0,'C');
$pdf->cell(50,10,'Usuario',1,0,'C');
$pdf->cell(50,10,'Correo',1,0,'C');
$pdf->cell(20,10,'Telefono',1,0,'C');
$pdf->ln(10);
//Mostrar los datos
$pdf->setfont('Arial','',8);
foreach($resp as $columnas=>$filas)
{
	$pdf->cell(10,10,$filas['codcliente'],0,0,'L');
	$pdf->cell(50,10,$filas['nombre'],0,0,'L');
	$pdf->cell(20,10,$filas['dui'],0,0,'L');
	$pdf->cell(50,10,$filas['usuario'],0,0,'L');
	$pdf->cell(50,10,$filas['correo'],0,0,'L');
	$pdf->cell(20,10,$filas['telefono'],0,0,'L');
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