<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	public function index()
	{
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true,
						'method' => 'db' 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					$this->load->view('home'); //if user already logined show main page
				}
			}else{
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			redirect('home'); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}
	
	public function check_login()
	{
		$this->load->model('user_model');		//load user model
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$username = $this->input->post('username'); //getting username from login form
		$password = $this->input->post('password'); //getting password from login form
		$remember = $this->input->post('remember'); //getting remember checkbox from login form
		if(!$this->session->userdata('logged_in')){	//Check if user already login
			$loginCheck = $this->user_model->login($username, $password);
			if ( $loginCheck == 'true' )//check username and password
			{
				$user_data = array(
					'username' => $username,
					'logged_in' => true,
					'method' => 'db' 	//create session variable
				);
				if($remember) { // if remember me is activated create cookie
					set_cookie("username", $username, '300'); //set cookie username
					set_cookie("password", $password, '300'); //set cookie password
					set_cookie("remember", $remember, '300'); //set cookie remember
				}
				$this->session->set_userdata($user_data); //set user status to login in session
				redirect('login'); // direct user home page
			}else
			{
				if($loginCheck == 'password'){
					$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect password!! </div> ";
				}else{
					$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Username does not exist!! </div> ";
				}
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			{
				redirect('login'); //if user already logined direct user to home page
			}
		$this->load->view('template/footer');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in'); //delete login status
		setcookie('username', '', time() - 3600, '/');
		setcookie('password', '', time() - 3600, '/');
		setcookie('remember', '', time() - 3600, '/');
		redirect('login'); // redirect user back to login
	}

	public function ForgotPassword(){//ask to enter username
		$this->load->view('template/header');
		$this->load->view('password/forgetPassword');
		$this->load->view('template/footer');
	}

	public function forgotPasswordEmail(){//send email
		$this->load->model('user_model');
		$uname = "";
		$Err = false;
        if($this->input->post('uname')){
			$uname = $this->input->post('uname');
			if ($this->user_model->uname_unique($uname)==0){
				$Err = true;
			}
		} else {
			$Err = true;
		}
		if(!$Err){
			$this->load->model('profile_model');
			$email = $this->profile_model->getEmail($uname);
			$vcode = hash('sha256',$uname.time());
			$this->load->model('profile_model');
			$this->user_model->updateCode($uname,$vcode);
			$url = base_url()."login/resetPassword/".$email."/";
			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_user' => 'zita6630@gmail.com', // change it to yours
				'smtp_pass' => 'shanae1218', // change it to yours
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE ,
				'starttls' => TRUE ,
				'newline' => "\r\n"
			);
			$this->email->initialize($config);
			$this->email->from("zita6630@gmail.com", "Kei Yin LUK");
			$this->email->to($email);
			$this->email->subject('Hair Dye Product Review Reset Password');
	
			$message = "<p>Thank you for returning Hair Dye Product Review.<p><br>";
			$message .= "<p>Please click the following link and use the code to reset your password.<p><br><a href='".$url."'>".$url."</a><br><p>Verification Code: ".$vcode."</p>";
	
			 $this->email->message($message);
			 $this->email->send();
			 $this->load->view('template/header');
			 $this->load->view('password/forgetPassword-2');//show "an email has been sent to you blablabla"
			 $this->load->view('template/footer');
		}else{
			$this->load->view('template/header');
			$data['err']="Sorry, the username you inputted does not exist in our database.";
			$this->load->view('password/setPasswordErr',$data);
			$this->load->view('template/footer');
		}

	}

	public function resetPassword($email){//ask user to enter code, answer security questions as well as enter new password
		$this->load->model('profile_model');
		$this->load->model('user_model');
		$uname = $this->profile_model->getUnameByEmail($email);
		if ($uname != NULL){
			$data['uname'] = $uname;
			$sq = $this->user_model->get($uname);
			foreach ($sq as $row){
				$sq1 = $row->sq1_id;
				$sq2 = $row->sq2_id;
			}
			$data['sq1'] = $sq1;
			$data['sq2'] = $sq2;
			$data['err_message'] = "";
			$this->load->view('template/header');
			$this->load->view('password/resetPassword',$data);
			$this->load->view('template/footer');
		}else{
			$this->load->view('template/header');
			$data['err']="Sorry, an error occured. Please check if you have copied the correct URL from the email.";
			$this->load->view('password/setPasswordErr',$data);
			$this->load->view('template/footer');
		}
	}

	public function verifyInsertNewPassword($uname){
		$this->load->model('user_model');
		$this->load->view('template/header');
		$Err = false;
		$vcode = "";
		if($this->input->post('vcode')){
			$vcode = $this->input->post('vcode');
			if (strlen($vcode)!=64){
				$Err = true;
				$data['err_message'] = "Verification Code should be 64-digit.";
			}
			if (!$this->user_model->checkCode($uname, $vcode)){
				$Err = true;
				$data['err_message'] = "Sorry, the Verification Code does not match!";
			}
		} else {
			$Err = true;
			$data['err_message'] = "Input error. Please try again.";
		}

		$sq1a = NULL;
		if($this->input->post('sq1a')){
			$sq1a = $this->input->post('sq1a');
		}else{
			$Err = true;
			$data['err_message'] = "Input error. Please try again.";
		}
		$sq1Status = $this->user_model->checkSq1Ans($uname,$sq1a);
		if(!$sq1Status){
			$Err = true;
			$data['err_message'] = "Security Question 1 Answer Incorrect!";
		}

		$sq2a = NULL;
		if($this->input->post('sq2a')){
			$sq2a = $this->input->post('sq2a');
		}else{
			$Err = true;
			$data['err_message'] = "Input error. Please try again.";
		}
		$sq2Status = $this->user_model->checkSq2Ans($uname,$sq2a);
		if($sq2Status == false){
			$Err = true;
			$data['err_message'] = "Security Question 2 Answer Incorrect!";
		}

		$pwd = "";
		$pwd2 = "";
		if(($this->input->post('pwd')) & ($this->input->post('pwd2'))){
			$pwd = $this->input->post('pwd');
			$pwd2 = $this->input->post('pwd2');
			if ($pwd==$pwd2){
				$uppercase = preg_match('@[A-Z]@', $pwd);
				$lowercase = preg_match('@[a-z]@', $pwd);
				$number    = preg_match('@[0-9]@', $pwd);
				$specialChars = preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $pwd);
				if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pwd) < 8) {
					$Err = true;
					$data['err_message'] = "A password must have 8-25 digits and contains at least 1 Capital letter, 1 lowercase letter, 1 number and 1 special character.";
				}
			}else{
				$Err = true;
				$data['err_message'] = "The 2 inputted password does not match!";
			}
		} else{
			$Err = true;
			$data['err_message'] = "Input error. Please try again.";
		}

		if($Err){
			$data['uname'] = $uname;
			$data['sq1'] = $this->input->post('sq1');
			$data['sq2'] = $this->input->post('sq2');
			$this->load->view('password/resetPassword',$data);
		}else{
			$this->user_model->updatePwd($uname,$pwd);
			redirect('home');
		}

	}

	
}
?>
