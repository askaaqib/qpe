<h2><?php echo $title; ?></h2>
<div class="user-info">
	<div class="form-group row">
		<div class="col-md-3">
			<label for="user_name" class="form-control col-form-label" >Name:</label>
		</div>
		<div class="col-md-9">
			<div class="form-control">
				<?php echo $evaluate_list_detail[0]['Firstname'].' '.$evaluate_list_detail[0]['Lastname'] ?>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-3">
			<label for="user_designation" class="form-control col-form-label" >Designation:</label>
		</div>
		<div class="col-md-3">
			<div class="form-control">
				<?php echo $evaluate_list_detail[0]['designation_name'] ?>
			</div>
		</div>
		<div class="col-md-3">
			<label for="user_department" class="form-control col-form-label" >Department:</label>
		</div>
		<div class="col-md-3">
			<div class="form-control">
				<?php echo $evaluate_list_detail[0]['dept_name'] ?>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-3">
			<label for="user_lead" class="form-control col-form-label" >Team Lead/Supervisor:</label>
		</div>
		<div class="col-md-3">
			 <div class="form-control">
			 	<?php echo $evaluate_list_detail[0]['tlm_lead_type'] ?>
			 </div>
		</div>
		<div class="col-md-3">
			<label for="lead_name" id="leadNameLabel" class="form-control col-form-label" ><span><?php echo $evaluate_list_detail[0]['tlm_lead_type'] ?></span> Name:</label>
		</div>
		<div class="col-md-3">
			<div class="form-control">
				<?php echo $evaluate_list_detail[0]['tlm_lead_name'] ?>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-3">
			<label for="user_joining_date" class="form-control col-form-label" >Joining Date:</label>
		</div>
		<div class="col-md-3">
			<div class="form-control">
				<?php echo date("Y-m-d",strtotime($evaluate_list_detail[0]['tlm_joining_date'])); ?>
			</div>
		</div>
		<div class="col-md-3">
			<label for="evaluation_quarter" class="form-control col-form-label" >Quarter:</label>
		</div>
		<div class="col-md-3">
			<div class="form-control">
				<?php echo $evaluate_list_detail[0]['tlm_quarter'] ?>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-3">
			<label for="user_project" class="form-control col-form-label" >Module:</label>
		</div>
		<div class="col-md-3">
			<div class="form-control">
				<?php echo $evaluate_list_detail[0]['project_name'] ?>
			</div>
		</div>
		<div class="col-md-3">
			<label for="evaluation_date" class="form-control col-form-label" >Date:</label>
		</div>
		<div class="col-md-3">
			<div class="form-control">
				<?php echo date("Y-m-d",strtotime($evaluate_list_detail[0]['tlm_date'])); ?>
			</div>
		</div>
	</div>

