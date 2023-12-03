<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent ::__construct();
	}

	public function index()
	{
	
		$this->load->view('login/login_view');
	}

	public function check_login()
	{

		$mobile_no = $_POST['mobile_no'];
		$password = $_POST['password'];



		$res = $this->db->query('SELECT * FROM users WHERE mobile_no = '.$mobile_no.' AND password = '.$password.'');

		if($res->num_rows() > 0)
		{
			$row = $res->result_array();
			$DB_Password = $row[0]['password'];
			$mobile_no = $row[0]['mobile_no'];
			$id = $row[0]['id'];

			$full_name = $row[0]['first_name'].' '.$row[0]['last_name'];

			$newdata = ['user_id' => $id, 'mobile_no' => $mobile_no, 'full_name' => $full_name];
			
			if($DB_Password == $password)
			{
				$this->session->set_userdata($newdata);

				redirect('dashboard');		
			}
			else{


				$message = "Invalid Password";
				$class = "alert-danger";
				$this->session->set_flashdata('message', $message);
				redirect("login");
			}

		}
		else{
			$message = 'Invalid Mobile number or Password';
			$class = "alert-danger";
			$this->session->set_flashdata('message', $message);
			redirect("login");
		}

	}



	public function CheckOTP()
	{
		$tmp_Shopkeeper_Id = $_SESSION['tmp_Shopkeeper_Id'];
		$OTP = $_POST['OTP'];

		
		$res = $this->db->query("SELECT OTP FROM shopkeeper_account WHERE Shopkeeper_Id = '$tmp_Shopkeeper_Id'");
		//pre($this->db->last_query());exit;
		if($res->num_rows() > 0)
		{
			$row = $res->result_array();
			$dbOTP = $row[0]['OTP'];

			if($dbOTP == $OTP){
				$_SESSION['Shopkeeper_Id'] =  $tmp_Shopkeeper_Id;

				$client  = @$_SERVER['HTTP_CLIENT_IP'];
				$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
				$remote  = $_SERVER['REMOTE_ADDR'];

				if(filter_var($client, FILTER_VALIDATE_IP))
				{
					$ip = $client;
				}
				elseif(filter_var($forward, FILTER_VALIDATE_IP))
				{
					$ip = $forward;
				}
				else
				{
					$ip = $remote;
				}

				$res_update = $this->db->query("UPDATE shopkeeper_account SET last_login_ip = '$ip' WHERE Shopkeeper_Id = '$tmp_Shopkeeper_Id'");

				echo '1';
			}
			else{
				echo '0';
			}

		}

	}


	public function logout()
	{
		if($this->session->userdata('user_id') == '')
		{
			redirect('login');
		}
		$this->session->sess_destroy();
		redirect('login');
	}

	public function forget_password()
	{

		if(isset($_POST['btn_forget']))
		{
			$Mobile_Number = $_POST['Mobile_Number'];

			$sql = $this->db->query("SELECT * FROM super_admin_account WHERE Phone_No = '$Mobile_Number'");

			if($sql->num_rows() > 0)
			{
				$row = $sql->result_array();
				$Status = $row[0]['Status'];
				$Admin_Id = $row[0]['Admin_Id'];

				if($Status == 'Yes')
				{
					$Password = rand(000000,999999);
					$MD5Pass = md5($Password);
					$text_msg = "We have received request for new password for your Crecer Trade account.\nNew password is: ".$Password;

					$text_msg = urlencode($text_msg);

					$url = SMS_URL."/sendsms/sendsms.php?username=".ADMIN_SMS_USERNAME."&password=".ADMIN_SMS_PASSWORD."&type=TEXT&sender=".ADMIN_SMS_SENDER_ID."&mobile=".$Mobile_Number."&message=".$text_msg;

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$output = curl_exec($ch);

					curl_close($ch);

					$res_update = $this->db->query("UPDATE super_admin_account SET Password = '$MD5Pass' WHERE Admin_Id = '$Admin_Id'");

					$message = "<strong>Success! </strong><br/>Password sent to your registered mobile number";
					$class = "alert-success";
					$status = 'success';

				}
				else
				{
					$message = "<strong>Sorry! </strong><br/>Your account is deactivate";
					$class = "alert-danger";
					$status = 'fail';
				}


			}
			else
			{
				$message = '<strong>Sorry! </strong><br/>Account not found';
				$class = "alert-danger";
				$status = 'fails';
			}

			$this->session->set_flashdata(array('message', $message, 'class' => $class, 'status' => $status));
			redirect("admin/login");
		}
	}
	
}
?>
