<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller
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
		$this->load->view('sale/salelist');
	}

	public function fetch_records()
	{  
		
		$table = "sale as a";  
	  	$select_column = array("a.id", "DATE_FORMAT(a.sale_date, '%d %M %Y') as sale_date", "b.name", "a.voucher_no", "a.status", "a.payment", "a.grand_total", "a.paid_amount", "a.due_amount");  
	  	$order_column = array(null, "a.voucher_no", "b.name",  "a.grand_total", "a.paid_amount");  
	  	$search_column = array("a.voucher_no", "b.name", "b.grand_total", "a.paid_amount", "b.due_amount");  
	  	$join =  array("customer as b", "a.customer_id = b.id", "LEFT");
             
           $fetch_data = $this->api_model->make_datatables($select_column, $table, $order_column, $search_column, $join);  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<label class="checkboxs">
								<input type="checkbox" id="select-'.$row->id.'">
								<span class="checkmarks"></span>
								</label>';  
                $sub_array[] = $row->sale_date; 
                $sub_array[] = $row->name; 
                $sub_array[] = $row->voucher_no; 
                $sub_array[] = $row->status;
                $sub_array[] = $row->payment;
                $sub_array[] = $row->grand_total;  
                $sub_array[] = $row->paid_amount;  
                $sub_array[] = $row->due_amount;  
                // $sub_array[] = $this->db->select('CONCAT(first_name, " ", last_name) AS username')->get_where('users', ['id' => $this->session->userdata('user_id')])->result_array()[0]['username'];  

                $sub_array[] = '<a class="me-3" href="'.base_url().'sale/editsale/'.$row->id.'">
					<img src="'.base_url().'assets/img/icons/edit.svg" alt="img">
					</a>
					<a class="me-3 confirm-text" href="javascript:void(0);" onclick="remove_record('.$row->id.');">
					<img src="'.base_url().'assets/img/icons/delete.svg" alt="img">
					</a><a class="me-3" href="'.base_url().'sale/view_sale_pdf/'.$row->id.'" target="_balnk">
					<img src="'.base_url().'assets/img/icons/pdf.svg" alt="img">
					</a>';

         //        <li>
					    // <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#showpayment"><img src="'.base_url().'assets/img/icons/dollar-square.svg" class="me-2" alt="img">Show Payments</a>
					    // </li>
					    // <li>
					    // <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#createpayment"><img src="'.base_url().'assets/img/icons/plus-circle.svg" class="me-2" alt="img">Create Payment</a>
					    // </li>

			// $sub_array[] = '<a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
			// 		    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
			// 		    </a>
			// 		    <ul class="dropdown-menu">
			// 		    <li>
			// 		    <a href="sales-details.html" class="dropdown-item"><img src="'.base_url().'assets/img/icons/eye1.svg" class="me-2" alt="img">View Detail</a>
			// 		    </li>
			// 		    <li>
			// 		    <a href="'.base_url().'sale/editsale/'.$row->id.'" class="dropdown-item"><img src="'.base_url().'assets/img/icons/edit.svg" class="me-2" alt="img">Edit</a>
			// 		    </li>
					    
			// 		    <li>
			// 		    <a href="javascript:void(0);" class="dropdown-item"><img src="'.base_url().'assets/img/icons/download.svg" class="me-2" alt="img">Download pdf</a>
			// 		    </li>
			// 		    <li>
			// 		    <a href="javascript:void(0);" class="dropdown-item confirm-text" onclick="remove_record('.$row->id.');"><img src="'.base_url().'assets/img/icons/delete1.svg" class="me-2" alt="img">Delete</a>
			// 		    </li>
			// 		    </ul>';
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"              => intval($_POST["draw"]),  
                "recordsTotal"      => $this->api_model->get_all_data($table),  
                "recordsFiltered"   => $this->api_model->get_filtered_data($select_column, $table, $order_column, $search_column, $join),  
                "data"              => $data  
           );  
           echo json_encode($output);  
      } 

	
	public function addsale()
	{
		$this->load->view('sale/addsale');
	}

	public function get_product_detail()
	{
		$html = '';
		$message = '';
		$data = $this->api_model->get_one_detail('products', $_REQUEST['prod_id']);
		$quantity = $this->db->select('quantity')->get_where('product_stock', ['product_id' => $_REQUEST['prod_id']])->row_array()['quantity'];
		if($quantity >= 1)
		{
			$status = 1;
			$counter = $_REQUEST['counter'];
			$image = !empty($data[0]['image']) ? '<a class="product-img">
					    <img src="'.base_url().$this->config->item('upload_url').'/'.$this->config->item('product_upload_url').'/'.$data[0]['image'].'" alt="product">
					    </a>' : '';
			
			$html .= '<tr class="product_row" id="'.$counter.'">
					    <td>'.$counter.'</td>
					    <td class="productimgname">
					    <input type="hidden" name="product_id[]" value="'.$data[0]['id'].'">
					    '.$image.'
					    <a href="javascript:void(0);">'.$data[0]['product_name'].'</a>
					    </td>
						<td><input type="text" name="hsn_code[]" class="form-control hsn_code" value="'.$data[0]['hsn_code'].'" readonly></td>
					    <td><input type="hidden" class="hidden_xQty" value="'.$quantity.'">
					    <input type="text" name="pQty[]" class="form-control xQty" value="1" style="width:50px"></td>
					    <td><input type="text" name="pPrice[]" class="form-control xPrice" value="'.$data[0]['price'].'" readonly></td>
						<td><input type="text" name="pUnit[]" class="form-control xPrice" value="'.$data[0]['unit'].'" readonly></td>
					    <td><input type="text" name="item_cgst[]" class="form-control item_cgst" value="0">
	                            <input type="hidden" name="item_cgst_amt[]" class="form-control item_cgst_amt" value="0"></td>
	                    <td><input type="text" name="item_sgst[]" class="form-control item_sgst" value="0">
	                            <input type="hidden" name="item_sgst_amt[]" class="form-control item_sgst_amt" value="0"></td>
					    <td><input type="text" name="pAmount[]" class="form-control xAmount" readonly = "readonly"></td>
					    <td>
					    <a href="javascript:void(0);" class="delete_item"><img src="'.base_url().'assets/img/icons/delete.svg" alt="svg"></a>
					    </td>
					</tr>';
		}
		else
		{
			$status = 0;
			$message = 'Product Out Of Stock!';
		}	

		echo json_encode(['status' => $status, 'message' => $message, 'html' => $html]);	
	}

	public function form_action($id = '')
	{
	
		$postdata = array(
			'customer_id' => $this->input->post("customer_id"),
			'sale_date' => date('Y-m-d', strtotime($this->input->post("sale_date"))),
			
		);

		if($id)
		{
			$postdata['updated_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$id);
			$this->db->update('sale',$postdata);
			$this->session->set_flashdata('message', 'Invoice Updated Successfully!');
		}
		else
		{
			$voucher_no = $this->db->query('SELECT MAX(`voucher_no`) AS voucher_no FROM `sale`')->result_array()[0]['voucher_no'] + 1; 
			$postdata['created_by'] = $this->session->userdata('user_id');
			$postdata['voucher_no'] = $voucher_no;
			$this->db->insert('sale',$postdata);
			$id = $this->db->insert_id();
			$this->session->set_flashdata('message', 'Invoice Added Successfully!');
		}


		$this->db->where('sale_id', $id)->delete('sale_items');

		$product_id = $this->input->post("product_id");
		$pQty = $this->input->post("pQty");
		$pPrice = $this->input->post("pPrice");
		$pUnit = $this->input->post("pUnit");
		$hsn_code = $this->input->post("hsn_code");
		$item_cgst = $this->input->post("item_cgst");
		$item_cgst_amt = $this->input->post("item_cgst_amt");
		$item_sgst = $this->input->post("item_sgst");
		$item_sgst_amt = $this->input->post("item_sgst_amt");
		$pAmount = $this->input->post("pAmount");

		for($i=0;$i<count($product_id);$i++)
		{
			$sale_items = array(
				'sale_id' => $id,
				'product_id' => $product_id[$i],
				'qty' => $pQty[$i],
				'price' => $pPrice[$i],
				'unit' => $pUnit[$i],
				'hsn_code' => $hsn_code[$i],
				'item_cgst' => $item_cgst[$i],
				'item_cgst_amt' => $item_cgst_amt[$i],
				'item_sgst' => $item_sgst[$i],
				'item_sgst_amt' => $item_sgst_amt[$i],
				'sub_total' => $pAmount[$i],
				'created_by' => $this->session->userdata('user_id'),
			);
			$this->db->insert('sale_items', $sale_items);

			$old_quantity = $this->db->select('quantity')->get_where('product_stock', ['product_id' => $product_id[$i]])->result_array()[0]['quantity'];
			
			$new_quantity = $old_quantity - $pQty[$i];

			$this->db->where('product_id', $product_id[$i]);
			$this->db->update('product_stock', ['quantity' => $new_quantity, 'updated_by' => $this->session->userdata('id')]);

			$this->db->where('id', $product_id[$i]);
			$this->db->update('products', ['quantity' => $new_quantity, 'updated_by' => $this->session->userdata('id')]);
		}

		$this->db->where('id', $id);
		$this->db->update('sale', ['totalCGstTax' => $_REQUEST['totalCGstTax'], 'totalSGstTax' => $_REQUEST['totalSGstTax'], 'grand_total' => $_REQUEST['xTotalPay'], 'discount' => $_REQUEST['dAmount'], 'final_total' => $_REQUEST['final_total'], 'paid_amount' => $_REQUEST['xTotalPaid'], 'due_amount' => $_REQUEST['xBalance']]);
		

		$this->session->set_flashdata('message', 'Submitted Successfully!');
		redirect('sale');
	
	}

	public function editsale($id = '')
	{
		$data['edit_data'] = $this->api_model->get_one_detail('sale', $id);
		$data['sale_items'] = $this->api_model->fetch_related_data('sale_items', $id, 'sale_id');
		$this->load->view('sale/addsale', $data);
	}

	
	public function removesale()
	{
		$id = $_POST['id'];
		$this->db->where('sale_id', $id)->delete('sale_items');
		$success = $this->db->where('id', $id)->delete('sale');
		
	
		if($success)
		{
			echo json_encode(['status' => 1, 'message' => 'Removed Successfully!']);
		}
	}

	
	public function view_sale($id = '')
	{		
		// $this->load->view('sale/sale_pdf_view', ['sale_id' => $id]);
		$this->load->view('sale/sale_details_view', ['sale_id' => $id]);
	}

	public function view_sale_pdf($id = '')
	{		
		$this->load->view('sale/sale_pdf_view', ['sale_id' => $id]);
		
	}



}
?>
