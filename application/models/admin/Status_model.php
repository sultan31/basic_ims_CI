<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Status_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
        date_default_timezone_set('UTC');
		$this->load->model('standard_database_model');
    }

	function get_status_list()
	{
		
		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['name'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.*,b.username',false);
		$this->db->from('status as a');
		$this->db->join('admin_user as b','a.user_id = b.id', 'inner');
		$this->db->where('a.flag','0');
		if($search_word != '')
		{
			$query->like('name',$search_word);
		}

		if($this->input->post('start')!="" && $this->input->post('length')!="-1")
		{
			$query->limit($this->input->post('length'),$this->input->post('start'));
		}

		if($order_by!="")
		{
			$query->order_by($order_by_column,$order_by);
		}

		$result 					= 	$query->get()->result_array();
		//echo $this->db->last_query();
		$query 						= 	$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$total_rows 				= 	$query->row()->Count;

		$data['draw'] 				= 	$this->input->get('draw');
		$data['recordsTotal'] 		= 	$total_rows;
		$data['recordsFiltered'] 	= 	$total_rows;
		$data['data'] 				= 	$result;

		return $data;
	}

	function status_delete()
	{
		$id = $this->input->post('id');
		$updatetArray = array(
				'flag' 	=> 1,
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('status',$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'Status Deleted Successfully'
							)
						);
	}

	public function save_status()
	{
		$error=0;
		$errorTxt='';
		if(addslashes($this->input->post("name"))=='') 
		{ $error++; $errorTxt.='Please Enter Status Name';}
		
		if($error==0)
		{
			if($this->input->post("id")	== 0 || $this->input->post("id") == '')
			{
				
				$query = $this->db->where("name",$this->input->post("name"))
									->where("status","1")
									    ->where("flag","0")
											->get("status")
												->num_rows();


				if($query == 0)
				{
					$insertArray = array(
						'name' 							=> $this->input->post("name"),	
						'status'						=> $this->input->post("status"),
						'user_id'						=> $this->session->userdata('user_id'),
						'created_date'					=> date('Y-m-d H:i:s'),
						'modified_date'					=> date('Y-m-d H:i:s')
					);

					$this->db->insert('status',$insertArray);
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'Status Added Successfully '));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'Status Already Exist'));
				}
			}
			else
			{
				$updatetArray = array(
					'name' 							=> $this->input->post("name"),	
					'status'						=> $this->input->post("status"),
					'user_id'						=> $this->session->userdata('user_id'),
					'modified_date'					=> date('Y-m-d H:i:s')
				);
				$this->db->where('id',$this->input->post('id'));
				$this->db->update('status',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Status Updated Successfully '));				
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}

	function status_edit()
	{
		$id = $this->input->post('id');
		$query = $this->db->select("*");
		$this->db->from('status');
		$this->db->where("id",$id);
		$result = $query->get()->result_array();
		$response 	= array(
			'id' 							=> $result[0]["id"],	
			'name' 							=> $result[0]["name"],	
			'status'						=> $result[0]["status"]
		);

		return $response;
	}	
}