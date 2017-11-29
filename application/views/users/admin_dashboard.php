<?php if($this->session->userdata('logged_in')) { ?>

	<h1>Admin Dashboard</h1>
	<h3><a href="<?php echo base_url(); ?>users/project">Projects</a></h3>
	<h3><a href="<?php echo base_url(); ?>users/department">Departments</a></h3>
	<h3><a href="<?php echo base_url(); ?>users/designation">Designations</a></h3>
	<h3><a href="<?php echo base_url(); ?>users/manage_users">Users</a></h3>

<?php  }
else{
	redirect('users/login');
}
?>