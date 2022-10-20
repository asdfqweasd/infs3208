<div class="container-md my-3">
<h2>Reset Password</h2>
<br>
</div>
<div class="container-md my-3" style="color:red;"><?php 
    if($err_message != ""){
        echo $err_message;
    };
?></div>
<div class="container-md my-3">
    <form method="post" action="<?php echo base_url(); ?>login/verifyInsertNewPassword/<?php echo $uname;?>/">
        <div class="form-group">
            <label for="uname">Username:</label>
            <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" value="<?php echo $uname;?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label for="vcode">Verification Code:</label>
            <input type="text" class="form-control" id="vcode" placeholder="Enter Verification Code" name="vcode" required>
        </div>
        <br>
        <div class="form-group">
            <label for="sq1">Security Question 1:</label>
            <select class="form-control" id="sq1" name="sq1" disabled>
                <option value="1" <?php if($sq1 == 1){echo "selected";};?>>In what city or town did your parent meet?</option>
                <option value="2" <?php if($sq1 == 2){echo "selected";};?>>What is your grandmother's maiden name?</option>
                <option value="3" <?php if($sq1 == 3){echo "selected";};?>>What are the first 5 digits of your first phone number?</option>
            </select>
            <input type="text" class="form-control" id="sq1a" placeholder="Enter Security Question 1 Answer" name="sq1a" required>
        </div>
        <br>
        <div class="form-group">
            <label for="sq2">Security Question 2:</label>
            <select class="form-control" id="sq2" name="sq2" disabled>
                <option value="4" <?php if($sq2 == 4){echo "selected";};?>>What is your eldest cousin's first name?</option>
                <option value="5" <?php if($sq2 == 5){echo "selected";};?>>What is the name of your favourite primary school teacher?</option>
                <option value="6" <?php if($sq2 == 6){echo "selected";};?>>What is the model name of your first mobile phone?</option>
            </select>
            <input type="text" class="form-control" id="sq2a" placeholder="Enter Security Question 2 Answer" name="sq2a" required>
        </div>
        <br>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
            <span id="pwd_err" style="color:red;"></span>
        </div>
        <br>
        <div class="form-group">
            <label for="pwd2">Password:</label>
            <input type="password" class="form-control" id="pwd2" placeholder="Re-enter password" name="pwd2" required>
            <span id="pwd2_err" style="color:red;"></span>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function(){

        function validatePassword(pw){
            var check=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,25}$/;
            if(pw.match(check)){
                return true;
            }else{
                return false;
            }
        }

        $("#pwd").keyup(function(){
            var pwd = $(this).val();
            var validate1 = validatePassword(pwd);
            if (validate1 == true){
                $("#pwd_err").text("");

            }else{
                $("#pwd_err").text("A password must have 8-25 digits and contains at least 1 Capital letter, 1 lowercase letter, 1 number and 1 special character.");

            }
        })

        $("#pwd2").keyup(function(){
            var pwd = $("#pwd").val();
            var pwd2 = $(this).val();
            var validate1 = validatePassword(pwd);
            if (validate1 == true){
                if(pwd==pwd2){
                    $("#pwd2_err").text("");

                }else{
                    $("#pwd2_err").text("This does not match the password you entered");

                }
            }else{
                $("#pwd2_err").text("A password must have 8-25 digits and contains at least 1 Capital letter, 1 lowercase letter, 1 number and 1 special character.");

            }
        })


    });
</script>