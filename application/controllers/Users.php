<?php

	class Users extends CI_Controller{

		// Register user
		public function __construct()
        {
        	parent::__construct();
			
                
                // Your own constructor code
        }


		public function index(){
			$data['title'] = 'Login';


			$this->load->view('templates/header');

			$this->load->view('users/login', $data);

			$this->load->view('templates/footer');

			

		}

		// Dashboard Function
		public function dashboard(){
			$data['title'] = 'Dashboard';
			
			$this->load->model('rating_model');

            $data['lthr_all_members'] = $this->rating_model->lthr_all_members();
            $data['ltm_all_members'] = $this->rating_model->ltm_all_members();
            $data['mtl_all_members'] = $this->rating_model->mtl_all_members();


			$this->load->view('templates/header');

			$this->load->view('users/dashboard', $data);

			$this->load->view('templates/footer');

		}

		// Register Function
		public function register(){

			$data['title'] = 'Registeration Form';



			$this->form_validation->set_rules('firstname', 'First Name', 'required');

			$this->form_validation->set_rules('lastname', 'Last Name', 'required');

			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');

			$this->form_validation->set_rules('password', 'Password', 'required');

			$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');



			if($this->form_validation->run() === FALSE){

				$this->load->view('templates/header');

				$this->load->view('users/register', $data);

				$this->load->view('templates/footer');

			} else {

				// Encrypt password

				$enc_password = md5($this->input->post('password'));



				$this->user_model->register($enc_password);



				// Set message

				$this->session->set_flashdata('user_registered', 'You are now registered and can log in');



				redirect('users');

			}

		}



		// Log in user

		public function login(){

			$data['title'] = 'Sign In';



			$this->form_validation->set_rules('email', 'Email', 'required');

			$this->form_validation->set_rules('password', 'Password', 'required');



			if($this->form_validation->run() === FALSE){

				$this->load->view('templates/header');

				$this->load->view('users/login', $data);

				$this->load->view('templates/footer');

			} else {

				

				// Get email

				$email = $this->input->post('email');

				// Get and encrypt the password

				$password = md5($this->input->post('password'));



				// Login user

				$user_id = $this->user_model->login($email, $password);



				if($user_id){

					// Create session

					$user_data = array(

						'user_id' => $user_id,

						'email' => $email,

						'logged_in' => true

					);



					$this->session->set_userdata($user_data);



					// Set message

					$this->session->set_flashdata('user_loggedin', 'You are now logged in');



					redirect('users');

				} else {

					// Set message

					$this->session->set_flashdata('login_failed', 'Login is invalid');



					redirect('users/login');

				}		

			}

		}



		// Log user out

		public function logout(){

			// Unset user data

			$this->session->unset_userdata('logged_in');

			$this->session->unset_userdata('user_id');

			$this->session->unset_userdata('email');



			// Set message

			$this->session->set_flashdata('user_loggedout', 'You are now logged out');



			redirect('users/login');

		}



		// Check if email exists

		public function check_username_exists($email){

			$this->form_validation->set_message('check_username_exists', 'That email is taken. Please choose a different one');

			if($this->user_model->check_username_exists($email)){

				return true;

			} else {

				return false;

			}

		}



		// Check if email exists
		public function check_email_exists($email){

		$this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');

			if($this->user_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}

		// Admin dashboard
		public function admin(){
			$data['title'] = 'Admin';
			
			// $this->load->model('rating_model');

   //          $data['lthr_all_members'] = $this->rating_model->lthr_all_members();
   //          $data['ltm_all_members'] = $this->rating_model->ltm_all_members();
   //          $data['mtl_all_members'] = $this->rating_model->mtl_all_members();


			$this->load->view('templates/header');
			$this->load->view('users/admin_dashboard', $data);
			$this->load->view('templates/footer');

		}
/*
*************************************************
		USER MANGEMENT FUNCTIONS STARTS
*************************************************
*/		
		// Show Departments
		public function manage_users(){
			if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$data['title'] = 'Users';	

			$data['all_manage_users'] = $this->user_model->all_manage_users();

			$this->load->view('templates/header');
			$this->load->view('users/manage_users', $data);
			$this->load->view('templates/footer');

		}
		// Create User
		public function update_manage_user($User_id=0){
			if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');

			$Usert = $User_id; 	
			if($Usert=0 || empty($Usert)){
				$data['title'] = 'Add User';
			}	
			else{
				$data['title'] = 'Edit User';
			}	
			$data['get_manage_user'] = $this->user_model->get_manage_user_by_id($User_id);
			$data['all_designations'] = $this->user_model->all_designations();

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/update_manage_user', $data);
				$this->load->view('templates/footer');

			} else {
				$this->user_model->update_manage_user($User_id);
				
				redirect('users/manage_users');

			}
		}

		// Delete User 
		public function delete_manage_user($User_id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
		$this->user_model->delete_manage_user($User_id);

		// Set message
		$this->session->set_flashdata('manage_user_success_delete', 'User has been Successfully deleted');

		redirect('users/manage_users');
		}		
/*
*************************************************
		DEPARTMENT FUNCTIONS STARTS
*************************************************
*/		
		// Show Departments
		public function department(){
			if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$data['title'] = 'Departments';	

			$data['all_departments'] = $this->user_model->all_departments();

			$this->load->view('templates/header');
			$this->load->view('users/department', $data);
			$this->load->view('templates/footer');

		}
		// Create Department
		public function update_department($dept_id=0){
			if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$deptt = $dept_id; 	
			if($deptt=0 || empty($deptt)){
				$data['title'] = 'Add Department';
			}	
			else{
				$data['title'] = 'Edit Department';
			}	
			$data['get_department'] = $this->user_model->get_department_by_id($dept_id);

			$this->form_validation->set_rules('department_name', 'Department Name', 'required');
			
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/update_department', $data);
				$this->load->view('templates/footer');

			} else {
				$this->user_model->update_department($dept_id);
				
				redirect('users/department');

			}
		}

		// Delete Department 
		public function delete_department($dept_id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
		$this->user_model->delete_department($dept_id);

		// Set message
		$this->session->set_flashdata('department_success_delete', 'Department has been Successfully deleted');

		redirect('users/department');
		}
