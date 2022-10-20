<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rating extends CI_Controller {

	public function index(){
		redirect('home');
	}

	public function updateRating($product_id){
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
					$this->load->view('file',array('error' => ' ')); //if user already logined show upload page
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
            $this->load->model('product_model');
            $uname = $this->session->userdata('username');
			$rated = $this->product_model->getUserRating($product_id, $uname);
			$data['err_message'] = "";
			if($rated != false){
				$data = $data + $rated;
			}
			$data['uname'] = $uname;
			$data['product'] = $product_id;
            $this->load->view('rate',$data);
            $this->load->view('template/footer');
        }
    }

    public function processUpdate(){
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
					$this->load->view('file',array('error' => ' ')); //if user already logined show upload page
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
            $this->load->model('product_model');
			//get data from post
			$uname = $this->input->post('uname');
			$product = $this->input->post('product');
			$overall = $this->input->post('ov');
			$easy = $this->input->post('ea');
			$smell = $this->input->post('sme');
			//determine if row already exist
			$rated = $this->product_model->getUserRating($product, $uname);
			if($rated != false){
				$this->product_model->updateRating($uname, $product,$easy, $smell, $overall);
				redirect('product/'.$product.'/');
			}else{
				//insert
				$this->product_model->insertRating($uname, $product,$easy, $smell, $overall);
				redirect('product/'.$product.'/');
			}
        }
    }
}