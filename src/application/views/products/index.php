<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>membership Cart</title>
    <link href=" <?php echo base_url('assets/css/bootstrap.min.css'); ?> " rel="stylesheet">
</head>
<body>

    <div class="container">
        <h2>Membership</h2>
        <!-- Cart basket -->
        <div class="cart-view">
            <a href="<?php echo base_url('cart'); ?>" title="View Cart"><img src="<?php echo base_url('assets/img/cart.jpg'); ?>" class="icart"> (<?php echo ($this->cart->total_items() > 0)?$this->cart->total_items().' Items':'Empty'; ?>)</a>
        </div>

        <!-- List all products -->
        <div class="row col-lg-12">
            <?php if(!empty($products)){ foreach($products as $row){ ?>
                <div class="card col-lg-3">
                    <img class="card-img-top" src="<?php echo base_url('uploads/'.$row['image']); ?>" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Price: <?php echo '$'.$row["price"].' USD'; ?></h6>
                        <p class="card-text"><?php echo $row["description"]; ?></p>
                        <a href="<?php echo base_url('products/addToCart/'.$row['p_id']); ?>" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            <?php } }else{ ?>
                <p>Product(s) not found...</p>
            <?php } ?>
        </div>
    </div>
	
