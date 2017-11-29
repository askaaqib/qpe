<?php if($this->session->flashdata('evaluation_rating_success')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('evaluation_rating_success').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('evaluation_rating_success_delete')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('evaluation_rating_success_delete').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('evaluation_rating_success_update')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('evaluation_rating_success_update').'</p>'; ?>
<?php endif; ?>
<h2><?php echo $title; ?></h2>
<?php if(!empty($mtl_all_members)){ ?>
<a href="<?php echo base_url(); ?>rating/evaluate_mtl" class="btn btn-primary btn-sm btn-tlhr-rating">Start Evaluation</a>
<?php } ?>
<div class="evaluate_list">
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th>Sr.#</th>
	      <th>Name</th>
	      <th>Designation</th>
	      <th>Department</th>
	      <th>Module</th>
	      <th>Average</th>
	      <th>Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php $i=1; foreach ($evaluate_list as $key => $value): ?>
	  		<tr>  			
	  			<td><?php echo $i; ?></td>
	  			<td><?php echo $value['Firstname'].' '. $value['Lastname']; ?></td>
	  			<td><?php echo $value['designation_name']; ?></td>
	  			<td><?php echo $value['dept_name']; ?></td>
	  			<td><?php echo $value['project_name']; ?></td>
	  			<td><?php echo $value['mtl_rating_avg']; ?></td>
	  			<td>
	  			<a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>rating/evaluate_mtl/<?php echo $value['mtl_name']. '/'. $value['mtl_id']; ?>">Edit</a>	
				<a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>rating/evaluate_mtl_list_detail/<?php echo $value['mtl_id']; ?>">Details</a>
				<a class="btn btn-danger btn-xs" onclick="javascript:deleteConfirm('<?php echo base_url().'rating/delete_mtl_list_item/'.$value['mtl_id'];?>');" deleteConfirm href="#">Delete</a></td>
	  		</tr>
	  	<?php $i++; endforeach ?>
	  </tbody>
	</table>
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