<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ajax extends CI_Controller {

    public function uname(){
        $this->load->model('user_model'); // load user_model
        $uname = "";
        if($this->input->post('uname')){
            $uname = $this->input->post('uname');
        }
        $data = $this->user_model->uname_unique($uname);
        echo $data;
    }

    public function email(){
        $this->load->model('profile_model'); // load profile_model
        $email = "";
        if($this->input->post('email')){
            $email = $this->input->post('email');
        }
        $data = $this->profile_model->email_unique($email);
        if(($data==1) & ($this->session->userdata('logged_in'))){
            $uname = $this->session->userdata('username');
            $result = $this->profile_model->email_user($uname,$email);
            if($result==true){
                $data= 0;
            }
        }
        echo $data;
    }

    //review continuous load
    public function loadreview(){
        $this->load->model('product_model');
        $id = "";
        $start = "";
        if($this->input->get('id')){
            $id = $this->input->get('id');
        }
        if($this->input->get('start')){
            $start = $this->input->get('start');
        }
        $data = $this->product_model->getReview($id,5,$start);
        if($data!=false){
            $output="";
            foreach($data as $row){
                //process data into html
                $output .= "<div class='container-md my-4 border border-dark'>";
                $output .="<div class='row'>";
                $output .= "<div class='col'>";
                $output .= "<p>Posted by ".$row->user."</p>";
                $output .= "<p>at ".$row->timestamp."(UTF+0)</p>";
                $output .= "</div>";
                $output .= "<div class='col'>";
                $output .= "<p>".$row->content."</p>";
                
                $img = $this->product_model->getRImg($row->id);
                
                if($img != false){
                    foreach($img as $i){
                        $output .= "<img class='m-3' src='".base_url()."/reviewImage/".$i->img."' alt='Product Image'>";
                    }
                }
                $output .= "</div>";
                $output .= "</div>";
                $output .= "</div>";
            }
            echo $output;
        }else{
            echo "false";
        }
    }

    public function searchbox(){
        $this->load->model('product_model');
        $keyword = "";
        if($this->input->get('headersearch')){
            $keyword = $this->input->get('headersearch');
        }
        $search = $this->product_model->searchAuto($keyword);
        if(isset($search)){
            echo json_encode($search);
        }else{
            echo "";
        }
    }
}
?>
