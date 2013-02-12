<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact extends CI_Controller {
	
	protected $data;

	protected $base_data;

	protected $row_data;
	
	public function index()
	{
		return null;
	}
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('contact_model');
		
		$this->base_data = base_url();
		
		$base = base_url();
		$this->row_data = $this->contact_model->getContactRowAsArray();
		
		$address_column		= $this->row_data['address'];
		$phone_column		= $this->row_data['phone'];
		$fax_column			= $this->row_data['fax'];
		$email_column		= $this->row_data['email'];
		$facebook_column	= $this->row_data['facebook'];
		$twitter_column		= $this->row_data['twitter'];
		$gplus_column		= $this->row_data['gplus'];
		
		$this->data = array(
							'base'		=> $base,
							'address'	=> $address_column,
							'phone'		=> $phone_column,	
							'fax'		=> $fax_column,
							'email'		=> $email_column,
							'facebook'	=> $facebook_column,
							'twitter'	=> $twitter_column,
							'gplus'		=> $gplus_column
							);
		
	}
	
	public function editContact()
	{
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->data);
		$this->parser->parse('backend_views/admin_main_view',$this->data);
		$this->parser->parse('backend_views/contact_view',$this->data);
		$this->parser->parse('backend_views/admin_footer_view',$this->data);
	}
	
	public function controlContact()
	{
		$address_field	= $this->input->post('address_field');
		$phone_field	= $this->input->post('phone_field');
		$fax_field		= $this->input->post('fax_field');
		$email_field	= $this->input->post('email_field');
		$facebook_field	= $this->input->post('facebook_field');
		$twitter_field	= $this->input->post('twitter_field');
		$gplus_field	= $this->input->post('gplus_field');
		/*$textt			= $this->input->post('textt');*/
		
		if(($address_field == '') || ($phone_field == '') || ($fax_field == '') || ($email_field == '') ||
		  ($facebook_field == '') || ($twitter_field == '') || ($gplus_field == ''))
		{
			$message = 'Lütfen Boş Alan Bırakmayın';
			$this->errorMessage($message);
		
		}
		
		$update = $this->contact_model->updateContact($address_field, $phone_field, $fax_field, $email_field, $facebook_field, $twitter_field, $gplus_field);
		
		if($update == TRUE)
		{
			$message = 'İletişim Bilgileri Başrıyla Değiştirildi';
			$this->successMessage($message);
		}
		else
		{
			$message =  ' Güncelleme İşlemi Başarısız Oldu';
			$this->errorMessage($message);
		}
			
		
	}



	public function errorMessage($message)
	{
		$this->parser_data = array(
									'base' 				=> $this->base_data,
									'error_message'		=> $message
								  );

		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/error_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
		echo "<meta http-equiv=\"refresh\" content=\"3; url=../contact/editContact\">";	

	}

	public function successMessage($message)
	{
		$this->parser_data = array(
									'base' 				=> $this->base_data,
									'success_message'	=> $message
								  );

		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/success_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
		echo "<meta http-equiv=\"refresh\" content=\"4; url=../contact/editContact\">";	

	}



}
