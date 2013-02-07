<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class logout extends CI_Controller {

	public function index()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		echo "<meta http-equiv=\"refresh\" content=\"0; url=login\">";
	}
}

