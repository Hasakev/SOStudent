<div class="container" id="main">
      <div class="col-6 offset-3">
        <h2> Change Name </h2>
			<?php echo form_open(base_url() . 'changename'); ?>
                    <div class="form-group">
						<label for="firstname">First Name:</label>
						<input id="firstname" type="text" class="form-control" placeholder="First Name" required="required" name="firstname">
					</div>
					<div class="form-group">
						<label for="lastname">Last Name:</label>
						<input id="lastname" type="text" class="form-control" placeholder="Last Name" required="required" name="lastname">
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
						<button type="submit" class="btn btn-primary btn-block">Change Name</button>
						<label for="log"> I changed my mind. </label>
						<a href="<?php base_url()?>profile" id="log"> Go back.</a>
						
					</div>  
			<?php echo form_close(); ?>
	</div>
</div>

