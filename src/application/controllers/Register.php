<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller{
    // public function __contstruct()
    // {
    //     parent:: __contstruct(); //parent class of construct
    //     $this->load->library('form_validation');
    //     $this->load->library('encrypt');
    //     $this->load->model("Register_model");
    // }

    function index()
    {
        $this->load->view('templates/header');
        $this->load->view('pages/register'); 
        $this->load->view('templates/footer');
    }


    function validation()
    {
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->model("Register_model");
        $this->form_validation->set_rules('user_name','Name','required|trim');
        $this->form_validation->set_rules('user_email','Email Address','required|trim|valid_email|is_unique[register.email]');
        $this->form_validation->set_rules('user_password','Password','required|min_length[6]');
        $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
        $this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');


        if($this->form_validation->run())
        {
            $verification_key = md5(rand());
            // $encrypted_password = $this ->encryption->encrypt($this->input->post('user_password'));
            $encrypted_password = password_hash($this->input->post('user_password'),PASSWORD_DEFAULT);
            $data = array(
                'name' => $this->input->post('user_name'),
                'email' => $this->input->post('user_email'),
                'password' => $encrypted_password,
                'r_question' =>$this->input->post('security_question'),
                'r_answer' =>$this->input->post('security_answer'),
                'verification_key' => $verification_key
            );
            $id = $this->Register_model->insert($data);
            if($id > 0)
            {
                $subject = 'Please verify email for login';
                $message = "
                <p> Hi ".$this->input->post('user_name')." </p>

                <p> This is email verification mail.First you need to  varify your
                email by click this <a href=' ".base_url()."register/verify_email/".
                $verification_key."'>link</a>.</p>
                <p> Once you click this link your email will be verified.</p>
                <p> Thanks, </p>
                ";

                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' =>'mailhub.eait.uq.edu.au',
                    'smtp_port'=> 25,
                    // 'smtp_user'=> 's4594931@student.uq.edu.au',
                    'mailtype' =>'html',
                    'charset'=>'iso-8859-1',
                    'wordwrap'=> TRUE
                );
                $this->load->library('email');
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->from(get_current_user().'@student.uq.edu.au',get_current_user());
                $this->email->to($this->input->post('user_email'));
                $this->email->subject($subject);
                $this->email->message($message);
            
                if(!$this->email->send())
                {
                    echo 'register failure';
                    
                }else
                {
                    $this->session->set_flashdata('message','Please check your email for verification');
                    redirect('login');
                }
            }
        }else
        {
            $this->index();
        }
    }

    function validate_captcha() {
        $captcha = $this->input->post('g-recaptcha-response');
         $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcVs_sfAAAAACbXpfrw_xM-MhPLj6DNp1gxUc-3&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        if ($response . 'success' == false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function verify_email()
    {
        $this->load->model("Register_model");
        if($this->uri->segment(3))
        {
            $verification_key = $this->uri->segment(3);
            
            if($this->Register_model->verify_email($verification_key))
            {
                $data['message'] = '
                <h1 align="center"> Your Email has been successfully verified,now you can login from <a href="'.base_url().'login">here</a></h1>';
            }
            else
            {
                $data['message'] = '
                <h1 align="center"> Your Email has been successfully verified,now you can login from <a href="'.base_url().'login">here</a></h1>';
            }

            $this->load->view('pages/email_verification',$data);
        }
    }
}



?>