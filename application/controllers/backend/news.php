<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news extends CI_Controller {

	protected $base_data;
	protected $row_data;
	protected $parser_data;

	protected $submit_button_css;

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
			$this->submit_button_css = array(array());

			if ($this->row_data == NULL) 
			{
				$this->row_data = array();
				$this->submit_button_css = array();
			}

			$this->parser_data = array(
											'base' 				=> $this->base_data,
											'haber_detaylari'	=> $this->row_data,
											'submit_button_css'	=> $this->submit_button_css
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
				$this->successMessage($message,'allNews');
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


	public function operation()
	{
		$news_radio_field = $this->input->post('news_radio_field');

		$operation_option = $news_radio_field[0];

		switch ($operation_option) 
		{
			case '0':
				$news_radio_id = strtr($news_radio_field, array('0.31' => '')); // formdan gelen id numarasını alır
				$this->editNews($news_radio_id);
				break;

			case '1':
				$news_radio_id = strtr($news_radio_field, array('1.31' => '')); // formdan gelen id numarasını alır
				$this->deleteNews($news_radio_id);
				break;	
			
			default:
				$message = 'HATA:: İşlem Yapabilmek Bir Eylem Seçmelisiniz, Yönlendiriliyorsunuz... ';
				$this->errorMessage($message,'allNews');
				break;
		}
		
	}

	protected function deleteNews($id)
	{
		$delete_news = $this->news_model->deleteNews($id);

		if ($delete_news == TRUE) 
		{
			$message = 'Haber Silindi';
			$this->successMessage($message,'allNews');
		}
		else
		{
			$message = 'HATA:: Haber Silinemedi';
			$this->errorMessage($message,'allNews');
		}
	}

	protected function editNews($id)
	{
		$get_news_by_id = $this->getNewsById($id);

		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/edit_news_form_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);			
	}


	public function updateNews()
	{
		$field_id = $this->input->post('id');
		$real_id = strtr($field_id, array('31' => ''));

		$news_date_field	= $this->input->post('news_date_field');
		$news_detail_field	= $this->input->post('news_detail_field');

		if (($news_date_field == '') || ($news_detail_field == '') ) 
		{
			$message = 'HATA:: Lütfen Boş Alan Bırakmayın';
			$this->errorMessage($message,'allNews');
		}
		else
		{
			$update_news = $this->news_model->updateNews($real_id, $news_date_field, $news_detail_field);
			if ($update_news == TRUE) 
			{
				$message = 'Haber Güncelllendi ';
				$this->successMessage($message,'allNews');
			}
			else
			{
				$message = 'HATA:: Haber Güncellenmesi Sırasında Bir Hata Oluştu';
				$this->errorMessage($message,'allNews');
			}
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
		echo "<meta http-equiv=\"refresh\" content=\"2; url=$return_path\">";	
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

	public function getNewsById($id = NULL)
	{
		if ($id == NULL) 
		{
			$message = 'HATA:: Buraya Erişim Yetkiniz Bulunmamaktadır';
			$this->errorMessage($message,'../../home');
		}
		$news_array = $this->news_model->getNewsRowById($id);

		$this->parser_data['haber_tarihi'] = $news_array['haber_tarihi'];
		$this->parser_data['haber_detayi'] = $news_array['haber_detayi'];
		$this->parser_data['id'] = $news_array['id'];


	}	


}
	