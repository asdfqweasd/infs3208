<div class="container-md my-3">
<h2>Forget Password</h2>
<br>
</div>
<div class="container-md my-3">
    <form method="post" action="<?php echo base_url(); ?>login/forgotPasswordEmail">
        <div class="form-group">
            <label for="uname">Username:</label>
            <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" required>
            <span id="uname_err" style="color:red;"></span>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function(){


        $("#uname").keyup(function(){ //check username unique
            var uname = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>ajax/uname",
                method:"POST",
                data: {uname:uname},
                success: function(result){
                    if (result == '1'){
                        $("#uname_err").text("");
                    }else{
                        $("#uname_err").text("Username does not exitst!");
                        
                    }
                }
            });
        });

    });
</script>