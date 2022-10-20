<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller
{
	
    public function index()
    {
		$this->load->model('File_model');
		$data = array(); 

        // Get files data from the database 
        $data['files'] = $this->file->getRows(); 
         
        // Pass the files data to view 
        $this->load->view('pages/file', $data); 

		$this->load->view('templates/header'); 
    	if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->check_login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
		 			$this->load->view('pages/file',array('error' => ' ')); //if user already logined show upload page
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->view('pages/file',array('error' => ' ')); //if user already logined show login page
		}
		$this->load->view('templates/footer');
    }
    // public function do_upload() {
	// 	$this->load->model('File_model');
    //     $config['upload_path'] = './uploads/';
	// 	$config['allowed_types'] = 'jpg|mp4|mkv';
		

	// 	$this->load->library('upload');
	// 	$this->upload->initialize($config); 
             
	// 	if ( ! $this->upload->do_upload('userfile')) {
	// 		$this->session->set_flashdata("error_msg","Upload failure");
    //         $this->load->view('templates/header');
    //         $this->load->view('pages/file');
    //         $this->load->view('templates/footer');
    //     } else {
	// 		$this->File_model->upload($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('user_email'));
	// 		$this->session->set_flashdata("success_msg","Upload successful");
    //         $this->load->view('templates/header');
    //         $this->load->view('pages/file');
    //         $this->load->view('templates/footer');
    //     }
	// }


	public function do_upload()
	{
		$this->load->model('File_model');
		$data = array(); 
		// $errorUploadType = $statusMsg = '';
		 // If file upload form submitted 
		 if($this->input->post('fileSubmit')){ 
             
            // If files are selected to upload 
            if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
                $filesCount = count($_FILES['files']['name']); 
                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']     = $_FILES['files']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i]; 
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i]; 
                     
                    // File upload configuration 
                    $config['upload_path'] = './uploads/';  
                    $config['allowed_types'] = '*'; 
                    //$config['max_size']    = '100'; 
                    //$config['max_width'] = '1024'; 
                    //$config['max_height'] = '768'; 
                     
                    // Load and initialize upload library 
                    $this->load->library('upload', $config); 
                    $this->upload->initialize($config); 
                     
                    // Upload file to server 
                    if($this->upload->do_upload('file')){ 
                        // Uploaded file data 
						$this->File_model->upload($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('user_email'));
                    }else{  
                        $errorUploadType .= $_FILES['file']['name'].' | ';  
                    } 
                } 
				$this->session->set_flashdata("success_msg","Upload successful");
				$this->load->view('templates/header');
				$this->load->view('pages/file');
				$this->load->view('templates/footer');
                 
                // $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
                if(!empty($uploadData)){ 
                    // Insert files data into the database 
					$this->File_model->upload($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('user_email'));
					$this->load->view('templates/header');
					$this->load->view('pages/file');
					$this->load->view('templates/footer');
                    // Upload status message 
                    // $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
                // }else{ 
                //     $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
                } 
            }else{ 
                // $statusMsg = 'Please select image files to upload.'; 
				$this->session->set_flashdata("error_msg","Upload failure");
				$this->load->view('templates/header');
				$this->load->view('pages/file');
				$this->load->view('templates/footer');
            } 
        } 
         
        
	}



	function dragDropUpload(){ 
		$this->load->model('File_model');
        if(!empty($_FILES)){ 
            // File upload configuration 
            $config['upload_path'] = './uploads/'; 
            $config['allowed_types'] = '*'; 
             
            // Load and initialize upload library 
            $this->load->library('upload', $config); 
            $this->upload->initialize($config); 
             
            // Upload file to the server 
            if($this->upload->do_upload('file')){ 
				$this->File_model->upload($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('user_email'));
            } 
        } 
    } 
}

