<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_id') == '')
		{
			redirect('login');
		}

		$config = array();
		$config['upload_path']          = $this->config->item('upload_url').'/'.$this->config->item('company_master_upload_url');
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
		$this->load->view('company_master/company_masterlist');
	}

	
	public function addcompany_master()
	{
		$this->load->view('company_master/addcompany_master');
	}

	public function fetch_records()
	{  
		
		$table = "company_master";  
	  	$select_column = array("id", "name", "tagline", "phone", "email", "office_address", "gst_no", "company_logo");  
	  	$order_column = array(null, "name",  "tagline", null); 
	  	$search_column = array("name",  "tagline");  
             
           $fetch_data = $this->api_model->make_datatables($select_column, $table, $order_column, $search_column);  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<label class="checkboxs">
								<input type="checkbox" id="select-'.$row->id.'">
								<span class="checkmarks"></span>
								</label>';  
                $sub_array[] = '<a class="me-3" href="'.base_url().'company/editcompany/'.$row->id.'">'.$row->name.'</a>';  
               
                $sub_array[] = $row->tagline;  
				$sub_array[] = $row->phone;  
				$sub_array[] = $row->email;  
				$sub_array[] = $row->office_address;  
				$sub_array[] = $row->gst_no;  
			
                $sub_array[] = '<img src="'.base_url().$this->config->item('upload_url').'/'.$this->config->item('company_master_upload_url').'/'.$row->company_logo.'" alt="'.$row->company_logo.'">';  

                $sub_array[] = '<a class="me-3" href="'.base_url().'company/editcompany/'.$row->id.'">
					<img src="'.base_url().'assets/img/icons/edit.svg" alt="img">
					</a>
					';
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
			'name' => $this->input->post("name"),
            'tagline' => $this->input->post("tagline"),
            'phone' => $this->input->post("phone"),
            'email' => $this->input->post("email"),
            'office_address' => $this->input->post("office_address"),
            'showroom_address' => $this->input->post("showroom_address"),
			'gst_no' => $this->input->post("gst_no")
		);

		if($id)
		{
			$postdata['updated_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$id);
			$this->db->update('company_master',$postdata);
			$this->session->set_flashdata('message', 'Updated Successfully!');
		}
		else
		{
			$postdata['created_by'] = $this->session->userdata('user_id');
			$this->db->insert('company_master',$postdata);
			$id = $this->db->insert_id();
			$this->session->set_flashdata('message', 'Added Successfully!');
		}

		if(isset($_FILES) && !empty($_FILES['company_logo']['name']))
		{
			if($this->input->post('saved_company_logo') != '')
			{
				unlink($this->config->item('upload_url').'/'.$this->config->item('company_master_upload_url').'/'.$this->input->post('saved_company_logo'));
			}
			if($this->upload->do_upload('company_logo'))
			{
	      		$upload_data = $this->upload->data();
	    		$updatetArray['company_logo'] = $upload_data["file_name"];
	    		$this->db->where('id',$id);
				$this->db->update('company_master',$updatetArray);
						
			}
		}

		

		if(isset($_FILES) && !empty($_FILES['qr_code']['name']))
		{
			if($this->input->post('saved_qr_code') != '')
			{
				unlink($this->config->item('upload_url').'/'.$this->config->item('company_master_upload_url').'/'.$this->input->post('saved_qr_code'));
			}
			if($this->upload->do_upload('qr_code'))
			{
	      		$upload_data = $this->upload->data();
	    		$updatetArray['qr_code'] = $upload_data["file_name"];
	    		$this->db->where('id',$id);
				$this->db->update('company_master',$updatetArray);
						
			}
		}


		$this->session->set_flashdata('message', 'Submitted Successfully!');
		redirect('company');
	
	}

	public function editcompany($id = '')
	{
	
		$data['edit_data'] = $this->api_model->get_one_detail('company_master', $id);
		
		$this->load->view('company_master/addcompany_master', $data);
	}

	public function removecompany()
	{
		$id = $_POST['id'];
		$category_logo = $this->db->select('category_logo')->get_where('category', ['id' => $id])->result_array()[0]['category_logo'];
		$success = $this->db->where('id', $id)->delete('category');
		if($category_logo != '')
		{
			unlink($this->config->item('upload_url').'/'.$this->config->item('company_master_upload_url').'/'.$category_logo);
		}
		
		if($success)
		{
			echo json_encode(['status' => 1, 'message' => 'Removed Successfully!']);
		}
	}


}
?>
