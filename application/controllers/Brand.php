<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_id') == '')
		{
			redirect('login');
		}
		$config = array();
		$config['upload_path']          = $this->config->item('upload_url').'/'.$this->config->item('brand_upload_url');
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
		$this->load->view('brand/brandlist');
	}

	
	public function addbrand()
	{
		$this->load->view('brand/addbrand');
	}

	public function fetch_records()
	{  
		
		$table = "brand";  
	  	$select_column = array("id", "brand_name", "description", "brand_logo");  
	  	$order_column = array(null, "brand_name",  "description", "brand_logo");  
	  	$search_column = array("brand_name", "description");  
             
           $fetch_data = $this->api_model->make_datatables($select_column, $table, $order_column, $search_column);  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<label class="checkboxs">
								<input type="checkbox" id="select-'.$row->id.'">
								<span class="checkmarks"></span>
								</label>';  
                $sub_array[] = $row->brand_name;  
                $sub_array[] = $row->description;  
                $sub_array[] = $row->brand_logo;  

                $sub_array[] = '<a class="me-3" href="'.base_url().'brand/editbrand/'.$row->id.'">
					<img src="'.base_url().'assets/img/icons/edit.svg" alt="img">
					</a>
					<a class="me-3 confirm-text" href="javascript:void(0);" onclick="remove_record('.$row->id.');">
					<img src="'.base_url().'assets/img/icons/delete.svg" alt="img">
					</a>';
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"              => intval($_POST["draw"]),  
                "recordsTotal"      => $this->api_model->get_all_data($table),  
                "recordsFiltered"   => $this->api_model->get_filtered_data($select_column, $table, $order_column, $search_column),  
                "data"              => $data  
           );  
           echo json_encode($output);  
      } 
  

	public function form_action($id = '')
	{
	
		$postdata = array(
			'brand_name' => $this->input->post("brand_name"),
			
			'description' => $this->input->post("description")
		);
		

		if($id)
		{
			$postdata['updated_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$id);
			$this->db->update('brand',$postdata);
			$this->session->set_flashdata('message', 'Brand Updated Successfully!');
		}
		else
		{
			$postdata['created_by'] = $this->session->userdata('user_id');
			$this->db->insert('brand',$postdata);
			$id = $this->db->insert_id();
			$this->session->set_flashdata('message', 'Brand Added Successfully!');
		}

		

		if(isset($_FILES) && !empty($_FILES['brand_logo']['name']))
		{
			if($this->input->post('saved_brand_logo') != '')
			{
				unlink($this->config->item('upload_url').'/'.$this->config->item('brand_upload_url').'/'.$this->input->post('saved_brand_logo'));
			}
			if($this->upload->do_upload('brand_logo'))
			{
	      		$upload_data = $this->upload->data();
	    		$updatetArray['brand_logo'] = $upload_data["file_name"];
	    		$this->db->where('id',$id);
				$this->db->update('brand',$updatetArray);
						
			}
		}
		

		$this->session->set_flashdata('message', 'Submitted Successfully!');
		redirect('brand');
	
	}

	public function editbrand($id = '')
	{
	
		$data['edit_data'] = $this->api_model->get_one_detail('brand', $id);
		
		$this->load->view('brand/addbrand', $data);
	}

	public function removebrand()
	{
		$id = $_POST['id'];
		$brand_logo = $this->db->select('brand_logo')->get_where('brand', ['id' => $id])->result_array()[0]['brand_logo'];
		$success = $this->db->where('id', $id)->delete('brand');
		if($brand_logo != '')
		{
			unlink($this->config->item('upload_url').'/'.$this->config->item('brand_upload_url').'/'.$brand_logo);
		}
		
		if($success)
		{
			echo json_encode(['status' => 1, 'message' => 'Removed Successfully!']);
		}
	}

}
?>
