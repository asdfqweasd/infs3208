<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CI_Controller {
    public function index()
	{
		$this->load->view('template/header');
        if (!$this->session->userdata('logged_in'))//if not logged in
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('profile');
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->model('profile_model');
			$uname = $this->session->userdata('username');
			$result = $this->profile_model->get($uname);
			foreach ($result as $row){
				$email = $row->email;
				$emailV = $row->email_verified;
				$gender = $row->gender;
				$dob = $row->DOB;
				$dateR = $row->DateRegistered;
			}
			$data['gender']=$gender;
			if($gender=='F'){
				$data['gender'] = 'Female';
			}elseif($gender=='M'){
				$data['gender'] = 'Male';
			}elseif($gender=='N'){
				$data['gender'] = 'Prefer not to tell';
			}
			$data['uname'] = $uname;
			$data['verify'] = $emailV;
			$data['email'] = $email;
			$data['dob'] = $dob;
			$data['dateReg'] = $dateR;
            $this->load->view('profile', $data);
		}
		$this->load->view('template/footer');
	}
	
	public function update(){
		if (!$this->session->userdata('logged_in'))//if not logged in
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('profile/update');
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->view('template/header');
			$this->load->model('profile_model');
			$uname = $this->session->userdata('username');
			$result = $this->profile_model->get($uname);
			foreach ($result as $row){
				$email = $row->email;
				$gender = $row->gender;
				$dob = $row->DOB;
			}
			$data['uname'] = $uname;
			$data['email'] = $email;
			$data['gender'] = $gender;
			$data['dob'] = $dob;
			$data['err_message']='';
			$this->load->view('profileUp',$data);
			$this->load->view('template/footer');
		}
	}

	public function validateUpdate(){
		if (!$this->session->userdata('logged_in'))//if not logged in
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('profile/update');
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->view('template/header');
			$uname = $this->session->userdata('username');
			$Err = false;
			$this->load->model('profile_model'); // for email, gender,dob
			$email = "";
			if($this->input->post('email')){
				$email = $this->input->post('email');
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$emailNotChanged = $this->profile_model->email_user($uname, $email);
					if ($this->profile_model->email_unique($email)!=0){
						if(!$emailNotChanged){
							$Err = true;
							$data['err_message'] = "This email has already been taken by another user.";
						}
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
			if($Err){
				$this->load->view('profileUpErr', $data);
			}else{
				if(!$emailNotChanged){
					$this->profile_model->update($uname,$email,$gender,$dob,$date);
					redirect('signUp/sendVerificationEmail/'.$email.'/');
				}else{
					$this->profile_model->update($uname,$email,$gender,$dob,$date);
					redirect('profile');
				}
			}
			$this->load->view('template/footer');
		}
	}

}
?>