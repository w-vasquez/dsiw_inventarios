<?php
require('fpdf/fpdf.php');
$pdf = new fpdf('P', 'mm', 'Letter');
$pdf-> AddPage('P');
$pdf-> Setfont('Arial', 'B', '14');
$pdf->image('../images/domain.png',10,10,20,20);
$pdf-> cell(80);
$pdf-> cell(50,10,'Titulo Reporte',1,0,'c');
$pdf-> ln(30);
$pdf-> Setfont('Times','','14');
for($i=1;$i<=60;$i++)
{
	$pdf-> cell(0,10,'Imprimir Linea #:'.$i,0,1);
}
//$pdf->header(); subclase
$pdf->line(10,245,200,245);
$pdf-> cell(0,10,'Total Lineas: '.$i,0,0,'C');
$pdf-> cell(0,10,'Pagina ·No: '.$pdf->PageNo(),0,0,'C');
$pdf->output();
?>