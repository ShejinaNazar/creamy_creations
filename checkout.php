<?php require_once('header.php'); ?>

<?php
if(!isset($_SESSION['cart_id'])) {
    header('location: index.php');
    exit;
}
?>

<div class="page-banner" style="background: #444;">
    <div class="inner">
        <h1>Checkout</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <?php if(!isset($_SESSION['customer'])): ?>
                    <center>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                    </center>
                <?php else: ?>

                <h3 class="special"><?php echo LANG_VALUE_26; ?></h3>
                <div class="cart">
                    <table class="table table-striped">
                        <tr>
                            <th><?php echo LANG_VALUE_7; ?></th>
                            <th><?php echo LANG_VALUE_8; ?></th>
                            <th>Details</th>
                            <th><?php echo LANG_VALUE_159; ?></th>
                            <th>Kg</th>
                            <th class="text-right"><?php echo LANG_VALUE_82; ?></th>
                        </tr>
                        <?php
                        $table_total_price = 0;
                        $customization_cost = 0;

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
                        foreach($_SESSION['cart_date'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_date[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_time'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_time[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_message'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_message[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_shape'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_shape[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_customization'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_customization[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_candles'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_candles[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_feedback'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_feedback[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_featured_photo[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_customization_cost'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_customization_cost[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_featured_photo[$i]; ?>" alt="" style="width: 35px;">
                            </td>
                            <td>
                                Cake Name: <?php echo $arr_cart_name[$i]; ?><br>
                                Delivery Date: <?php echo $arr_cart_date[$i]; ?><br>
                                Delivery Time: <?php echo $arr_cart_time[$i]; ?><br>
                                <?php
                                if($arr_cart_message[$i]=='') 
                                {
                                   
                                }else{
                                ?>
                                Message on cake: <?php echo $arr_cart_message[$i]; ?><br>
                                <?php
                                }
                                ?>
                                Shape of cake: <?php echo $arr_cart_shape[$i]; ?><br>
                                <?php
                                if($arr_cart_customization[$i]=='') 
                                {
                                   
                                }else{
                                ?>
                                Customization Method: <?php echo $arr_cart_customization[$i]; ?><br>
                                <?php
                                }
                                ?>
                                <?php
                                if($arr_cart_candles[$i]==0) 
                                {
                                   
                                }else{
                                ?>
                                Number Candles: <?php echo $arr_cart_candles[$i]; ?><br>
                                <?php
                                }
                                ?>
                                <?php
                                if($arr_cart_feedback[$i]=='') 
                                {
                                   
                                }else{
                                ?>
                                Feedback: <?php echo $arr_cart_feedback[$i]; ?>
                                <?php
                                }
                                ?>
                            </td>
                            <td><?php echo LANG_VALUE_1; ?><?php echo $arr_cart_current_price[$i]; ?></td>
                            <td><?php echo $arr_cart_kg[$i]; ?></td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_current_price[$i]*$arr_cart_kg[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                $customization_cost = $customization_cost + $arr_cart_customization_cost[$i];
                                ?>
                                <?php echo LANG_VALUE_1; ?> <?php echo $row_total_price; ?>
                            </td>
                        </tr>
                        <?php endfor; ?>           
                        <tr>
                            <th colspan="5" class="total-text"><?php echo LANG_VALUE_81; ?></th>
                            <th class="total-amount"><?php echo LANG_VALUE_1; ?> <?php echo $table_total_price; ?></th>
                        </tr>
                        <?php if($customization_cost <= 0): ?>
                        <tr>
                            <th colspan="5" class="total-text"><?php echo LANG_VALUE_82; ?></th>
                            <th class="total-amount">
                                <?php echo LANG_VALUE_1; ?> <?php echo $table_total_price; ?>
                            </th>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <th colspan="5" class="total-text">Customization Cost</th>
                            <th class="total-amount">
                               Rs <?php echo $customization_cost ?> 
                            </th>   
                        </tr>
                        <tr>
                            <th colspan="5" class="total-text"><?php echo LANG_VALUE_82; ?></th>
                            <th class="total-amount">
                                <?php echo LANG_VALUE_1; ?> <?php echo $table_total_price+$customization_cost ?>
                            </th>
                        </tr>
                        <?php endif; ?>  
                    </table> 
                </div>

                <?php
                if (isset($_POST['form1'])) {
                    // update data into the database
                    $statement = $pdo->prepare("UPDATE tbl_customer SET 
                                            cust_b_name=?,  
                                            cust_b_phone=?,  
                                            cust_b_address=?, 
                                            cust_b_city=?, 
                                            cust_b_state=?, 
                                            cust_b_zip=?
                                            WHERE cust_id=?");
                    $statement->execute(array(
                                            $_POST['cust_b_name'],
                                            $_POST['cust_b_phone'],
                                            $_POST['cust_b_address'],
                                            $_POST['cust_b_city'],
                                            $_POST['cust_b_state'],
                                            $_POST['cust_b_zip'],
                                            $_SESSION['customer']['cust_id']
                                        ));  
                
                    $success_message = LANG_VALUE_122;

                    $_SESSION['customer']['cust_b_name'] = $_POST['cust_b_name'];
                    $_SESSION['customer']['cust_b_phone'] = $_POST['cust_b_phone'];
                    $_SESSION['customer']['cust_b_address'] = $_POST['cust_b_address'];
                    $_SESSION['customer']['cust_b_city'] = $_POST['cust_b_city'];
                    $_SESSION['customer']['cust_b_state'] = $_POST['cust_b_state'];
                    $_SESSION['customer']['cust_b_zip'] = $_POST['cust_b_zip'];

                }
                ?>

                <div class="billing-address">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="user-content">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <form action="" method="post" class="was-validated">
                                    <?php $csrf->echoInputField(); ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Update billing and shipping information</h3>
                                            <div class="form-group pt-3">
                                                <label for=""><?php echo LANG_VALUE_102; ?></label>
                                                <input type="text" class="form-control textOnly" name="cust_b_name" value="<?php echo $_SESSION['customer']['cust_b_name']; ?>">
                                            </div>
                                            <div class="form-group pt-3">
                                                <label for=""><?php echo LANG_VALUE_104; ?></label>
                                                <input type="text" maxlength="10" class="form-control numbersOnly" name="cust_b_phone" value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>">
                                            </div>
                                            <div class="form-group pt-3">
                                                <label for=""><?php echo LANG_VALUE_105; ?></label>
                                                <textarea name="cust_b_address" class="form-control" cols="30" rows="10" style="height:100px;"><?php echo $_SESSION['customer']['cust_b_address']; ?></textarea>
                                            </div>
                                            <div class="form-group pt-3">
                                                <label for=""><?php echo LANG_VALUE_107; ?></label>
                                                <input type="text" class="form-control textOnly" name="cust_b_city" value="<?php echo $_SESSION['customer']['cust_b_city']; ?>">
                                            </div>
                                            <div class="form-group pt-3">
                                                <label for=""><?php echo LANG_VALUE_108; ?></label>
                                                <input type="text" class="form-control textOnly" name="cust_b_state" value="<?php echo $_SESSION['customer']['cust_b_state']; ?>">
                                            </div>
                                            <div class="form-group pt-3">
                                                <label for=""><?php echo LANG_VALUE_109; ?></label>
                                                <input type="text" maxlength="6" class="form-control numbersOnly" name="cust_b_zip" value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>">
                                            </div>
                                            <br>
                                            <input type="submit" class="btn btn-danger" value="<?php echo LANG_VALUE_5; ?>" name="form1">
                                        </div>
                                    </div>
                                    <br>
                                </form>
                            </div>                
                        </div>
                        <div class="col-md-6">
                            <div class="clear"></div>
                            <h3 class="special">Payment Section</h3>
                            <div class="row">    
                                <?php
                                $checkout_access = 1;
                                if(
                                    ($_SESSION['customer']['cust_b_name']=='') ||
                                    ($_SESSION['customer']['cust_b_phone']=='') ||
                                    ($_SESSION['customer']['cust_b_country']=='') ||
                                    ($_SESSION['customer']['cust_b_address']=='') ||
                                    ($_SESSION['customer']['cust_b_city']=='') ||
                                    ($_SESSION['customer']['cust_b_state']=='') ||
                                    ($_SESSION['customer']['cust_b_zip']=='')
                                ) {
                                    $checkout_access = 0;
                                }
                                ?>
                                <?php if($checkout_access == 0): ?>
                                    <div class="col-md-12">
                                        <div style="color:red;font-size:22px;margin-bottom:50px;">
                                            You must have to fill up all the billing and shipping information</a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12">	                		
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for=""><?php echo LANG_VALUE_34; ?> *</label>
                                            </div>
                                            <style>
                                                .order-button-payment input {
                                                    background: #FC4C4E none repeat scroll 0 0;
                                                    border: medium none;
                                                    color: #fff;
                                                    font-size: 17px;
                                                    font-weight: 600;
                                                    height: 50px;
                                                    margin: 8px 0 0;
                                                    padding: 0;
                                                    text-transform: uppercase;
                                                    -webkit-transition: all 0.3s ease 0s;
                                                    transition: all 0.3s ease 0s;
                                                    width: 100%;
                                                    border: 1px solid transparent;
                                                    cursor: pointer;
                                                }

                                                .order-button-payment input:hover {
                                                    background: #434343 none repeat scroll 0 0;
                                                }
                                            </style>
                                            <?php
                                            $checkout_access2 = 1;
                                            if(
                                                ($_SESSION['cart_customization']=='')
                                            ) {
                                                $checkout_access2 = 0;
                                            }
                                            ?>
                                            <?php if($checkout_access2 == 0): ?>
                                            <div class="order-button-payment">
                                                <?php
                                                require_once('payment/pay.php');
                                                ?>
                                                <form action="payment/payment_success.php" method="POST">
                                                <input type="hidden" name="customization_cost" value="<?php echo $customization_cost; ?>">
                                                <input type="hidden" name="final_total" value="<?php echo $table_total_price; ?>">
                                                <script
                                                    src="https://checkout.razorpay.com/v1/checkout.js"
                                                    data-key="<?php echo $keyId ?>"
                                                    data-amount="<?php echo $table_total_price*100 ?>"
                                                    data-currency="INR"
                                                    data-buttontext="Place Order"
                                                    data-name="Creamy Creations"
                                                    data-prefill.name="<?php echo $_SESSION['customer']['cust_b_name']; ?>"
                                                    data-prefill.email="<?php echo $_SESSION['customer']['cust_email']; ?>"
                                                    data-prefill.contact="<?php echo $_SESSION['customer']['cust_b_phone']; ?>"
                                                    data-theme.color="#F37254">
                                                </script>
                                                <input type="hidden" custom="Hidden Element" name="hidden">
                                                </form>
                                            </div>  
                                            <?php else: ?>
                                            <div class="order-button-payment">
                                                <?php
                                                require_once('payment/pay.php');
                                                ?>
                                                <form action="payment/payment_success.php" method="POST">
                                                <input type="hidden" name="customization_cost" value="<?php echo $customization_cost; ?>">
                                                <input type="hidden" name="final_total" value="<?php echo $table_total_price; ?>">
                                                <script
                                                    src="https://checkout.razorpay.com/v1/checkout.js"
                                                    data-key="<?php echo $keyId ?>"
                                                    data-amount="<?php echo $table_total_price*100; ?>"
                                                    data-currency="INR"
                                                    data-buttontext="Place Order"
                                                    data-name="Creamy Creations"
                                                    data-prefill.name="<?php echo $_SESSION['customer']['cust_b_name']; ?>"
                                                    data-prefill.email="<?php echo $_SESSION['customer']['cust_email']; ?>"
                                                    data-prefill.contact="<?php echo $_SESSION['customer']['cust_b_phone']; ?>"
                                                    data-theme.color="#F37254">
                                                </script>
                                                <input type="hidden" custom="Hidden Element" name="hidden">
                                                </form>
                                            </div>  
                                            <?php endif; ?>                  
                                        </div>            
                                    </div>
                                <?php endif; ?>         
                            </div>
                        </div>
                    </div>                    
                </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>