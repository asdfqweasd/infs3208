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
            <select class="form-control" id="name" name="name" hidden>
                <option value="<?php echo $name->id;?>"><?php echo $name->name;?></option>
            </select>
            <label for="sname">Choose the Name of your product:</label>
            <select class="form-control" id="sname" name="sname" disabled>
                <option value="<?php echo $name->id;?>"><?php echo $name->name;?></option>
            </select>
        </div>
        <div class="form-group" id="Color">
            <label for="scolor">Choose the Color of your product:</label>
            <select class="form-control" id="scolor" name="scolor">
                <option id="phc">Please Choose a Color</option>
                <option value="other">Other Color</option>
                <?php
                    if(isset($colors)){
                        foreach($colors as $row){
                            echo "<option value='".$row->id."'>".$row->color."</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div class="form-group" id="otherColor">
        </div>
        <div class="form-group" id="sub">
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){

        $("#scolor").change(function(){
            var color = $(this).val();
            $("#phc").attr("disabled", true);
            $("#otherColor").empty();
            $("#sub").empty();
            if(color == "other"){
                $("#otherColor").append('<label for="color">Color:</label>');
                $("#otherColor").append('<input class="form-control" type="text" name="color" required>');
                $("#otherColor").append('<br>');
                $("#sub").append('<button type="submit" class="btn btn-outline-primary">Continue</button>');
            }else{
                $("#sub").append('<a class="btn btn-primary" href="<?php echo base_url(); ?>review/displayReviewForm/'+color+'">Continue to Review</button>');
            }
        })


    });
    
</script>