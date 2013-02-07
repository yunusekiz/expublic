<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hakkimizda extends CI_Controller {
	
	protected $base_data;
	protected $row_data;
	protected $parser_data;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('about_model');
		
		$this->row_data = $this->about_model->getAboutUsRowForView();

		$this->base_data = base_url();

		$this->parser_data = array(
									'base' => $this->base_data,
									'hakkimizda_kayitlari' => $this->row_data
								);
	}
	
	public function index(){
		
		$this->parser->parse('frontend_views/tr/hakkimizda_view',$this->parser_data);
		$this->parser->parse('frontend_views/tr/footer_view',$this->parser_data);
		}
	
}