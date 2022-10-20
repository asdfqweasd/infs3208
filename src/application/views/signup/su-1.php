<div class="container-md my-3">
<h2>Sign Up - Step 1</h2>
<br>
</div>
<div style="color:red;"><?php 
    if($err_message != ""){
        echo $err_message;
    };
?></div>
<div class="container-md my-3">
    <form method="post" action="<?php echo base_url(); ?>signUp/validateInsert">
        <div class="form-group">
            <label for="uname">Username:</label>
            <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" required>
            <span id="uname_err" style="color:red;"></span>
        </div>
        <br>
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter Email Address" name="email" required>
            <span id="email_err" style="color:red;"></span>
        </div>
        <br>
        <div class="form-group">
            <label for="dob">Date of Birth(YYYY-MM-DD):</label>
            <input type="date" class="form-control" id="dob" name="dob">
        </div>
        <br>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control" id="gender" name="gender">
                <option value="F">Female</option>
                <option value="M">Male</option>
                <option value="N">Prefer not to tell</option>
            </select>
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
        <div class="form-group">
            <label for="sq1">Security Question 1:</label>
            <select class="form-control" id="sq1" name="sq1">
                <option value="1">In what city or town did your parent meet?</option>
                <option value="2">What is your grandmother's maiden name?</option>
                <option value="3">What are the first 5 digits of your first phone number?</option>
            </select>
            <input type="text" class="form-control" id="sq1a" placeholder="Enter Security Question 1 Answer" name="sq1a" required>
        </div>
        <br>
        <div class="form-group">
            <label for="sq2">Security Question 2:</label>
            <select class="form-control" id="sq2" name="sq2">
                <option value="4">What is your eldest cousin's first name?</option>
                <option value="5">What is the name of your favourite primary school teacher?</option>
                <option value="6">What is the model name of your first mobile phone?</option>
            </select>
            <input type="text" class="form-control" id="sq2a" placeholder="Enter Security Question 2 Answer" name="sq2a" required>
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
                        $("#uname_err").text("Username already exist, please try another one.");
                    }else{
                        if (uname.length >15){
                            $("#uname_err").text("The maximum length of a username is 15 digits.");
                        }else{
                            $("#uname_err").text("");
                        }
                    }
                }
            });
        });

        $("#email").keyup(function(){
            var email = $(this).val();
            var re = /\S+@\S+\.\S+/;
            $.ajax({
                url: "<?php echo base_url(); ?>ajax/email",
                method:"POST",
                data: {email:email},
                success: function(result){
                    if (result == '1'){
                        $("#email_err").text("Email address already exist, please try another one.");
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