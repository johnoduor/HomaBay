<?php
require('../pdf/fpdf17/fpdf.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219.(10*2)= 189mm

$pdf = new FPDF('p','mm','A4');

$pdf -> AddPage();

//set font to arial, bold, 14pt
$pdf-> SetFont('Arial', 'B', 14);

//cell(width,height, text,border,endline, [align])

$pdf->Cell(130 ,5, 'HOMABAY HOSPITAL',0,0);
$pdf->Cell(59 ,5, 'INVOICE',0,1);//end of line

//set font toarial,regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130 ,5,'Hospital Road',0,0);
$pdf->Cell(59 ,5,'',0,1);//end of line

$pdf->Cell(130 ,5,'HomaBay, Kenya, 00200',0,0);
$pdf->Cell(25 ,5,'Date',0,0);
$pdf->Cell(34 ,5,'[dd/mm/yyyy]',1,1);//end of line

$pdf->Cell(130 ,5,'Phone +254 705109561',0,0);
$pdf->Cell(25 ,5,'Invoive #',0,0);
$pdf->Cell(34 ,5,'[1234567]',0,1);//end of line

$pdf->Cell(130 ,5,'Fax [+254 700]',0,0);
$pdf->Cell(25 ,5,'Patient ID',0,0);
$pdf->Cell(34 ,5,'[1234567]',0,1);//end of line


$pdf->Output();
?>