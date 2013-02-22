<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slider extends CI_Controller {
	
	protected $parser_data;

	protected $base_data;

	protected $row_data;

	protected $is_there_any_row;

	protected $display_image_up_resize_errors;

	public $current_nav;
	public $big_slider_current;
	public $little_slider_current;
	
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
		
		$this->load->model('slider_model');

		$this->base_data = base_url();

		$this->current_nav = 'current';
		$this->big_slider_current = 'current';
		$this->little_slider_current = 'current';

		$this->row_data = $this->slider_model->getBigSliderRowForAdminPanel();

		// slider da herhangi bir resim yüklü olup olmadığına bakar
		$this->is_there_any_row = $this->slider_model->isThereAnyRowInDB();
		
		if ($this->is_there_any_row == TRUE)
		{
			$this->parser_data = array(
										'base' 	=> $this->base_data,
										'slider_current_nav'	=>	$this->current_nav,
										'buyuk_slider_detaylari' => $this->row_data
								  	  );			
		}
		else
		{
			$this->parser_data = array(
										'base' 	=> $this->base_data,
										'slider_current_nav'	=>	$this->current_nav,
										'buyuk_slider_detaylari' => $this->row_data
								  	  );			
		}
		
	}
	
	
	public function editBigSlider()
	{
		$this->parser_data['big_slider_current'] = $this->big_slider_current;

		if ($this->is_there_any_row == TRUE)
		{
			
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/big_slider_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);		
		}
		else
		{
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/big_slider_view_empty',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);	
		}

				
	}


	public function imageUploadToBigSlider()
	{

		$big_slider_title_form_field = $this->input->post('big_slider_title_form_field');

		if($big_slider_title_form_field == '')
		{
			$message = 'HATA:: Yüklediğiniz Resme Bir İsim Vermelisiniz';
			$this->errorMessage($message);
		}
		
		$array = array(
						'image_form_field'	=>	'big_slider_image_form_field',
						'upload_path'		=>	'assets/theme_assets/slider_assets/photo',
						'image_name'		=>	$big_slider_title_form_field,
						'big_img_width'		=>	960,
						'big_img_height'	=>	300,
						'thumb_img_width'	=>	80,
						'thumb_img_height'	=>	80
					  );

		$this->load->library('image_upload_resize_library');
				
		$this->image_upload_resize_library->setBootstrapData($array);
		
		$this->image_upload_resize_library->display_errors = TRUE;

		$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize();

		if($image_up_and_resize == TRUE)
		{
			
			$big_img_data_for_db	= $this->image_upload_resize_library->getSizedBigImgNameForDB();
			$thumb_img_data_for_db	= $this->image_upload_resize_library->getSizedThumbImgNameForDB();

			$insert_data_to_db = $this->slider_model->insertImageToBigSlider(
															$big_slider_title_form_field,
															$big_img_data_for_db,
															$thumb_img_data_for_db
														  );

			if($insert_data_to_db == TRUE)
			{
				$message = 'Resim Başarıyla Yüklendi';
				$this->successMessage($message);
			}
			else
			{
				$message = 'HATA:: Resim Yüklenemedi :';
				$this->errorMessage($message);
			}

		}
		else
		{
			$message = '<h1> HataKodu::1001:: Resim Yükleme Başarısız Oldu : ';
		}



	}


	public function deleteBigSlider($id)
	{
		$big_img_row 	= $this->slider_model->getBigImagePathFromDB($id);
		$thumb_img_row	= $this->slider_model->getThumbImagePathFromDB($id);

		$unlink_big_image = $this->unLinkImage($big_img_row);
		if (!$unlink_big_image)
		{
			echo '<h1>buyuk resim silinemedi : ';
			die();
		}

		$unlink_thumb_image = $this->unLinkImage($thumb_img_row);
		if (!$unlink_thumb_image)
		{
			echo '<h1>kucuk resim silinemedi';
			die();
		}

		//echo '<h1>'. $id.' nolu slider i siliyorum kardes haberin olsun ';
		$delete_row_from_db = $this->slider_model->deleteBigSlider($id);

		if($delete_row_from_db == TRUE)
		{
			$message = 'Resim Başarıyla Silindi';
			$return_path = '../editBigSlider';
			$this->successMessage($message,$return_path);
		}
		else
		{
			$message = 'HATA::Veritabanından İlgili Kayit Silinemedi';
			$return_path = '../editBigSlider';
			$this->errorMessage($message,$return_path);
		}
	}


	public function editLittleSlider()
	{
		$this->parser_data['little_slider_current'] = $this->little_slider_current;

		if ($this->is_there_any_row == TRUE)
		{
			
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/big_slider_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);		
		}
		else
		{
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/big_slider_view_empty',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);	
		}

	}


	public function unLinkImage($victim)
	{
		// hostdaki(Allahın cezası hostmana.com ) php versiyonu 5.2.17 olduğu için strstr fonksiyonuna üçüncü parametre tanımlanamıyor, bu yüzden eski usul devam edeceğiz
		$full_victim = strstr(dirname(__FILE__),'\application',TRUE).'/'.$victim;
		//$full_victim = $_SERVER['DOCUMENT_ROOT'].'/'.$victim;

		if (unlink($full_victim))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
	

	public function errorMessage($message, $return_path = NULL)
	{
		if ($return_path == NULL)
		{
			$return_path = 'editBigSlider';
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

	public function successMessage($message, $return_path = NULL)
	{
		if ($return_path == NULL)
		{
			$return_path = 'editBigSlider';
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


	
}