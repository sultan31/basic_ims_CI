<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_id') == '')
		{
			redirect('login');
		}

		$config = array();
		$config['upload_path']          = $this->config->item('upload_url').'/'.$this->config->item('profile_upload_url');
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

	public function view_profile($id = '')
	{
		$data['id'] = $id;
		$data['user_data'] = $this->api_model->get_one_detail('users', $id);
		
		$this->load->view('profile/profile_view', $data);
	}
	
	public function form_action($id = '')
	{
		
	
		$postdata = array(
			'first_name' => $this->input->post("first_name"),
			'last_name' => $this->input->post("last_name"),
			'email' => $this->input->post("email"),
			'mobile_no' => $this->input->post("mobile_no"),
			'password' => $this->input->post("password")
		);

		if($id)
		{
			$postdata['updated_by'] = $this->session->userdata('user_id');
			$this->db->where('id',$id);
			$this->db->update('users',$postdata);
			$this->session->set_flashdata('message', 'Profile Updated Successfully!');
		}
		

		if(isset($_FILES) && !empty($_FILES['user_photo']['name']))
		{
			if($this->input->post('saved_user_photo') != '')
			{
				unlink($this->config->item('upload_url').'/'.$this->config->item('profile_upload_url').'/'.$this->input->post('saved_user_photo'));
			}
			if($this->upload->do_upload('user_photo'))
			{
	      		$upload_data = $this->upload->data();
	    		$updatetArray['user_photo'] = $upload_data["file_name"];
	    		$this->db->where('id',$id);
			$this->db->update('users',$updatetArray);
						
			}
		}
		

		$this->session->set_flashdata('message', 'Submitted Successfully!');
		redirect('Profile/view_profile/'.$id);
	
	}


}
?>
