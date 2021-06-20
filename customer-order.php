<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3><?php echo LANG_VALUE_25; ?></h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo LANG_VALUE_7; ?></th>
                                    <th><?php echo LANG_VALUE_48; ?></th>
                                    <th><?php echo LANG_VALUE_27; ?></th>
                                    <th><?php echo LANG_VALUE_29; ?></th>
                                    <th>Status</th>
                                    <th><?php echo LANG_VALUE_31; ?></th>
                                    <th>Order Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=0;
                                $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_email=? ORDER BY id DESC");
                                $statement->execute(array($_SESSION['customer']['cust_email']));
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                            $statement1->execute(array($row['payment_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                echo 'Product Name: '.$row1['product_name'];
                                                echo '<br>Unit Price: '.$row1['unit_price'];
                                                echo '<br><br>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['payment_date']; ?></td>
                                        <td><?php echo $row['paid_amount']; ?></td>
                                        <td>
                                            <?php if($row['order_status'] == 1): ?>
                                            Order Cancelled
                                            <?php else: ?>
                                            Order Confirmation: <?php echo $row['payment_status']; ?><br>
                                            Deliver Status: <?php echo $row['shipping_status']; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row['payment_method']; ?></td>
                                        <td>
                                        <?php echo $row['payment_id']; ?><br>
                                        <a href="invoice.php?q=<?php echo $row['payment_id']; ?>" class="btn btn-danger">Order Details</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>