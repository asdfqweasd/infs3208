<div class="container-md my-3">
<h2>Update User Profile</h2>
<br>
</div>
<div style="color:red;"><?php 
    if($err_message != ""){
        echo $err_message;
    };
?></div>
<div class="container-md my-3">
    <form method="post" action="<?php echo base_url(); ?>profile/validateUpdate">
        <div class="form-group">
            <label for="uname">Username:</label>
            <input type="text" class="form-control" id="uname" name="uname" value="<?php echo $uname;?>"disabled>
        </div>
        <br>
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter Email Address" name="email" value="<?php echo $email;?>"required>
            <span id="email_err" style="color:red;"></span>
        </div>
        <br>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob;?>">
        </div>
        <br>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control" id="gender" name="gender">
                <option value="F" <?php if($gender =='F'){echo "selected";};?>>Female</option>
                <option value="M" <?php if($gender =='M'){echo "selected";};?>>Male</option>
                <option value="N" <?php if($gender =='N'){echo "selected";};?>>Prefer not to tell</option>
            </select>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function(){

        $("#email").keyup(function(){
            var email = $(this).val();
            var re = /\S+@\S+\.\S+/;
            $.ajax({
                url: "<?php echo base_url(); ?>ajax/email",
                method:"POST",
                data: {email:email},
                success: function(result){
                    if (result == '1'){
                        $("#email_err").text("Email address already exist, ignore if this is your original email");
                    }else{
                        if (!re.test(email)){
                            $("#email_err").text("This is not a valid email address.");

                        }else{
                            $("#email_err").text("");

                        }
                    }
                }
            });
        })


    });
</script>