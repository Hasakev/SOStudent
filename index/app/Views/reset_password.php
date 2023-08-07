<div class="container" id="main">
	<div class="col-4 offset-4">
		<?php echo form_open(base_url() . 'forgotpass'); ?>
		<h2 class="text-center">Reset your password</h2>
		<p> We will send a link to your email to reset your password. </p>
		<div class="form-group">
			<input type="email" class="form-control" placeholder="Enter your email" required="required" name="email">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Send Reset Email</button>
		</div>
		<div class="form-group">
			<?php echo $error; ?>
			<?php echo $message; ?>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>