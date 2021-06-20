<?php require_once('header.php'); ?>

<?php

// Check if the product is valid or not
if( !isset($_REQUEST['id']) ) {
    header('location: cart.php');
    exit;
}

$i=0;
foreach($_SESSION['cart_id'] as $key => $value) {
    $i++;
    $arr_cart_id[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_current_price'] as $key => $value) {
    $i++;
    $arr_cart_current_price[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_name'] as $key => $value) {
    $i++;
    $arr_cart_name[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_featured_photo'] as $key => $value) {
    $i++;
    $arr_cart_featured_photo[$i] = $value;
}

unset($_SESSION['cart_id']);
unset($_SESSION['cart_current_price']);
unset($_SESSION['cart_name']);
unset($_SESSION['cart_featured_photo']);

$k=1;
for($i=1;$i<=count($arr_cart_id);$i++) {
    if( ($arr_cart_id[$i] == $_REQUEST['id']) ) {
        continue;
    } else {
        $_SESSION['cart_id'][$k] = $arr_cart_id[$i];
        $_SESSION['cart_current_price'][$k] = $arr_cart_current_price[$i];
        $_SESSION['cart_name'][$k] = $arr_cart_name[$i];
        $_SESSION['cart_featured_photo'][$k] = $arr_cart_featured_photo[$i];
        $k++;
    }
}
header('location: cart.php');
?>