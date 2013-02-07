<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news extends CI_Controller {

	protected $base_data;
	protected $row_data;
	protected $parser_data;

	public function index()
	{
		return null;
	}

	public function __construct()
	{
		parent::__construct();

		$this->load->model('news_model');

		$this->base_data = base_url();
		$this->row_data = $this->news_model->getNewsRowForView();

		$this->parser_data = array(
										'base' => $this->base_data,
										'haber_detaylari' => $this->row_data
								  );
		$this->parser->parse('frontend_views/tr/news_view',$this->parser_data);

	}

}
	