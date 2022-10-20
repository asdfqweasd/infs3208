<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index(){
		$this->load->view('template/header');
		$this->load->model('product_model');
		$this->load->model('user_product_model');
		$data['loggedin'] = FALSE;
		if($this->session->userdata('logged_in')){
			$uname = $this->session->userdata('username');
			$data['loggedin'] = TRUE;
		}
		$keyword = "";
		if ($this->input->get('headersearch')){
			$keyword = $this->input->get('headersearch');
		}
		$sear = $this->product_model->search($keyword);
		if($sear == 'no result'){
			$data['err']= "No result found";
			$this->load->view('search_empty',$data);
		}else{
			$products = array();
			foreach($sear as $row){
				$id = $row->id;
				$name = $row->name;
                $color = $row->color;
                $brand = $row->brand;
                $des = $row->description;
                $category1 = $row->category1;
                $category2 = $row->category2;
				$img = $row->img_path;
				$brandN = NULL;
				$cat1N = NULL;
				$cat2N =NULL;
				$wish = FALSE;
				if($brand!=NULL){
					$brandN = $this->product_model->getBrandName($brand);
				}
				if($category1!=NULL){
					$cat1N = $this->product_model->getCatName($category1);
				}
				if($category2!=NULL){
					$cat2N = $this->product_model->getCatName($category2);
				}
				if($this->session->userdata('logged_in')){
					if($this->user_product_model->checkExist($uname, $id)){
						$wish = TRUE;
					}
				}
				$add = array(
					'id' => $id,
					'name' => $name,
					'color' => $color,
					'brand' => $brandN,
					'description' => $des,
					'category1' => $cat1N,
					'category2' => $cat2N,
					'img_path' => $img,
					'wish' => $wish
				);
				$products[] = $add;
			}
			$data['products']= $products;
			$data['key']= $keyword;
			if(get_cookie('searchKeyword')){
				if((get_cookie('searchKeyword')==$keyword)||(($keyword=="")&&(get_cookie('searchKeyword'=="emptysearch")))){
					if(get_cookie('searchScroll')){
						$data['scroll'] = get_cookie('searchScroll');
						setcookie('searchScroll', '', time() - 3600, '/');
						setcookie('searchKeyword', '', time() - 3600, '/');
					}
				}
				
			}
			
			$this->load->view('search', $data);
		}
		$this->load->view('template/footer');
	}

	public function searchCat($id = NULL)
	{
		$this->load->view('template/header');
		$this->load->model('product_model');
		$this->load->model('user_product_model');
		$data['loggedin'] = FALSE;
		if($this->session->userdata('logged_in')){
			$uname = $this->session->userdata('username');
			$data['loggedin'] = TRUE;
		}
		$sear = $this->product_model->searchCat($id);
		if($sear == 'invalid'){
			$data['err']= "Invalid URL";
			$this->load->view('search_empty',$data);
		}elseif($sear == 'no result'){
			$data['err']= "No result found";
			$this->load->view('search_empty',$data);
		}else{
			$products = array();
			foreach($sear as $row){
				$id = $row->id;
				$name = $row->name;
                $color = $row->color;
                $brand = $row->brand;
                $des = $row->description;
                $category1 = $row->category1;
                $category2 = $row->category2;
				$img = $row->img_path;
				$brandN = NULL;
				$cat1N = NULL;
				$cat2N =NULL;
				$wish = FALSE;
				if($brand!=NULL){
					$brandN = $this->product_model->getBrandName($brand);
				}
				if($category1!=NULL){
					$cat1N = $this->product_model->getCatName($category1);
				}
				if($category2!=NULL){
					$cat2N = $this->product_model->getCatName($category2);
				}
				if($this->session->userdata('logged_in')){
					if($this->user_product_model->checkExist($uname, $id)){
						$wish = TRUE;
					}
				}
				$add = array(
					'id' => $id,
					'name' => $name,
					'color' => $color,
					'brand' => $brandN,
					'description' => $des,
					'category1' => $cat1N,
					'category2' => $cat2N,
					'img_path' => $img,
					'wish' => $wish
				);
				$products[] = $add;
			}
			$data['products']= $products;
			$data['key']="";
			$this->load->view('search', $data);
		}
		$this->load->view('template/footer');
	}
}