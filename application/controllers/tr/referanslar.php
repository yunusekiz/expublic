<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class referanslar extends CI_Controller {

	protected $base_data;
	protected $row_data;
	protected $parser_data;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('contact_model');

		$this->row_data = $this->contact_model->getContactRowForView();

		$this->base_data = base_url();

		// $this->parser_data = array(
		// 							'base' => $this->base_data,
		// 							'iletisim_kayitlari' => $this->row_data
		// 						  );

		$this->parser_data = array(
									'base' => $this->base_data
								  );

	}
	
	public function index(){

		$this->parser->parse('frontend_views/tr/referanslar_view',$this->parser_data);
		$this->parser->parse('frontend_views/tr/footer_2_view',$this->parser_data);

		}
	
}