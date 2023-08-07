<div class="container" id="main">
      <div class="col-6 offset-3">
		<h2> Reset Password </h2>
			<?php echo form_open(base_url().'forgot/verify/'.$code); ?>
					<div class="form-group">
						<label for="password">New Password:</label>
						<input id="password" type="password" class="form-control" placeholder="New Password" required="required" name="password">
					</div>
                    <div class="form-group">
						<label for="passconf">Confirm New Password:</label>
						<input id="passconf" type="password" class="form-control" placeholder="Confirm" required="required" name="passconf">
					</div>
					<div class="form-group">
					</div>
					<div class="form-group">
						<!-- Error Handling-->
						<?php if(validation_list_errors()!=null) {?>
							<div class='alert alert-danger mt-2'>
								<?= validation_list_errors()?>
            				</div>
						<?php }?>
						<button type="submit" class="btn btn-primary btn-block">Change Password</button>
						
					</div>  
			<?php echo form_close(); ?>
	</div>
</div>

