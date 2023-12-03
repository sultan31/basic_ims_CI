<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
        date_default_timezone_set('UTC');
    }

	function get_category_list($order_by_col = "category_name" )
	{
		if($order_by_col == null ){
			$order_by_col = "category_name";
		}

		$search_word 		= 	isset($this->input->post('search')['value']) ? $this->input->post('search')['value'] : '';
		$coloum_index 		= 	isset($this->input->post('order')[0]['column']) ? $this->input->post('order')[0]['column'] : '';
		//$order_by_column 	= 	$this->input->post('columns')[$coloum_index]['category_name'];
		$order_by 			= 	isset($this->input->post('order')[0]['dir']) ? $this->input->post('order')[0]['dir'] : 'category_name';
		$query = $this->db->select('SQL_CALC_FOUND_ROWS a.*',false);
		$this->db->from('category as a');
		$this->db->order_by("a.".$order_by_col, "asc");
		$this->db->where('a.flag','0');
		if($search_word != '')
		{
			$query->like('a.category_name',$search_word);
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
	function get_categorylist_for_area($area_id){
		$query = $this->db->select('a.*');
		$this->db->from('category as a');
		// $this->db->order_by("category_name", "asc");
		$this->db->join('store as b','b.category_id = a.category_id', 'inner');
		$this->db->where('b.area_id',$area_id);
		// $this->db->where('a.flag',0);
		return $query->get()->result_array();
	}

	function category_delete()
	{
		$category_id = $this->input->post('category_id');
		$updatetArray = array(
				'flag' 	=> 1,
				'modified_date'	=> date('Y-m-d H:i:s')
		);
		$this->db->where('category_id',$category_id);
		$this->db->update('category',$updatetArray);
		echo json_encode(
						array(
							'success'=>true,
							'message'=>'Category Deleted Successfully'
							)
						);
	}

	public function save_category()
	{
		$category_name = $this->input->post("category_name");

		$error=0;
		$errorTxt='';
		if(addslashes($category_name)=='')
		{ $error++; $errorTxt.='Please Enter Category Name';}

		if($error==0)
		{
			if($this->input->post("id")	== 0 || $this->input->post("id") == '')
			{
				
					$insertArray = array(
						'category_name' => $category_name,
						'added_by'	    => $this->session->userdata('user_id'),
						'created_date'	=> date('Y-m-d H:i:s'),
						'modified_date'	=> date('Y-m-d H:i:s')
					);
					if(!$this->upload->do_upload('category_logo'))
					{
						$error = array('success'=>false,'message' => $this->upload->display_errors());
						echo json_encode($error);
					}
					else
					{
						$upload_data = $this->upload->data();
						$insertArray['category_logo'] = $upload_data["file_name"];
							
					}
					$this->db->insert('category',$insertArray);
					$id = $this->db->insert_id();
					echo json_encode(array('success'=>true,'message'=>'Category Added Successfully '));
				
				
			}
			else
			{
				$updatetArray = array(
						'category_name' => $category_name,
						'status'		=> $this->input->post("status"),
						'added_by'	    => 'administrator',
						'modified_date'	=> date('Y-m-d H:i:s')
					);
				if($this->upload->do_upload('category_logo'))
				{
              		$upload_data = $this->upload->data();
		    		$updatetArray['category_logo'] = $upload_data["file_name"];
							
				}
                $this->db->where('category_id',$this->input->post('id'));
						$this->db->update('category',$updatetArray);
						echo json_encode(array('success'=>true,'message'=>'Category Updated Successfully '));
          // }
			}
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$errorTxt));
		}
	}

	function category_edit()
	{
		$category_id = $this->input->post('category_id');
		$query = $this->db->select("*");
		$this->db->from('category');
		$this->db->where("category_id",$category_id);
		$result = $query->get()->result_array();
		$response 	= array(
			'category_id' 					=> $result[0]["category_id"],
			'category_name' 				=> $result[0]["category_name"],
			'category_logo' 				=> $result[0]["category_logo"],
			'status'						=> $result[0]["status"]
		);
		return $response;
	}
}
