<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HtmltoPDF extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Htmltopdf_model');
		$this->load->library('pdf');
	}

	public function index()
	{
		$data['customer_data'] = $this->htmltopdf_model->fetch();
		$this->load->view('pages/register', $data);
	}

	public function details()
	{
		if($this->uri->segment(3))
		{
			$customer_id = $this->uri->segment(3);
			$data['customer_details'] = $this->htmltopdf_model->fetch_single_details($customer_id);
			$this->load->view('htmltopdf', $data);
		}
	}
	public function pdfdetails()
	{
		
		
			$customer_id =$this->session->userdata("User_id");
			$html_content = '<h3 align="center">Convert HTML to PDF in CodeIgniter using Dompdf</h3>';
			$html_content = $this->Htmltopdf_model->fetch_single_details($customer_id);
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("".$customer_id.".pdf", array("Attachment"=>0));
		
	}

}

?>
