<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class eposta extends CI_Controller {

	protected $name;
	protected $to;
	protected $from;
	protected $subject;
	protected $message;

	public function index()
	{
		$this->load->helper('email');
		$name 		= $this->input->post('name');
		$email 		= $this->input->post('email');
		$subject	= $this->input->post('subject');
		$message	= $this->input->post('message');

		if (($name =='')||($email =='')||($subject =='')||($message =='')) 
		{
			echo 'Lütfen Boş Alan Bırakmayın';
		}
		elseif(!valid_email($email))
		{
			echo 'Lütfen Geçerli Bir Eposta Adresi Girin';
		}
		else
		{

		}

		$from 	= $email;
		$to		= array('ynsekiz@gmail.com');

		  $this->emailDataSet($name,$from, $to, $subject, $message);

		  $email_send = $this->sendEmail();
		  
/*		  if ($email_send == TRUE)
		  	echo 'mail gonderme basarili';
		  else
		  	echo 'mail gonderme basarisiz';*/
	}
	
	protected function emailDataSet($name, $from, array $to, $subject, $message)
	{
		$this->name    = $name;
		$this->to      = $to;
		$this->from    = $from;
		$this->subject = $subject;
		$this->message = $message;
	}




	protected function sendEmail()
	{
		$this->load->library('email');
		
		$this->email->from($this->from,$this->name)->to($this->to)->subject($this->subject)->message($this->message);

		if (!$this->email->send())
		{
			echo $this->email->print_debugger();
			echo 'false geldi';
			//return TRUE;
		}
		else
		{
			echo $this->email->print_debugger();
			echo 'true geldi';
			//return FALSE;			
		}

	}

}