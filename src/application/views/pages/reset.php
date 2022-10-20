
<h3>Password Reset</h3>

<div class="col-lg-4">
	<?php if($error = $this->session->flashdata('success_msg')): ?>
		<div class="alter alter-success" role="alert">
			<?= $error ?>
		</div>
	<?php endif; ?>
		<?php if($error = $this->session->flashdata('error_msg')): ?>
		<div class="alter alter-danger" role="alert">
			<?= $error ?>
		</div>
	<?php endif; ?>
</div>
<form class="login-form" method="post" action="<?php echo base_url(); ?>Pages/resetPassword">
		<h2 class="form-title">New password</h2>
		<!-- form validation messages -->
		
		<div class="form-group">
			<label>New password</label>
			<input type="text" name="new_pass">
            <span class="text-danger"> <?php echo form_error('user_password');?> </span>
		</div>
		<!-- <div class="form-group">
			<label>New password</label>
			<input type="text" name="user_password" class="form-control"/>
			<span class="text-danger"> <?php echo form_error('user_password');?> </span>
		</div> -->
		<!-- <div class="form-group">
			<label>Confirm new password</label>
			<input type="password" name="new_pass_c">
		</div> -->
		<div class="form-group">
			<button type="submit"  class="login-btn">Reset</button>
            
		</div>
</form>

