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
    $p_id = $row['p_id'];
    $p_name = $row['p_name'];
    $p_current_price = $row['p_current_price'];
	$p_choose_kg_piece = $row['p_choose_kg_piece'];
    $p_featured_photo = $row['p_featured_photo'];
    $p_description = $row['p_description'];
    $p_is_active = $row['p_is_active'];
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
				<div class="product">
					<div class="row">
						<div class="col-md-5">
							<img src="assets/uploads/flavour/<?php echo $f_featured_photo; ?>" alt="">
						</div>
						<div class="col-md-7">
							<div class="p-title"><h2><?php echo $f_name; ?></h2></div>
                            <div class="p-price">
                                <span style="font-size:14px;">Cake Price</span><br>
                                <span>
                                    <?php echo LANG_VALUE_1; ?><?php echo $f_current_price; ?><?php if($f_choose_kg_piece == 'ml') { }else{ ?>/<?php echo $f_choose_kg_piece; } ?>
                                </span>
                            </div>
							<div class="p-short-des">
								<p>
									<?php echo $f_description; ?>
								</p>
							</div>
							<div class="btn-cart btn-cart1">
                                <a href="product.php?id=<?php echo $f_id; ?>&type=flavour">Add to Cart</a>
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
				<div class="product">
					<div class="row">
						<div class="col-md-5">
							<img src="assets/uploads/<?php echo $p_featured_photo; ?>" alt="">
						</div>
						<div class="col-md-7">
							<div class="p-title"><h2><?php echo $p_name; ?></h2></div>
                            <div class="p-price">
								<span style="font-size:14px;">Cake Price</span><br>
                                <span>
                                    <?php echo LANG_VALUE_1; ?><?php echo $p_current_price; ?><?php if($p_choose_kg_piece == 'ml') { }else{ ?>/<?php echo $p_choose_kg_piece; } ?>
                                </span>
                            </div>
							<div class="p-short-des">
								<p>
									<?php echo $p_description; ?>
								</p>
							</div>
							<div class="btn-cart btn-cart1">
                                <a href="product.php?id=<?php echo $p_id; ?>&type=category">Add to Cart</a>
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
