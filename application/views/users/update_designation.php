<h3><?php echo $title; ?></h3>
<?php echo form_open('users/update_designation'.'/'.@$get_designation['designation_id']); ?>
<div class="form-group row">
		<div class="col-md-3">
			<label for="designation_name" class="form-control col-form-label" >Designation Name:</label>
		</div>
		<div class="col-md-3">
			<input type="text" name="designation_name" class="form-control" placeholder="Enter Designation Name" value="<?php echo @$get_designation['designation_name']; ?>" required autofocus>
		</div>
</div>

<div class="form-group row">
		<div class="col-md-3">
			<label for="designation_module" class="form-control col-form-label" >Status:</label>
		</div>
		<div class="col-md-3">
			<select class="form-control" name="designation_status" id="designation_status" required autofocus >
			    <option value="">Please Select</option>
				<option <?php if(@$get_designation['designation_status']=='Y'){echo 'selected="selected"'; } ?> value="Y">Y</option>
			    <option <?php if(@$get_designation['designation_status']=='N'){echo 'selected="selected"'; } ?> value="N">N</option>
			</select>			
		</div>
</div>
<input type="hidden" name="designation_added_by" value="<?php echo $this->session->userdata('user_id'); ?>" >
<button type="submit" class="btn btn-primary"><?php if(empty($get_designation)){ echo 'Add';}else{echo 'Update';} ?></button>	
<?php echo form_close(); ?>