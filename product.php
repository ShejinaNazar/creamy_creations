<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: index.php');
    exit;
}

$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row) {
    $p_name = $row['p_name'];
    $p_current_price = $row['p_current_price'];
    $p_choose_kg_piece = $row['p_choose_kg_piece'];
    $p_featured_photo = $row['p_featured_photo'];
    $p_description = $row['p_description'];
    $p_is_active = $row['p_is_active'];
}

if(isset($_POST['form_add_to_cart'])) {
    if(isset($_SESSION['cart_id']))
    {
        $arr_cart_id = array();
        $arr_cart_kg = array();
        $arr_cart_current_price = array();
        $cart_customization_cost = array();

        $i=0;
        foreach($_SESSION['cart_id'] as $key => $value) 
        {
            $i++;
            $arr_cart_id[$i] = $value;
        }

        $added = 0;

        for($i=1;$i<=count($arr_cart_id);$i++) {
            if( ($arr_cart_id[$i]==$_REQUEST['id']) ) {
                $added = 1;
                break;
            }
        }
        if($added == 1) {
           $error_message1 = 'This product is already added to the shopping cart.';
        } else {

            $i=0;
            foreach($_SESSION['cart_id'] as $key => $res) 
            {
                $i++;
            }
            $new_key = $i+1;

            $_SESSION['cart_id'][$new_key] = $_REQUEST['id'];
            $_SESSION['cart_kg'][$new_key] = $_POST['p_kg'];
            $_SESSION['cart_current_price'][$new_key] = $_POST['p_current_price'];
            $_SESSION['cart_name'][$new_key] = $_POST['p_name'];
            $_SESSION['cart_featured_photo'][$new_key] = $_POST['p_featured_photo'];
            $_SESSION['cart_date'][$new_key] = $_POST['date'];
            $_SESSION['cart_time'][$new_key] = $_POST['time'];
            $_SESSION['cart_message'][$new_key] = $_POST['message'];
            $_SESSION['cart_shape'][$new_key] = $_POST['shape'];
            $_SESSION['cart_customization'][$new_key] = $_POST['customization'];
            $_SESSION['cart_candles'][$new_key] = $_POST['candles'];
            $_SESSION['cart_feedback'][$new_key] = $_POST['feedback'];
            if(($_POST['customization']=='') OR ($_POST['candles']=='')){
                $_SESSION['cart_customization_cost'][$new_key] = 0;
            }else{
                $_SESSION['cart_customization_cost'][$new_key] = 100;
            }

            $success_message1 = 'Product is added to the cart successfully!';

            header('location: cart.php');

        }
        
    }
    else
    {
        $_SESSION['cart_id'][1] = $_REQUEST['id'];
        $_SESSION['cart_kg'][1] = $_POST['p_kg'];
        $_SESSION['cart_current_price'][1] = $_POST['p_current_price'];
        $_SESSION['cart_name'][1] = $_POST['p_name'];
        $_SESSION['cart_featured_photo'][1] = $_POST['p_featured_photo'];
        $_SESSION['cart_date'][1] = $_POST['date'];
        $_SESSION['cart_time'][1] = $_POST['time'];
        $_SESSION['cart_message'][1] = $_POST['message'];
        $_SESSION['cart_shape'][1] = $_POST['shape'];
        $_SESSION['cart_customization'][1] = $_POST['customization'];
        $_SESSION['cart_candles'][1] = $_POST['candles'];
        $_SESSION['cart_feedback'][1] = $_POST['feedback'];
        if(($_POST['customization']=='') OR ($_POST['candles']=='')){
            $_SESSION['cart_customization_cost'][1] = 0;
        }else{
            $_SESSION['cart_customization_cost'][1] = 100;
        }

        $success_message1 = 'Product is added to the cart successfully!';

        header('location: cart.php');

    }
}
?>

<?php
if($error_message1 != '') {
    echo "<script>alert('".$error_message1."')</script>";
}
if($success_message1 != '') {
    echo "<script>alert('".$success_message1."')</script>";
}
?>

