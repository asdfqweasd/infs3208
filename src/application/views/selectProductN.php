<div class="container-md my-3">
<h2>Choose a product</h2>
<br>
</div>
<div class="container-md my-3">
    <form method="post" action="<?php echo base_url(); ?>product/add/">
        <div class="form-group" id="brand">
            <select class="form-control" id="brand" name="brand" hidden>
                <option value="<?php echo $brand;?>"><?php echo $bname;?></option>
            </select>
            <label for="sbrand">Choose the Brand of your product:</label>
            <select class="form-control" id="sbrand" name="sbrand" disabled>
                <option value="<?php echo $brand;?>"><?php echo $bname;?></option>
            </select>
        </div>
        <div class="form-group" id="name">
            <label for="sname">Choose the Name of your product:</label>
            <select class="form-control" id="sname" name="sname">
                <option id="phn">Please Choose a Name</option>
                <option value="other">Other Name</option>
                <?php
                    if(isset($names)){
                        foreach($names as $row){
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div class="form-group" id="otherName">
        </div>
        <div class="form-group" id="sub">
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){

        $("#sname").change(function(){
            var name = $(this).val();
            $("#phn").attr("disabled", true);
            $("#otherName").empty();
            $("#sub").empty();
            if(name == "other"){
                $("#otherName").append('<label for="pname">Product Name:</label>');
                $("#otherName").append('<input class="form-control" type="text" name="pname" required>');
                $("#otherName").append('<br>');
                $("#otherName").append('<label for="color">Color:</label>');
                $("#otherName").append('<input class="form-control" type="text" name="color" required>');
                $("#otherName").append('<br>');
                $("#otherName").append('<label for="des">Description of the Product:</label>');
                $("#otherName").append('<input class="form-control" type="text" name="des" required>');
                $("#otherName").append('<br>');
                $("#otherName").append('<label for="cat1">Category 1:</label>');
                $("#otherName").append('<select class="form-control" name="cat1"><?php
                    if(isset($cats)){
                        foreach($cats as $row){
                            echo "<option value=\'".$row->id."\'>".$row->category."</option>";
                        }
                    }
                ?>
               </select>');
                $("#otherName").append('<br>');
                $("#otherName").append('<label for="cat2">Category 2 (optional):</label>');
                $("#otherName").append('<select class="form-control" name="cat2"><option value="no">Not Applicable</option><?php
                    if(isset($cats)){
                        foreach($cats as $row){
                            echo "<option value=\'".$row->id."\'>".$row->category."</option>";
                        }
                    }
                ?>
               </select>');
                $("#otherName").append('<br>');
                $("#sub").append('<button type="submit" class="btn btn-primary">Continue to Review</button>');
            }else{
                $("#sub").append('<a class="btn btn-outline-primary" href="<?php echo base_url(); ?>product/productColor/'+<?php echo $brand;?>+'/'+name+'">Continue</button>');
            }
        })


    });
    
</script>