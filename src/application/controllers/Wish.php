<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wish extends CI_Controller {

	public function index() //display wishlist
	{
		if (!$this->session->userdata('logged_in'))//if not logged in
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('wish');
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->view('template/header');
			$this->load->model('user_product_model');
			$uname = $this->session->userdata('username');
			$data['uname']=$uname;
			$wish = $this->user_product_model->getWish($uname);
			if($wish != false){
				$data['wish']=$wish;
			}
			if(get_cookie('wishScroll')){
				$data['scroll'] = get_cookie('wishScroll');
				setcookie('wishScroll', '', time() - 3600, '/');
			}
			$this->load->view('wish',$data);
			$this->load->view('template/footer');
		}
	}
    
    public function add($product){
		if (!$this->session->userdata('logged_in'))//if not logged in
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('wish');
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->model('user_product_model');
			$uname = $this->session->userdata('username');
			$data['uname']=$uname;
			$this->user_product_model->add($uname,$product);
			redirect('product/'.$product.'/');
		}
	}

	public function delete($product ,$list=FALSE){
		if (!$this->session->userdata('logged_in'))//if not logged in
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('wish');
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->model('user_product_model');
			$uname = $this->session->userdata('username');
			$this->user_product_model->delete($uname,$product);
			if($list){
				redirect('wish');
			}else{
				redirect('product/'.$product.'/');
			}
		}
	}
}



?>



