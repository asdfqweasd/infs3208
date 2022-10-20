<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller{
    public function __contstruct()
    {
        parent:: __contstruct(); //parent class of construct
        $this->load->library('form_validation');
        $this->load->model("post_model");
    }
    public function index(){
        
        // switch first char to Uppercase
        if(!$this->session->userdata('logged_in'))
        {
            redirect('login');
        }
        $data['title'] = 'Latest Posts';

        $data['posts'] = $this -> Post_model -> get_posts();

        $this->load->view('templates/header');
        $this->load->view('posts/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL){
        $data['post'] = $this ->Post_model -> get_posts($slug);
        if(empty($data['post'])){
            show_404( );
        }

        $data['title'] = $data['post']['title'];
        $this->load->view('templates/header');
        $this->load->view('posts/view', $data);
        $this->load->view('templates/footer');
    }

    public function create(){
        if(!$this->session->userdata('logged_in'))
        {
            redirect('login');
        }
        $data['title'] = "Create Post";
        $this->load->library('form_validation');
        $this -> form_validation -> set_rules('title', 'Title','required');

        $this -> form_validation -> set_rules('body', 'Body','required');

        // flase means validation doesn't run else means form has been submiited
        if($this-> form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('posts/create', $data);
            $this->load->view('templates/footer');
        }else{
            $this -> Post_model ->create_post();
            redirect('posts');
        }

    }

    public function delete($id){
            $this -> Post_model -> delete_post($id);
            redirect('posts');
    }

    public function edit($slug){
        $data['post'] = $this ->Post_model -> get_posts($slug);
        if(empty($data['post'])){
            show_404( );
        }

        $data['title'] = 'Edit Post';
        $this->load->view('templates/header');
        $this->load->view('posts/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update(){
        $this->Post_model->update_post();
        redirect('posts');
    }

}

?>