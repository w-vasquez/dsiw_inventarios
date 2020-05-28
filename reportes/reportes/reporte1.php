<?php
//Agregamos la libreria fpdf
require('fpdf/fpdf.php');
//Creamos el objeto FPDF
$pdf=new FPDF('L','mm','LETTER');
//Tipo tamaño diferente array(100,150) personalizado
//Despues de definir el Objeto, agrego la primera pagina y defino el tipo de fuente
$pdf->AddPage('L');
$pdf->SetFont('Arial','B',14); //Tipo,Carac,tamaño
//Una celda para imprimir
$pdf->Cell(260,10,'Texto a imprimir con la libreria',1,1,'C');
$pdf->ln(10);
$pdf->SetFont('Arial','',6);
$pdf->Cell(20,10,'Otro Texto',1,0,'R');
$pdf->Cell(30,10,'Otro Otro Texto',1,0,'L');
$pdf->Cell(30,10,'3Otro Otro Texto',1,0,'L');
$pdf->Cell(30,10,'4Otro Otro Texto',1,0,'L');
$pdf->Cell(30,10,'5Otro Otro Texto',1,0,'L');
$pdf->Cell(30,20,'6Otro Otro Texto'.'{\n}'.'dfhskd sdfhsdk',1,0,'L');
$pdf->Text(50, 50, 'Un texto con TEXT');
$pdf->Write(25,'Otro texto con Write ');
//Generar el PDF
$pdf->OutPut(); //$pdf->output('D','doc.pdf')
?>