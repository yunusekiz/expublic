<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class anasayfa extends CI_Controller {

	private $parser_data;

	protected $base_data;
	
	public function __construct()
	{
		parent::__construct();

		echo "<meta http-equiv=\"refresh\" content=\"0; url=tr/anasayfa\">";

	}
	
	public function index(){
		return null;

		}
	
}