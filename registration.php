<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message1 .= LANG_VALUE_123."<br>";
    }

    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message2 .= LANG_VALUE_131."<br>";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message2 .= LANG_VALUE_134."<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                            
            if($total) {
                $valid = 0;
                $error_message2 .= LANG_VALUE_147."<br>";
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message3 .= LANG_VALUE_124."<br>";
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message4 .= LANG_VALUE_125."<br>";
    }

    if(empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message6 .= LANG_VALUE_127."<br>";
    }

    if(empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message7 .= LANG_VALUE_128."<br>";
    }

    if(empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message8 .= LANG_VALUE_129."<br>";
    }

    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message9 .= LANG_VALUE_138."<br>";
    }

    if( !empty($_POST['cust_password']) && !empty($_POST['cust_re_password']) ) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message9 .= LANG_VALUE_139."<br>";
        }
    }

    if($valid == 1) {

        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                                        cust_name,
                                        cust_email,
                                        cust_phone,
                                        cust_address,
                                        cust_city,
                                        cust_state,
                                        cust_zip,
                                        cust_b_name,
                                        cust_b_phone,
                                        cust_b_country,
                                        cust_b_address,
                                        cust_b_city,
                                        cust_b_state,
                                        cust_b_zip,
                                        cust_password,
                                        cust_token,
                                        cust_datetime,
                                        cust_timestamp,
                                        cust_status
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
                                        $_POST['cust_name'],
                                        $_POST['cust_email'],
                                        $_POST['cust_phone'],
                                        $_POST['cust_address'],
                                        $_POST['cust_city'],
                                        $_POST['cust_state'],
                                        $_POST['cust_zip'],
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        md5($_POST['cust_password']),
                                        $token,
                                        $cust_datetime,
                                        $cust_timestamp,
                                        1
                                    ));

                                    if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
                                        $_SESSION['status'] ="Email and/or Password can not be empty";
                                        $_SESSION['status_code'] ="warning";
                                      } else {
                                        
                                          $cust_email = $_POST['cust_email'];
                                          $cust_password = $_POST['cust_password'];
                                  
                                          $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
                                          $statement->execute(array($cust_email));
                                          $total = $statement->rowCount();
                                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                          foreach($result as $row) {
                                              $cust_status = $row['cust_status'];
                                              $row_password = $row['cust_password'];
                                          }
                                  
                                          if($total==0) {
                                            $_SESSION['status'] ="Email Address does not match";
                                            $_SESSION['status_code'] ="warning";
                                          } else {
                                  
                                              if( $row_password != md5($cust_password) ) {
                                                $_SESSION['status'] ="Passwords do not match";
                                                $_SESSION['status_code'] ="warning";
                                              } else {
                                                  if($cust_status == 0) {
                                                    $_SESSION['status'] ="Sorry! Your account is inactive. Please contact to the administrator";
                                                    $_SESSION['status_code'] ="warning";
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
                <form action="" method="post" class="was-validated" style="width: 370px;">
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
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control textOnly" placeholder="name" name="cust_name" required>
                        <?php
                        if($error_message1 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message1."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="email" name="cust_email" required>
                        <?php
                        if($error_message2 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message2."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">Phone</label>
                        <input type="text" maxlength="10" class="form-control numbersOnly" placeholder="phone" name="cust_phone" required>
                        <?php
                        if($error_message3 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message3."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control textOnly" placeholder="address" name="cust_address" required>
                        <?php
                        if($error_message4 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message4."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">City</label>
                        <input type="text" maxlength="10" class="form-control textOnly" placeholder="city" name="cust_city" required>
                        <?php
                        if($error_message6 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message6."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">State</label>
                        <input type="text" maxlength="10" class="form-control textOnly" placeholder="state" name="cust_state" required>
                        <?php
                        if($error_message7 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message7."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">Zip Code</label>
                        <input type="text" maxlength="6" class="form-control numbersOnly" placeholder="zip code" name="cust_zip" required>
                        <?php
                        if($error_message8 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message8."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="password" name="cust_password" required>
                        <?php
                        if($error_message9 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message9."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group pt-3">
                        <label class="form-label">Retype Password</label>
                        <input type="password" class="form-control" placeholder="retype password" name="cust_re_password" required>
                        <?php
                        if($error_message9 != '') {
                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message9."</div>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for=""></label>
                        <input type="submit" class="btn btn-danger form-control" value="Register" name="form1">
                    </div>
                    <br>
                    <div class="form-group">
                        <a href="login.php" class="btn btn-danger form-control" style="color:#fff;">Already have an account?</a>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>