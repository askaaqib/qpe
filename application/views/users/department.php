<?php if($this->session->flashdata('user_department')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_department').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_department_updated')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_department_updated').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('department_success_delete')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('department_success_delete').'</p>'; ?>
<?php endif; ?>
<h1><?php echo $title; ?></h1>
<a class="btn btn-primary btn-md" style="float:right;" href="<?php echo base_url(); ?>users/update_department">Add Department</a>
<?php if(!empty($all_departments)){ ?>
<table class="table table-inverse">
	<thead>
		<tr>
			<th>Sr.#</th>
			<th>Department Name</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach (@$all_departments as $key => $value): ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo @$value['dept_name']; ?></td>
				<td><a class="btn btn-info btn-xs" href="<?php echo base_url('users/update_department'.'/'.@$value['dept_id']); ?>">Edit</a><a class="btn btn-danger btn-xs" onclick="javascript:deleteConfirm('<?php echo base_url().'users/delete_department/'.@$value['dept_id'];?>');" deleteConfirm href="#">Delete</a></td>				
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
<h3>There are no Departments. Please Add the Department</h3>
<?php } ?>