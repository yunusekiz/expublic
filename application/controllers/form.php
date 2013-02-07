<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

class Form extends CI_Controller {

	function index()
	{
		$this->load->helper(array('form'));

		$this->load->library('form_validation');
		
		$this->load->library('parser');
		$base_url = base_url();
		
		$data = array(
					'base'=>"$base_url"
					);
		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
					
		if ($this->form_validation->run() == FALSE)
		{
			$this->parser->parse('form_view',$data);
		}
		else
		{
			$this->parser->parse('formsuccess',$data);
		}
	}
}
?>


</body>
</html>