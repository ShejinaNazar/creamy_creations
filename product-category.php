<?php require_once('header.php'); ?>

<?php
if( !isset($_REQUEST['id']) || !isset($_REQUEST['type']) ) {
    header('location: index.php');
    exit;
} else {

    if( ($_REQUEST['type'] != 'category') && ($_REQUEST['type'] != 'type')) {
        header('location: index.php');
        exit;
    } else {

        if($_REQUEST['type'] == 'category') {
            $statement = $pdo->prepare("SELECT * FROM tbl_category WHERE cat_id=?");
            $statement->execute(array($_REQUEST['id']));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) {
                $cat_name = $row['cat_name'];
            } 
        }

        if($_REQUEST['type'] == 'type') {
            $statement = $pdo->prepare("SELECT * FROM tbl_type WHERE id=?");
            $statement->execute(array($_REQUEST['id']));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) {
                $name = $row['name'];
            }
        }
        
    }   
}
?>


<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                if($_REQUEST['type'] == 'category') {
                ?>
                <h3>All Cakes Under "<?php echo $cat_name; ?>"</h3>
                <?php
                }
                ?>
                <?php 
                if($_REQUEST['type'] == 'type') {
                ?>
                <h3>All Cakes Under "<?php echo $name; ?>"</h3>
                <?php
                }
                ?>
                <div class="product product-cat">
                    <div class="row">
                        <?php
                        if($_REQUEST['type'] == 'category') {
                        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE cat_id=? AND p_is_active=? ORDER BY p_current_price AND p_id DESC");
                        $statement->execute(array($_REQUEST['id'],1));
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                        ?>
                        <div class="col-md-3 item item-product-cat">
                            <div class="inner">
                                <a href="product-details.php?id=<?php echo $row['p_id']; ?>&type=category">
                                <div class="thumb">
                                    <div class="photo" style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);"></div>
                                    <div class="overlay"></div>
                                </div>
                                </a>
                                <div class="text" style="background: #FFB6C1;">
                                    <h3><a href="product-details.php?id=<?php echo $row['p_id']; ?>&type=category"><?php echo $row['p_name']; ?></a></h3>
                                    <h4>
                                        <?php echo LANG_VALUE_1; ?><?php echo $row['p_current_price']; ?> 
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        }
                        ?>
                        <?php
                        if($_REQUEST['type'] == 'type') {
                        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE type_id=? AND p_is_active=? ORDER BY p_current_price AND p_id DESC");
                        $statement->execute(array($_REQUEST['id'],1));
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                        ?>
                        <div class="col-md-3 item item-product-cat">
                            <div class="inner">
                                <a href="product-details.php?id=<?php echo $row['p_id']; ?>&type=type">
                                <div class="thumb">
                                    <div class="photo" style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);"></div>
                                    <div class="overlay"></div>
                                </div>
                                </a>
                                <div class="text" style="background: #FFB6C1;">
                                    <h3><a href="product-details.php?id=<?php echo $row['p_id']; ?>&type=type"><?php echo $row['p_name']; ?></a></h3>
                                    <h4>
                                        <?php echo LANG_VALUE_1; ?><?php echo $row['p_current_price']; ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>