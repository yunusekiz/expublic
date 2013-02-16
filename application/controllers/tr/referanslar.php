<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class referanslar extends CI_Controller {

	protected $base_data;
	protected $ref_row_data;
	protected $parser_data;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('reference_model');

		$this->ref_row_data = $this->reference_model->getRefRowsForViewLayer();

		if ($this->ref_row_data == NULL)
		{
			$ref_row_data = array();
		}


		$this->ref_row_data = $this->reference_model->getRefRowsForViewLayer();

		$this->base_data = base_url();

		$this->parser_data = array(
									'base' 					=> $this->base_data,
									'referans_kayitlari'	=> $this->ref_row_data,
									'kategoriler'			=> $this->ref_row_data
								  );

	}
	
	public function index(){

		$this->parser->parse('frontend_views/tr/referanslar_view',$this->parser_data);
		$this->parser->parse('frontend_views/tr/footer_2_view',$this->parser_data);

		}
	
}