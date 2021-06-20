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

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12"> 
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
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
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <h3><?php echo LANG_VALUE_86; ?></h3>
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
                            <div class="col-md-3"></div>
                        </div>
                        <br>
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>