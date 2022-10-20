<!DOCTYPE html>
<html>
<head>
    <script src="https://www.google.com/recaptcha/enterprise.js?render= 6LcVs_sfAAAAACbXpfrw_xM-MhPLj6DNp1gxUc-3 "></script>
    ....
</head>
  
<body>
    <div class="container">
        <br>
        <h3>Register System</h3>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">Create a new account</div>
            <div class="panel-body">
                <?php
                if($this->session->flashdata('message'))
                {
                    echo'
                    <div class = "alert alert-success“>
                    '.$this->session->flashdata("message").'
                    </div>
                    ';
                }
                ?>
                 <form method="post" action="<?php echo base_url(); ?>register/validation">
                     <div class="form-group">
                         <label>Enter Your name</label>
                         <input type="text" name="user_name" class="form-control" value="<?php echo set_value('user_name'); ?>"/>
                         <span class="text-danger"> <?php echo form_error('user_name');?> </span>
                     </div>

                     <div class="form-group">
                        <label>Enter Your Email Address</label>
                        <input type="text" name="user_email" class="form-control" value="<?php echo set_value('user_email'); ?>"/>
                        <span class="text-danger"> <?php echo form_error('user_email');?> </span>
                    </div>
                     
                    <div class="form-group">
                        <label>Enter Your Password</label>
                        <input type="text" name="user_password" class="form-control" value="<?php echo set_value('user_password'); ?>"/>
                        <span class="text-danger"> <?php echo form_error('user_password');?> </span>
                    </div>
                    <div class="form-group">
                        <label>Set your security question</label>
                        <input type="text" name="security_question" class="form-control" />
                        <span class="text-danger"> <?php echo form_error('security_question');?> </span>
                    </div>
                    <div class="form-group">
                        <label>Set your security answer</label>
                        <input type="text" name="security_answer" class="form-control" />
                        <span class="text-danger"> <?php echo form_error('security_answer');?> </span>
                    </div>
                    <div class = "g-recaptcha" data-sitekey="6LcVs_sfAAAAACbXpfrw_xM-MhPLj6DNp1gxUc-3"></div>
                    <div class="form-group">
                        <input type="submit" name="register" value="Register" class="btn btn-primary"/>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</body>


</html>