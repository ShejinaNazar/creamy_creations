<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by payment_id=?");
$statement->execute(array($_REQUEST['q']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
    $order_status = $row['order_status'];
}
?>

<?php if($order_status == 1): ?>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12 text-center">
                <h3 style="margin-top:20px;">Order is cancelled</h3>
                <div class="row pt-5">
                    <div class="col-md-12">
                        <a href="customer-order.php" class="btn btn-danger">View Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else: ?>

<style>
    .hh-grayBox {
        background-color: #F8F8F8;
        margin-bottom: 20px;
        padding: 35px;
    margin-top: 20px;
    }
    .pt45{padding-top:45px;}
    .order-tracking{
        text-align: center;
        width: 33.33%;
        position: relative;
        display: block;
    }
    .order-tracking .is-complete{
        display: block;
        position: relative;
        border-radius: 50%;
        height: 30px;
        width: 30px;
        border: 0px solid #AFAFAF;
        background-color: #f7be16;
        margin: 0 auto;
        transition: background 0.25s linear;
        -webkit-transition: background 0.25s linear;
        z-index: 2;
    }
    .order-tracking .is-complete:after {
        display: block;
        position: absolute;
        content: '';
        height: 14px;
        width: 7px;
        top: -2px;
        bottom: 0;
        left: 5px;
        margin: auto 0;
        border: 0px solid #AFAFAF;
        border-width: 0px 2px 2px 0;
        transform: rotate(45deg);
        opacity: 0;
    }
    .order-tracking.completed .is-complete{
        border-color: #27aa80;
        border-width: 0px;
        background-color: #27aa80;
    }
    .order-tracking.completed .is-complete:after {
        border-color: #fff;
        border-width: 0px 3px 3px 0;
        width: 7px;
        left: 11px;
        opacity: 1;
    }
    .order-tracking p {
        color: #A4A4A4;
        font-size: 16px;
        margin-top: 8px;
        margin-bottom: 0;
        line-height: 20px;
    }
    .order-tracking p span{font-size: 14px;}
    .order-tracking.completed p{color: #000;}
    .order-tracking::before {
        content: '';
        display: block;
        height: 3px;
        width: calc(100% - 40px);
        background-color: #f7be16;
        top: 13px;
        position: absolute;
        left: calc(-50% + 20px);
        z-index: 0;
    }
    .order-tracking:first-child:before{display: none;}
    .order-tracking.completed:before{background-color: #27aa80;}
</style>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by payment_id=?");
$statement->execute(array($_REQUEST['q']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
    $payment_status = $row['payment_status'];
    $shipping_status = $row['shipping_status'];
}
?>

<?php
// Checking the order table and removing the pending transaction that are 24 hours+ old
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
$statement->execute(array($_REQUEST['q']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$ts1 = strtotime($row['payment_date']);
	$ts2 = strtotime($current_date_time);     
	$diff = $ts2 - $ts1;
	$time = $diff/(60);
	if($time<5) {

?>

<script type="text/javascript">
   setTimeout(function(){
       location.reload();
   },60000);
</script>

<div class="container text-center pt-5">
    <h3 style="margin-top:20px;">Order Cancellation</h3>
    <p>You can cancel the item within 5 minutes</p>
    <div class="row pt-5">
        <div class="col-md-12">
            <a href="order-cancel.php?id=<?php echo $_REQUEST['q']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger">Cancel Order</a>
        </div>
    </div>
</div>

<?php
}
}
?>

<div class="container text-center pt-5">
    <h3 style="margin-top:20px;">Order Details</h3>
    <div class="row pt-5">
        <div class="col-md-12">
            <div class="row justify-content-between">
                <div class="order-tracking completed">
                    <span class="is-complete"></span>
                    <p>Ordered</p>
                </div>
                <div class="order-tracking <?php if($payment_status=='Completed'){echo 'completed';} ?>">
                    <span class="is-complete"></span>
                    <p>Shipped</p>
                </div>
                <div class="order-tracking <?php if($shipping_status=='Completed'){echo 'completed';} ?>">
                    <span class="is-complete"></span>
                    <p>Delivered</p>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <center>
                    <p>
                        <div class="row">
                            <div class="col-md-6 pt-2">
                                <a href="customer-order.php" class="btn btn-danger">View Orders</a>
                            </div>
                            <div class="col-md-6 pt-2">
                                <a href="pdf.php?q=<?php echo $_REQUEST['q']; ?>" class="btn btn-danger">Download Invoice</a>
                            </div>
                        </div>
                    </p>
                </center>
            </div>
        </div>
    </div>
</div>

<hr>

<style>
    .card {
        margin-bottom: 30px;
        border: none;
        -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
        -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
        box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22)
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e6e6f2
    }

    h3 {
        font-size: 20px
    }

    h5 {
        font-size: 15px;
        line-height: 26px;
        color: #3d405c;
        margin: 0px 0px 15px 0px;
        font-family: 'Circular Std Medium'
    }

    .text-dark {
        color: #3d405c !important
    }              
</style>        
<?php
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
<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
    <div class="card" style="background: #eee;">
        <div class="card-header p-4">
            <div class="row mb-4">
                <div class="col-sm-6 pt-3">
                    <h3 class="text-dark mb-1"><?php echo $cust_name; ?></h3>
                    <div><?php echo $cust_city; ?>, <?php echo $cust_state; ?> <?php echo $cust_zip; ?></div>
                    <div>Email: <?php echo $cust_email; ?></div>
                    <div>Phone: <?php echo $cust_phone; ?></div>
                </div>
                <div class="col-sm-6 pt-3">
                    <div class="float-right">
                        <h3 class="mb-0">Invoice #<?php echo $_REQUEST['q']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>Cake</th>
                            <th class="right">Price</th>
                            <th class="center">Kg</th>
                            <th class="right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                        $statement->execute(array($_REQUEST['q']));
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                        ?>
                        <tr>
                            <td class="center"><?php echo $i; ?></td>
                            <td class="left strong"><?php echo $row['product_name']; ?></td>
                            <td class="right"><?php echo $row['unit_price']; ?></td>
                            <td class="center"><?php echo $row['kilogram']; ?></td>
                            <td class="right">Rs <?php echo $row['kilogram'] * $row['unit_price'] ?> </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5">
                </div>
                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
                            $statement->execute(array($_REQUEST['q']));
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $customization_cost = $row['customization_cost'];
                                $paid_amount = $row['paid_amount'];
                            }
                            ?>
                            <tr>
                                <td class="left">
                                    <strong class="text-dark">Customization Cost</strong> </td>
                                <td class="right">
                                    <strong class="text-dark">Rs <?php echo $customization_cost ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="left">
                                    <strong class="text-dark">Total Price</strong> </td>
                                <td class="right">
                                    <strong class="text-dark">Rs <?php echo $paid_amount ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<?php require_once('footer.php'); ?>