<?php if($this->session->flashdata('user_manage_user_inserted')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_manage_user_inserted').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_manage_user_updated')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_manage_user_updated').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('manage_user_success_delete')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('manage_user_success_delete').'</p>'; ?>
<?php endif; ?>
<h1><?php echo $title; ?></h1>
<a class="btn btn-primary btn-md" style="float:right;" href="<?php echo base_url(); ?>users/update_manage_user">Add User</a>
<?php if(!empty($all_manage_users)){ ?>
<table class="table table-inverse">
	<thead>
		<tr>
			<th>Sr.#</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Designation</th>
			<th>Team Lead</th>
			<th>User Type</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach (@$all_manage_users as $key => $value): ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo @$value['Firstname'].' '.@$value['Lastname']; ?></td>
				<td><?php echo @$value['Email']; ?></td>
				<td><?php echo @$value['designation_name']; ?></td>
				<td><?php echo @$value['Team_lead']; ?></td>
				<td><?php echo @$value['User_type']; ?></td>
				<td><a class="btn btn-info btn-xs" href="<?php echo base_url('users/update_manage_user'.'/'.@$value['User_id']); ?>">Edit</a><a class="btn btn-danger btn-xs" onclick="javascript:deleteConfirm('<?php echo base_url().'users/delete_manage_user/'.@$value['User_id'];?>');" deleteConfirm href="#">Delete</a></td>				
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