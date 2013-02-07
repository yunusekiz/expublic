<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pass extends CI_Controller {

	private $pass_column_data;
	protected $base_data;
	protected $parser_data;

	protected $error_data;

	public function index()
	{
		return null;
	}

	public function __construct()
	{
		parent::__construct();

		$this->load->model('pass_model');

		$this->base_data = base_url();

	}

	public function changePass()
	{
		$this->parser_data = array(
									'base' => $this->base_data
								  );

		$pass_now = $this->pass_model->getPassColumnFromAdmin();

		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/pass_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);


	}

	public function controlPass()
	{


		$this->pass_column_data = $this->pass_model->getPassColumnFromAdmin();

		$pass_field 			= $this->input->post('pass_field');
		$new_pass_field			= $this->input->post('new_pass_field');
		$new_pass_field_again	= $this->input->post('new_pass_field_again');

		if( ($pass_field != '') && ($new_pass_field != '') && ($new_pass_field_again != '') )
		{
			if ($new_pass_field == $new_pass_field_again)
			{
				if ($this->pass_column_data == $pass_field)
				{
					$update_pass = $this->pass_model->updatePass($new_pass_field);
					if ($update_pass == TRUE)
					{
						$message = 'Şifre Başarıyla Değiştirildi';
						$this->successPass($message);
					}
					else
					{
						$message = 'HATA:: Şifreniz Değiştirilemedi';
						$this->errorPass($message);
					}
				}
				else
				{
					$message = 'HATA:: Mevcut Şifrenizi Yanlış Girdiğiniz';
					$this->errorPass($message);
				}

			}
			else
			{
				$message = 'HATA:: Girdiğiniz Şifreler Birbiriyle Uyuşmuyor';
				$this->errorPass($message);
			}
		}
		else
		{
			$message ='HATA:: Boş Alan Bırakmayınuz';
			$this->errorPass($message);
		}

	}

	public function errorPass($message)
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
		echo "<meta http-equiv=\"refresh\" content=\"3; url=changePass\">";	

	}

	public function successPass($message)
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
		echo "<meta http-equiv=\"refresh\" content=\"4; url=../home\">";	

	}

}
	