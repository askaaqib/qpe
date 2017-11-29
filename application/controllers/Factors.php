<?php

	class Factors extends CI_Controller{


		public function __construct()
        {
        	parent::__construct();
			$this->load->model('rating_model');
			$this->load->model('factor_model');
			$this->load->helper('url');
                
                // Your own constructor code
        }

/*
*****************************************************
	Factors Evaluation for lthr (Lead to H.R)
*****************************************************
*/
		// Add Evaluation Team Lead to H.R
		public function lead_to_hr(){
			// Check login
				if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$data['title'] = 'Add Evaluation Factor (Team Lead To H.R)';

			

			$this->form_validation->set_rules('category_name', 'Category', 'required');
			$this->form_validation->set_rules('factor_description', 'Factor Description', 'required');
			
            $factor_id   = $this->input->post("factor_id");
            $category_id = $this->input->post("category_id");
             

			$data['factors_list'] = $this->rating_model->lthr_get_factors();
			$data['factors_row'] = $this->rating_model->lthr_get_factors_by_id($factor_id);
			


			if(!empty($factor_id)){
            	 // Check Form Validation
				if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('factors/lead_to_hr', $data);
				$this->load->view('templates/footer');

				} else {
					// Update Evaluation Factor
					$this->factor_model->update_lead_to_hr($factor_id,$category_id);
					
             	    $this->session->set_flashdata('evaluation_success_edit', 'Evaluation Factor Successfully Edited');
					redirect('rating/lead_to_hr');		
				}
                    	   
            }
            else{
	         	// Check Form Validation
				if($this->form_validation->run() === FALSE){
					$this->load->view('templates/header');
					$this->load->view('factors/lead_to_hr', $data);
					$this->load->view('templates/footer');

				} else {
						// Insert Evaluation Factor
						$this->factor_model->update_lead_to_hr();

						// echo $this->db->last_query();
						// exit;
						$this->session->set_flashdata('evaluation_success_insert', 'Evaluation Factor Successfully Inserted');
						redirect('rating/lead_to_hr');		
					}
				}
			}

			// Delete Evaluation lthr
			public function delete_lead_to_hr($factor_id,$category_id){
				// Check login
				if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
				$this->load->model('factor_model');

				$this->factor_model->delete_lead_to_hr($factor_id,$category_id);

				// Set message
				$this->session->set_flashdata('evaluation_success_delete', 'Evaluation has been Successfully Deleted');

				redirect('rating/lead_to_hr');
			}

/*
*****************************************************
	Factors Evaluation for ltm (Lead to Member)
*****************************************************
*/
			// Add Evaluation Team Lead to Member
			public function lead_to_member(){
			// Check login
				if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$data['title'] = 'Add Evaluation Factor (Team Lead To Member)';

			

			$this->form_validation->set_rules('category_name', 'Category', 'required');
			$this->form_validation->set_rules('factor_description', 'Factor Description', 'required');
			
            $factor_id   = $this->input->post("factor_id");
            $category_id = $this->input->post("category_id");
             

			$data['factors_list'] = $this->rating_model->ltm_get_factors();
			$data['factors_row'] = $this->rating_model->ltm_get_factors_by_id($factor_id);
			


			if(!empty($factor_id)){
            	 // Check Form Validation
				if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('factors/lead_to_member', $data);
				$this->load->view('templates/footer');

				} else {
					// Update Evaluation Factor
					$this->factor_model->update_lead_to_member($factor_id,$category_id);
					
             	    $this->session->set_flashdata('evaluation_success_edit', 'Evaluation Factor Successfully Edited');
					redirect('rating/lead_to_member');		
				}
                    	   
            }
            else{
	         	// Check Form Validation
				if($this->form_validation->run() === FALSE){
					$this->load->view('templates/header');
					$this->load->view('factors/lead_to_member', $data);
					$this->load->view('templates/footer');

				} else {
						// Insert Evaluation Factor
						$this->factor_model->update_lead_to_member();

						// echo $this->db->last_query();
						// exit;
						$this->session->set_flashdata('evaluation_success_insert', 'Evaluation Factor Successfully Inserted');
						redirect('rating/lead_to_member');		
					}
				}
			}

			// Delete Evaluation lthr
			public function delete_lead_to_member($factor_id,$category_id){
				// Check login
				if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
				$this->load->model('factor_model');

				$this->factor_model->delete_lead_to_member($factor_id,$category_id);

				// Set message
				$this->session->set_flashdata('evaluation_success_delete', 'Evaluation has been Successfully Deleted');

				redirect('rating/lead_to_member');
			}
/*
*****************************************************
	Factors Evaluation for mtl (Member to Lead)
*****************************************************
*/
			// Add Evaluation Team Lead to Member
			public function member_to_lead(){
			// Check login
				if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
			$data['title'] = 'Add Evaluation Factor (Team Lead To Member)';

			

			$this->form_validation->set_rules('category_name', 'Category', 'required');
			$this->form_validation->set_rules('factor_description', 'Factor Description', 'required');
			
            $factor_id   = $this->input->post("factor_id");
            $category_id = $this->input->post("category_id");
             

			$data['factors_list'] = $this->rating_model->mtl_get_factors();
			$data['factors_row'] = $this->rating_model->mtl_get_factors_by_id($factor_id);
			


			if(!empty($factor_id)){
            	 // Check Form Validation
				if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('factors/member_to_lead', $data);
				$this->load->view('templates/footer');

				} else {
					// Update Evaluation Factor
					$this->factor_model->update_member_to_lead($factor_id,$category_id);
					
             	    $this->session->set_flashdata('evaluation_success_edit', 'Evaluation Factor Successfully Edited');
					redirect('rating/member_to_lead');		
				}
                    	   
            }
            else{
	         	// Check Form Validation
				if($this->form_validation->run() === FALSE){
					$this->load->view('templates/header');
					$this->load->view('factors/member_to_lead', $data);
					$this->load->view('templates/footer');

				} else {
						// Insert Evaluation Factor
						$this->factor_model->update_member_to_lead();

						// echo $this->db->last_query();
						// exit;
						$this->session->set_flashdata('evaluation_success_insert', 'Evaluation Factor Successfully Inserted');
						redirect('rating/member_to_lead');		
					}
				}
			}

			// Delete Evaluation lthr
			public function delete_member_to_lead($factor_id,$category_id){
				// Check login
				if(!$this->session->userdata('logged_in')){
					redirect('users/login');
				}
				$this->load->model('factor_model');

				$this->factor_model->delete_member_to_lead($factor_id,$category_id);

				// Set message
				$this->session->set_flashdata('evaluation_success_delete', 'Evaluation has been Successfully Deleted');

				redirect('rating/member_to_lead');
			}
	}