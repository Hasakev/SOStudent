<div class="container" id="main">
      <div class="col-6 offset-3">
		<h2> Change Password </h2>
			<?php echo form_open(base_url() . 'changepass'); ?>
                    <div class="form-group">
						<label for="oldpassword">Old Password:</label>
						<input id="oldpassword" type="password" class="form-control" placeholder="Old Password" required="required" name="oldpassword">
					</div>
					<div class="form-group">
						<label for="password">New Password:</label>
						<input id="password" type="password" class="form-control" placeholder="New Password" required="required" name="password">
					</div>
                    <div class="form-group">
						<label for="passwordconf">Confirm New Password:</label>
						<input id="passwordconf" type="password" class="form-control" placeholder="Confirm" required="required" name="passwordconf">
					</div>
					<div class="form-group">
						<?php echo $error; ?>
					</div>
					<div class="form-group">
						<!-- Error Handling-->
						<?php if(validation_list_errors()!=null) {?>
							<div class='alert alert-danger mt-2'>
								<?= validation_list_errors()?>
            				</div>
						<?php }?>
						<button type="submit" class="btn btn-primary btn-block">Change Password</button>
						<label for="log"> I changed my mind. </label>
						<a href="<?php base_url()?>profile" id="log"> Go back.</a>
						
					</div>  
			<?php echo form_close(); ?>
	</div>
</div>

