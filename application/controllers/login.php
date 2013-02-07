<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class login extends CI_Controller {
	
	protected $data;
	
	public function index()
	{
		
		//$this->setData(array('title'=>'Giriş'));
		
		//$this->parser->parse('login_views/login_header',$this->data);
		
		$this->load->view('login_views/login_header');
		$this->load->view('login_views/login_form');
		$this->load->view('login_views/login_footer');
	}
	
	protected function setData(array $setData = array())
	{
		$this->data = $setData;
	}
	
	protected function getData()
	{
		return $this->data;
	}
	
}