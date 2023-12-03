<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_id') == '')
		{
			redirect('login');
		}
		$config = array();
		$config['upload_path']          = $this->config->item('upload_url').'/'.$this->config->item('sub_category_upload_url');
        $config['allowed_types']    	= $this->config->item('allowed_types');
		$config['max_size']             = 0; //2048000;
		$config['max_width']            = 0; //1024;
		$config['max_height']           = 0; //768;
		$config['remove_spaces'] 		= true;
		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0777, true);
		}
		$this->load->library('upload', $config);
	}

	public function index()
	{
		$this->load->view('subcategory/subcategorylist');
	}

	
	public function addsubcategory()
	{
		$this->load->view('subcategory/addsubcategory');
	}

	public function fetch_records()
	{  
		
		$table = "sub_category as a";  
	  	$select_column = array("a.id", "a.sub_category_name", "b.category_name", "a.description", "a.sub_category_logo");  
	  	$order_column = array(null, "a.sub_category_name", "b.category_name", "a.description", null); 
	  	$search_column = array("a.sub_category_name", "b.category_name", "a.description");  

	  	$join =  array("category as b", "a.category_id = b.id", "LEFT");
             
           $fetch_data = $this->api_model->make_datatables($select_column, $table, $order_column, $search_column, $join);  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<label class="checkboxs">
								<input type="checkbox" id="select-'.$row->id.'">
								<span class="checkmarks"></span>
								</label>';  
                $sub_array[] = $row->sub_category_name;  
                $sub_array[] = $row->category_name;  
                
                $sub_array[] = $row->description;  
                $sub_array[] = $row->sub_category_logo;  

                $sub_array[] = '<a class="me-3" href="'.base_url().'subcategory/editsubcategory/'.$row->id.'">
					<img src="'.base_url().'assets/img/icons/edit.svg" alt="img">
					</a>
					<a class="me-3 confirm-text" href="javascript:void(0);" onclick="remove_record('.$row->id.');">
					<img src="'.base_url().'assets/img/icons/delete.svg" alt="img">
					</a>';
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"              => intval($_POST["draw"]),  
                "recordsTotal"      => $this->api_model->get_all_data($table, $join),  
                "recordsFiltered"   => $this->api_model->get_filtered_data($select_column, $table, $order_column, $search_column, $join),  
                "data"              => $data  
           );  
           echo json_encode($output);  
      } 

	public function form_action($id = '')
	{
	
		$postdata = array(
			'category_id'	=> $this->input->post("category_id"),
			'sub_category_name' => $this->input->post("sub_category_name"),
			
			'description' => $this->input->post("description")
		);

		if($id)
		{
			$postdata['updated_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$id);
			$this->db->update('sub_category',$postdata);
			$this->session->set_flashdata('message', 'Sub Category Updated Successfully!');
		}
		else
		{
			$postdata['created_by'] = $this->session->userdata('user_id');
			$this->db->insert('sub_category',$postdata);
			$id = $this->db->insert_id();
			$this->session->set_flashdata('message', 'Sub Category Added Successfully!');
		}

		

		if(isset($_FILES) && !empty($_FILES['sub_category_logo']['name']))
		{
			if($this->input->post('saved_sub_category_logo') != '')
			{
				unlink($this->config->item('upload_url').'/'.$this->config->item('sub_category_upload_url').'/'.$this->input->post('saved_sub_category_logo'));
			}
			if($this->upload->do_upload('sub_category_logo'))
			{
	      		$upload_data = $this->upload->data();
	    		$updatetArray['sub_category_logo'] = $upload_data["file_name"];
	    		$this->db->where('id',$id);
				$this->db->update('sub_category',$updatetArray);
						
			}
		}
		

		$this->session->set_flashdata('message', 'Submitted Successfully!');
		redirect('subcategory');
	
	}


	public function editsubcategory($id = '')
	{
	
		$data['edit_data'] = $this->api_model->get_one_detail('sub_category', $id);
		
		$this->load->view('subcategory/addsubcategory', $data);
	}

	public function removesub_category()
	{
		$id = $_POST['id'];
		$sub_category_logo = $this->db->select('sub_category_logo')->get_where('sub_category', ['id' => $id])->result_array()[0]['sub_category_logo'];
		$success = $this->db->where('id', $id)->delete('sub_category');
		if($sub_category_logo != '')
		{
			unlink($this->config->item('upload_url').'/'.$this->config->item('sub_category_upload_url').'/'.$sub_category_logo);
		}
		
		if($success)
		{
			echo json_encode(['status' => 1, 'message' => 'Removed Successfully!']);
		}
	}

}
?>
