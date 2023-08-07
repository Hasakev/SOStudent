<div class="container">
      <div class="col-6 offset-3">
			<?php echo form_open(base_url() . 'postquestion'); ?>
				<h2 class="text-center">New Question</h2>
                    <div class="form-group">
						<label for="subject">Subject:</label>
						<input id="subject" type="text" class="form-control" placeholder="Subject" required="required" name="subject" value="<?=set_value('subject')?>">
					</div>
                    <div class="form-group">
						<label for="question">Question:</label>
						<input id="question" type="text" class="form-control" placeholder="Question" required="required" name="question" value="<?=set_value('question')?>">
					</div> 
					<div class="form-group">
						<label for="content">Content:</label>
						<input id="content" type="text" class="form-control input-group-lg" placeholder="Content" required="required" name="content" value="<?=set_value('content')?>" maxlength="10000">
					</div>
					<div class="form-group">
						<!-- Error Handling-->
						<?php if(validation_list_errors()!=null) {?>
							<div class='alert alert-danger mt-2'>
								<?= validation_list_errors()?>
            				</div>
						<?php }?>
						<button type="submit" class="btn btn-primary btn-block">Post</button>
						<label for="log"> Never mind, I don't have a new question. </label>
						<a href="<?php base_url()?>login" id="log"> Go back</a>
						
					</div>  
			<?php echo form_close(); ?>
	</div>
</div>

