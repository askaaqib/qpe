<?php if($this->session->flashdata('user_registered')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
<?php endif; ?>
<?php if (isset($message)) {
    echo '<p class="alert alert-info">'.$message.'</p>';
} elseif (isset($error)) {
    echo '<p class="alert alert-danger"><strong>Error: </strong>'.$error.'</p>';
}?>

<style>

</style>

<?php echo form_open('rating/evaluate_rating_mtl/'.$user_id.' '); ?>
<div class="row">
	<div class="col-md-12 text-center">
		<h2><?php echo $title; ?></h2>		
	</div>
</div>
<div class="user-info">
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_name" class="form-control col-form-label" >Name:</label>
		</div>
		<?php 
		 $evaluated_user_id =@$selected_factors_list[0]['mtl_name']; 
		?>
		
		<div class="col-md-10">
			<?php 
				if($mtl_edit_id ==0){
			?>
			<select class="form-control" name="user_name" id="user_name" required autofocus>
			    <option value="">Select User Name</option>
			    <?php foreach($mtl_all_members as $kk=>$vv){ ?>
			    <option <?php if($evaluated_user_id==$vv['User_id']){echo 'Selected="Selected"';}  ?>  value="<?php echo $vv['User_id']; ?>"><?php echo $vv['Firstname']." ".$vv['Lastname']; ?></option>
			    <?php } ?>
			</select>
			<?php }
			else { ?>
				<select class="form-control" name="user_name" id="user_name" >
			    <option  value="<?php echo @$selected_factors_list[0]['mtl_name']; ?>"><?php echo @$selected_factors_list[0]['Firstname'].' '.@$selected_factors_list[0]['Lastname'] ; ?></option>
				</select> 

			<?php
			} 
			?>

		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_designation" class="form-control col-form-label" >Designation:</label>
		</div>
		<div class="col-md-4">
			<select name="user_designation" id="user_designation" class="form-control" required>
					<option value="">Select Designation</option>
				<?php foreach ($all_designations as $key => $value): ?>
					<option value="<?php echo $value['designation_id']; ?>" <?php if(@$selected_factors_list[0]['mtl_designation'] ==$value['designation_id']){ echo 'selected';} ?>><?php echo $value['designation_name']; ?></option>
				<?php endforeach ?>
			</select>
			<!-- <input type="text" name="user_designation" class="form-control" placeholder="Enter Designation" value="<?php echo @$selected_factors_list[0]['mtl_designation']; ?>" required autofocus> -->
		</div>
		<div class="col-md-2">
			<label for="user_department" class="form-control col-form-label" >Department:</label>
		</div>
		<div class="col-md-4">
			<select name="user_department" id="user_department" class="form-control" required>
					<option value="">Select Department</option>
				<?php foreach ($all_departments as $key => $value): ?>
					<option value="<?php echo $value['dept_id']; ?>" <?php if(@$selected_factors_list[0]['mtl_department'] ==$value['dept_id']){ echo 'selected';} ?>><?php echo $value['dept_name']; ?></option>
				<?php endforeach ?>
			</select>
			<!-- <input type="text" name="user_department" class="form-control" placeholder="Enter Department" value="<?php echo @$selected_factors_list[0]['mtl_department']; ?>" required autofocus> -->
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_lead" class="form-control col-form-label" >Team Lead/Supervisor:</label>
		</div>
		<div class="col-md-4">
			 <select class="form-control" name="selectLeadType" id="selectLeadType">
			    <option value="TeamLead" <?php if(@$selected_factors_list[0]['mtl_lead_type'] === 'TeamLead'){echo 'selected';} ?>> Team Lead</option>
			    <option value="Supervisor" <?php if(@$selected_factors_list[0]['mtl_lead_type'] === 'Supervisor'){echo 'selected';} ?> >Supervisor</option>
			  	<option value="Manager" <?php if(@$selected_factors_list[0]['mtl_lead_type'] === 'Manager'){echo 'selected';} ?>> Manager</option>
			</select>
		</div>
		<div class="col-md-2">
			<label for="lead_name" id="leadNameLabel" class="form-control col-form-label" ><span><?php if(!empty($selected_factors_list[0]['mtl_lead_type'])){echo $selected_factors_list[0]['mtl_lead_type']. '</span> Name:';}else{ ?>Team Lead</span> Name:<?php } ?></label>
		</div>
		<div class="col-md-4">
			<input type="text" name="lead_name" class="form-control" placeholder="Enter Name" value="<?php echo @$selected_factors_list[0]['mtl_lead_name']; ?>" required autofocus>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_joining_date" class="form-control col-form-label" >Joining Date:</label>
		</div>
		<div class="col-md-4">
			<input type="text" name="user_joining_date" class="form-control datepicker" placeholder="Enter Joining Date" value="<?php if(!empty(@$selected_factors_list[0]['mtl_joining_date'])){echo date("Y-m-d",strtotime(@$selected_factors_list[0]['mtl_joining_date']));} ?>"  required autofocus>
		</div>
		<div class="col-md-2">
			<label for="evaluation_quarter" class="form-control col-form-label" >Quarter:</label>
		</div>
		<div class="col-md-4">
			<select class="form-control" name="evaluation_quarter" id="evaluation_quarter" required>
				<option value="">Select Quarter</option>
				<option value="Fall" <?php if(@$selected_factors_list[0]['mtl_quarter'] == 'Fall'){echo 'selected="selected"'; } ?>>Fall</option>
				<option value="Winter" <?php if(@$selected_factors_list[0]['mtl_quarter'] == 'Winter'){echo 'selected="selected"'; } ?>>Winter</option>
				<option value="Spring" <?php if(@$selected_factors_list[0]['mtl_quarter'] == 'Spring'){echo 'selected="selected"'; } ?>>Spring</option>	
			</select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_project" class="form-control col-form-label" >Module:</label>
		</div>
		<div class="col-md-4">
			<select name="user_project" id="user_project" class="form-control" required>
					<option value="">Select Project/Module</option>
				<?php foreach ($all_projects as $key => $value): ?>
					<option value="<?php echo $value['project_id']; ?>" <?php if(@$selected_factors_list[0]['mtl_project'] ==$value['project_id']){ echo 'selected';} ?>><?php echo $value['project_name']; ?></option>
				<?php endforeach ?>
			</select>			
		</div>
		<div class="col-md-2">
			<label for="evaluation_date" class="form-control col-form-label" >Date:</label>
		</div>
		<div class="col-md-4">
			<input type="text" name="evaluation_date" class="form-control datepicker" placeholder="Enter Date" value="<?php echo date('Y-m-d'); ?>" value="<?php echo @$selected_factors_list[0]['mtl_date']; ?>" required autofocus>
		</div>
	</div>

</div>
<table class="table table-bordered table-inverse factors-table">
	  <thead>
	    <tr>
	      <th>Sr.#</th>
	      <th colspan="7">Evaluation Factors</th>
	      <th>Remarks</th>	      
	    </tr>
	  </thead>
	  <tbody>
	      

	      
	      
	  	<?php $i=1; foreach ($selected_factors_list as $key => $value): ?>
	  		<?php @$mtl_rating_number = $value['mtl_rating_number'];  $active_class ='active'; ?>
	  		<tr>
	  			<td><?php echo $i; ?></td>
	  			
			
			<td colspan  ="7" >
	  		<div class="question-wrapper set1">
                <div class="statement">
                    <?php echo '<b>'.$value['mtl_cat_name'].' : </b>'.$value['mtl_eval_description']; ?>
                </div>
                <div class="row decision">
                    <div class="hidden-xs col-sm-3 caption left">Agree</div>
                    <div class="col-xs-12 col-sm-6 options btn-group" data-toggle="buttons" role="group" aria-label="Options">
                        <input type="hidden" name="mtl_rating_<?php echo $i; ?>" value="<?php echo @$value['mtl_rating_id'] ?>" autocomplete="off">
                        <label class="btn btn-default option agree max <?php if(@$mtl_rating_number== 3){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="3" <?php echo  set_radio('btn_radio_rating'.$i, '3', @$value['mtl_rating_number'] == '3' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option agree med <?php if(@$mtl_rating_number== 2){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="2" <?php echo  set_radio('btn_radio_rating'.$i, '2', @$value['mtl_rating_number'] == '2' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option agree min <?php if(@$mtl_rating_number== 1){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="1" <?php echo  set_radio('btn_radio_rating'.$i, '1', @$value['mtl_rating_number'] == '1' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option neutral <?php if(@$mtl_rating_number== 0){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="0" <?php echo  set_radio('btn_radio_rating'.$i, '0', @$value['mtl_rating_number'] == '0' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option disagree min <?php if(@$mtl_rating_number== -1){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="-1" <?php echo  set_radio('btn_radio_rating'.$i, '-1', @$value['mtl_rating_number'] == '-1' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option disagree med <?php if(@$mtl_rating_number== -2){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="-2" <?php echo  set_radio('btn_radio_rating'.$i, '-2', @$value['mtl_rating_number'] == '-2' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option disagree max <?php if(@$mtl_rating_number== -3){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="-3" <?php echo  set_radio('btn_radio_rating'.$i, '-3', @$value['mtl_rating_number'] == '-3' ); ?> autocomplete="off">
                        </label>
                    </div>
                    <div class="hidden-xs col-sm-3 caption right">Disagree</div>
                </div>
                <div class="row decision mobile visible-xs">
                    <div class="col-xs-6 caption left">Agree</div>
                    <div class="col-xs-6 caption right">Disagree</div>
                </div>
            </div>
			<input type="hidden" name="eval_fact_id<?php echo $i; ?>" value="<?php echo $value['mtl_eval_fact_id']; ?>">
	  		</td>
					

  			<td><textarea class="evaluate_remarks_text" name="remarks<?php echo $i; ?>" id="remarks<?php echo $i; ?>" cols="28" rows="5"><?php echo @$value['mtl_rating_remarks'] ?></textarea></td>
  			<input type="hidden" name="mtl_id" value="<?php echo @$value['mtl_id'] ?>">

	  		</tr>
	  	<?php $i++; endforeach ?>
	  </tbody>
	</table>
	<div class="form-group row evaluate-recommendations">
		<div class="col-md-12 text-center">
			<label for="recommendations" class="form-control col-form-label" >Recommendations:</label>
			<textarea class="form-control" name="evaluate_recommendation" id="evaluate_recommendation" cols="30" rows="10" required autofocus><?php echo @$selected_factors_list[0]['mtl_recommendations']; ?></textarea>
		</div>
	</div>
<div class="overall-rating">
	<label class="custom-control custom-radio" >
	  	<input id="radio1" name="overall_rating" type="radio" value="(05-06)" class="custom-control-input" <?php echo  set_radio('overall_rating', '(05-06)', @$value['mtl_overall_rating'] == '(05-06)' ); ?> required>
	  	<span class="custom-control-indicator">Superb</span><span class="number">(05-06)</span>
	  	<span class="custom-control-description">Employee is working superb and extraordinary expectations</span>
	</label>
	<label class="custom-control custom-radio">
	  	<input id="radio1" name="overall_rating" type="radio" value="(04-05)" class="custom-control-input" <?php echo  set_radio('overall_rating', '(04-05)', @$value['mtl_overall_rating'] == '(04-05)' ); ?> >
	  	<span class="custom-control-indicator">Great</span><span class="number">(04-05)</span>
	  	<span class="custom-control-description">Employee is working great and above the expectations</span>
	</label>
	<label class="custom-control custom-radio">
	  	<input id="radio1" name="overall_rating" type="radio" value="(03-04)" class="custom-control-input" <?php echo  set_radio('btn_radio_rating', '(03-04)', @$value['mtl_overall_rating'] == '(03-04)' ); ?>>
	  	<span class="custom-control-indicator">Good</span><span class="number">(03-04)</span>
	  	<span class="custom-control-description">Employee is working good and meeting the expectations</span>
	</label>
	<label class="custom-control custom-radio">
	  	<input id="radio1" name="overall_rating" type="radio" value="(02-03)" class="custom-control-input" <?php echo  set_radio('btn_radio_rating', '(02-03)', @$value['mtl_overall_rating'] == '(02-03)' ); ?>>
	  	<span class="custom-control-indicator">Need Improvement</span><span class="number">(02-03)</span>
	  	<span class="custom-control-description">Employee is working below the expecations and needs little improvement</span>
	</label>
	<label class="custom-control custom-radio">
	  	<input id="radio1" name="overall_rating" type="radio" value="(01-02)" class="custom-control-input" <?php echo  set_radio('btn_radio_rating', '(01-02)', @$value['mtl_overall_rating'] == '(01-02)' ); ?>>
	  	<span class="custom-control-indicator">Failing</span><span class="number">(01-02)</span>
	  	<span class="custom-control-description">Employee is working below the expecations and needs strong improvement</span>
	</label>
</div>	
	<button type="submit" style="float:right;" class="btn btn-primary">Evaluate</button>
<?php echo form_close(); ?>	