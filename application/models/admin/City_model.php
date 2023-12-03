<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        date_default_timezone_set('UTC');
		// $this->tableName = "city";
	}
	
	function get_active_city_list()
	{
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.city_id, a.city_name, a.status, a.created_date, a.modified_date, b.state_name as state_name',false);
		$this->db->from('city as a');
		$this->db->join('state as b','a.state_id = b.state_id','inner');
		$this->db->where('a.flag','0');
		$this->db->where('a.status','1');
		$this->db->join("state as s","s.state_id = a.state_id");
		$this->db->where('s.status','1');
		return array("data"=>$query->get()->result_array());
	}
	function get_city_list()
	{

		$search_word 	= 	$this->input->post('search')['value'];
		$coloum_index = 	$this->input->post('order')[0]['column'];
		//$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['city_name'];
		$order_by 		= 	$this->input->post('order')[0]['dir'];
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.city_id, a.city_name, a.status, a.created_date, a.modified_date, b.state_name as state_name',false);
		$this->db->from('city as a');
		$this->db->join('state as b','a.state_id = b.state_id','inner');
		$this->db->where('a.flag','0');
		//Hamid commented
		// $this->db->where('a.status','1');
		if($search_word != '')
		{
			$query->like('a.city_name',$search_word);
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


	function city_delete()
	{
		$city_id = $this->input->post('city_id');
		$updatetArray = array(
				'flag' 	=> 1,
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('city_id',$city_id);
		$this->db->update('city',$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'City Deleted Successfully'
							)
						);
	}
	function city_by_state_id($state_id)
	{
		// $state_id = $this->uri->segment(4);
		//$state_id = $this->input->get('id');
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.city_id, a.city_name, a.status, a.created_date, a.modified_date',false);
		$this->db->from('city as a');
		$this->db->where('a.state_id',$state_id);
		$this->db->where('a.flag','0');
		$this->db->where('a.status','1');
		$result = $query->get()->result_array();
		$data = array();
		$data['data'] = $result;
		return $data;
		// echo json_encode($data);
	}

	public function save_city()
	{
		$city_name = $this->input->post("city_name");
		$error=0;
		$errorTxt='';
		if(addslashes($city_name)=='')
		{ $error++; $errorTxt.='Please Enter City Name';}

		if($error==0)
		{
			if($this->input->post("id")	== 0 || $this->input->post("id") == '')
			{

				$query = $this->db->where("city_name",$city_name)
									->where("status","1")
									    ->where("flag","0")
											->get("city")
												->num_rows();



				if($query == 0)
				{
					$insertArray = array(
						'city_name' 	=> $city_name,
						'state_id'		=> $this->input->post('state_id'),
						'status'		=> $this->input->post("status"),
						'added_by'	    => 'administrator',
						'created_date'	=> date('Y-m-d H:i:s'),
						'modified_date'	=> date('Y-m-d H:i:s')
					);

					$this->db->insert('city',$insertArray);
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'City Added Successfully '));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'City Already Exist'));
				}
			}
			else
			{
				$updatetArray = array(
						'city_name' => $city_name,
						'state_id'		=> $this->input->post('state_id'),
						'status'		=> $this->input->post("status"),
						'added_by'	    => 'administrator',
						'modified_date'	=> date('Y-m-d H:i:s')
					);
				$this->db->where('city_id',$this->input->post('id'));
				$this->db->update('city',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'City Updated Successfully '));
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}

	function city_edit()
	{
		$city_id = $this->input->post('city_id');
		$query = $this->db->select("*");
		$this->db->from('city');
		$this->db->where("city_id",$city_id);
		$result = $query->get()->result_array();
		//echo $this->db->last_query();exit;
		$response 	= array(
			'city_id' 	=> $result[0]["city_id"],
			'city_name' => $result[0]["city_name"],
			'state_id'  => $result[0]["state_id"],
			'status'	=> $result[0]["status"]
		);
		return $response;
	}

	function get_state()
	{
		$query = $this->db->select("a.state_id, a.state_name");
		$this->db->from('state as a');
		$this->db->where("a.flag",'0');
		//hamid Commented
		// $this->db->where("a.status",'1');
		$response = $query->get()->result_array();
		return $response;
	}
}
