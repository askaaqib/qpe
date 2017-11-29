<?php if($this->session->userdata('logged_in')) { ?>

	<h1>Dashboard</h1>
	<h3><a href="<?php echo base_url(); ?>rating/member_to_lead">Performance Evaluation T.M to T.L</a></h3>
	<?php if(!empty($mtl_all_members)){ ?>
	<h5><a href="<?php echo base_url(); ?>rating/evaluate_mtl">Start Evaluation</a></h5>
	<?php } ?>
	<h5><a href="<?php echo base_url(); ?>rating/evaluate_mtl_list">Evaluation List</a></h5>
	<h3><a href="<?php echo base_url(); ?>rating/lead_to_hr">Performance Evaluation T.L to H.R</a></h3>  
	<?php if(!empty($lthr_all_members)){ ?>
	<h5><a href="<?php echo base_url(); ?>rating/evaluate_lthr">Start Evaluation</a></h5>
	<?php } ?>
	<h5><a href="<?php echo base_url(); ?>rating/evaluate_lthr_list">Evaluation List</a></h5>
	<h3><a href="<?php echo base_url(); ?>rating/lead_to_member">Performance Evaluation T.L to T.M</a></h3>
	<?php if(!empty($ltm_all_members)){ ?>
	<h5><a href="<?php echo base_url(); ?>rating/evaluate_ltm">Start Evaluation</a></h5>
	<?php } ?>
	<h5><a href="<?php echo base_url(); ?>rating/evaluate_ltm_list">Evaluation List</a></h5>	
	
<?php  }
else{
	redirect('users/login');
}
?>