<?php require_once('header.php'); ?>

<div class="container-fluid" style="background: #FFB6C1;">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="row d-flex justify-content-center mt-4 g-1 px-4 mb-5">
                <?php
            	$statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY cat_id");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            	?>
                <div class="col-md-2 col-4">
                    <a href="product-category.php?id=<?php echo $row['cat_id']; ?>&type=category">
                        <div class="card-inner p-3 d-flex flex-column align-items-center" style="margin: 7px;"> <img src="assets/uploads/category/<?php echo $row['photo']; ?>" width="50">
                            <div class="text-center text-dark"> <span><?php echo $row['cat_name']; ?></span> </div>
                        </div>
                    </a>
                </div>
                <?php
            	}
            	?>
            </div>
        </div>
    </div>
</div>

<div class="product bg-gray pt_30 pb_30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h3 style="font-size: 30px;">Our Flavours</h3>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center g-1 px-4 mb-5">
            <?php
            $statement = $pdo->prepare("SELECT * FROM tbl_flavour ORDER BY p_id");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            foreach ($result as $row) {
            ?>
            <div class="col-md-2 col-6">
                <a href="product-details.php?id=<?php echo $row['p_id']; ?>&type=flavour">
                    <div class="card-inner p-3 d-flex flex-column align-items-center bg-white" style="margin: 7px;"> <img src="assets/uploads/flavour/<?php echo $row['p_featured_photo']; ?>" style="width: 170px;height: 130px;">
                        <div class="text-center text-dark"> <span><?php echo $row['p_name']; ?></span> </div>
                    </div>
                </a>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="product pt_30 pb_30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h3 style="font-size: 30px;">Our Varities</h3>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center g-1 px-4 mb-5">
            <?php
            $statement = $pdo->prepare("SELECT * FROM tbl_type ORDER BY id");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            foreach ($result as $row) {
            ?>
            <div class="col-md-2 col-6">
                <a href="product-category.php?id=<?php echo $row['id']; ?>&type=type">
                    <div class="card-inner p-3 d-flex flex-column align-items-center bg-gray" style="margin: 7px;"> <img src="assets/uploads/type/<?php echo $row['photo']; ?>" style="width: 170px;height: 130px;">
                        <div class="text-center text-dark"> <span><?php echo $row['name']; ?></span> </div>
                    </div>
                </a>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>