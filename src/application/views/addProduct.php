<div class="container-md my-3">
<h2>Choose a product</h2>
<br>
</div>
<div class="container-md my-3">
    <form method="post" action="<?php echo base_url(); ?>product/add/">
        <div class="form-group" id="brand">
            <label for="sbrand">Choose the Brand of your product:</label>
            <select class="form-control" id="sbrand" name="sbrand">
                <option id="phb">Please Choose a Brand</option>
                <option value="other">Other brand</option>
                <?php
                    if(isset($brands)){
                        foreach($brands as $row){
                            echo "<option value='".$row->id."'>".$row->b_name."</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div class="form-group" id="otherBrand">
        </div>
        <div class="form-group" id="sub">
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){

        $("#sbrand").change(function(){
            var brand = $(this).val();
            $("#phb").attr("disabled", true);
            $("#otherBrand").empty();
            $("#sub").empty();
            if(brand == "other"){
                $("#otherBrand").append('<label for="bname">Brand Name:</label>');
                $("#otherBrand").append('<input class="form-control" type="text" name="bname" required>');
                $("#otherBrand").append('<br>');
                $("#otherBrand").append('<label for="pname">Product Name:</label>');
                $("#otherBrand").append('<input class="form-control" type="text" name="pname" required>');
                $("#otherBrand").append('<br>');
                $("#otherBrand").append('<label for="color">Color:</label>');
                $("#otherBrand").append('<input class="form-control" type="text" name="color" required>');
                $("#otherBrand").append('<br>');
                $("#otherBrand").append('<label for="des">Description of the Product:</label>');
                $("#otherBrand").append('<textarea class="form-control" name="des" required></textarea>');
                $("#otherBrand").append('<br>');
                $("#otherBrand").append('<label for="cat1">Category 1:</label>');
                $("#otherBrand").append('<select class="form-control" name="cat1"><?php
                    if(isset($cats)){
                        foreach($cats as $row){
                            echo "<option value=\'".$row->id."\'>".$row->category."</option>";
                        }
                    }
                ?>
               </select>');
                $("#otherBrand").append('<br>');
                $("#otherBrand").append('<label for="cat2">Category 2 (optional):</label>');
                $("#otherBrand").append('<select class="form-control" name="cat2"><option value="no">Not Applicable</option><?php
                    if(isset($cats)){
                        foreach($cats as $row){
                            echo "<option value=\'".$row->id."\'>".$row->category."</option>";
                        }
                    }
                ?>
               </select>');
                $("#otherBrand").append('<br>');
                $("#sub").append('<button type="submit" class="btn btn-outline-secondary">Continue</button>');
            }else{
                $("#sub").append('<a class="btn btn-outline-primary" href="<?php echo base_url(); ?>product/productName/'+brand+'">Continue</button>');
            }
        })


    });
    
</script>