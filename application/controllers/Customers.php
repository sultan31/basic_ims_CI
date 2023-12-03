<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_id') == '')
		{
			redirect('login');
		}
	}

	public function index()
	{
		$this->load->view('customers/customerlist');
	}

	
	public function addcustomer()
	{
		$this->load->view('customers/addcustomer');
	}

	public function fetch_records()
	{  
		
		$table = "customer";  
	  	$select_column = array("id", "name", "phone", "email", "address");  
	  	$order_column = array(null, "name", "phone",  "email", "address");  
	  	$search_column = array("name", "phone", "email", "address");  
             
           $fetch_data = $this->api_model->make_datatables($select_column, $table, $order_column, $search_column);  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<label class="checkboxs">
								<input type="checkbox" id="select-'.$row->id.'">
								<span class="checkmarks"></span>
								</label>';  
                $sub_array[] = $row->name;  
                $sub_array[] = $row->phone;  
                $sub_array[] = $row->email;  
                $sub_array[] = $row->address;  

                $sub_array[] = '<a class="me-3" href="'.base_url().'customers/editcustomer/'.$row->id.'">
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
			'name' => $this->input->post("name"),
			'phone' => $this->input->post("phone"),
			'email' => $this->input->post("email"),
			'address' => $this->input->post("address"),
			'gst_no' => $this->input->post("gst_no")
		);

		if($id)
		{
			$postdata['updated_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$id);
			$this->db->update('customer',$postdata);
			$this->session->set_flashdata('message', 'Customer Updated Successfully!');
		}
		else
		{
			$postdata['added_by'] = $this->session->userdata('user_id');
			$this->db->insert('customer',$postdata);
			$id = $this->db->insert_id();
			$this->session->set_flashdata('message', 'Customer Added Successfully!');
		}

		$this->session->set_flashdata('message', 'Submitted Successfully!');
		redirect('customers');
	
	}

	public function editcustomer($id = '')
	{
	
		$data['edit_data'] = $this->api_model->get_one_detail('customer', $id);
		
		$this->load->view('customers/addcustomer', $data);
	}

	public function removecustomer()
	{
		$id = $_POST['id'];
		
		$success = $this->db->where('id', $id)->delete('customer');
		
		
		if($success)
		{
			echo json_encode(['status' => 1, 'message' => 'Removed Successfully!']);
		}
	}


}
?>
