<h3><?php echo $title; ?></h3>
<?php echo form_open('users/update_department'.'/'.@$get_department['dept_id']); ?>
<div class="form-group row">
		<div class="col-md-3">
			<label for="department_name" class="form-control col-form-label" >Department:</label>
		</div>
		<div class="col-md-3">
			<input type="text" name="department_name" class="form-control" placeholder="Enter Department" value="<?php echo @$get_department['dept_name'] ?>" required autofocus>
		</div>
	<button type="submit" class="btn btn-primary"><?php if(empty($get_department)){ echo 'Add';}else{echo 'Update';} ?></button>

	</div>
<?php echo form_close(); ?>