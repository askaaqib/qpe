<?php if($this->session->flashdata('evaluation_success_insert')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('evaluation_success_insert').'</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('evaluation_success_edit')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('evaluation_success_edit').'</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('evaluation_success_delete')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('evaluation_success_delete').'</p>'; ?>
<?php endif; ?>
<div class="factorslist-lthr">
<h2><?php echo $title; ?></h2>
<a href="<?php echo base_url(); ?>factors/lead_to_hr" class="btn btn-primary btn-sm btn-tlhr-eval">Add Evaluation Factor</a>
<?php //print_r($factors_list); ?>
<div class="factors_list">
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th>#</th>
	      <th>Category Name</th>
	      <th >Factors Description</th>
	      <th class="actions">Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php $i=1; foreach ($factors_list as $key => $value): ?>
	  		<tr>
	  			<td><?php echo $i; ?></td>
	  			<td><?php echo $value['tlhr_cat_name']; ?></td>
	  			<td><?php echo $value['tlhr_eval_description']; ?></td>
	  			<td class="actions">
	  			<a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>factors/lead_to_hr/<?php echo $value['tlhr_eval_fact_id']; ?>">Edit</a>
	  			<a class="btn btn-danger btn-xs" onclick="javascript:deleteConfirm('<?php echo base_url().'factors/delete_lead_to_hr/'.$value['tlhr_eval_fact_id'].'/'.$value['tlhr_cat_id'];?>');" deleteConfirm href="#">Delete</a></td>
	  		</tr>
	  	<?php $i++; endforeach ?>
	  </tbody>
	</table>
</div>
</div>
<script type="text/javascript"> 
function deleteConfirm(url)
 {
    if(confirm('Do you want to Delete this record ?'))
    {
        window.location.href=url;
    }
 }
</script>