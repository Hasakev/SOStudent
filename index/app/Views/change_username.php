<div class="container" id="main">
      <div class="col-6 offset-3">
        <h2> Change Username </h2>
			<?php echo form_open(base_url() . 'changeusername'); ?>
                    <div class="form-group">
						<label for="username">Username:</label>
						<input id="username" type="text" class="form-control" placeholder="Username" required="required" name="username">
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
						<button type="submit" class="btn btn-primary btn-block">Change Username</button>
						<label for="log"> I changed my mind. </label>
						<a href="<?php base_url()?>profile" id="log"> Go back.</a>
						
					</div>  
			<?php echo form_close(); ?>
	</div>
</div>

