<div class="container">
      <div class="col-6 offset-3">
			<?php echo form_open(base_url() . 'signup'); ?>
				<h2 class="text-center">Create an Account</h2>
                    <div class="form-group">
						<label for="firstname">First Name:</label>
						<input id="firstname" type="text" class="form-control" placeholder="First Name" required="required" name="firstname" value="<?=set_value('firstname')?>">
					</div>
                    <div class="form-group">
						<label for="lastname">Last Name:</label>
						<input id="lastname" type="text" class="form-control" placeholder="Last Name" required="required" name="lastname" value="<?=set_value('lastname')?>">
					</div> 
					<div class="form-group">
						<label for="username">Username:</label>
						<input id="username" type="text" class="form-control" placeholder="Username" required="required" name="username" value="<?=set_value('username')?>">
					</div>
					<div class="form-group">
						
						<label for="Email">Email:</label>
						<input id="email" type="email" class="form-control" placeholder="Email" required="required" name="email" value="<?=set_value('email')?>">
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input id="password" type="password" class="form-control" placeholder="Password" required="required" name="password">
					</div>
                    <div class="form-group">
						<label for="passconf">Confirm Password:</label>
						<input id="passconf" type="password" class="form-control" placeholder="Confirm" required="required" name="passconf">
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
						<button type="submit" class="btn btn-primary btn-block">Register</button>
						<label for="log"> Already have an account? </label>
						<a href="<?php base_url()?>login" id="log"> Log in</a>
						
					</div>  
			<?php echo form_close(); ?>
	</div>
</div>

