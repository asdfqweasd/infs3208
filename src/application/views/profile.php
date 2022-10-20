<div class="container-md my-3">
<h2>User Profile</h2>
<br>
</div>
<div class="container-md my-3">
    <p>Username: <?php echo $uname; ?></p>
    <br>
    <p>Email: <?php echo $email; if($verify == 0){echo ' (Not verified)  <a href="'.base_url().'signUp/sendVerificationEmail/'.$email.'/" class="btn btn-outline-secondary">Send verification email</a>';}else{echo ' (verified)';}?></p>
    <br>
    <p>Gender: <?php echo $gender; ?></p>
    <br>
    <p>Date of Birth: <?php echo $dob; ?></p>
    <br>
    <p>Date Registered: <?php echo $dateReg; ?></p>
    <br>
    <!--
    <p>Natural hair colour: <?php //echo $color; ?></p>
    <br>
    <p>Percentage of grey hair: <?php //echo $greyHair; ?></p>
    <br>
    <p>Hair Thickness: <?php //echo $thick; ?></p>
    <br>
    <p>Sensitive scalp? <?php //echo $scalp; ?></p>
    <br>
    -->
    <a class="btn btn-primary" href="<?php echo base_url(); ?>profile/update" role="button">Update Profile</a>
</div>

<script>
    $(document).ready(function(){
        <?php if($useVerifiedFunction){echo "alert('Please verify your email to enable all functionalities');";}?>
    });
</script>