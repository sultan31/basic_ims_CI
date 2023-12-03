<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// $this->db->where_in('id', array('20','15','22','42','86'));

class Store_model extends CI_Model
{
	function __construct()
    {
		parent::__construct();
		$this->load->model("admin/city_model");
		$this->load->model("admin/state_model");
    }

	function get_store_list()
	{

		$search_word 		= 	$this->input->post('search')['value'];
		$coloum_index 		= 	$this->input->post('order')[0]['column'];
		$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['name'];
		$order_by 			= 	$this->input->post('order')[0]['dir'];
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.store_id, a.store_name, a.tag_line, a.store_logo, a.status,  SUBSTRING(a.description, 1, 100) as description, SUBSTRING(a.specification,1,100) as specification, b.category_name as category, c.name as customer, d.area_name as area',false);
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
						'tag_line' 				=> $this->input->post("tag_line"),
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
						'tag_line' 				=> $this->input->post("tag_line"),
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
				else
				{
				    $updatetArray['store_logo'] = $this->input->post('banner_images');	
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
					'terms_conditions' 	=> $this->input->post("terms_conditions"),
					'added_by'		    => 'administrator',
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
						'status'	    => $this->input->post("img_status"),
						'added_by'		=> 'administrator',
						'created_date'	=> date('Y-m-d H:i:s'),
						'modified_date'	=> date('Y-m-d H:i:s')
					);
					$this->multiple_image_save($_FILES,$insertArray);

					
					echo json_encode(array('success'=>true,'message'=>'Store Image Added Successfully'));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'Store Image Already Exist'));
				}
			}
			else
			{

				$updateArray = array(
					'store_id' 			=> $this->input->post("i_store_id"),
					'status'			=> $this->input->post("img_status"),
					'added_by'			=> 'administrator',
					'modified_date'		=> date('Y-m-d H:i:s')
				);
				$this->multiple_image_save($_FILES,$updateArray,$this->input->post("image_id"));
				// if($this->upload->do_upload('image_name'))
				// {
				// 	$upload_data = $this->upload->data();
				// 	$updateArray['image_name'] = $upload_data["file_name"];
				// }
				// $this->db->where('image_id',$this->input->post("image_id"));
				// $this->db->update('images',$updateArray);
				echo json_encode(array('success'=>true,'message'=>'Store Image Updated Successfully'));
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}

	private function multiple_image_save($files,$insertArray,$image_id = 0)
	{
		$cpt = count($_FILES['image_name']['name']);
		if($cpt > 1 && gettype($_FILES['image_name']['name']) != "array")
		for($i=0; $i<$cpt; $i++){
			$_FILES['image_name']['name']= $files['image_name']['name'][$i];
			$_FILES['image_name']['type']= $files['image_name']['type'][$i];
			$_FILES['image_name']['tmp_name']= $files['image_name']['tmp_name'][$i];
			$_FILES['image_name']['error']= $files['image_name']['error'][$i];
			$_FILES['image_name']['size']= $files['image_name']['size'][$i];    
			//$this->upload->do_upload("image_name");
			$this->upload->do_upload();
			$upload_data = $this->upload->data();
			$insertArray['image_name'] = $upload_data["file_name"];
			if($image_id == 0){
				$this->db->insert('images',$insertArray);
			}else{
				// $insertArray['image_id'] = $image_id; 
				$this->db->where("image_id",$image_id);
				$this->db->update('images',$insertArray);
			}
		}else{	
			$_FILES['image_name']['name']= $files['image_name']['name'];
			$_FILES['image_name']['type']= $files['image_name']['type'];
			$_FILES['image_name']['tmp_name']= $files['image_name']['tmp_name'];
			$_FILES['image_name']['error']= $files['image_name']['error'];
			$_FILES['image_name']['size']= $files['image_name']['size'];    
			if($this->upload->do_upload()){
				$upload_data = $this->upload->data();
				$insertArray['image_name'] = $upload_data["file_name"];
				if($image_id == 0){
					$this->db->insert('images',$insertArray);
				}else{
					// $insertArray['image_id'] = $image_id;
					$this->db->where("image_id",$image_id); 
					$this->db->update('images',$insertArray);
				}
			}
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
			'tag_line' 			=> $result[0]["tag_line"],
			'description' 		=> $result[0]["description"],
			'specification' 	=> $result[0]["specification"],
			'terms_conditions' 	=> $result[0]["terms_conditions"],
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
		//$this->db->where('a.store_id',$this->input->post('store_id'));
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
        //echo $this->db->last_query();exit;
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
		$this->db->where("image_id",$id);
		$result = $query->get()->result_array();
		$response 	= array(
			'image_id' 		=> $result[0]["image_id"],
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

	function get_store_list_by_id($id )
	{
		//store.* , customer.* , area.*
		$this->db->select('a.*, c.area_name, d.city_name, e.state_name, COUNT(f.review_id) as num_of_reviews, sum(f.star) as star');
		$this->db->from('store as a');
		$this->db->join('area as c','a.area_id = c.area_id');
		$this->db->join('city as d','c.city_id = d.city_id');
		$this->db->join('state as e','d.state_id = e.state_id');
		$this->db->join('reviews as f', 'f.store_id = a.store_id','left outer');
		$this->db->where( 'category_id' , $id );
		$this->db->where('a.flag','0');
		$this->db->group_by('a.store_id');
		$this->db->order_by("a.store_name", "asc");
        $result = $this->db->get()->result_array();
		//echo $this->db->last_query();exit;
		return $result;
		//print_r($result);exit;
	}

	function get_store_details_by_id($store_id)
	{
		$this->db->select('a.*,b.name, b.phone, b.email,c.area_name, d.category_name, e.city_name, f.state_name');
		$this->db->from('store as a');
		$this->db->join('customer as b','a.cust_id = b.cust_id');
		$this->db->join('area as c','a.area_id = c.area_id');
		$this->db->join('category as d','a.category_id = d.category_id');
		$this->db->join('city as e','c.city_id = e.city_id');
		$this->db->join('state as f','e.state_id = f.state_id');
		$this->db->where('store_id' , $store_id );
		$this->db->where('a.flag','0');
        $result = $this->db->get()->result_array();
		//print_r($result);exit;
        $res = array();
        if (count($result)>0 ) {
        	$res = $result[0];
        }
		return $res;
	}
	function get_store_images_by_id($store_id)
    {
		$this->db->select('*');
		$this->db->where('flag','0');
		$this->db->where( 'store_id' , $store_id );
		$this->db->order_by("created_date", "asc");
        $result = $this->db->get('images')->result_array();
		return $result;

	}
    
    function get_store_reviews($store_id)
    {
        $this->db->select('*');
		$this->db->where('flag','0');
		$this->db->where('status','1');
		$this->db->where( 'store_id' , $store_id );
		$this->db->order_by("created_date", "DESC");
        $result = $this->db->get('reviews')->result_array();
		return $result;
    }
    
	public function get_search_data_by_query($query)
    {

		$area_ids = array();
		$this->db->select('a.*, c.area_name, b.city_name, d.state_name, COUNT(r.review_id) as num_of_reviews, sum(r.star) as star');
		$this->db->from('store as a');
		$this->db->join("area as c","a.area_id =c.area_id");
		$this->db->join("city as b","b.city_id =c.city_id");
		$this->db->join("state as d","d.state_id = b.state_id");
		$this->db->join('reviews as r', 'r.store_id = a.store_id','left outer');
        
		$this->db->group_by('a.store_id');

		if(isset($query['area_id']) && $query['area_id'] != ''){
			$this->db->where('a.area_id',$query['area_id']);
		}
		else
		{
			if((isset($query['city_id']) && $query['city_id'] != '') || (isset($query['state_id']) && $query['state_id'] != ''))
			{
				if(isset($query['city_id']) && $query['city_id']){
					$this->db->where("b.city_id =".$query['city_id']);
				}else{
					$this->db->where("d.state_id =".$query['state_id']);
				}
			}
		}

		if(isset($query['category_id']) && $query['category_id'] != ''){
			$this->db->where('a.category_id',$query['category_id']);
		}

		$this->db->where('a.flag','0');
		
        $query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->result_array();
		//print_r($result);exit;
		return $result;
	}
}
