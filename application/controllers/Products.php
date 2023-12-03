<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_id') == '')
		{
			redirect('login');
		}
		$config = array();
		$config['upload_path']          = $this->config->item('upload_url').'/'.$this->config->item('product_upload_url');
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
		$this->load->view('products/productlist');
	}

	public function fetch_records()
	{  
		
		$table = "products as a";  
	  	$select_column = array("a.id", "a.product_name", "a.hsn_code", "b.category_name", "a.price", "a.quantity", "a.unit", "a.image");  
	  	$order_column = array(null, "a.product_name", "a.hsn_code", "b.category_name", "a.price", "a.quantity", "a.unit"); 
	  	$search_column = array("a.product_name", "a.hsn_code", "b.category_name", "a.price", "a.quantity", "a.unit");  

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
			$image = $row->image != '' ? '<a href="javascript:void(0);" class="product-img">
					        <img src="'.base_url().$this->config->item('upload_url').'/'.$this->config->item('product_upload_url').'/'.$row->image.'" alt="product">
					        </a>' : '';
                $sub_array[] = $image.$row->product_name;  
                $sub_array[] = $row->hsn_code;  
                $sub_array[] = $row->category_name;  
                $sub_array[] = $row->price;  
                $sub_array[] = $row->quantity;  
				$sub_array[] = $row->unit;  

                $sub_array[] = '<a class="me-3" href="'.base_url().'products/editproduct/'.$row->id.'">
					<img src="'.base_url().'assets/img/icons/edit.svg" alt="img">
					</a>
					<a class="me-3 confirm-text" href="javascript:void(0);" onclick="remove_record('.$row->id.');">
					<img src="'.base_url().'assets/img/icons/delete.svg" alt="img">
					</a>
					<a class="me-3" href="'.base_url().'products/edit_stock/'.$row->id.'">
					<i class="fa fa-table" style="color:#39dd10;font-size:24px;"></i>
					</a>
					';
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


	
	public function addproduct()
	{
		$this->load->view('products/addproduct');
	}

	public function fetch_sub_cat()
	{
		$category_id = $_REQUEST['category_id'];
		$sub_cat_data = $this->api_model->fetch_related_data('sub_category', $category_id, 'category_id');
		echo json_encode($sub_cat_data); 
	}

	public function form_action($id = '')
	{

	
		$postdata = array(
			'category_id'	=> $this->input->post("category_id"),
			'sub_category_id'	=> $this->input->post("sub_category_id"),
			'brand_id'	=> $this->input->post("brand_id"),
			'product_name' => $this->input->post("product_name"),
			'hsn_code' => $this->input->post("hsn_code"),
			'description' => $this->input->post("description"),
			'quantity' => $this->input->post("quantity"),
			'price' => $this->input->post("price"),
			'unit' => $this->input->post("unit")
		);

		if($id)
		{
			$postdata['updated_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$id);
			$this->db->update('products',$postdata);
			$this->session->set_flashdata('message', 'Product Updated Successfully!');
		}
		else
		{
			$postdata['created_by'] = $this->session->userdata('user_id');
			$this->db->insert('products',$postdata);
			$id = $this->db->insert_id();
			$this->db->insert('product_stock', ['product_id' => $id, 'quantity' => $this->input->post("quantity"), 'created_by' => $this->session->userdata('user_id')]);
			$this->session->set_flashdata('message', 'Product Added Successfully!');
		}

		if(isset($_FILES) && !empty($_FILES['image']['name']))
		{
			if($this->input->post('saved_image') != '')
			{
				unlink($this->config->item('upload_url').'/'.$this->config->item('product_upload_url').'/'.$this->input->post('saved_image'));
			}
			if($this->upload->do_upload('image'))
			{
	      		$upload_data = $this->upload->data();
	    		$updatetArray['image'] = $upload_data["file_name"];
	    		$this->db->where('id',$id);
				$this->db->update('products',$updatetArray);
						
			}
		}
		

		$this->session->set_flashdata('message', 'Submitted Successfully!');
		redirect('products');
	
	}

	public function editproduct($id = '')
	{
		$data['edit_data'] = $this->api_model->get_one_detail('products', $id);
		
		$this->load->view('products/addproduct', $data);
	}

	

	public function removeproduct()
	{
		$id = $_POST['id'];
		$image = $this->db->select('image')->get_where('products', ['id' => $id])->result_array()[0]['image'];
		$this->db->where('product_id', $id)->delete('product_stock');
		$success = $this->db->where('id', $id)->delete('products');
		if($image != '')
		{
			unlink($this->config->item('upload_url').'/'.$this->config->item('product_upload_url').'/'.$image);
		}
		
		if($success)
		{
			echo json_encode(['status' => 1, 'message' => 'Removed Successfully!']);
		}
	}

	public function edit_stock($id = '')
	{
		$data['id'] = $id;
		$data['quantity'] = $this->db->select('quantity')->get_where('product_stock', ['product_id' => $id])->row_array()['quantity'];
		$this->load->view('products/stock', $data);
	}

	
	public function update_stock($id = '')
	{		
		$this->db->where('product_id', $id)->update('product_stock', ['quantity' => $_REQUEST['quantity']]);
		$this->db->where('id', $id)->update('products', ['quantity' => $_REQUEST['quantity']]);
		redirect('products');
	}


}
?>
