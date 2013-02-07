<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pagenotfound extends CI_Controller {

	function index()
	{
		$base = base_url();
		
		$parser_data = array(
								'base' => $base
							);
		
		$this->parser->parse('404/404_view',$parser_data);
		
		//$this->load->view('404/404_view');
	}

}
?>