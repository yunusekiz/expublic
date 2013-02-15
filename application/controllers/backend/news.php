<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news extends CI_Controller {

	protected $base_data;
	protected $row_data;
	protected $parser_data;

	public function index()
	{
		return null;
	}

	public function __construct()
	{
		parent::__construct();


		$this->load->library('session');// session ın nimetlerinden faydalanabilmek için 'session' isimli library yi yükler.
		$admin = $this->session->userdata('admin_session'); // $admin diye bi değişken set edilir, değer olarak ise
															// şu aşamada olup olmadığı bilinmeyen admin_session değişkeni atanır
		if( empty($admin) ) // eğer $admin değişkenini değeri boş ise, kullanıcı login formuna geri gönderilir
		{
			echo "<meta http-equiv=\"refresh\" content=\"0; url=../../login\">";
			die();
		}
		
			$this->load->model('news_model');

			$this->base_data = base_url();
			$this->row_data = $this->news_model->getNewsRowForView();

			$this->parser_data = array(
											'base' => $this->base_data
								 	  );			
	


	}

	public function addNews()
	{
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/news_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
	}


	public function controlNews()
	{
		$news_date_field = $this->input->post('news_date_field');
		$news_detail_field = $this->input->post('news_detail_field');

		if ( ($news_date_field == '') || ($news_detail_field == '') ) 
		{
			$message = 'HATA:: Lütfen Boş Alan Bırakmayın';
			$this->errorMessage($message);
		}
		else
		{
			$add_new_news = $this->news_model->insertNewNews($news_date_field, $news_detail_field);

			if ($add_new_news == TRUE)
			{
				$message = 'Yeni Haber Eklendi';
				$this->successMessage($message);
			}
			else
			{
				$message = 'HATA:: Haber Eklenirken Bir Sorunla Karşılaşıldı';
				$this->errorMessage($message);
			}
		}

	}


	public function allNews()
	{
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/all_news_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);	
	}


	public function operation($operation)
	{
		$radio_field = $this->input->post('radio_field');

		var_dump($radio_field);
		
		echo '<br/>';

		if ($operation == 'edit') 
		{
			echo 'edit islemi yapiyorum ben';
		}
		elseif ($operation == 'delete') 
		{
			echo 'delete islemi yapiyorum ben';
		}
		else
		{
			echo 'HATA basarim acimam';
		}
	}


	public function successMessage($message, $return_path = NULL)
	{
		if ($return_path == NULL)
		{
			$return_path = 'addNews';
		}

		$this->parser_data = array(
									'base' 				=> $this->base_data,
									'success_message'	=> $message
								  );
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/success_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
		echo "<meta http-equiv=\"refresh\" content=\"4; url=$return_path\">";	
	}


	public function errorMessage($message, $return_path = NULL)
	{
		if ($return_path == NULL)
		{
			$return_path = 'addNews';
		}

		$this->parser_data = array(
									'base' 				=> $this->base_data,
									'error_message'		=> $message
								  );
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/error_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
		echo "<meta http-equiv=\"refresh\" content=\"3; url=$return_path\">";	
	}	


}
	