<html>
	<head>
		<title>QPE</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/flatly.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/timepicker//jquery-ui-timepicker-addon.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/redmond/jquery-ui.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/evaluate/css/vendors-v1bcbd.css?vx=2'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/evaluate/css/16p-all-v3ae52.css?v=5'); ?>"> -->
    <!-- <script src="http://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script> -->
	</head>
	<body>
  <header>
  	<nav class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">QPE</a>
          </div>
          <div id="navbar">
            <ul class="nav navbar-nav">
              <?php if($this->session->userdata('logged_in')) : ?>
              <li><a href="<?php echo base_url(); ?>users/dashboard">Dashboard</a></li>
              <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav">
              <?php if($this->session->userdata('logged_in')) : ?>
              <li><a href="<?php echo base_url(); ?>users/admin">Admin</a></li>
              <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <?php if(!$this->session->userdata('logged_in')) : ?>
              <li><a href="<?php echo base_url(); ?>login">Login</a></li>
              <li><a href="<?php echo base_url(); ?>register">Register</a></li>
            <?php endif; ?>
            <?php if($this->session->userdata('logged_in')) : ?>
              <li><a href="<?php echo base_url(); ?>users/logout">Logout</a></li>
            <?php endif; ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="container main-container">
      <!-- Flash messages -->
      <?php if($this->session->flashdata('user_registered')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('login_failed')): ?>
        <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('login_failed').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('user_loggedin')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedin').'</p>'; ?>
      <?php endif; ?>

       <?php if($this->session->flashdata('user_loggedout')): ?>
        <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedout').'</p>'; ?>
      <?php endif; ?>