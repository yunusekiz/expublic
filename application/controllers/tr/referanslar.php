<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class referanslar extends CI_Controller {

	protected $base_data;
	protected $reference_view_row_data;
	protected $reference_category_row_data;
	protected $parser_data;
	protected $required_css_text;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('reference_model');

		$this->required_css_text = array(array('metin' => 'Hepsi'));
		
		$this->reference_view_row_data = $this->reference_model->getRefRowsForViewLayer();

		$this->reference_category_row_data = $this->reference_model->getRefCategoryRows();

		if ($this->reference_view_row_data == NULL)
		{
		  	$this->reference_view_row_data = array();
		  	$this->required_css_text = array();
		}

		if ($this->reference_category_row_data == NULL)
		{
		 	$this->reference_category_row_data = array();
		}




		$this->base_data = base_url();

		$this->parser_data = array(
									'base' 					=> $this->base_data,
									'referans_kayitlari'	=> $this->reference_view_row_data,
									'referans_kategorileri'	=> $this->reference_category_row_data,
									'hepsi_metni'			=> $this->required_css_text
								  );

	}
	
	public function index(){

		$this->parser->parse('frontend_views/tr/referanslar_view',$this->parser_data);
		$this->parser->parse('frontend_views/tr/footer_2_view',$this->parser_data);

		}
	
}