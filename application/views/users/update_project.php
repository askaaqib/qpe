<h3><?php echo $title; ?></h3>
<?php echo form_open('users/update_project'.'/'.@$get_project['project_id']); ?>
<div class="form-group row">
		<div class="col-md-3">
			<label for="project_name" class="form-control col-form-label" >Project Name:</label>
		</div>
		<div class="col-md-3">
			<input type="text" name="project_name" class="form-control" placeholder="Enter Project Name" value="<?php echo @$get_project['project_name']; ?>" required autofocus>
		</div>
</div>
<div class="form-group row">
		<div class="col-md-3">
			<label for="project_module" class="form-control col-form-label" >Is Module?</label>
		</div>
		<div class="col-md-3">
			<select class="form-control" name="project_is_module" id="project_is_module" required autofocus>
			    <option value="">Please Select</option>
			    <option <?php if(@$get_project['project_is_module']=='Y'){echo 'selected="selected"';} ?> value="Y">Y</option>
			    <option <?php if(@$get_project['project_is_module']=='N'){echo 'selected="selected"'; } ?> value="N">N</option>
			</select>
		</div>
</div>	
<div class="form-group row">
		<div class="col-md-3">
			<label for="project_module" class="form-control col-form-label" >Status:</label>
		</div>
		<div class="col-md-3">
			<select class="form-control" name="project_status" id="project_status" required autofocus >
			    <option value="">Please Select</option>
				<option <?php if(@$get_project['project_status']=='Y'){echo 'selected="selected"'; } ?> value="Y">Y</option>
			    <option <?php if(@$get_project['project_status']=='N'){echo 'selected="selected"'; } ?> value="N">N</option>
			</select>			
		</div>
</div>
<input type="hidden" name="project_added_by" value="<?php echo $this->session->userdata('user_id'); ?>" >
<button type="submit" class="btn btn-primary"><?php if(empty($get_project)){ echo 'Add';}else{echo 'Update';} ?></button>	
<?php echo form_close(); ?>