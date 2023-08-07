<div class="container">
      <div class="col-6 offset-3">
			<?php echo form_open(base_url() . 'addcomment'); ?>
				<h2 class="text-center">New Comment</h2>
					<div class="form-group">
						<label for="comment">Comment:</label>
						<input id="comment" type="text" class="form-control input-group-lg" placeholder="Comment" required="required" name="comment" value="<?=set_value('comment')?>" maxlength="10000">
					</div>
					<div class="form-group">
						<!-- Error Handling-->
						<?php if(validation_list_errors()!=null) {?>
							<div class='alert alert-danger mt-2'>
								<?= validation_list_errors()?>
            				</div>
						<?php }?>
						<button type="submit" class="btn btn-primary btn-block">Post</button>
						<label for="log"> Never mind, I don't have a new comment. </label>
						<a href="<?php echo base_url()?>question/<?php echo session()->get("id")?>" id="log"> Go back</a>
						
					</div>  
			<?php echo form_close(); ?>
	</div>
</div>