</div>
<table class="table table-bordered table-inverse factors-table">
	  <thead>
	    <tr>
	      <th>Sr.#</th>
	      <th colspan="7">Evaluation Factors</th>>
	      <th>Remarks</th>	      
	    </tr>
	  </thead>
	  <tbody>
	  	<?php $i=1; foreach ($evaluate_list_detail as $key => $value): ?>
	  		<tr>
	  			<?php @$tlm_rating_number = $value['tlm_rating_number'];  $active_class ='active'; ?>
	  			<td><?php echo $i; ?></td>
	  			<td colspan="7" >
	  		<div class="question-wrapper set1">
                <div class="statement">
                    <?php echo '<b>'.$value['tlm_cat_name'].' : </b>'.$value['tlm_eval_description']; ?>
                </div>
                <script>
                	document.getElementsByClassName("btn_radio_rating1").disabled = true;
                </script>
                <div class="row decision">
                    <div class="hidden-xs col-sm-3 caption left">Agree</div>
                    <div class="col-xs-12 col-sm-6 options btn-group" data-toggle="buttons" role="group" aria-label="Options">
                        <label class="btn btn-default option agree max <?php if(@$tlm_rating_number== 3){echo $active_class;} ?>" >
                        	<input type="radio" class="btn_radio_rating<?php echo $i; ?>" name="btn_radio_rating<?php echo $i; ?>" value="3" <?php echo  set_radio('btn_radio_rating'.$i, '3', $value['tlm_rating_number'] == '3'); ?> disabled />
                        </label>
                        <label class="btn btn-default option agree med <?php if(@$tlm_rating_number== 2){echo $active_class;} ?>" >
                            <input type="radio" class="btn_radio_rating<?php echo $i; ?>" name="btn_radio_rating<?php echo $i; ?>" value="2" <?php echo  set_radio('btn_radio_rating'.$i, '2', $value['tlm_rating_number'] == '2'); ?>  />
                        </label>
                        <label class="btn btn-default option agree min <?php if(@$tlm_rating_number== 1){echo $active_class;} ?>" >
                            <input type="radio" class="btn_radio_rating<?php echo $i; ?>" name="btn_radio_rating<?php echo $i; ?>" value="1" <?php echo  set_radio('btn_radio_rating'.$i, '1', $value['tlm_rating_number'] == '1'); ?> />
                        </label>
                        <label class="btn btn-default option neutral <?php if(@$tlm_rating_number== 0){echo $active_class;} ?>" >
                            <input type="radio" class="btn_radio_rating<?php echo $i; ?>" name="btn_radio_rating<?php echo $i; ?>" value="0" <?php echo  set_radio('btn_radio_rating'.$i, '0', $value['tlm_rating_number'] == '0'); ?>  />
                        </label>
                        <label class="btn btn-default option disagree min <?php if(@$tlm_rating_number== -1){echo $active_class;} ?>" >
                            <input type="radio" class="btn_radio_rating<?php echo $i; ?>" name="btn_radio_rating<?php echo $i; ?>" value="-1" <?php echo  set_radio('btn_radio_rating'.$i, '-1', $value['tlm_rating_number'] == '-1'); ?> />
                        </label>
                        <label class="btn btn-default option disagree med <?php if(@$tlm_rating_number== -2){echo $active_class;} ?>" >
                            <input type="radio" class="btn_radio_rating<?php echo $i; ?>" name="btn_radio_rating<?php echo $i; ?>" value="-2" <?php echo  set_radio('btn_radio_rating'.$i, '-2', $value['tlm_rating_number'] == '-2'); ?> />
                        </label>
                        <label class="btn btn-default option disagree max <?php if(@$tlm_rating_number== -3){echo $active_class;} ?>" >
                            <input type="radio" class="btn_radio_rating<?php echo $i; ?>" name="btn_radio_rating<?php echo $i; ?>" value="-3" <?php echo  set_radio('btn_radio_rating'.$i, '-3', $value['tlm_rating_number'] == '-3'); ?>  />
                        </label>
                    </div>
                    <div class="hidden-xs col-sm-3 caption right">Disagree</div>
                </div>
                <div class="row decision mobile visible-xs">
                    <div class="col-xs-6 caption left">Agree</div>
                    <div class="col-xs-6 caption right">Disagree</div>
                </div>
            </div>
			</td>


	  			<!-- <td class="text-center">
	  				<input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="5" <?php echo  set_radio('btn_radio_rating'.$i, '5', $value['tlm_rating_number'] == '5'); ?> disabled />
	  			</td>
	  			<td class="text-center">
	  				<input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="4" <?php echo  set_radio('btn_radio_rating'.$i, '4', $value['tlm_rating_number'] == '4' ); ?> disabled/>
	  			</td>
	  			<td class="text-center">
	  				<input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="3" <?php echo  set_radio('btn_radio_rating'.$i, '3', $value['tlm_rating_number'] == '3' ); ?> disabled/>
	  			</td>
	  			<td class="text-center">
	  				<input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="2" <?php echo  set_radio('btn_radio_rating'.$i, '2', $value['tlm_rating_number'] == '2' ); ?> disabled/>
	  			</td>
	  			<td class="text-center">
	  				<input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="1" <?php echo  set_radio('btn_radio_rating'.$i, '1', $value['tlm_rating_number'] == '1' ); ?> disabled/>
	  			</td>
	  			-->
	  			<td><textarea class="evaluate_remarks_text" name="remarks<?php echo $i; ?>" id="remarks<?php echo $i; ?>" cols="28" rows="5" disabled ><?php echo $value['tlm_rating_remarks'] ?></textarea></td> 


	  		</tr>
	  	<?php $i++; endforeach ?>
	  </tbody>
	</table>
	<div class="form-group row evaluate-recommendations">
		<div class="col-md-12 text-center">
			<label for="recommendations" class="form-control col-form-label" >Recommendations:</label>
			<textarea class="form-control" name="evaluate_recommendation" id="evaluate_recommendation" cols="30" rows="10" disabled><?php echo $evaluate_list_detail[0]['tlm_recommendations'] ?></textarea>
		</div>
	</div>
<div class="row">
	<div class="col-md-12">
		<table class="table-evaluate-instructions">
			<tr>
				<td class="font-weight-bold">Superb</td>
				<td>(05-06)</td>
				<td>Employee is working superb and extraordinary expectations</td>
			</tr>
			<tr>
				<td>Great</td>
				<td>(04-05)</td>
				<td>Employee is working great and above the expectations</td>
			</tr>
			<tr>
				<td>Good</td>
				<td>(03-04)</td>
				<td>Employee is working good and meeting the expectations</td>
			</tr>
			<tr>
				<td>Need Improvement</td>
				<td>(02-03)</td>
				<td>Employee is working below the expecations and needs little improvement</td>
			</tr>
			<tr>
				<td>Failing</td>
				<td>(01-02)</td>
				<td>Employee is working below the expecations and needs strong improvement</td>
			</tr>
		</table>
	</div>
</div>

<script>
	$(function(){
		$("btn_radio_rating1").prop("disabled", false);
	});
</script>