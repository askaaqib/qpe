<?php
	class Factor_model extends CI_Model{
		
		public function register($enc_password){
			// User data array
			$data = array(
				'Firstname' => $this->input->post('firstname'),
				'Lastname' => $this->input->post('lastname'),
				'Email' => $this->input->post('email'),
                'Designation' => $this->input->post('designation'),
                'password' => $enc_password
			);

			// Insert user
			return $this->db->insert('user', $data);
		}

		// Add Evaluation Factors and Edit Evaluation Factor (Team Lead To HR)
		public function update_lead_to_hr($factor_id=0,$cat_id=0){
			// Insert The Evaluation Factor

			if(empty($factor_id) || $factor_id=0 || empty($cat_id) || $cat_id=0){
				// Category data array

				$data_category = array(
					'tlhr_cat_name' => $this->input->post('category_name'),
				);
				
				$this->db->set('tlhr_cat_created', 'NOW()', FALSE);
				$this->db->set('tlhr_cat_modified', 'NOW()', FALSE);
				// Insert Category
				$result =  $this->db->insert('tlhr_categories', $data_category);
				
				$insert_id = $this->db->insert_id();

				// Check If Category inserted
				if($insert_id){
					// Category data array
					$data_factors = array(
						'tlhr_eval_description' => $this->input->post('factor_description'),
						'tlhr_eval_cat' => $insert_id,
					);
					$this->db->set('tlhr_eval_created', 'NOW()', FALSE);
					$this->db->set('tlhr_eval_modified', 'NOW()', FALSE);
				// Insert Factors
				$result =  $this->db->insert('tlhr_eval_factors', $data_factors);
				return $result;	

				}
			}
			// Update The Evaluation Factor
			else{
				
				$data_factors = array(
					'tlhr_eval_description' => $this->input->post('factor_description'),
				);
				$this->db->set('tlhr_eval_modified', 'NOW()', FALSE);

                $data_cat_factors = array(
					'tlhr_cat_name' => $this->input->post('category_name'),
				);
				
 				$factor_id   = $this->input->post("factor_id");
            	$cat_id = $this->input->post("category_id");

				$this->db->where('tlhr_eval_fact_id', $factor_id);
				$this->db->where('tlhr_eval_cat', $cat_id);
                
                if($this->db->update('tlhr_eval_factors', $data_factors)){
	          		$this->db->set('tlhr_cat_modified', 'NOW()', FALSE);
			        $this->db->where('tlhr_cat_id', $cat_id);
			        $this->db->update('tlhr_categories', $data_cat_factors);
                }
			}
		}

		// Delete Evaluation Factor ( Team  Lead To H.R)
		public function delete_lead_to_hr($factor_id,$cat_id){
			$this->db->where('tlhr_eval_fact_id', $cat_id);
			if($this->db->delete('tlhr_eval_factors')){
				$this->db->where('tlhr_cat_id', $cat_id);
				$this->db->delete('tlhr_categories');
				return true;	
			}
			
		}

		// Add Evaluation Factors and Edit Evaluation Factor (Team Lead To Member)
		public function update_lead_to_member($factor_id=0,$cat_id=0){
			// Insert The Evaluation Factor

			if(empty($factor_id) || $factor_id=0 || empty($cat_id) || $cat_id=0){
				// Category data array

				$data_category = array(
					'tlm_cat_name' => $this->input->post('category_name'),
				);
				
				$this->db->set('tlm_cat_created', 'NOW()', FALSE);
				$this->db->set('tlm_cat_modified', 'NOW()', FALSE);
				// Insert Category
				$result =  $this->db->insert('tlm_categories', $data_category);
				
				$insert_id = $this->db->insert_id();

				// Check If Category inserted
				if($insert_id){
					// Category data array
					$data_factors = array(
						'tlm_eval_description' => $this->input->post('factor_description'),
						'tlm_eval_cat' => $insert_id,
					);
					$this->db->set('tlm_eval_created', 'NOW()', FALSE);
					$this->db->set('tlm_eval_modified', 'NOW()', FALSE);
				// Insert Factors
				$result =  $this->db->insert('tlm_eval_factors', $data_factors);
				return $result;	

				}
			}
			// Update The Evaluation Factor
			else{
				
				$data_factors = array(
					'tlm_eval_description' => $this->input->post('factor_description'),
				);
				$this->db->set('tlm_eval_modified', 'NOW()', FALSE);

                $data_cat_factors = array(
					'tlm_cat_name' => $this->input->post('category_name'),
				);
				
 				$factor_id   = $this->input->post("factor_id");
            	$cat_id = $this->input->post("category_id");

				$this->db->where('tlm_eval_fact_id', $factor_id);
				$this->db->where('tlm_eval_cat', $cat_id);
                
                if($this->db->update('tlm_eval_factors', $data_factors)){
	          		$this->db->set('tlm_cat_modified', 'NOW()', FALSE);
			        $this->db->where('tlm_cat_id', $cat_id);
			        $this->db->update('tlm_categories', $data_cat_factors);
                }
			}
		}


		// Delete Evaluation Factor ( Team  Lead To Member)
		public function delete_lead_to_member($factor_id,$cat_id){
			$this->db->where('tlm_eval_fact_id', $cat_id);
			if($this->db->delete('tlm_eval_factors')){
				$this->db->where('tlm_cat_id', $cat_id);
				$this->db->delete('tlm_categories');
				return true;	
			}
			
		}

		// Add Evaluation Factors and Edit Evaluation Factor (Member to Team Lead)
		public function update_member_to_lead($factor_id=0,$cat_id=0){
			// Insert The Evaluation Factor

			if(empty($factor_id) || $factor_id=0 || empty($cat_id) || $cat_id=0){
				// Category data array

				$data_category = array(
					'mtl_cat_name' => $this->input->post('category_name'),
				);
				
				$this->db->set('mtl_cat_created', 'NOW()', FALSE);
				$this->db->set('mtl_cat_modified', 'NOW()', FALSE);
				// Insert Category
				$result =  $this->db->insert('mtl_categories', $data_category);
				
				$insert_id = $this->db->insert_id();

				// Check If Category inserted
				if($insert_id){
					// Category data array
					$data_factors = array(
						'mtl_eval_description' => $this->input->post('factor_description'),
						'mtl_eval_cat' => $insert_id,
					);
					$this->db->set('mtl_eval_created', 'NOW()', FALSE);
					$this->db->set('mtl_eval_modified', 'NOW()', FALSE);
				// Insert Factors
				$result =  $this->db->insert('mtl_eval_factors', $data_factors);
				return $result;	

				}
			}
			// Update The Evaluation Factor
			else{
				
				$data_factors = array(
					'mtl_eval_description' => $this->input->post('factor_description'),
				);
				$this->db->set('mtl_eval_modified', 'NOW()', FALSE);

                $data_cat_factors = array(
					'mtl_cat_name' => $this->input->post('category_name'),
				);
				
 				$factor_id   = $this->input->post("factor_id");
            	$cat_id = $this->input->post("category_id");

				$this->db->where('mtl_eval_fact_id', $factor_id);
				$this->db->where('mtl_eval_cat', $cat_id);
                
                if($this->db->update('mtl_eval_factors', $data_factors)){
	          		$this->db->set('mtl_cat_modified', 'NOW()', FALSE);
			        $this->db->where('mtl_cat_id', $cat_id);
			        $this->db->update('mtl_categories', $data_cat_factors);
                }
			}
		}


		// Delete Evaluation Factor ( Member To Team Lead )
		public function delete_member_to_lead($factor_id,$cat_id){
			$this->db->where('mtl_eval_fact_id', $cat_id);
			if($this->db->delete('mtl_eval_factors')){
				$this->db->where('mtl_cat_id', $cat_id);
				$this->db->delete('mtl_categories');
				return true;	
			}
			
		}

}