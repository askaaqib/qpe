<?php
	ob_start();
	class Rating extends CI_Controller{

		// Register user

		public function __construct()
        {
        	parent::__construct();
			$this->load->model('rating_model');
			$this->load->helper('url');
                
                // Your own constructor code
        }

		public function member_to_lead(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Performance Evaluation Team Member to Team Lead';
			$data['factors_list'] = $this->rating_model->mtl_get_factors();

			$this->load->view('templates/header');
			$this->load->view('rating/mtl/member_to_lead', $data);
			$this->load->view('templates/footer');

		}


		public function lead_to_hr(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Performance Evaluation Team Lead to H.R';
			$data['factors_list'] = $this->rating_model->lthr_get_factors();

			$this->load->view('templates/header');
			$this->load->view('rating/lthr/lead_to_hr', $data);
			$this->load->view('templates/footer');

		}

		public function lead_to_member(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Performance Evaluation Team Lead to Team Member';
			$data['factors_list'] = $this->rating_model->ltm_get_factors();

			$this->load->view('templates/header');
			$this->load->view('rating/ltm/lead_to_member', $data);
			$this->load->view('templates/footer');

		}

/*
***********************************************************
	EVALUATION FUNCTION STARTS lthr (Team Lead To H.R)
***********************************************************
*/		
        public function evaluate_lthr($tlhr_name=0,$tlhr_id=0){
        	// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation (Team Lead To H.R)';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            
            $data['all_factors_list'] = $this->rating_model->lthr_get_factors();
            $data['selected_factors_list'] = $this->rating_model->lthr_get_selected_factors($tlhr_name,$tlhr_id);
            $data['lthr_all_members'] = $this->rating_model->lthr_all_members();
			$data['all_departments'] = $this->user_model->all_departments();
			$data['all_projects'] = $this->user_model->all_projects();
			$data['all_designations'] = $this->user_model->all_designations();
			$data['tlhr_edit_id'] = $tlhr_name;
			
			$this->load->view('templates/header');
			$this->load->view('rating/lthr/evaluate', $data);
			$this->load->view('templates/footer');

		}

		// Evaluation Rating lthr (Team Lead To H.R)
        public function evaluate_rating_lthr($user_id=0,$tlhr_id=0){
        	// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}

			$data['user_id']   = $this->session->userdata('user_id');
    		$data['email']     = $this->session->userdata('email');
    		$data['logged_in'] = $this->session->userdata('logged_in');

			
			$this->form_validation->set_rules('user_name', 'Name', 'required');
			$this->form_validation->set_rules('user_designation', 'Designation', 'required');
			$this->form_validation->set_rules('user_department', 'Department', 'required');
			$this->form_validation->set_rules('lead_name', 'TeamLead/Supersior Name', 'required');
			$this->form_validation->set_rules('user_joining_date', 'Joining', 'required');
			$this->form_validation->set_rules('evaluation_quarter', 'Quarter', 'required');
			$this->form_validation->set_rules('user_project', 'Project', 'required');
			$this->form_validation->set_rules('evaluation_date', 'Date', 'required');
			// $this->form_validation->set_rules('btn_radio_rating', 'Rating', 'required');
			// $this->form_validation->set_rules('remarks', 'Remarks', 'required');
			$this->form_validation->set_rules('evaluate_recommendation', 'Recommendations', 'required');

			if($this->form_validation->run() === FALSE){
				$this->session->set_flashdata('error', validation_errors());
				if (!empty($this->session->flashdata('message'))) {
				    $data['message'] = $this->session->flashdata('message');
				} elseif (!empty($this->session->flashdata('error'))) {
				    $data['error'] = $this->session->flashdata('error');
				}
				$data['title'] = 'Quarterly Performance Evaluation (Team Lead To H.R)';

            	$data['all_factors_list'] = $this->rating_model->lthr_get_factors();
            	$data['count_factors'] = COUNT($data['all_factors_list']);
            	$data['selected_factors_list'] = $this->rating_model->lthr_get_selected_factors();
 
				$this->load->view('templates/header');
				$this->load->view('rating/lthr/evaluate', $data);
				$this->load->view('templates/footer');
			} else {
				
				$data['all_factors_list'] = $this->rating_model->lthr_get_factors();
            	$data['count_factors'] = COUNT($data['all_factors_list']);
            	$data['selected_factors_list'] = $this->rating_model->lthr_get_selected_factors();

				$this->rating_model->evaluate_lthr($data,$user_id,$tlhr_id);

				// Set message
				$this->session->set_flashdata('evaluation_rating_success', 'Evaluation Successfully Applied');

				redirect('rating/evaluate_lthr_list');
				
			}
            
		}

		// Evaluation List Show lthr (Team Lead To H.R)
		public function evaluate_lthr_list(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation List(Team Lead To H.R)';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            $data['evaluate_list'] = $this->rating_model->evaluate_lthr_list();
            $data['lthr_all_members'] = $this->rating_model->lthr_all_members();
            
            $this->load->view('templates/header');
			$this->load->view('rating/lthr/evaluate_lthr_list', $data);
			$this->load->view('templates/footer');

		}

		// Evaluation Detail/View Page lthr (Team Lead to H.R)
		public function evaluate_lthr_list_detail($tlhr_id=0){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation List Detail(Team Lead To H.R)';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            $data['evaluate_list_detail'] = $this->rating_model->evaluate_lthr_list_detail($tlhr_id);
            
            $this->load->view('templates/header');
			$this->load->view('rating/lthr/evaluate_lthr_list_detail', $data);
			$this->load->view('templates/footer');

		}

		// Delete Evaluation lthr iteam (Team Lead to HR)
		public function delete_lthr_list_item($tlhr_id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			
		$this->rating_model->delete_evaluate_lthr_item($tlhr_id);

			// Set message
		$this->session->set_flashdata('evaluation_rating_success_delete', 'Evaluation has been Successfully deleted');

		redirect('rating/evaluate_lthr_list');
		}

/*
****************************************************************
	EVALUATION FUNCTION STARTS lthm (Team Lead To Member)
****************************************************************
*/		
        public function evaluate_ltm($tlm_name=0,$tlm_id=0){
        	// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation (Team Lead To Member)';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            
            $data['all_factors_list'] = $this->rating_model->ltm_get_factors();
            $data['selected_factors_list'] = $this->rating_model->ltm_get_selected_factors($tlm_name,$tlm_id);
            $data['ltm_all_members'] = $this->rating_model->ltm_all_members();
			$data['all_departments'] = $this->user_model->all_departments();
			$data['all_projects'] = $this->user_model->all_projects();
			$data['all_designations'] = $this->user_model->all_designations();
			$data['tlm_edit_id'] = $tlm_name;
			
			$this->load->view('templates/header');
			$this->load->view('rating/ltm/evaluate', $data);
			$this->load->view('templates/footer');

		}

		// Evaluation Rating ltm (Team Lead To Member)
        public function evaluate_rating_ltm($user_id=0,$tlm_id=0){
        	// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}

			$data['user_id']   = $this->session->userdata('user_id');
    		$data['email']     = $this->session->userdata('email');
    		$data['logged_in'] = $this->session->userdata('logged_in');

			
			$this->form_validation->set_rules('user_name', 'Name', 'required');
			$this->form_validation->set_rules('user_designation', 'Designation', 'required');
			$this->form_validation->set_rules('user_department', 'Department', 'required');
			$this->form_validation->set_rules('lead_name', 'TeamLead/Supersior Name', 'required');
			$this->form_validation->set_rules('user_joining_date', 'Joining', 'required');
			$this->form_validation->set_rules('evaluation_quarter', 'Quarter', 'required');
			$this->form_validation->set_rules('user_project', 'Project', 'required');
			$this->form_validation->set_rules('evaluation_date', 'Date', 'required');
			// $this->form_validation->set_rules('btn_radio_rating', 'Rating', 'required');
			// $this->form_validation->set_rules('remarks', 'Remarks', 'required');
			$this->form_validation->set_rules('evaluate_recommendation', 'Recommendations', 'required');

			if($this->form_validation->run() === FALSE){
				$this->session->set_flashdata('error', validation_errors());
				if (!empty($this->session->flashdata('message'))) {
				    $data['message'] = $this->session->flashdata('message');
				} elseif (!empty($this->session->flashdata('error'))) {
				    $data['error'] = $this->session->flashdata('error');
				}
				$data['title'] = 'Quarterly Performance Evaluation (Team Lead To Member)';

            	$data['all_factors_list'] = $this->rating_model->ltm_get_factors();
            	$data['count_factors'] = COUNT($data['all_factors_list']);
            	$data['selected_factors_list'] = $this->rating_model->ltm_get_selected_factors();
 
				$this->load->view('templates/header');
				$this->load->view('rating/ltm/evaluate', $data);
				$this->load->view('templates/footer');
			} else {
				
				$data['all_factors_list'] = $this->rating_model->ltm_get_factors();
            	$data['count_factors'] = COUNT($data['all_factors_list']);
            	$data['selected_factors_list'] = $this->rating_model->ltm_get_selected_factors();

				$this->rating_model->evaluate_ltm($data,$user_id,$tlm_id);

				// Set message
				$this->session->set_flashdata('evaluation_rating_success', 'Evaluation Successfully Applied');

				redirect('rating/evaluate_ltm_list');
				
			}
            
		}

		// Evaluation List Show ltm (Team Lead To Member)
		public function evaluate_ltm_list(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation List(Team Lead To Member)';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            $data['evaluate_list'] = $this->rating_model->evaluate_ltm_list();
            $data['ltm_all_members'] = $this->rating_model->ltm_all_members();
            
            $this->load->view('templates/header');
			$this->load->view('rating/ltm/evaluate_ltm_list', $data);
			$this->load->view('templates/footer');

		}

		// Evaluation Detail/View Page ltm (Team Lead to Member)
		public function evaluate_ltm_list_detail($tlm_id=0){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation List Detail(Team Lead To Member)';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            $data['evaluate_list_detail'] = $this->rating_model->evaluate_ltm_list_detail($tlm_id);
            
            $this->load->view('templates/header');
			$this->load->view('rating/ltm/evaluate_ltm_list_detail', $data);
			$this->load->view('templates/footer');

		}

		// Delete Evaluation ltm iteam (Team Lead to Member)
		public function delete_ltm_list_item($tlm_id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			
		$this->rating_model->delete_evaluate_ltm_item($tlm_id);

			// Set message
		$this->session->set_flashdata('evaluation_rating_success_delete', 'Evaluation has been Successfully deleted');

		redirect('rating/evaluate_ltm_list');
		}		

/*
****************************************************************
	EVALUATION FUNCTION STARTS mtl ( Member to Team Lead )
****************************************************************
*/		
        public function evaluate_mtl($mtl_name=0,$mtl_id=0){
        	// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation (Team Member To Lead )';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            
            $data['all_factors_list'] = $this->rating_model->mtl_get_factors();
            $data['selected_factors_list'] = $this->rating_model->mtl_get_selected_factors($mtl_name,$mtl_id);
            $data['mtl_all_members'] = $this->rating_model->mtl_all_members();
			$data['all_departments'] = $this->user_model->all_departments();
			$data['all_projects'] = $this->user_model->all_projects();
			$data['all_designations'] = $this->user_model->all_designations();
			$data['mtl_edit_id'] = $mtl_name;
			
			$this->load->view('templates/header');
			$this->load->view('rating/mtl/evaluate', $data);
			$this->load->view('templates/footer');

		}

		// Evaluation Rating mtl ( Member to Team Lead)
        public function evaluate_rating_mtl($user_id=0,$mtl_id=0){
        	// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}

			$data['user_id']   = $this->session->userdata('user_id');
    		$data['email']     = $this->session->userdata('email');
    		$data['logged_in'] = $this->session->userdata('logged_in');

			
			$this->form_validation->set_rules('user_name', 'Name', 'required');
			$this->form_validation->set_rules('user_designation', 'Designation', 'required');
			$this->form_validation->set_rules('user_department', 'Department', 'required');
			$this->form_validation->set_rules('lead_name', 'TeamLead/Supersior Name', 'required');
			$this->form_validation->set_rules('user_joining_date', 'Joining', 'required');
			$this->form_validation->set_rules('evaluation_quarter', 'Quarter', 'required');
			$this->form_validation->set_rules('user_project', 'Project', 'required');
			$this->form_validation->set_rules('evaluation_date', 'Date', 'required');
			// $this->form_validation->set_rules('btn_radio_rating', 'Rating', 'required');
			// $this->form_validation->set_rules('remarks', 'Remarks', 'required');
			$this->form_validation->set_rules('evaluate_recommendation', 'Recommendations', 'required');

			if($this->form_validation->run() === FALSE){
				$this->session->set_flashdata('error', validation_errors());
				if (!empty($this->session->flashdata('message'))) {
				    $data['message'] = $this->session->flashdata('message');
				} elseif (!empty($this->session->flashdata('error'))) {
				    $data['error'] = $this->session->flashdata('error');
				}
				$data['title'] = 'Quarterly Performance Evaluation ( Team Member To Lead )';

            	$data['all_factors_list'] = $this->rating_model->mtl_get_factors();
            	$data['count_factors'] = COUNT($data['all_factors_list']);
            	$data['selected_factors_list'] = $this->rating_model->mtl_get_selected_factors();
 
				$this->load->view('templates/header');
				$this->load->view('rating/mtl/evaluate', $data);
				$this->load->view('templates/footer');
			} else {
				
				$data['all_factors_list'] = $this->rating_model->mtl_get_factors();
            	$data['count_factors'] = COUNT($data['all_factors_list']);
            	$data['selected_factors_list'] = $this->rating_model->mtl_get_selected_factors();

				$this->rating_model->evaluate_mtl($data,$user_id,$mtl_id);

				// Set message
				$this->session->set_flashdata('evaluation_rating_success', 'Evaluation Successfully Applied');

				redirect('rating/evaluate_mtl_list');
				
			}
            
		}

		// Evaluation List Show mtl ( Member to Team Lead )
		public function evaluate_mtl_list(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation List( Team Member To Lead )';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            $data['evaluate_list'] = $this->rating_model->evaluate_mtl_list();
            $data['mtl_all_members'] = $this->rating_model->mtl_all_members();
            
            $this->load->view('templates/header');
			$this->load->view('rating/mtl/evaluate_mtl_list', $data);
			$this->load->view('templates/footer');

		}

		// Evaluation Detail/View Page mtl ( Member to Team Lead)
		public function evaluate_mtl_list_detail($mtl_id=0){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			$data['title'] = 'Quarterly Performance Evaluation List Detail( Team Member To Lead )';
                       	
              $data['user_id']   = $this->session->userdata('user_id');
    		  $data['email']     = $this->session->userdata('email');
    		  $data['logged_in'] = $this->session->userdata('logged_in');
            
            $data['evaluate_list_detail'] = $this->rating_model->evaluate_mtl_list_detail($mtl_id);
            
            $this->load->view('templates/header');
			$this->load->view('rating/mtl/evaluate_mtl_list_detail', $data);
			$this->load->view('templates/footer');

		}

		// Delete Evaluation mtl item (Member to Team Lead)
		public function delete_mtl_list_item($mtl_id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
			
		$this->rating_model->delete_evaluate_mtl_item($mtl_id);

			// Set message
		$this->session->set_flashdata('evaluation_rating_success_delete', 'Evaluation has been Successfully deleted');

		redirect('rating/evaluate_mtl_list');
		}

}
	ob_flush();	