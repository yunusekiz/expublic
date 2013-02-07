<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slider extends CI_Controller {
	
	protected $parser_data;

	protected $base_data;

	protected $row_data;
	
	public function index()
	{
		return null;
	}
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('slider_model');

		$this->base_data = base_url();
	
		
		$this->parser_data = array('base' => $this->base_data);
		
	}
	
	
	public function editBigSlider()
	{
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/big_slider_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
				
	}


	public function imageUploadToBigSlider()
	{
		// 
	}


	public function deleteBigSlider()
	{
	
	}
	

	public function errorMessage($message)
	{
		$this->parser_data = array(
									'base' 				=> $this->base_data,
									'error_message'		=> $message
								  );

		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/error_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
		echo "<meta http-equiv=\"refresh\" content=\"3; url=editAboutUs\">";	

	}

	public function successMessage($message)
	{
		$this->parser_data = array(
									'base' 				=> $this->base_data,
									'success_message'	=> $message
								  );

		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/success_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
		echo "<meta http-equiv=\"refresh\" content=\"4; url=../home\">";	

	}
	
}