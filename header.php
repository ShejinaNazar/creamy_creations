<?php
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();

require 'assets/mail/PHPMailer.php';
require 'assets/mail/Exception.php';
$mail = new PHPMailer\PHPMailer\PHPMailer();

$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';
$error_message2 = '';
$error_message3 = '';
$error_message4 = '';
$error_message5 = '';
$error_message6 = '';
$error_message7 = '';
$error_message8 = '';
$error_message9 = '';

// Getting all language variables into array as global variable
$i=1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	define('LANG_VALUE_'.$i,$row['lang_value']);
	$i++;
}

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$logo = $row['logo'];
	$favicon = $row['favicon'];
    $theme_color = $row['color'];
}

// Checking the order table and removing the pending transaction that are 24 hours+ old
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$ts1 = strtotime($row['payment_date']);
	$ts2 = strtotime($current_date_time);     
	$diff = $ts2 - $ts1;
	$time = $diff/(3600);
	if($time>24) {

		// Deleting data from table
		$statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));

		$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
		$statement1->execute(array($row['id']));
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Meta Tags -->
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/uploads/<?php echo $favicon; ?>">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="assets/css/jquery.bxslider.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/rating.css">
	<link rel="stylesheet" href="assets/css/spacing.css">
	<link rel="stylesheet" href="assets/css/bootstrap-touch-slider.css">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/tree-menu.css">
	<link rel="stylesheet" href="assets/css/select2.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/responsive.css">

	<?php

	$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	
	if($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'product-category.php' || $cur_page == 'product.php') {
		?>
		<title>Home Page</title>
		<?php
	}
	
	if($cur_page == 'product.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
		    $og_photo = $row['p_featured_photo'];
		    $og_title = $row['p_name'];
		    $og_slug = 'product.php?id='.$_REQUEST['id'];
			$og_description = substr(strip_tags($row['p_description']),0,200).'...';
		}
	}

	if($cur_page == 'dashboard.php') {
		?>
		<title>Dashboard</title>
		<?php
	}
	if($cur_page == 'customer-profile-update.php') {
		?>
		<title>Update Profile</title>
		<?php
	}
	if($cur_page == 'customer-billing-shipping-update.php') {
		?>
		<title>Update Billing and Shipping Info</title>
		<?php
	}
	if($cur_page == 'customer-password-update.php') {
		?>
		<title>Update Password</title>
		<?php
	}
	if($cur_page == 'customer-order.php') {
		?>
		<title>Orders</title>
		<?php
	}
	?>

	<?php if($cur_page == 'product.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

	<style>
		.search {
			width: 100%;
			margin-bottom: auto;
			margin-top: 20px;
			height: 50px;
			background-color: #fff;
			padding: 10px;
			border-radius: 5px
		}

		.search-input {
			color: white;
			border: 0;
			outline: 0;
			background: none;
			width: 0;
			margin-top: 5px;
			caret-color: transparent;
			line-height: 20px;
			transition: width 0.4s linear
		}

		.search .search-input {
			padding: 0 10px;
			width: 100%;
			caret-color: #536bf6;
			font-size: 19px;
			font-weight: 300;
			color: black;
			transition: width 0.4s linear
		}

		.search-icon {
			height: 34px;
			width: 34px;
			float: right;
			display: flex;
			justify-content: center;
			align-items: center;
			color: white;
			background-color: #536bf6;
			font-size: 10px;
			bottom: 30px;
			position: relative;
			border-radius: 5px
		}

		.search-icon:hover {
			color: #fff !important
		}

		a:link {
			text-decoration: none
		}

		.card-inner {
			position: relative;
			display: flex;
			overflow: hidden;
			flex-direction: column;
			min-width: 0;
			word-wrap: break-word;
			background-color: #fff;
			background-clip: border-box;
			border: 1px solid rgba(0, 0, 0, .125);
			border-radius: .25rem;
			border: none;
			cursor: pointer;
			transition: all 2s
		}

		.card-inner:hover {
			transform: scale(1.1)
		}

		.mg-text span {
			font-size: 12px
		}

		.mg-text {
			line-height: 14px
		}
		
		.top .right ul li a:hover,
        .nav,
        .menu-container,
        .slide-text > a.btn-primary,
        .welcome p.button a,
        .product .owl-controls .owl-prev:hover, 
        .product .owl-controls .owl-next:hover,
        .product .text p a,
        .home-blog .text p.button a,
        .home-newsletter,
        .footer-main h3:after,
        .scrollup i,
        .cform input[type="submit"],
        .blog p.button a,
        div.pagination a,
        #left ul.nav>li.cat-level-1.parent>a,
        .product .btn-cart1 input[type="submit"],
        .review-form .btn-default {
			background: #<?php echo $theme_color; ?>!important;
		}
        
        #left ul.nav>li.cat-level-1.parent>a>.sign, 
        #left ul.nav>li.cat-level-1 li.parent>a>.sign {
            background-color: #<?php echo $theme_color; ?>!important;
        }
        
        .top .left ul li,
        .top .left ul li i,
        .top .right ul li a,
        .welcome p.button a:hover,
        .product .text h4,
        .cform address span,
        .blog h3 a:hover,
        .blog .text ul.status li a,
        .blog .text ul.status li,
        .widget ul li a:hover,
        .breadcrumb ul li,
        .breadcrumb ul li a,
        .product .p-title h2 {
			color: #<?php echo $theme_color; ?>!important;
		}
        
        .scrollup i,
        div.pagination a,
        #left ul.nav>li.cat-level-1.parent>a {
            border-color: #<?php echo $theme_color; ?>!important;
        }
        
        .widget h4 {
            border-bottom-color: #<?php echo $theme_color; ?>!important;
        }
        
        
        .top .right ul li a:hover,
        #left ul.nav>li.cat-level-1 .lbl1 {
            color: #fff!important;
        }
        .welcome p.button a:hover {
            background: #fff!important;
        }
        .slide-text > a:hover, .slide-text > a:active {
            background-color: #333333!important;
        }
        .product .text p a:hover,
        .home-blog .text p.button a:hover,
        .blog p.button a:hover {
            background: #333!important;
        }
        
        div.pagination span.current {
            border-color: #777!important;
            background: #777!important;
        }
        
        div.pagination a:hover, 
        div.pagination a:active {
            border-color: #777!important;
            background: #777!important;
        }
        
        .product .nav {
            background: transparent!important;
        }
        
    </style>

