<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class anasayfa extends CI_Controller {

	private $parser_data;

	protected $base_data;

	protected $is_there_any_row;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('slider_model');
		// slider da herhangi bir resim yüklü olup olmadığına bakar
		$this->is_there_any_row = $this->slider_model->isThereAnyRowInDB();

		if ($this->is_there_any_row == TRUE)
		{
			$buyuk_slider_resimleri = $this->slider_model->getBigSliderRowForAdminPanel();
		}
		else
		{
			$buyuk_slider_resimleri = array();
		}

		$this->base_data = base_url();

		$this->parser_data = array(
									'base'	=>	$this->base_data,
									'buyuk_slider_resimleri_dizisi'	=> $buyuk_slider_resimleri
								  );

	}
	
	public function index(){
		//$this->output->cache(2);

		//$this->parser->parse('frontend_views/tr/header_view',$this->parser_data);
		$this->parser->parse('frontend_views/tr/anasayfa_view',$this->parser_data);
		$this->parser->parse('frontend_views/tr/footer_view',$this->parser_data);
		

		}
	
}