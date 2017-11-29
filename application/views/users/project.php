<?php if($this->session->flashdata('user_project')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_project').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_project_updated')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_project_updated').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('project_success_delete')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('project_success_delete').'</p>'; ?>
<?php endif; ?>
<h1><?php echo $title; ?></h1>
<a class="btn btn-primary btn-md" style="float:right;" href="<?php echo base_url(); ?>users/update_project">Add Project</a>
<?php if(!empty($all_projects)){ ?>
<div class="projects-list">
<table class="table table-inverse">
	<thead>
		<tr>
			<th>Sr.#</th>
			<th>Project Name</th>
			<th>Is Module?</th>
			<th>Project Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach (@$all_projects as $key => $value): ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo @$value['project_name']; ?></td>
				<td><?php echo @$value['project_is_module']; ?></td>
				<td><?php echo @$value['project_status']; ?></td>
				<td><a class="btn btn-info btn-xs" href="<?php echo base_url('users/update_project'.'/'.@$value['project_id']); ?>">Edit</a><a class="btn btn-danger btn-xs" onclick="javascript:deleteConfirm('<?php echo base_url().'users/delete_project/'.@$value['project_id'];?>');" deleteConfirm href="#">Delete</a></td>				
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
<?php } else{ ?>
<h3>There are no Projects. Please Add the Project</h3>
<?php } ?>