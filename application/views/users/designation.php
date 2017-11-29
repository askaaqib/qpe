<?php if($this->session->flashdata('user_designation')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_designation').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_designation_updated')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_designation_updated').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('designation_success_delete')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('designation_success_delete').'</p>'; ?>
<?php endif; ?>
<h1><?php echo $title; ?></h1>
<a class="btn btn-primary btn-md" style="float:right;" href="<?php echo base_url(); ?>users/update_designation">Add Designation</a>
<?php if(!empty($all_designations)){ ?>
<table class="table table-inverse">
	<thead>
		<tr>
			<th>Sr.#</th>
			<th>Designation Name</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach (@$all_designations as $key => $value): ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo @$value['designation_name']; ?></td>
				<td><?php echo @$value['designation_status']; ?></td>
				<td><a class="btn btn-info btn-xs" href="<?php echo base_url('users/update_designation'.'/'.@$value['designation_id']); ?>">Edit</a><a class="btn btn-danger btn-xs" onclick="javascript:deleteConfirm('<?php echo base_url().'users/delete_designation/'.@$value['designation_id'];?>');" deleteConfirm href="#">Delete</a></td>				
			</tr>

		<?php $i++; endforeach ?>
	</tbody>
</table>		

<script type="text/javascript"> 
function deleteConfirm(url)
 {
    if(confirm('Do you want to Delete this record ?'))
    {
        window.location.href=url;
    }
 }
</script>
<?php } else{ ?>
<h3>There are no Designations. Please Add the Designation</h3>
<?php } ?>