</head>
<body>

<!-- <div id="preloader">
	<div id="status">
	</div>
</div> -->

<div class="top">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="left">
					<ul>
						<li><i class="fa fa-phone"></i> +918606292325</li>
						<li><i class="fa fa-envelope-o"></i> creamycreationmdkm@gmail.com</li>
					</ul>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="right">
					<ul>
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						<li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="header" style="background: #FFB6C1;padding: 10px;">
	<div class="container">
		<div class="row inner">
			<div class="col-md-3 logo pt-3">
				<a href="index.php"><h1 style="color:#fff">Creamy Creation</h1></a>
			</div>
			<div class="col-md-6 search-area">
				<form class="navbar-form" role="search" action="search-result.php" method="get">
					<?php $csrf->echoInputField(); ?>
					<div class="d-flex justify-content-center">
						<div class="search"> <input type="text" class="search-input" placeholder="Search..." name="search_text"> <button type="submit" class="btn btn-default search-icon" style="background-color:#FC4C4E; color:#fff;"><i class="fa fa-search" aria-hidden="true"></i></button></div>
					</div>
				</form>
			</div>
			<div class="col-md-3 right pt-3">
				<ul>
					
					<?php
					if(isset($_SESSION['customer'])) {
						?>
						<li style="color:#000;"><i class="fa fa-user" style="color:#000;"></i> <?php echo LANG_VALUE_13; ?> <?php echo $_SESSION['customer']['cust_name']; ?></li>
						<li><a href="dashboard.php" style="color:#000;"><i class="fa fa-home"></i> <?php echo LANG_VALUE_89; ?></a></li>
						<?php
					} else {
						?>
						<li><a href="login.php" style="color:#000;"><i class="fa fa-sign-in"></i> <?php echo LANG_VALUE_9; ?></a></li>
						<li><a href="registration.php" style="color:#000;"><i class="fa fa-user-plus"></i> <?php echo LANG_VALUE_15; ?></a></li>
						<?php	
					}
					?>
					<li><a href="cart.php" style="color:#FC4C4E;"><i class="fa fa-shopping-cart"></i> <?php echo LANG_VALUE_19; ?>
					(<?php
					 if(isset($_SESSION['cart_id'])) {
						$table_total_items = 0;
						$i=0;
	                    foreach($_SESSION['cart_id'] as $key => $value) 
	                    {
	                        $i++;
	                        $arr_cart_id[$i] = $value;
	                    }
						echo count($arr_cart_id);
					} else {
						echo '0';
					}
					?>)
					</a></li>
					<?php
					if(isset($_SESSION['customer'])) {
						?>
						<li><a href="logout.php" style="color:#000;"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
						<?php
					} else {
						?>
						
						<?php	
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="nav">
	<div class="container">
		<div class="row">
			<div class="col-md-12 pl_0 pr_0">
				<div class="menu-container">
					<div class="menu">
						<ul>
							<li><a href="index.php">Home</a></li>
							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE show_on_menu=1");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
							?>
							<li><a href="product-category.php?id=<?php echo $row['cat_id']; ?>&type=category"><?php echo $row['cat_name']; ?></a></li>
							<?php
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>