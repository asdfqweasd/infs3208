<!DOCTYPE html>
<html>
<head>
<title>Login Form</title>
<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>

</head>
    <body>

    <div id="main">
    <div id="login">
    <?php echo @$error; ?>
    <h2>Forgot Password</h2>
    <br>
    <?= form_open(base_url().'Pages/get_pass')?>

        <div class="form-group">
            <label>Enter Your Email Address</label>
            <input type="text" name="user_email" class="form-control" value="<?=$this->session->userdata("Email") ?>"/>
            <span class="text-danger"> <?php echo form_error('user_email');?> </span>
        </div>

        <div class="form-group">
            <label>Varify your security question</label>
            <input type="text" name="security_question" class="form-control" value="<?= $this->session->userdata("security_question")?>"/>
            <span class="text-danger"> <?php echo form_error('security_question');?> </span>
        </div>
        <div class="form-group">
            <label>Varify your security answer</label>
            <input type="text" name="security_answer" class="form-control" value="<?= $this->session->userdata("security_answer") ?>"/>
            <span class="text-danger"> <?php echo form_error('security_answer');?> </span>
        </div>
        <br>
        <br>
        <input type="submit" value="Check your password" name="forgot_pass"/><br />
        <?php echo form_close(); ?>
    </div>
    </div>
</body>
</html>