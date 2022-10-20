<div class="container-md my-3">
<h2>Write Review - <?php echo $brand.' '.$name.' '.$color; ?></h2>
<br>
</div>
<div style="color:red;"><?php 
    if(isset($err_message)){
        echo $err_message;
    };
?></div>
<div class="container-md my-3">
    <form method="post" action="<?php echo base_url(); ?>review/processReview/">
        <input type="hidden" class="form-control" id="uname" name="uname" value="<?php echo $uname?>">
        <input type="hidden" class="form-control" id="product" name="product" value="<?php echo $product_id?>">
        <div class="form-group">
            <label for="content">Review Content:</label>
            <textarea type="text" class="form-control" id="con" placeholder="Enter review content" name="con" required></textarea>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