<?php 
if($_REQUEST['type'] == 'flavour') {
$statement = $pdo->prepare("SELECT * FROM tbl_flavour WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {
    $f_id = $row['p_id'];
    $f_name = $row['p_name'];
    $f_current_price = $row['p_current_price'];
    $f_choose_kg_piece = $row['p_choose_kg_piece'];
    $f_featured_photo = $row['p_featured_photo'];
    $f_description = $row['p_description'];
    $f_is_active = $row['p_is_active'];
}
?>

<div class="page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <center>
                    <h1>Order Page</h1>
                    <hr>
                </center>
				<div class="product">
					<div class="row">
						<div class="col-md-5">
							<img src="assets/uploads/flavour/<?php echo $f_featured_photo; ?>" alt="">
						</div>
						<div class="col-md-7">
							<div class="p-title"><h2><?php echo $f_name; ?></h2></div>
							<div class="p-short-des">
								<p>
									<?php echo $f_description; ?>
								</p>
							</div>
                            <form action="" method="post" class="was-validated">
							<div class="p-price">
                                <span style="font-size:14px;"><?php echo $f_name; ?></span><br>
                                <span>
                                    <?php echo LANG_VALUE_1; ?> <?php echo $f_current_price; ?><?php if($f_choose_kg_piece == 'ml') { }else{ ?>/<?php echo $f_choose_kg_piece; } ?>
                                </span>
                            </div>
                            <input type="hidden" name="p_current_price" value="<?php echo $f_current_price; ?>">
                            <input type="hidden" name="p_name" value="<?php echo $f_name; ?>">
                            <input type="hidden" name="p_featured_photo" value="<?php echo $f_featured_photo; ?>">
                            <?php if($f_choose_kg_piece == 'kg')
                            {
                            ?>
                            <div class="p-quantity col-md-6">
                                <?php echo $f_choose_kg_piece; ?><br>
								<input type="number" class="form-control input-text qty" step="0.5" min="0.5" max="" name="p_kg" value="1" title="Kg" size="4" pattern="[0-9]*" inputmode="numeric" required>
							</div>
                            <?php
                            }elseif($f_choose_kg_piece == 'piece'){
                            ?>
                            <div class="p-quantity col-md-6">
                                <?php echo $f_choose_kg_piece; ?><br>
								<input type="number" class="form-control input-text qty" step="1" min="1" max="" name="p_kg" value="1" title="Kg" size="4" pattern="[0-9]*" inputmode="numeric" required>
							</div>
                            <?php
                            }else{
                            ?>
                            <div class="p-quantity col-md-6">
                                <?php echo $f_choose_kg_piece; ?><br>
								<input type="number" class="form-control input-text qty" step="1" min="1" max="" name="p_kg" value="1" title="Kg" size="4" pattern="[0-9]*" inputmode="numeric" required>
							</div>
                            <?php
                            }
                            ?>
							<div class="p-quantity col-md-6">
                                <span style="font-size:14px;">Delivery Date</span><br>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="p-quantity col-md-6">
                                <span style="font-size:14px;">Delivery Time</span><br>
                                <input type="time" name="time" class="form-control" required>
                            </div>
                            <div class="p-price col-md-6">
                                <span style="font-size:14px;">Message on cake</span><br>
                                <textarea name="message" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="p-quantity col-md-6">
                                <span style="font-size:14px;">Shape of cake</span><br>
                                <select name="shape" class="form-control" required>
									<option value="">Select Shape</option>
                                    <option value="Default">Default</option>
                                    <option value="Heart">Heart</option>
                                    <option value="Circle">Circle</option>
                                    <option value="Square">Square</option>
                                    <option value="doll">Doll</option>
                                    <option value="car">Car</option>
								</select>
                            </div>
                            <div class="p-quantity col-md-6">
                                <span style="font-size:14px;">Customization</span><br>
                                <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck"> Yes <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck"> No<br>
                            </div>
                            <div id="ifYes" style="visibility:hidden">
                                <div class="p-quantity col-md-6">
                                    <span style="font-size:14px;">Customization Method</span><br>
                                    <select name="customization" class="form-control">
                                        <option value="">Select Method</option>
                                        <option value="Fondant">Fondant</option>
                                        <option value="Candles">Candles</option>
                                        <option value="Topper">Topper</option>
                                        <option value="Cigerates">Cigerates</option>
                                    </select>
                                </div>
                                <div class="p-quantity col-md-6">
                                    <span style="font-size:14px;">Number Candles</span><br>
                                    <input type="number" min="0" name="candles" id='yes' value="0" class="form-control">
                                </div>
                            </div>
                            <div class="p-price col-md-6">
                                <span style="font-size:14px;">Feedback</span><br>
                                <textarea name="feedback" class="form-control" id="" cols="30" rows="5"></textarea>
                            </div>
							<div class="btn-cart btn-cart1">
                                <input type="submit" value="Add to Cart" name="form_add_to_cart">
							</div>
                            </form>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>
<?php
}else{
?>
<div class="page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <center>
                    <h1>Order Page</h1>
                    <hr>
                </center>
				<div class="product">
					<div class="row">
                        <div class="col-md-5">
							<img src="assets/uploads/<?php echo $p_featured_photo; ?>" alt="">
						</div>
						<div class="col-md-7">
							<div class="p-title"><h2><?php echo $p_name; ?></h2></div>
							<div class="p-short-des">
								<p>
									<?php echo $p_description; ?>
								</p>
							</div>
                            <form action="" method="post" class="was-validated">
							<div class="p-price">
                                <span style="font-size:14px;"><?php echo $p_name; ?></span><br>
                                <span>
                                    <?php echo LANG_VALUE_1; ?> <?php echo $p_current_price; ?><?php if($p_choose_kg_piece == 'ml') { }else{ ?>/<?php echo $p_choose_kg_piece; } ?>
                                </span>
                            </div>
                            <input type="hidden" name="p_current_price" value="<?php echo $p_current_price; ?>">
                            <input type="hidden" name="p_name" value="<?php echo $p_name; ?>">
                            <input type="hidden" name="p_featured_photo" value="<?php echo $p_featured_photo; ?>">
                            <?php if($p_choose_kg_piece == 'kg')
                            {
                            ?>
                            <div class="p-quantity col-md-6">
                                <?php echo $p_choose_kg_piece; ?><br>
								<input type="number" class="form-control input-text qty" step="0.5" min="0.5" max="" name="p_kg" value="1" title="Kg" size="4" pattern="[0-9]*" inputmode="numeric" required>
							</div>
                            <?php
                            }elseif($p_choose_kg_piece == 'piece'){
                            ?>
                            <div class="p-quantity col-md-6">
                                <?php echo $p_choose_kg_piece; ?><br>
								<input type="number" class="form-control input-text qty" step="1" min="1" max="" name="p_kg" value="1" title="Kg" size="4" pattern="[0-9]*" inputmode="numeric" required>
							</div>
                            <?php
                            }else{
                            ?>
                            <div class="p-quantity col-md-6">
                                Number of Jar
								<input type="number" class="form-control input-text qty" step="1" min="1" max="" name="p_kg" value="1" title="Kg" size="4" pattern="[0-9]*" inputmode="numeric" required>
							</div>
                            <?php
                            }
                            ?>
                            <div class="p-quantity col-md-6">
                                <span style="font-size:14px;">Delivery Date</span><br>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="p-quantity col-md-6">
                                <span style="font-size:14px;">Delivery Time</span><br>
                                <input type="time" name="time" class="form-control" required>
                            </div>
                            <div class="p-price col-md-6">
                                <span style="font-size:14px;">Message on cake</span><br>
                                <textarea name="message" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="p-quantity col-md-6">
                                <span style="font-size:14px;">Shape of cake</span><br>
                                <select name="shape" class="form-control" required>
									<option value="">Select Shape</option>
                                    <option value="Default">Default</option>
                                    <option value="Heart">Heart</option>
                                    <option value="Circle">Circle</option>
                                    <option value="Square">Square</option>
                                    <option value="doll">Doll</option>
                                    <option value="car">Car</option>
								</select>
                            </div>
                            <div class="p-quantity col-md-6">
                                <span style="font-size:14px;">Customization</span><br>
                                <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck"> Yes <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck"> No<br>
                            </div>
                            <div id="ifYes" style="visibility:hidden">
                                <div class="p-quantity col-md-6">
                                    <span style="font-size:14px;">Customization Method</span><br>
                                    <select name="customization" class="form-control">
                                        <option value="">Select Method</option>
                                        <option value="Fondant">Fondant</option>
                                        <option value="Candles">Candles</option>
                                        <option value="Topper">Topper</option>
                                        <option value="Cigerates">Cigerates</option>
                                    </select>
                                </div>
                                <div class="p-quantity col-md-6">
                                    <span style="font-size:14px;">Number Candles</span><br>
                                    <input type="number" min="0" name="candles" id='yes' value="0" class="form-control">
                                </div>
                            </div>
                            <div class="p-price col-md-6">
                                <span style="font-size:14px;">Feedback</span><br>
                                <textarea name="feedback" class="form-control" id="" cols="30" rows="5"></textarea>
                            </div>
							<div class="btn-cart btn-cart1">
                                <input type="submit" value="Add to Cart" name="form_add_to_cart">
							</div>
                            </form>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>
<?php
}
?>
<?php require_once('footer.php'); ?>
<script>
function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    else document.getElementById('ifYes').style.visibility = 'hidden';

}
</script>