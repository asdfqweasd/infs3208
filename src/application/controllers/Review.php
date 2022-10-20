<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

	public function index(){
		redirect('home');
	}

	public function displayReviewForm($product_id){
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
            // check if email verified
            $this->load->model('profile_model');
            $uname = $this->session->userdata('username');
            if($this->profile_model->verified($uname)){ //if verified
                //get product details
                    $this->load->model('product_model');
                    $detail = $this->product_model->get($product_id);
                    $data['uname'] = $uname;
                    $data['product_id'] = $product_id;
                    if($detail != false){
                        $data = $data + $detail;
                        $this->load->view('review',$data);
                    }else{
                        $this->load->view('product_error');
                    }
            }else{//if not verified, load view profile and alert please verify email first
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
                $data['useVerifiedFunction']=true;
                $this->load->view('profile', $data);
            }
            
        }
        $this->load->view('template/footer');
    }

    public function processReview(){
        $uname="";
        if($this->input->post('uname')){
            $uname = $this->input->post('uname');
        }
        $product="";
        if($this->input->post('product')){
            $product = $this->input->post('product');
        }
        $con="";
        if($this->input->post('con')){
            $con = $this->input->post('con');
        }
        $this->load->model('product_model');
        $insert = $this->product_model->insertReview($product, $uname, $con);
        if($insert != false){
            $this->load->view('template/header');
            $detail = $this->product_model->get($product);
            $data['reviewID'] = $insert;
            if($detail != false){
                $data = $data + $detail;
                $this->load->view('reviewImg',$data);
            }
        }
        
        $this->load->view('template/footer');
    }

    public function reviewPhotos(){
        $this->load->model('product_model');
        $id = $this->input->post('reviewID');
        $product = $this->input->post('product');
        $err = false;
        if($this->input->post('upload')){
            $data=array();
            $count = count($_FILES['userfiles']['name']);
            $this->load->library('image_lib');

            for($i=0;$i<$count;$i++){
                if(!empty($_FILES['userfiles']['name'][$i])){
                    $_FILES['userfile']['name'] = $_FILES['userfiles']['name'][$i];
                    $_FILES['userfile']['type'] = $_FILES['userfiles']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $_FILES['userfiles']['tmp_name'][$i];
                    $_FILES['userfile']['error'] = $_FILES['userfiles']['error'][$i];
                    $_FILES['userfile']['size'] = $_FILES['userfiles']['size'][$i];

                    $new_name = $id.'N'.$_FILES["userfile"]['name'];
                    $config['upload_path'] = './reviewImage/';
                    $config['allowed_types'] = 'jpg|gif|png|jpeg';
                    $config['max_size'] = 10000000;
                    $config['max_width'] = 1024;
                    $config['max_height'] = 1024;
                    $config['file_name'] = $new_name;
                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('userfile')) {
                        $err = true;
                        $data['err'][$i] = array('error' => $this->upload->display_errors());
                        
                    } else {
                        $imageData = $this->upload->data();
                        $configs['image_library'] = 'gd2';
                        $configs['source_image'] = $imageData['full_path'];
                        $configs['maintain_ratio'] = TRUE;
                        $configs['height'] = 150;
                        $this->image_lib->initialize($configs);
                        $this->image_lib->resize();
            
                        $this->product_model->insertRImg($id,$this->upload->data('file_name'));
                    }
                }
            }
            if($err){
                $this->load->view('template/header');
                $detail = $this->product_model->get($product);
                $data['brand'] = $detail['brand'];
                $data['name'] = $detail['name'];
                $data['color'] = $detail['color'];
                $data['reviewID'] = $id;
                $data['id'] = $product;
                $this->load->view('reviewImg',$data);
                $this->load->view('template/footer');
            }else{
                redirect('product/'.$product.'/');
            }
        }else{
            echo "error";
        }
        
        
        
    }


    //public function editReview(){}

    //public function deleteReview
}
