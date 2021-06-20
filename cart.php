<?php require_once('header.php'); ?>

<?php
$error_message = '';
if(isset($_POST['form1'])) {

    $i = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_product");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $i++;
        $table_product_id[$i] = $row['p_id'];
    }

    $i=0;
    foreach($_POST['product_id'] as $val) {
        $i++;
        $arr1[$i] = $val;
    }
    $i=0;
    foreach($_POST['kg'] as $val) {
        $i++;
        $arr2[$i] = $val;
    }
    $i=0;
    foreach($_POST['product_name'] as $val) {
        $i++;
        $arr3[$i] = $val;
    }
    
    $allow_update = 1;
    for($i=1;$i<=count($arr1);$i++) {
        for($j=1;$j<=count($table_product_id);$j++) {
            if($arr1[$i] == $table_product_id[$j]) {
                $temp_index = $j;
                break;
            }
        }
        $_SESSION['cart_p_kg'][$i] = $arr2[$i];
    }
    $error_message .= '\nOther items are updated successfully!';
    ?>
    
    <?php if($allow_update == 0): ?>
    	<script>alert('<?php echo $error_message; ?>');</script>
	<?php else: ?>
		<script>alert('All Items Update is Successful!');</script>
	<?php endif; ?>
    
<?php
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_cart; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo LANG_VALUE_18; ?></h1>
    </div>
</div>

<div class="page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

                <?php if(!isset($_SESSION['cart_id'])): ?>
                    <?php echo 'Cart is empty'; ?>
                <?php else: ?>
                <form action="" method="post">
                    <?php $csrf->echoInputField(); ?>
				<div class="cart">
                    <table class="table table-striped">
                        <tr>
                            <th>Serial</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>kg/ml</th>
                            <th class="text-right">Total</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php
                        $table_total_price = 0;
                        $i=0;
                        foreach($_SESSION['cart_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_kg'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_kg[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_featured_photo[$i]; ?>" alt="" style="width: 35px;">
                            </td>
                            <td><?php echo $arr_cart_name[$i]; ?></td>
                            <td><?php echo LANG_VALUE_1; ?> <?php echo $arr_cart_current_price[$i]; ?></td>
                            <td><?php echo $arr_cart_kg[$i]; ?></td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_current_price[$i]*$arr_cart_kg[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                <?php echo LANG_VALUE_1; ?> <?php echo $row_total_price; ?>
                            </td>
                            <td class="text-center">
                                <a onclick="return confirmDelete();" href="cart-item-delete.php?id=<?php echo $arr_cart_id[$i]; ?>" class="trash" style="color: #FC4C4E;"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endfor; ?>
                        <tr>
                            <td colspan="5" class="total-text">Total</td>
                            <td class="total-amount"><?php echo LANG_VALUE_1; ?><?php echo $table_total_price; ?></td>
                        </tr>
                    </table> 
                </div>

                <div class="cart-buttons">
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <li><a href="index.php" class="btn btn-primary"><?php echo LANG_VALUE_85; ?></a></li>
                        </div>
                        <div class="col-md-3 col-6">
                            <li><a href="checkout.php" class="btn btn-primary">Continue Ordering</a></li>
                        </div>
                    </div>
                </div>
                </form>
                <?php endif; ?>

			</div>
		</div>
	</div>
</div>


<?php require_once('footer.php'); ?>