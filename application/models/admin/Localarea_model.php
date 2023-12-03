<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Localarea_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        date_default_timezone_set('UTC');
		// $this->tableName = "area";
    }

	function get_localarea_list()
	{

		$search_word 	= 	$this->input->post('search')['value'];
		$coloum_index 	= 	$this->input->post('order')[0]['column'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.*,b.username',false);
		$this->db->from('area as a');
		$this->db->join('users as b','a.added_by = b.username', 'inner');
		$this->db->where('a.flag','0');
		if($search_word != '')
		{
			$query->like('a.area_name',$search_word);
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

	function localarea_delete()
	{
		$id = $this->input->post('id');
		$updatetArray = array(
				'flag' 	=> 1,
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('area_id',$this->input->post('id'));
		$this->db->update($this->tableName,$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'Area Deleted Successfully'
							)
						);
	}

	public function save_localarea()
	{
		$area_name = $this->input->post("area_name");
    $city_id = $this->input->post("city_id");
    $pincode = $this->input->post("pincode");
		$error=0;
		$errorTxt='';
		if(addslashes($area_name)=='')
		{ $error++; $errorTxt.='Please Enter area Name';}

		if($error==0)
		{
			if($this->input->post("id")	== 0 || $this->input->post("id") == '')
			{

        $query = $this->db->where("area_name",$area_name)
                                ->where("pincode",$pincode)
                                    ->where("status","1")
                                        ->where("flag","0")
                                            ->get($this->tableName)
                                                ->num_rows();

				if($query == 0)
				{
					$insertArray = array(
                        'area_name'     => $area_name,
                        'pincode'       => $pincode,
                        'city_id'       => $city_id,
												'status'				=> $this->input->post("status"),
												'added_by'	    => 'administrator',
												'created_date'	=> date('Y-m-d H:i:s'),
												'modified_date'	=> date('Y-m-d H:i:s')
											);

					$this->db->insert($this->tableName , $insertArray);
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'Area Added Successfully '));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'Area Already Exist'));
				}
			}
			else
			{
				$updatetArray = array(
                        'area_name'     => $area_name,
                        'pincode'       => $pincode,
                        'city_id'       => $city_id,
						'status'		=> $this->input->post("status"),
						'added_by'	    => 'administrator',
						'modified_date'	=> date('Y-m-d H:i:s')
									);

				$this->db->where('area_id',$this->input->post('id'));
				$this->db->update($this->tableName,$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Area Updated Successfully '));
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}
	
	public function get_area_list()
	{
		$query = $this->db->select('*');
		$this->db->from($this->tableName);
		$this->db->where('flag','0');
		$this->db->where('status','1');		
		$result = $query->get()->result_array();
		return array("data"=>$result);
	
	}
	public function localarea_by_city_id($city_id)
	{
		$query = $this->db->select('*');
		$this->db->from($this->tableName);
		$this->db->where('flag','0');
		$this->db->where('status','1');				
		$this->db->where('city_id',$city_id);
		$result = $query->get()->result_array();
		return array("data"=>$result);
	}

	function localarea_edit()
	{
		$id = $this->input->post('id');
		//Hamid altered
		$query = $this->db->select("a.* , c.city_id,c.state_id");
		$this->db->from($this->tableName." as a");
		$this->db->join('city as c','a.city_id = c.city_id', 'inner');
		$this->db->where("area_id",$id);
		$result = $query->get()->result_array();
		$response 	= array(
			'area_id'   => $result[0]["area_id"],
			'area_name' => $result[0]["area_name"],
			'pincode' => $result[0]["pincode"],
			'city_id' => $result[0]["city_id"],
			'state_id' => $result[0]["state_id"],
			'status'	=> $result[0]["status"]
		);

		return $response;
	}
	
	function get_state()
	{
		$query = $this->db->select("a.state_id, a.state_name");
		$this->db->from('state as a');
		$this->db->where("a.flag",'0');
		// $this->db->where("a.status",'1');
		$response = $query->get()->result_array();
		return $response;
	}
	
	function get_city_by_state()
	{
		$state_id = $this->uri->segment(4);
		$query = $this->db->select("a.city_id, a.city_name");
		$this->db->from('city as a');
		$this->db->where("a.flag",'0');
		// $this->db->where("a.status",'1');
		$this->db->where("a.state_id",$state_id);
		$response = $query->get()->result_array();
		return $response;
	}
}
