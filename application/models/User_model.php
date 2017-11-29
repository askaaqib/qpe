<?php
	class User_model extends CI_Model{
		public function register($enc_password){
			// User data array
			$data = array(
				'Firstname' => $this->input->post('firstname'),
				'Lastname' => $this->input->post('lastname'),
				'Email' => $this->input->post('email'),
                'Designation' => $this->input->post('designation'),
                'User_type' => $this->input->post('user_type'),
                'password' => $enc_password
			);

			// Insert user
			return $this->db->insert('user', $data);
		}

		// Log user in
		public function login($email, $password){
			// Validate
			$this->db->where('Email', $email);
			$this->db->where('Password', $password);

			$result = $this->db->get('user');

			if($result->num_rows() == 1){
				return $result->row(0)->User_id;
			} else {
				return false;
			}
		}

		// Check username exists
		public function check_username_exists($email){
			$query = $this->db->get_where('user', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		// Check email exists
		public function check_email_exists($email){
			$query = $this->db->get_where('user', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}
/*
*********************************************************
			USERS FUNCTION STARTS 
*********************************************************
*/
		// Show All Users
		public function all_manage_users(){
			$this->db->join('designations', 'designations.designation_id = user.Designation');
			$query = $this->db->get('user');
			if($query->result_array()){
				return $query->result_array();
			}
			else{
				return $query->result_array();	
			}			
		}
		
		// Get User by ID
		public function get_manage_user_by_id($user_id){
			$this->db->join('designations', 'designations.designation_id = user.Designation');
			$this->db->where('User_id', $user_id);
			$query = $this->db->get('user');
			if($query->result_array()){
				return $query->row_array();
			}			
		}
		// Add & Update User
		public function update_manage_user($user_id=0){
			// User data array
			$enc_password = md5($this->input->post('password'));
			$data = array(
				'Firstname' => $this->input->post('firstname'),
				'Lastname' => $this->input->post('lastname'),
				'Email' => $this->input->post('email'),
                'Designation' => $this->input->post('designation'),
                'Team_lead' => $this->input->post('team_lead'),
                'User_type' => $this->input->post('user_type'),
                'password' => $enc_password
			);
			$usert = $user_id;
			if($user_id=0 || empty($user_id)){
				// Insert manage_user
				$this->session->set_flashdata('user_manage_user_inserted', 'User Successfully Inserted!');
				return $this->db->insert('user', $data);
			}
			else{
				$data = array(
				'Firstname' => $this->input->post('firstname'),
				'Lastname' => $this->input->post('lastname'),
				'Email' => $this->input->post('email'),
                'Designation' => $this->input->post('designation'),
                'Team_lead' => $this->input->post('team_lead'),
                'User_type' => $this->input->post('user_type')
				);
				// Update User
				$this->db->where('user_id', $usert);
				$this->db->update('user', $data);
				$this->session->set_flashdata('user_manage_user_updated', 'User Successfully Updated!');
			}
		}

		// Delete User
		public function delete_manage_user($user_id){
			$this->db->where('User_id', $user_id);
			$this->db->delete('user');
			return true;	
		}		
/*
*********************************************************
			DEPARTMENTS FUNCTION STARTS 
*********************************************************
*/
		// Show All Departments
		public function all_departments(){
			$query = $this->db->get('departments');
			if($query->result_array()){
				return $query->result_array();
			}
			else{
				return $query->result_array();	
			}			
		}
		
		// Get Department by ID
		public function get_department_by_id($dept_id){
			$this->db->where('dept_id', $dept_id);
			$query = $this->db->get('departments');
			if($query->result_array()){
				return $query->row_array();
			}			
		}
		// Add & Update Department
		public function update_department($dept_id=0){
			// User data array
			$data = array(
				'dept_name' => $this->input->post('department_name'),
			);
			$deptt = $dept_id;
			if($dept_id=0 || empty($dept_id)){
				// Insert department
				return $this->db->insert('departments', $data);
				$this->session->set_flashdata('user_department', 'Department Successfully Inserted!');
			}
			else{
				// Update Department
				$this->db->where('dept_id', $deptt);
				$this->db->update('departments', $data);
				$this->session->set_flashdata('user_department_updated', 'Department Successfully Updated!');
			}
		}

		// Delete Department
		public function delete_department($dept_id){
			$this->db->where('dept_id', $dept_id);
			$this->db->delete('departments');
			return true;	
		}
/*
*********************************************************
			PROJECTS FUNCTION STARTS 
*********************************************************
*/

		// Show All Projects
		public function all_projects(){
			$query = $this->db->get('projects');
			if($query->result_array()){
				return $query->result_array();
			}
			else{
				return $query->result_array();	
			}			
		}
		
		// Get Project by ID
		public function get_project_by_id($project_id){
			$this->db->where('project_id', $project_id);
			$query = $this->db->get('projects');
			if($query->result_array()){
				return $query->row_array();
			}			
		}
		// Add & Update Project
		public function update_project($project_id=0){
			// User data array
			$data = array(
				'project_name' => $this->input->post('project_name'),
				'project_is_module' => $this->input->post('project_is_module'),
				'project_status' => $this->input->post('project_status'),
			);
			$projectt = $project_id;
			if($project_id=0 || empty($project_id)){
				// Insert project
				$this->db->set('project_added_by', $this->input->post('project_added_by') );
				$this->db->set('project_created_date', 'NOW()', FALSE);
				$this->db->set('project_modified_date', 'NOW()', FALSE);
				return $this->db->insert('projects', $data);
				$this->session->set_flashdata('user_project', 'Project Successfully Inserted!');
			}
			else{
				// Update Project
				$this->db->set('project_modified_date', 'NOW()', FALSE);
				$this->db->where('project_id', $projectt);
				$this->db->update('projects', $data);
				$this->session->set_flashdata('user_project_updated', 'Project Successfully Updated!');
			}
		}

		// Delete Project
		public function delete_project($project_id){
			$this->db->where('project_id', $project_id);
			$this->db->delete('projects');
			return true;	
		}

/*
*********************************************************
			DESIGNATIONS FUNCTION STARTS 
*********************************************************
*/

		// Show All Designations
		public function all_designations(){
			$query = $this->db->get('designations');
			if($query->result_array()){
				return $query->result_array();
			}
			else{
				return $query->result_array();	
			}			
		}
		
		// Get Designation by ID
		public function get_designation_by_id($designation_id){
			$this->db->where('designation_id', $designation_id);
			$query = $this->db->get('designations');
			if($query->result_array()){
				return $query->row_array();
			}			
		}
		// Add & Update Designation
		public function update_designation($designation_id=0){
			// User data array
			$data = array(
				'designation_name' => $this->input->post('designation_name'),
				'designation_desc' => 'Designation Description',
				'designation_status' => $this->input->post('designation_status'),
			);
			$designationt = $designation_id;
			if($designation_id=0 || empty($designation_id)){
				// Insert designation
				$this->db->set('designation_added_by', $this->input->post('designation_added_by') );
				$this->db->set('designation_created_date', 'NOW()', FALSE);
				$this->db->set('designation_modified_date', 'NOW()', FALSE);
				return $this->db->insert('designations', $data);
				$this->session->set_flashdata('user_designation', 'Designation Successfully Inserted!');
			}
			else{
				// Update Designation
				$this->db->set('designation_modified_date', 'NOW()', FALSE);
				$this->db->where('designation_id', $designationt);
				$this->db->update('designations', $data);
				$this->session->set_flashdata('user_designation_updated', 'Designation Successfully Updated!');
			}
		}

		// Delete Designation
		public function delete_designation($designation_id){
			$this->db->where('designation_id', $designation_id);
			$this->db->delete('designations');
			return true;	
		}		

}