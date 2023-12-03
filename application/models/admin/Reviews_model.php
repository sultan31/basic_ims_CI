<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reviews_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function get_reviews_list()
	{
		
		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['name'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.review_id, a.review, a.reviewer_name, b.store_name ,a.created_date, a.ip_address',false);
		$this->db->from('reviews as a');
		$this->db->join('store as b','a.store_id = b.store_id','inner');
		$this->db->where('a.flag','0');
		$this->db->where('a.status','1');
		if($this->input->post('startDate') && $this->input->post('endDate')){
			$startDate = $this->input->post('startDate');
			$endDate = $this->input->post('endDate');
			$this->db->where('DATE_FORMAT(a.created_date,"%Y-%m-%d") >=',$startDate);
			$this->db->where('DATE_FORMAT(a.created_date,"%Y-%m-%d") <=',$endDate);
		}
		
		if($search_word != '')
		{
			$query->like('a.review',$search_word);
			$query->like('a.reviewer_name',$search_word);
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

	function reviews_delete()
	{
		$review_id = $this->input->post('review_id');
		
		$updatetArray = array(
				'flag' 			=> '1',
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('review_id',$review_id);
		$this->db->update('reviews',$updatetArray);
		//echo $this->db->last_query();exit;
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'Review Deleted Successfully'
							)
						);
	}
	
	function reviews_view()
	{
		$review_id = $this->input->post('review_id');
		$query = $this->db->select("a.*,b.store_name");
		$this->db->from('reviews as a');
		$this->db->join('store as b','a.store_id = b.store_id','inner');
		$this->db->where('a.flag','0');
		$this->db->where("a.review_id",$review_id);
		$result = $query->get()->result_array();
		
		$response 	= array(
			'review' 	    => $result[0]["review"],
			'store_name'    => $result[0]["store_name"],
			'reviewer_name' => $result[0]["reviewer_name"],
		);

		return $response;
	}
	
	function reviews_add($insertArray)
	{
		$this->db->insert('reviews',$insertArray);
		$id = $this->db->insert_id();
		//echo $id;exit;
		if($id)
		{
		   echo json_encode(array('success' => true, 'message' => 'Thanks For Review'));	
		}
	}
	
}