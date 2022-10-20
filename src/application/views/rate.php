<div class="container-md my-3">
<h2>Rating</h2>
<br>
</div>
<div style="color:red;"><?php 
    if($err_message != ""){
        echo $err_message;
    };
?></div>
<div class="container-md my-3">
    <form method="post" action="<?php echo base_url(); ?>rating/processUpdate">
        <input type="hidden" class="form-control" id="uname" name="uname" value="<?php echo $uname?>">
        <input type="hidden" class="form-control" id="product" name="product" value="<?php echo $product?>">
        <div class="form-group">
            <label for="overall">Overall(From 1 for bad to 5 for Excellent):</label>
            <input type="range" class="form-control" id="ov" name="ov" min="1" max="5" step="1" <?php if(isset($overall)){echo 'value="'.$overall.'"';}?>>
        </div>
        <br>
        <div class="form-group">
            <label for="ea">Easy to Use (From 1 for hard to use to 5 for easy to use):</label>
            <input type="range" class="form-control" id="ea" name="ea" min="1" max="5" step="1" <?php if(isset($easy)){echo 'value="'.$easy.'"';}?>>
        </div>
        <br>
        <div class="form-group">
            <label for="sme">Smells(From 1 for stinking smells to 5 for no smells):</label>
            <input type="range" class="form-control" id="sme" name="sme" min="1" max="5" step="1" <?php if(isset($smell)){echo 'value="'.$smell.'"';}?>>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

