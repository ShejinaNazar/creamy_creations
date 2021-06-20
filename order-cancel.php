<?php require_once('header.php'); ?>

<?php
if( !isset($_REQUEST['id']) ) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	$statement = $pdo->prepare("UPDATE tbl_payment SET order_status=? WHERE payment_id=?");
	$statement->execute(array(1,$_REQUEST['id']));
	header('location: invoice.php?q='.$_REQUEST['id'].'');
?>