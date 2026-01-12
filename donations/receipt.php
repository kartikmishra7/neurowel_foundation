<?php
require('../fpdf/fpdf.php');
include '../config.php';

$id = (int)$_GET['id'];

$d = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT d.full_name,d.email,do.*,c.title
FROM donations do
JOIN donors d ON do.donor_id=d.id
LEFT JOIN campaigns c ON do.campaign_id=c.id
WHERE do.id=$id
"));

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);

$pdf->Cell(0,10,'Donation Receipt',0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,"Name: {$d['full_name']}",0,1);
$pdf->Cell(0,8,"Email: {$d['email']}",0,1);
$pdf->Cell(0,8,"Campaign: {$d['title']}",0,1);
$pdf->Cell(0,8,"Amount: Rs {$d['amount']}",0,1);
$pdf->Cell(0,8,"Payment: {$d['payment_method']}",0,1);
$pdf->Cell(0,8,"Date: {$d['donated_on']}",0,1);

$pdf->Output();
