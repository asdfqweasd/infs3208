<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('template/header');
		$this->load->model('product_model');
		$this->load->model('user_product_model');
		$data['loggedin'] = FALSE;
		if($this->session->userdata('logged_in')){
			$uname = $this->session->userdata('username');
			$data['loggedin'] = TRUE;
		}
		$review = $this->product_model->topReviewed();
		$products = array();
		foreach($review as $row){
			$id = $row->product;
			$num = $row->numReview;
			$add = $this->product_model->get($id);
			$add['num'] = $num;
			$wish = FALSE;
			if($this->session->userdata('logged_in')){
				if($this->user_product_model->checkExist($uname, $id)){
					$wish = TRUE;
				}
			}
			$add['wish'] = $wish;
			$products[] = $add;
		}
		$data['products']=$products;
		$this->load->view('home',$data);
		$this->load->view('template/footer');
	}
}
