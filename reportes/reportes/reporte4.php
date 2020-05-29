<?php
session_start();
require('fpdf/fpdf.php');
$_SESSION['Titulo']='Reporte Prueba';
$_SESSION['Total']=80;
require('encfoo.php');

// Creación del objeto de la clase heredada
//$pdf=new FPDF('P','mm','LETTER'); //YA NO
$pdf = new miPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=80;$i++)
    $pdf->Cell(0,10,'Imprimir Linea #: '.$i,0,1);
$pdf->Output();
?>