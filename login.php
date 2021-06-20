<?php require_once('header.php'); ?>

<?php
    if(isset($_POST['form1'])) {
        if($_POST['cust_email'] == 'admin@gmail.com'){ 
            if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
                $error_message = 'Email and/or Password can not be empty<br>';
            } else {
                
                $email = strip_tags($_POST['cust_email']);
                $password = strip_tags($_POST['cust_password']);
        
                $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? AND status=?");
                $statement->execute(array($email,'Active'));
                $total = $statement->rowCount();    
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                if($total==0) {
                    $error_message .= 'Email Address does not match<br>';
                } else {       
                    foreach($result as $row) { 
                        $row_password = $row['password'];
                    }
                
                    if( $row_password != md5($password) ) {
                        $error_message .= 'Password does not match<br>';
                    } else {       
                    
                        $_SESSION['user'] = $row;
                        header("location: admin/index.php");
                    }
                }
            }   
        }else{
            if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
                $error_message = LANG_VALUE_132.'<br>';
            } else {
                
                $cust_email = strip_tags($_POST['cust_email']);
                $cust_password = strip_tags($_POST['cust_password']);
    
                $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
                $statement->execute(array($cust_email));
                $total = $statement->rowCount();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row) {
                    $cust_status = $row['cust_status'];
                    $row_password = $row['cust_password'];
                }
    
                if($total==0) {
                    $error_message .= LANG_VALUE_133.'<br>';
                } else {
    
                    if( $row_password != md5($cust_password) ) {
                        $error_message .= LANG_VALUE_139.'<br>';
                    } else {
                        if($cust_status == 0) {
                            $error_message .= LANG_VALUE_148.'<br>';
                        } else {
                            $_SESSION['customer'] = $row;
                            header("location: dashboard.php");
                        }
                    }
                    
                }
            }
        }
    }
?>


<style>
    
    .form-control {
        line-height: 2;
    }

    .bg-custom {
        background-color: #FFB6C1;
    }

    .btn-custom {
        background-color: #3e3d56;
        color: #fff;
    }

    .btn-custom:hover {
        background-color: #33313f;
        color: #fff;
    }

    label {
        color: #fff;
    }

    a,
    a:hover {
        color: #fff;
        text-decoration: none;
    }

    a,
    a:hover {
        text-decoration: none;
    }

    @media(max-width: 932px) {
        .display-none {
            display: none !important;
        }
    }
</style>




<div class="page">
    <div class="container">
        <div class="row m-0 h-100">
            <div class="col p-0 text-center d-flex justify-content-center align-items-center display-none">
                <img src="assets/img/login.svg" class="w-100">
            </div>
            <div class="col p-0 bg-custom d-flex justify-content-center align-items-center flex-column w-100">
                <form action="" method="post" class="was-validated" style="width: 300px;">
                    <?php $csrf->echoInputField(); ?>     
                    <?php
                    if($error_message != '') {
                        echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                    }
                    if($success_message != '') {
                        echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                    }
                    ?>   
                    <div class="form-group pt-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="email" name="cust_email" required>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="password" name="cust_password" required>
                    </div>
                    <div class="form-group">
                        <label for=""></label>
                        <input type="submit" class="btn btn-danger form-control" value="<?php echo LANG_VALUE_9; ?>" name="form1">
                    </div>
                    <br>
                    <div class="form-group">
                        <a href="registration.php" class="btn btn-danger form-control" style="color:#fff;">Signup</a>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>