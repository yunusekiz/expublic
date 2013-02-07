<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class anasayfa extends CI_Controller {

	private $parser_data;

	protected $base_data;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index(){
		//$this->output->cache(2);

		$this->base_data = base_url();

		$this->parser_data = array(
									'base'	=>	$this->base_data
								  );

		//$this->parser->parse('frontend_views/tr/header_view',$this->parser_data);
		$this->parser->parse('frontend_views/tr/anasayfa_view',$this->parser_data);
		$this->parser->parse('frontend_views/tr/footer_view',$this->parser_data);
		

		}
	
}