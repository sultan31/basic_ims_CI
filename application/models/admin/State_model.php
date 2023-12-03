<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class State_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        date_default_timezone_set('UTC');
    }


	function get_active_state_list()
	{
		$query = $this->db->select("*");
		$this->db->from('state');
		$this->db->where('status','1');
		return array("data"=> $query->get()->result_array());
	}
	function get_state_list()
	{

		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		//$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['state_name'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.*',false);
		$this->db->from('state as a');
		// $this->db->join('users as b','a.added_by = b.username', 'inner');
		$this->db->where('a.flag','0');
		if($search_word != '')
		{
			$query->like('a.state_name',$search_word);
		}

		if($this->input->post('start')!="" && $this->input->post('length')!="-1")
		{
			$query->limit($this->input->post('length'),$this->input->post('start'));
		}

		/*if($order_by!="")
		{
			$query->order_by($order_by_column,$order_by);
		}*/

		$result = $query->get()->result_array();
		//echo $this->db->last_query();exit;
		$query 						= 	$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$total_rows 				= 	$query->row()->Count;

		$data['draw'] 				= 	$this->input->get('draw');
		$data['recordsTotal'] 		= 	$total_rows;
		$data['recordsFiltered'] 	= 	$total_rows;
		$data['data'] 				= 	$result;

		return $data;
	}


	function state_delete()
	{
		$id = $this->input->post('id');
		$updatetArray = array(
				'flag' 	=> 1,
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('state_id',$this->input->post('id'));
		$this->db->update('state',$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'State Deleted Successfully'
							)
						);
	}

	public function save_state()
	{
		$state_name = $this->input->post("state_name");

		$error=0;
		$errorTxt='';
		if(addslashes($state_name)=='')
		{ $error++; $errorTxt.='Please Enter State Name';}

		if($error==0)
		{
			if($this->input->post("id")	== 0 || $this->input->post("id") == '')
			{

				$query = $this->db->where("state_name",$state_name)
									->where("status","1")
									    ->where("flag","0")
											->get("state")
												->num_rows();


				if($query == 0)
				{
					$insertArray = array(
						'state_name' => $state_name,
						'status'		=> $this->input->post("status"),
						'added_by'	    => 'administrator',
						'created_date'	=> date('Y-m-d H:i:s'),
						'modified_date'	=> date('Y-m-d H:i:s')
					);

					$this->db->insert('state',$insertArray);
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'State Added Successfully '));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'State Already Exist'));
				}
			}
			else
			{
				$updatetArray = array(
						'state_name' => $state_name,
						'status'		=> $this->input->post("status"),
						'added_by'	    => 'administrator',
						'modified_date'	=> date('Y-m-d H:i:s')
					);

				$this->db->where('state_id',$this->input->post('id'));
				$this->db->update('state',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'State Updated Successfully '));
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}

	function state_edit()
	{
		$id = $this->input->post('id');
		$query = $this->db->select("*");
		$this->db->from('state');
		$this->db->where("state_id",$id);
		$result = $query->get()->result_array();
		//echo $this->db->last_query();exit;
		$response 	= array(
			'state_id'   => $result[0]["state_id"],
			'state_name' => $result[0]["state_name"],
			'status'		=> $result[0]["status"]
		);

		return $response;
	}
	public function get_area_ids($city_id)
	{
		$query = $this->db->select("n.area_id");
		$this->db->from('state as s');
		$this->db->join("city as n","s.state_id = s.state_id");
		$this->db->where("n.city_id",$city_id);
		$result = $query->get()->result_array();
		$result_array = array();
		foreach($result as $key => $value){
			array_push($result_array,$value);
		}
		return $result_array;
	}
}
