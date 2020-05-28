<?php
class miPDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
	    // Logo
	    $this->Image('../images/domain.png',10,10,20,20);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Movernos a la derecha
	    $this->Cell(80);
	    // Título
	    $this->Cell(30,10,''.$_SESSION['Titulo'],1,0,'C');
	    // Salto de línea
	    $this->Ln(20);
	}

	// Pie de página
	function Footer()
	{
	    // Posición: a 1,5 cm del final
	    $this->SetY(-25);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    $this->Cell(0,10,'Total '.$_SESSION['Total'],0,1,'C');
	    // Número de página
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	    //{nb} imprime el total de paginas siempre que se active con la funcion AliasNbPages()
	}
}

?>