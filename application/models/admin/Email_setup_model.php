<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_setup_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
        date_default_timezone_set('UTC');
		$this->load->model('standard_database_model');
    }

	public function save_email_setup()
	{
		$error=0;
		$errorTxt='';
		if($error==0)
		{
			if($this->input->post("id")	== 0 || $this->input->post("id") == '')
			{
				
				$query = $this->db->where("support",$this->input->post("support"))
									->get("email_setup")
										->num_rows();
				if($query == 0)
				{
					$insertArray = array(
						'support' 				=> $this->input->post("support"),	
						'status'				=> '1',
						'user_id'				=> $this->session->userdata('user_id'),
						'created_date'			=> date('Y-m-d H:i:s'),
						'modified_date'			=> date('Y-m-d H:i:s')
					);

					$this->db->insert('email_setup',$insertArray);
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'Contact Form Email Setup Added Successfully '));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'Contact Form Email Setup Already Exist'));
				}
			}
			else
			{
				$updatetArray = array(
					'support' 				=> $this->input->post("support"),	
					'user_id'				=> $this->session->userdata('user_id'),
					'modified_date'			=> date('Y-m-d H:i:s')
				);
				$this->db->where('id',$this->input->post('id'));
				$this->db->update('email_setup',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Contact Form Email Setup Updated Successfully '));				
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}

	function email_setup_edit()
	{
		$query = $this->db->select("*");
		$this->db->from('email_setup');
		$this->db->limit(0,1);
		$result = $query->get()->result_array();
		$response 	= array(
			'id' 			=> $result[0]["id"],	
			'support' 		=> $result[0]["support"],	
		);
		return $response;
	}
}