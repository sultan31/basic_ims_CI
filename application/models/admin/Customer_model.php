<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		date_default_timezone_set('UTC');
		$this->tableName = "customer";
    }

	function get_customer_list()
	{

		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		//$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['customer_name'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.*,b.username',false);
		$this->db->from($this->tableName.' as a');
		$this->db->join('users as b','a.added_by = b.username', 'inner');
		$this->db->where('a.flag','0');
		if($search_word != '')
		{
			$query->like('a.name',$search_word);
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


	function customer_delete()
	{
		$id = $this->input->post('id');
		$updatetArray = array(
				'flag' 	=> 1,
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('cust_id',$this->input->post('id'));
		$this->db->update($this->tableName,$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'customer Deleted Successfully'
							)
						);
	}

	public function save_customer()
	{
		$name = $this->input->post("name");
		$phone = $this->input->post("phone");
		$email = $this->input->post("email");
		$error=0;
		$errorTxt='';
		if(addslashes($name)=='') 
		{ $error++; $errorTxt.='Please Enter customer Name';}
		
		if(addslashes($phone)=='') 
		{ $error++; $errorTxt.='Please Enter customer phone Number';}

		if(addslashes($email)=='') 
		{ $error++; $errorTxt.='Please Enter customer email';}

		if($error==0)
		{
			if($this->input->post("id")	== 0 || $this->input->post("id") == '')
			{
				
				$query = $this->db->where("phone",$phone)
									->where("status","1")
									    ->where("flag","0")
											->get($this->tableName)
												->num_rows();


				if($query == 0)
				{
					$insertArray = array(
						'name' => $name,
						'phone' => $phone,
						'email' => $email,
						'status' => $this->input->post("status"),
						'added_by' => 'administrator',
						'created_date' => date('Y-m-d H:i:s'),
						'modified_date'	=> date('Y-m-d H:i:s')
					);
					
					$this->db->insert('customer',$insertArray);
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'customer Added Successfully '));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'customer Already Exist'));
				}
			}
			else
			{
				$updatetArray = array(
						'name' => $name,
						'phone' => $phone,
						'email' => $email,
						'status'		=> $this->input->post("status"),
						'added_by'	    => 'administrator',
						'modified_date'	=> date('Y-m-d H:i:s')
					);
				
				$this->db->where('cust_id',$this->input->post('id'));
				$this->db->update($this->tableName,$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'customer Updated Successfully '));				
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}

	function customer_edit()
	{
		$id = $this->input->post('id');
		$query = $this->db->select("*");
		$this->db->from($this->tableName);
		$this->db->where("cust_id",$id);
		$result = $query->get()->result_array();
		$response 	= array(
			'cust_id'   => $result[0]["cust_id"],
			'name' => $result[0]["name"],
			'phone' => $result[0]["phone"],
			'email' => $result[0]["email"],
			'status'=> $result[0]["status"]
		);

		return $response;
	}
}
