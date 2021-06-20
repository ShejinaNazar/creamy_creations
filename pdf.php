<?php
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();


$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
$statement->execute(array($_SESSION['customer']['cust_id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $cust_name = $row['cust_name'];
    $cust_email = $row['cust_email'];
    $cust_phone = $row['cust_phone'];
    $cust_address = $row['cust_address'];
    $cust_city = $row['cust_city'];
    $cust_state = $row['cust_state'];
    $cust_zip = $row['cust_zip'];
}
?>

<?php
require('fpdf183/fpdf.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130	,5,'Creamy Creation',0,0);
$pdf->Cell(59	,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130	,5,'Kottayam, Mundakayam',0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(130	,5,'Phone: 8606292325',0,0);
$pdf->Cell(25	,5,'Invoice',0,0);
$pdf->Cell(34	,5,'#'.$_REQUEST['q'].'',0,1);//end of line

$pdf->Cell(130	,5,'Email creamycreationmdkm@gmail.com',0,0);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//billing address
$pdf->Cell(100	,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,''.$cust_name.'',0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,''.$cust_email.'',0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,''.$cust_address.'',0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,''.$cust_phone.'',0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(100	,5,'Items',1,0);
$pdf->Cell(30	,5,'Price',1,0);
$pdf->Cell(25	,5,'kg/ml/piece',1,0);
$pdf->Cell(34	,5,'Amount',1,1);//end of line

$pdf->SetFont('Arial','',12);

//Numbers are right-aligned so we give 'R' after new line parameter
$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
$statement->execute(array($_REQUEST['q']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {

$pdf->Cell(100	,5,''.$row['product_name'].'',1,0);
$pdf->Cell(30	,5,''.$row['unit_price'].'',1,0);
$pdf->Cell(25	,5,''.$row['kilogram'].'',1,0);
$pdf->Cell(34	,5,''.$row['kilogram'] * $row['unit_price'].'',1,1,'R');//end of line

}

$sum = 0;
$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
$statement->execute(array($_REQUEST['q']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$customization_cost = $statement->rowCount();
foreach ($result as $row) {
    $sum += $row['unit_price'] * $row['kilogram'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
$statement->execute(array($_REQUEST['q']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $customization_cost = $row['customization_cost'];
    $paid_amount = $row['paid_amount'];
}

//summary
$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(29	,5,'Cus. Cost',0,0);
$pdf->Cell(30	,5,'Rs '.$customization_cost.'',1,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(29	,5,'Total Price',0,0);
$pdf->Cell(30	,5,'Rs '.$paid_amount.'',1,1,'R');//end of line


$pdf->Output();
?>