/*
*************************************************
		PROJECTS FUNCTIONS STARTS
*************************************************
*/
		// Show Projects
		public function project(){
			if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$data['title'] = 'Projects';	

			$data['all_projects'] = $this->user_model->all_projects();

			$this->load->view('templates/header');
			$this->load->view('users/project', $data);
			$this->load->view('templates/footer');

		}
		// Create Project
		public function update_project($project_id=0){
			if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$projectt = $project_id; 	
			if($projectt=0 || empty($projectt)){
				$data['title'] = 'Add Project';
			}	
			else{
				$data['title'] = 'Edit Project';
			}	
			$data['get_project'] = $this->user_model->get_project_by_id($project_id);

			$this->form_validation->set_rules('project_name', 'Project Name', 'required');
			
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/update_project', $data);
				$this->load->view('templates/footer');

			} else {
				$this->user_model->update_project($project_id);
				
				redirect('users/project');

			}
		}

		// Delete Project 
		public function delete_project($project_id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
		$this->user_model->delete_project($project_id);

		// Set message
		$this->session->set_flashdata('project_success_delete', 'Project has been Successfully deleted');

		redirect('users/project');
		}

/*
*************************************************
		DESIGNATIONS FUNCTIONS STARTS
*************************************************
*/
		// Show Designations
		public function designation(){
			if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$data['title'] = 'Designations';	

			$data['all_designations'] = $this->user_model->all_designations();

			$this->load->view('templates/header');
			$this->load->view('users/designation', $data);
			$this->load->view('templates/footer');
		}

		// Create Designation
		public function update_designation($designation_id=0){
			if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$designationt = $designation_id; 	
			if($designationt=0 || empty($designationt)){
				$data['title'] = 'Add Designation';
			}	
			else{
				$data['title'] = 'Edit Designation';
			}	
			$data['get_designation'] = $this->user_model->get_designation_by_id($designation_id);

			$this->form_validation->set_rules('designation_name', 'Designation Name', 'required');
			
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/update_designation', $data);
				$this->load->view('templates/footer');

			} else {
				$this->user_model->update_designation($designation_id);
				
				redirect('users/designation');

			}
		}

		// Delete Designation 
		public function delete_designation($designation_id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
		$this->user_model->delete_designation($designation_id);

		// Set message
		$this->session->set_flashdata('designation_success_delete', 'Designation has been Successfully deleted');

		redirect('users/desgination');
		}						
		
}