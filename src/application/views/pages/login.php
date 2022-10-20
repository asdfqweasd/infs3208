
<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'pages/check_login');?>
			
				<h2 class="text-center">Login</h2>
				<h4> If you don't have an account,Please REGISTER ONE </h4>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Email" required="required" name="user_email">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password">
					</div>
					<div class="form-group">
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Log in</button>
					</div>
					<div class="clearfix">
						<label class="float-left form-check-label"><input type="checkbox" name = "remember"> Remember me</label>
						<a href="forgot_pass" class="float-right">Forgot Password?</a>
					</div>    
			<?php echo form_close(); ?>
	</div>
</div>