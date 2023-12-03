<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Store_details_model extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
    }

	function get_store_list()
	{
		
		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['name'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.store_id, a.store_name, a.store_logo, a.status,  SUBSTRING(a.description, 1, 100) as description, SUBSTRING(a.specification,1,100) as specification, b.category_name as category, c.name as customer, d.area_name as area',false);
		$this->db->from('store as a');
		$this->db->join('category as b','b.category_id = a.category_id', 'left');
		$this->db->join('customer as c','c.cust_id = a.cust_id', 'left');
		$this->db->join('area as d','d.area_id = a.area_id', 'left');
		$this->db->where('a.flag','0');
		if($search_word != '')
		{
			$query->like('a.description',$search_word);
			$query->or_like('a.store_name',$search_word);
			$query->or_like('a.specification',$search_word);
			$query->or_like('b.category_name',$search_word);
			$query->or_like('c.name',$search_word);
			$query->or_like('d.area_name',$search_word);
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

	function store_delete()
	{
		$store_id = $this->input->post('store_id');
		$updatetArray = array(
				'flag' 	=> 1,
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('store_id',$store_id);
		$this->db->update('store',$updatetArray);
		echo json_encode(array('success'=>true,'message'=>'Store Deleted Successfully'));
	}

	function save_basic_form()
	{
		//print_r($this->input->post());exit;
		$error=0;
		$errorTxt='';
		if(addslashes($this->input->post("store_name"))=='') 
		{ $error++; $errorTxt.='Please Enter Store Name';}
		
		if($error==0)
		{
			if($this->input->post("b_store_id")	== 0 || $this->input->post("b_store_id") == '')
			{
				
				$query = $this->db->where("store_name",$this->input->post("store_name"))
									->where("flag","0")
										->get("store")
											->num_rows();

				if($query == 0)
				{
					$insertArray = array(
						'store_name' 			=> $this->input->post("store_name"),
						'cust_id' 				=> $this->input->post("cust_id"),
						'category_id' 			=> $this->input->post("category_id"),
						'area_id' 				=> $this->input->post("area_id"),
						'status'				=> $this->input->post("status"),
						'added_by'				=> 'administrator',
						'created_date'			=> date('Y-m-d H:i:s'),
						'modified_date'			=> date('Y-m-d H:i:s')
					);
					
					if(!$this->upload->do_upload('store_logo'))
					{
						$error = array('success'=>false,'message' => $this->upload->display_errors());
						echo json_encode($error);
					}
					else
					{
						$upload_data = $this->upload->data();
						$insertArray['store_logo'] = $upload_data["file_name"];
					}
					$this->db->insert('store',$insertArray);
			
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'Store Added Successfully ', 'store_id'=>$id));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'Store Already Exist'));
				}
			}
			else
			{
				$updatetArray = array(
						'store_name' 			=> $this->input->post("store_name"),
						'cust_id' 				=> $this->input->post("cust_id"),
						'category_id' 			=> $this->input->post("category_id"),
						'area_id' 				=> $this->input->post("area_id"),
						'status'				=> $this->input->post("status"),
						'added_by'				=> 'administrator',
						'created_date'			=> date('Y-m-d H:i:s'),
						'modified_date'			=> date('Y-m-d H:i:s')
						);
				
				if($this->upload->do_upload('store_logo'))
				{
					$upload_data = $this->upload->data();
					$updatetArray['store_logo'] = $upload_data["file_name"];
							
				}
				$this->db->where('store_id',$this->input->post("b_store_id"));
				$this->db->update('store',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Basic Details Updated Successfully', 'store_id'=> $this->input->post("b_store_id")));				
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}
	
	public function save_details_form()
	{	
		$error=0;
		$errorTxt='';
		if(addslashes($this->input->post("description"))=='') 
		{ $error++; $errorTxt.='Please Enter Description';}
		
		if($error==0)
		{
			if($this->input->post("d_store_id")	== 0 || $this->input->post("d_store_id") == '')
			{
				echo json_encode(array('success'=>false,'message'=>'Unauthorized Access'));
			}
			else
			{
				$updatetArray = array(
					'description' 	=> $this->input->post("description"),
					'specification' => $this->input->post("specification"),
					'added_by'		=> 'administrator',
					'modified_date'	=> date('Y-m-d H:i:s')
				);
				
				$this->db->where('store_id',$this->input->post("d_store_id"));
				$this->db->update('store',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Details Info Added / Updated Successfully', 'store_id'=> $this->input->post("d_store_id")));				
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}
	

	public function save_image_form()
	{
		$error=0;
		$errorTxt='';
		if(addslashes($this->input->post("image_desc"))=='') 
		{ $error++; $errorTxt.='Please Enter Image Description';}
		if($this->input->post("i_store_id")	== 0 || $this->input->post("i_store_id") == '') 
		{ $error++; $errorTxt.='Some thing is wrong. Please Refresh Page.';}
		
		if($error==0)
		{
			if($this->input->post("image_id")	== 0 || $this->input->post("image_id") == '')
			{
				$query = 0;
				if($query == 0)
				{
					$insertArray = array(
						'store_id' 	    => $this->input->post("i_store_id"),
						'image_desc' 	=> $this->input->post("image_desc"),
						'status'	    => $this->input->post("img_status"),
						'added_by'		=> 'administrator',
						'created_date'	=> date('Y-m-d H:i:s'),
						'modified_date'	=> date('Y-m-d H:i:s')
					);
					
					if(!$this->upload->do_upload('image_name'))
					{
						$error = array('success'=>false,'message' => $this->upload->display_errors());
						echo json_encode($error);
					}
					else
					{
						$upload_data = $this->upload->data();
						$insertArray['image_name'] = $upload_data["file_name"];
					}
					$this->db->insert('images',$insertArray);
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'Store Image Added Successfully'));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'Store Image Already Exist'));
				}
			}
			else
			{
				
				$updatetArray = array(
					'store_id' 			=> $this->input->post("i_store_id"),
					'image_desc'	    => $this->input->post("image_desc"),
					'status'			=> $this->input->post("img_status"),
					'added_by'			=> 'administrator',
					'modified_date'		=> date('Y-m-d H:i:s')
				);
				if($this->upload->do_upload('image_name'))
				{
					$upload_data = $this->upload->data();
					$updatetArray['image_name'] = $upload_data["file_name"];
				}
				$this->db->where('image_id',$this->input->post("image_id"));
				$this->db->update('images',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Store Image Updated Successfully'));				
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}

	function store_edit()
	{
		$store_id = $this->input->post('store_id');
		$query = $this->db->select("*");
		$this->db->from('store as a');
		$this->db->join('area as b','a.area_id = b.area_id','inner');
		$this->db->join('city as c','b.city_id = c.city_id','inner');
		$this->db->where("store_id",$store_id);
		$result = $query->get()->result_array();
		$response 	= array(
			'store_id' 	        => $result[0]["store_id"],	
			'store_name' 		=> $result[0]["store_name"],
			'description' 		=> $result[0]["description"],
			'specification' 	=> $result[0]["specification"],
			'cust_id' 			=> $result[0]["cust_id"],
			'category_id' 		=> $result[0]["category_id"],
			'area_id' 			=> $result[0]["area_id"],
			'city_id' 			=> $result[0]["city_id"],			
			'state_id' 			=> $result[0]["state_id"],
			'store_logo'		=> $result[0]["store_logo"],
			'status'			=> $result[0]["status"]
		);

		return $response;
	}	

	function change_status()
	{
		$id = $this->input->post('id');
		$status 	= $this->input->post('status');
		if($status==1){
			$updatetArray['status'] = '0';
		}else{
			$updatetArray['status'] = '1';
		}
		$updatetArray['user_id'] = $this->session->userdata('user_id');
		$updatetArray['modified_date'] = date('Y-m-d H:i:s');
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('store',$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>"Store's Status Updated Successfully"
							)
						);
	}
	
	function get_customer()
	{
		$this->db->select('cust_id, name');
		$this->db->where('flag','0');
        $result = $this->db->get('customer')->result_array();
		return $result;
	}
	
	function get_category()
	{
		$this->db->select('category_id, category_name');
		$this->db->where('flag','0');
        $result = $this->db->get('category')->result_array();
		return $result;
	}
	
	function get_state()
	{
		$query = $this->db->select("a.state_id, a.state_name");
		$this->db->from('state as a');
		$this->db->where("a.flag",'0');
		$this->db->where("a.status",'1');
		$response = $query->get()->result_array();
		return $response;
	}
	
	function get_city_by_state()
	{
		$state_id = $this->input->post('state_id');
		$query = $this->db->select("a.city_id, a.city_name");
		$this->db->from('city as a');
		$this->db->where("a.state_id",$state_id);
		$this->db->where("a.flag",'0');
		$this->db->where("a.status",'1');
		$response = $query->get()->result_array();
		return $response;
	}
	
	function get_area_by_city()
	{
		$city_id = $this->input->post('city_id');
		$query = $this->db->select("a.area_id, a.area_name");
		$this->db->from('area as a');
		$this->db->where("a.city_id",$city_id);
		$this->db->where("a.flag",'0');
		$this->db->where("a.status",'1');
		$response = $query->get()->result_array();
		return $response;
	}
	
	function get_area()
	{
		$this->db->select('area_id, area_name');
		$this->db->where('flag','0');
        $result = $this->db->get('area')->result_array();
		return $result;
	}
	
	function remove_image()
	{
		if($this->input->post('id'))
		{
			if($this->input->post('banner'))
			{
				if(file_exists('upload/store/'.$this->input->post('banner'))) {
					unlink('upload/store/'.$this->input->post('banner'));
				}	
				$id = $this->input->post('id');
				$updatetArray = array(
						'banner' 	=> "",
						'modified_date'	=> date('Y-m-d H:i:s')
				);
				$this->db->where('id',$id);
				$this->db->update('store',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Featured Image Removed Successfully'));
			}
			else if($this->input->post('small_img'))
			{
				if(file_exists('upload/store/'.$this->input->post('small_img'))) {
					unlink('upload/store/'.$this->input->post('small_img'));
				}	
				$id = $this->input->post('id');
				$updatetArray = array(
						'small_img' 	=> "",
						'modified_date'	=> date('Y-m-d H:i:s')
				);
				$this->db->where('id',$id);
				$this->db->update('images',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Thumbnail Image Removed Successfully'));
			}
			else if($this->input->post('image_name'))
			{
				if(file_exists('upload/store/'.$this->input->post('image_name'))) {
					unlink('upload/store/'.$this->input->post('image_name'));
				}	
				$id = $this->input->post('id');
				$updatetArray = array(
						'image_name' 	=> "",
						'modified_date'	=> date('Y-m-d H:i:s')
				);
				$this->db->where('id',$id);
				$this->db->update('images',$updatetArray);
				echo json_encode(array('success'=>true,'message'=>'Store Image Removed Successfully'));
			}	
		}
	}
	
	function get_image_list()
	{
		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['name'];
		
		$order_by 	= 	$this->input->post('order')[0]['dir'];
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.*, b.store_name',false);
		$this->db->from('images as a');
		$this->db->join('store as b','a.store_id = b.store_id','inner');
		$this->db->where('a.flag','0');
		$this->db->where('a.store_id',$this->input->post('store_id'));
		if($search_word != '')
		{
			$query->like('a.image_name',$search_word);
		}

		if($this->input->post('start')!="" && $this->input->post('length')!="-1")
		{
			$query->limit($this->input->post('length'),$this->input->post('start'));
		}

		/*if($order_by!="")
		{
			$query->order_by('a.'.$order_by_column,$order_by);
		}*/

		$result = 	$query->get()->result_array();
		
		$query 						= 	$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$total_rows 				= 	$query->row()->Count;

		$data['draw'] 				= 	$this->input->get('draw');
		$data['recordsTotal'] 		= 	$total_rows;
		$data['recordsFiltered'] 	= 	$total_rows;
		$data['data'] 				= 	$result;

		return $data;
	}
	
	function image_edit()
	{
		$id = $this->input->post('id');
		$query = $this->db->select("*");
		$this->db->from('images');
		$this->db->where("id",$id);
		$result = $query->get()->result_array();
		$response 	= array(
			'image_id' 		=> $result[0]["id"],	
			'i_store_id' 	=> $result[0]["store_id"],
			'image_name' 	=> $result[0]["image_name"],	
			'img_status'	=> $result[0]["status"],
		);

		return $response;
	}
	
	function image_delete()
	{
		$image_id = $this->input->post('image_id');
		$updatetArray = array(
				'flag' 		=> 1,
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('image_id',$image_id);
		$this->db->update('images',$updatetArray);
		echo json_encode(array('success'=>true, 'message'=>'Image Deleted Successfully'));
	}
	
	function change_status_img()
	{
		$id = $this->input->post('id');
		$status 	= $this->input->post('status');
		if($status==1){
			$updatetArray['status'] = '0';
		}else{
			$updatetArray['status'] = '1';
		}
		$updatetArray['user_id'] = $this->session->userdata('user_id');
		$updatetArray['modified_date'] = date('Y-m-d H:i:s');
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('store_images',$updatetArray);
		echo json_encode(array('success'=>true, 'message'=>"Store Image Status Updated Successfully"));
	}
	
	function get_store_list_by_id($id ){

		$this->db->select('*');
		$this->db->where('flag','0');
		$this->db->where( 'category_id' , $id );
		$this->db->order_by("store_name", "asc");
        $result = $this->db->get('store')->result_array();
		return $result;
	}
	function get_store_details_by_id($store_id){

		$this->db->select('*');
		$this->db->where('flag','0');
		$this->db->where( 'store_id' , $store_id );
        $result = $this->db->get('store')->result_array();
        $res = array();
        if (count($result)>0 ) {
        	$res = $result[0];
        }
		return $res;	
	}
	function get_store_images_by_id($store_id){
		$this->db->select('*');
		$this->db->where('flag','0');
		$this->db->where( 'store_id' , $store_id );
		$this->db->order_by("created_date", "asc");
        $result = $this->db->get('images')->result_array();
		return $result;
		
	}
}