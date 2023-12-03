<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_queries_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
        $this->load->model('standard_database_model');
    }

	function get_contact_query_list()
	{
		
		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['name'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.id, a.name, a.email, a.mobile, SUBSTRING(a.message, 1, 100) as message, a.created_date, a.ip_address',false);
		$this->db->from('queries as a');
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
			$query->or_like('a.message',$search_word);
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

	function contact_query_delete()
	{
		$id = $this->input->post('id');
		$updatetArray = array(
				'flag' 			=> 1,
				'user_id' 		=> $this->session->userdata('user_id'),
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('queries',$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'Contact Query Deleted Successfully'
							)
						);
	}
	
	function contact_query_view()
	{
		$id = $this->input->post('id');
		$query = $this->db->select("a.*");
		$this->db->from('queries as a');
		$this->db->where('a.flag','0');
		$this->db->where("a.id",$id);
		$result = $query->get()->result_array();
		$response 	= array(
			'name' 			=> $result[0]["name"],
			'email'					=> $result[0]["email"],
			'mobile'				=> $result[0]["mobile"],
			'message'				=> $result[0]["message"]	
		);

		return $response;
	}
}