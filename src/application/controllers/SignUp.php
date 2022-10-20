<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

	public function index()
	{
		$this->load->view('template/header');
		$data['err_message'] = "";
		$this->load->view('signup/su-1', $data);
		$this->load->view('template/footer');
    }

	public function validateInsert(){ // Validate and process inputted data
		$this->load->model('user_model'); //for username and password
		$this->load->view('template/header');
		$uname = "";
		$Err = false;
        if($this->input->post('uname')){
			$uname = $this->input->post('uname');
			if (strlen($uname)>=15){
				$Err = true;
				$data['err_message'] = "Username invalid! Username should be less then or equal to 15 digits";
			}
			if ($this->user_model->uname_unique($uname)!=0){
				$Err = true;
				$data['err_message'] = "Sorry, your chosen username has already been used.";
			}
		} else {
			$Err = true;
			$data['err_message'] = "Input error. Please try again.";
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
		$this->load->model('profile_model'); // for email, gender,dob
		$email = "";
		if($this->input->post('email')){
			$email = $this->input->post('email');
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				if ($this->profile_model->email_unique($email)!=0){
					$Err = true;
					$data['err_message'] = "This email has already been taken by another user.";
				}
			}else{
				$Err = true;
				$data['err_message'] = "Email invalid format.";
			}
		} else {
			$Err = true;
			$data['err_message'] = "Input error. Please try again.";
		}
		$gender = NULL;
		if($this->input->post('gender')){
			$gender = $this->input->post('gender');
		}
		$dob = NULL;
		if($this->input->post('dob')){
			$dob = $this->input->post('dob');
		}
		//Security questions and answers
		$sq1 = NULL;
		if($this->input->post('sq1')){
			$sq1 = $this->input->post('sq1');
		}
		$sq1a = NULL;
		if($this->input->post('sq1a')){
			$sq1a = $this->input->post('sq1a');
		}else{
			$Err = true;
		}
		$sq2 = NULL;
		if($this->input->post('sq2')){
			$sq2 = $this->input->post('sq2');
		}
		$sq2a = NULL;
		if($this->input->post('sq2a')){
			$sq2a = $this->input->post('sq2a');
		}else{
			$Err = true;
		}
		if($Err){
			$this->load->view('signup/su-1', $data);
		}else{
			$this->user_model->insert($uname,$pwd,$sq1,$sq1a,$sq2,$sq2a);
			$date = date('Y-m-d');
			$this->profile_model->insert($uname,$email,$gender,$dob,$date);
			$this->sendVerificationEmail($email,$vcode);
			redirect('login'); //redirect('signUp/hair');
		}
		$this->load->view('template/footer');
	}
	

	public function sendVerificationEmail($email){
		$vcode = hash("sha256",$email.time());
		$this->load->model('profile_model');
		$this->profile_model->updateCode($email,$vcode);
		$url = base_url()."signUp/verifyEmail/".$email."/".$vcode."/";
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
		$this->email->subject('Hair Dye Product Review Account Verification');

		$message = "<p>Thank you for signing up at Hair Dye Product Review.<p><br>";
		$message .= "<p>Please click the following link to verify your email address to unlock all functionalities.<p><br><a href='".$url."'>".$url."</a><br>";

 		$this->email->message($message);
 		$this->email->send();
		$this->load->view('template/header');
		$this->load->view('home');
		$this->load->view('template/footer');
	}

	public function verifyEmail($email,$code){
		$this->load->model('profile_model');
		$status = $this->profile_model->VerifyEmail($email,$code);
		if($status){
			redirect('login');
		}else{
			$this->load->view('template/header');
			$data['email']=$email;
			$this->load->view('signup/verifyErr',$data);
			$this->load->view('template/footer');
		}
	}
}