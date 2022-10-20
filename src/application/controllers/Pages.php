<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller{
	public function index()
	{
		$this->load->model('user_model');	
		$data['error']= "wrong mail or password";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('templates/header');
		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$user_email = get_cookie('user_email'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->can_login($user_email, $password) )//check username and password correct
				{
					$user_data = array(
						'user_email' => $user_email,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					$this->load->view('home'); //if user already logined show main page
				}
			}else{
				$this->load->view('pages/login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$this->load->view('home'); //if user already logined show main page
		}
		$this->load->view('templates/footer');
	}
	
    #default is home 
    public function view($page = 'home'){
        // switch first char to Uppercase
        $data['title'] = ucfirst($page);
        $this->load->view('templates/header');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer');
    }

    public function check_login()
	{
		$this->load->model('user_model');		//load user model
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('templates/header');
		$user_email = $this->input->post('user_email'); //getting username from login form
		$password = $this->input->post('password'); //getting password from login form
		$remember = $this->input->post('remember'); //getting remember checkbox from login form
		if(!$this->session->userdata('logged_in')){	//Check if user already login
			if ( $this->user_model->can_login($user_email, $password) )//check username and password
			{
				
				$user_data = array(
					'user_email' => $user_email,
					'logged_in' => true 	//create session variable
				);
				if($remember) { // if remember me is activated create cookie
					set_cookie("user_email", $user_email, '300'); //set cookie username
					set_cookie("password", $password, '300'); //set cookie password
					set_cookie("remember", $remember, '300'); //set cookie remember
				}	

				$this->session->set_userdata($user_data); //set user status to login in session
				redirect('home'); // direct user home page
			}else
			{	
				$this->load->view('pages/login');	//if username password incorrect, show error msg and ask user to login
				echo "<div class=\"alert alert-danger\" role=\"alert\" align=\"center\"> Incorrect username or passwrod!! </div> "; 
			}
		}else{
			{
				redirect('home'); //if user already logined direct user to home page
			}
		$this->load->view('templates/footer');
		
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in'); //delete login status
		redirect('login'); // redirect user back to login
	}

	public function get_profile()
	{	
		$this->load->library('form_validation');
		$useremail = $this->session->userdata("user_email");
		$result = $this->User_model->get_infor($useremail);
       
		if(is_object($result))
		{
			$file_data =array(
				'Name' => $result ->name,
				'Email' => $result ->email,
				'Password' => $result ->password,
				'User_id' => $result ->u_id,
				'V_key' => $result ->verification_key,
				'Verified'=> $result->is_email_verified,
			);
			$this->session->set_userdata($file_data);
		}else
		{
			redirect('login');
		}
		$this->form_validation->set_rules('user_name','Name','required|trim');
        $this->form_validation->set_rules('user_email','Email Address','required|trim|valid_email|is_unique[register.email]');
        $this->form_validation->set_rules('user_password','Password','required|min_length[6]');

		if(!$this->form_validation->run()){
			$this->load->view('templates/header');
			$this->load->view('pages/profile');
			$this->load->view('templates/footer');
		}else
		{
			$data = array(
				'name' => $this->input->post('user_name',TRUE),
				'email' => $this->input->post('user_email',TRUE),
				'password' => $this->input->post('user_password',TRUE),
			);
			$result = $this->User_model->Update_User_Data($this->session->userdata('User_id'),$data);

			if($result > 0)
			{
				$file_data =array(
					'Name' => $data['name'],
					'Email' => $data['email'],
					'Password' => $data['password'],
				);
				$this->session->set_userdata($file_data);
				$this->session->set_flashdata("success_msg","Update successful");
				return redirect("profile");
			}else{
				$this->session->set_flashdata("error_msg","Update failure");
				return redirect("profile");
			}
		}


		
	}

	public function get_pass()
	{
		$this->load->model('Forgot_model');
		$user_email = $this->input->post('user_email');
		$question =  $this->input->post('security_question');
		$answer =  $this->input->post('security_answer');
		$result = $this->Forgot_model->got_password($user_email,$question,$answer);
		if(is_object($result))
		{
			$check_data =array(
				'Name' => $result ->name,
				'Email' => $result ->email,
				'Password' => $result ->password,
				'security_question' =>  $result ->r_question,
				'security_answer' => $result ->r_answer,

			);
			$this->session->set_userdata($check_data);
			redirect('reset');
		}else
		{
			redirect('login');
		}
	
	}

	public function resetPassword()
	{	$this->load->library('form_validation');
		$this->load->model('Forgot_model');
		$this->form_validation->set_rules('new_pass','Password','required|min_length[6]');
		

		// $user_email = $this->session->userdata("Email");
		// $data = array(
		// 	'password' => password_hash($this->input->post('new_pass'),PASSWORD_DEFAULT),
		// );
		// if( $this->Forgot_model->Update_User_Password($user_email,$data)){
		// 	redirect('login');
		// }
		if(!$this->form_validation->run()){
			$this->session->set_flashdata("error_msg","Reset failure, Your password must longer than 6");
			$this->load->view('templates/header');
			$this->load->view('pages/reset');
			$this->load->view('templates/footer');
			
		}else
		{	
			$user_email = $this->session->userdata("Email");
			$data = array(
				'password' => password_hash($this->input->post('new_pass'),PASSWORD_DEFAULT),
			);
			if( $this->Forgot_model->Update_User_Password($user_email,$data)){
				$this->session->set_flashdata("success_msg","Update successful");
				redirect('login');
			}
		}
		
	}

}

?>