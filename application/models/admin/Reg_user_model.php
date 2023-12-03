<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reg_user_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('standard_database_model');
    }

	function get_reg_user_list()
	{
		
		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['name'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.id, a.fname, a.lname, a.email, a.mobile, a.created_date, a.ip_address',false);
		$this->db->from('user as a');
		$this->db->where('a.flag','0');
		if($this->input->post('startDate') && $this->input->post('endDate')){
			$startDate = $this->input->post('startDate');
			$endDate = $this->input->post('endDate');
			$this->db->where('DATE_FORMAT(a.created_date,"%Y-%m-%d") >=',$startDate);
			$this->db->where('DATE_FORMAT(a.created_date,"%Y-%m-%d") <=',$endDate);
		}
		
		if($search_word != '')
		{
			$query->like('a.name',$search_word);
			$query->or_like('a.mobile',$search_word);
			$query->or_like('a.email',$search_word);
			$query->or_like('a.ip_address',$search_word);
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

	function reg_user_delete()
	{
		$id = $this->input->post('id');
		$updatetArray = array(
				'flag' 			=> 1,
				'user_id' 		=> $this->session->userdata('user_id'),
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('user',$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'Registered User Deleted Successfully'
							)
						);
	}
	
	function reg_user_view()
	{
		$id = $this->input->post('id');
		$query = $this->db->select("a.*");
		$this->db->from('user as a');
		$this->db->where('a.flag','0');
		$this->db->where("a.id",$id);
		$result = $query->get()->result_array();
		$response 	= array(
			'fname' 				=> $result[0]["fname"],
			'lname' 				=> $result[0]["lname"],
			'email'					=> $result[0]["email"],
			'mobile'				=> $result[0]["mobile"],
			'address1'				=> $result[0]["address1"],
			'address2'				=> $result[0]["address2"],
			'city'					=> $result[0]["city"],
			'state'					=> $result[0]["state"],
			'country'				=> $result[0]["country"],
			'pincode'				=> $result[0]["pincode"],
			'company'				=> $result[0]["company"]
		);

		return $response;
	}
}