<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index(){
		redirect('product');
	}

	public function products($product_id = NULL)
	{
		$this->load->view('template/header');
		$this->load->model('product_model');
		$this->load->model('user_product_model');
		$data['loggedin'] = FALSE;
		if($this->session->userdata('logged_in')){
			$uname = $this->session->userdata('username');
			$data['loggedin'] = TRUE;
		}
		$detail = $this->product_model->get($product_id);
		$data['product_id'] = $product_id;
		if($detail != false){
			$data = $data + $detail;
			if($this->session->userdata('logged_in')){
				$wish = FALSE;
				if($this->user_product_model->checkExist($uname, $product_id)){
					$wish = TRUE;
				}
				$data['wish'] = $wish;
			}
			$overallRatings = $this->product_model->getOverallRating($product_id);
			if($overallRatings != null){
				$data['overall'] = $overallRatings;
			}
			$easyRatings = $this->product_model->getEasyRating($product_id);
			if($easyRatings != null){
				$data['easy'] = $easyRatings;
			}
			$smellRatings = $this->product_model->getSmellRating($product_id);
			if($smellRatings != null){
				$data['smell'] = $smellRatings;
			}
			//load reviews
			$review = $this->product_model->getReview($product_id,3,0);
			if($review != false){
				$reviews = array();
				foreach($review as $row){
					$id = $row->id;
					$uname = $row->user;
					$time = $row->timestamp;
					$con = $row->content;
					$img = array();
					$rimg = $this->product_model->getRImg($id);
					if($rimg!=false){
						foreach($rimg as $i){
							$img[]=$i->img;
						}
					}
					$add = array(
						'id' => $id,
						'uname' => $uname,
						'time' => $time,
						'content' =>$con,
						'img' => $img
					);
					$reviews[] = $add;
				}
				$data["review"] = $reviews;
			}
			$this->load->view('product', $data);
		}else{
			$this->load->view('product_error');
		}
		$this->load->view('template/footer');
	}

	//add product before review
	public function addProduct(){ //first page
		$this->load->view('template/header');
		$this->load->model('product_model');
		$data['brands']=$this->product_model->getBrands();
		$data['cats']=$this->product_model->getCats();
		$this->load->view('addProduct',$data);
		$this->load->view('template/footer');
	}

	public function productName($brand){ //second page
		$this->load->view('template/header');
		$this->load->model('product_model');
		$data['brand']=$brand;
		$data['bname']=$this->product_model->getBrandName($brand);
		$data['names'] = $this->product_model->getNames($brand);
		$data['cats']=$this->product_model->getCats();
		$this->load->view('selectProductN',$data);
		$this->load->view('template/footer');    
	}
	
	public function productColor($brand,$id){ //third page
		$this->load->view('template/header');
		$this->load->model('product_model');
		$data['brand']=$brand;
		$data['bname']=$this->product_model->getBrandName($brand);
		$name = $this->product_model->getName($id);
		$data['name'] = $name;
		$data['colors'] = $this->product_model->getColors($brand,$name->name);
		$data['cats']=$this->product_model->getCats();
		$this->load->view('selectProductC',$data);
		$this->load->view('template/footer');    
	}
	
	public function add(){ //add product
		$this->load->model('product_model');
		$bname = "";
		$brand = "";//for brand id
		$pname = "";
		$color = "";
		$des = "";
		$cat1 = "";
		$cat2 = "";

		if($this->input->post("bname")){
			$bname = $this->input->post("bname");
			$brand = $this->product_model->insertBrand($bname);
		}elseif($this->input->post("brand")){
			$brand = $this->input->post("brand");
		}

		if($this->input->post("pname")){
			$pname = $this->input->post("pname");
		}elseif($this->input->post("name")){
			$pid = $this->input->post("name");
			$pname = $this->product_model->getName($pid)->name;
		}

		if($this->input->post("color")){
			$color = $this->input->post("color");
		}

		$productDetail = $this->product_model->getProductDetail($brand,$pname);

		if($this->input->post("des")){
			$des = $this->input->post("des");
		}else{
			$des = $productDetail->description;
		}
		if($this->input->post("cat1")){
			$cat1 = $this->input->post("cat1");
		}else{
			$cat1 = $productDetail->category1;
		}
		if($this->input->post("cat2")){
			$cat2 = $this->input->post("cat2");
		}else{
			$cat2 = $productDetail->category2;
		}

		$id = $this->product_model->addProduct($brand, $pname, $color, $des, $cat1, $cat2);
		$data['id']=$id;
		$data['product'] = $this->product_model->get($id);
		$this->load->view('template/header');
		$this->load->view('productImg',$data);
		$this->load->view('template/footer');
	}
	
	public function addpimg(){
		$this->load->model('product_model');
		$product = $this->input->post('product');
		$new_name = $product.$_FILES["userfilep"]['name'];
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|gif|png|jpeg';
		$config['max_size'] = 10000000;
		$config['max_width'] = 1024;
		$config['max_height'] = 1024;
		$config['file_name'] = $new_name;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('userfilep')) {
			$this->load->view('template/header');
			$data = array('error' => $this->upload->display_errors());
			$detail = $this->product_model->get($product);
			$data['product'] = $detail;
			$data['id'] = $product;
			$this->load->view('productImg',$data);
			$this->load->view('template/footer');
		} else {
			$imageData = $this->upload->data();
			$configs['image_library'] = 'gd2';
			$configs['source_image'] = $imageData['full_path'];
			$configs['maintain_ratio'] = TRUE;
			$configs['height'] = 256;
			$this->load->library('image_lib',$configs);
			$this->image_lib->resize();

			$this->product_model->insertPImg($product,$this->upload->data('file_name'));
			
			redirect("review/displayReviewForm/".$product."/");
		}
	}
}