<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class deneme extends CI_controller{

/*	public function __construct()
	{
		parent::__construct();
		
		echo 'merhaba ben construct metodundan peydah oldum';
	}*/
	
	protected $data;
	
	public function index()
	{
		$this->load->helper('form');
		echo form_open_multipart('upload/do_upload');
	}
	
	public function __construct(){
		
		parent::__construct();
		
		$this->data = '***value of data***';
		
		}
	
	public function deneme_metod()
	{
		echo 'merhaba ben deneme_metod isim li bir metodum';
		echo '<br>';
		
		echo 'data isim li degiskenin degeri ise <b>'.$this->data.'<b>';
	}
	
}