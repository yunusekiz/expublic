<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slider extends CI_Controller {
	
	protected $parser_data;

	protected $base_data;

	protected $row_data;

	protected $is_there_any_row;

	protected $display_image_up_resize_errors;

	protected $static_images_row_data;
	protected $is_there_any_static_images;

	protected $little_slider_row_data;
	protected $is_there_any_little_slider;

	public $current_nav;
	public $big_slider_current;
	public $little_slider_current;
	
	public function index()
	{
		//return null;
		echo "<meta http-equiv=\"refresh\" content=\"0; url=../home\">";
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

		$this->parser_data['base'] = $this->base_data;


		//////////////////////////////////////////////
		$this->is_there_any_little_slider	= $this->slider_model->isThereAnyLittleSliderRow();
		$this->little_slider_row_data	= $this->slider_model->getLittleSliderRow();

		if ($this->is_there_any_little_slider == TRUE) 
		{
			$this->parser_data['kucuk_slider_detaylari'] = $this->little_slider_row_data;
		}
		//////////////////////////////////////////////
		//////////////////////////////////////////////
		//////////////////////////////////////////////
		$this->is_there_any_static_images = $this->slider_model->isThereAnyStaticImages();
		$this->static_images_row_data = $this->slider_model->getStaticImagesRow();

		if ($this->is_there_any_static_images == TRUE)
		{
			$this->parser_data['sabit_resim_detaylari' ] = $this->static_images_row_data;
											
		}
		//////////////////////////////////////////////

		// slider da herhangi bir resim yüklü olup olmadığına bakar
		$this->is_there_any_row = $this->slider_model->isThereAnyRowInDB();
		$this->row_data = $this->slider_model->getBigSliderRowForAdminPanel();

		if ($this->is_there_any_row == TRUE)
		{
			$this->parser_data['buyuk_slider_detaylari'] = $this->row_data;		
		}
		
	}
	
	
	public function editBigSlider()
	{
		//$this->parser_data['big_slider_current'] = $this->big_slider_current;

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


	public function editStaticImages()
	{
		if ($this->is_there_any_static_images == TRUE)
		{
			
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/static_images_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);		
		}
		else
		{
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/static_images_view_empty',$this->parser_data);
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



#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
	public function imageUploadToStaticImages()
	{
		$count_of_static_Images = $this->countOfStaticImages();

		if ($count_of_static_Images < 3 ) 
		{
			
###################################################################################################################

		$static_images_title_form_field		= $this->input->post('static_images_title_form_field');
		$static_images_detail_form_field	= $this->input->post('static_images_detail_form_field');

		if( ($static_images_title_form_field == '') || ($static_images_detail_form_field == '') )
		{
			$message = 'HATA:: Lütfen Boş Alan Bırakmayın';
			$this->errorMessage($message,'editStaticImages'); 
		}
		$array = array(
						'image_form_field'	=>	'static_images_form_field',
						'upload_path'		=>	'assets/images/home_static_images',
						'image_name'		=>	$static_images_title_form_field,
						'big_img_width'		=>	NULL,
						'big_img_height'	=>	NULL,
						'thumb_img_width'	=>	300,
						'thumb_img_height'	=>	165
					  );

		$this->load->library('image_upload_resize_library');
				
		$this->image_upload_resize_library->setBootstrapData($array);
		
		$this->image_upload_resize_library->display_errors = TRUE;

		$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize();

		if($image_up_and_resize == TRUE)
		{
			
			$big_img_data_for_db	= $this->image_upload_resize_library->getSizedBigImgNameForDB();
			$thumb_img_data_for_db	= $this->image_upload_resize_library->getSizedThumbImgNameForDB();

			$insert_data_to_db = $this->slider_model->insertImageToStaticImages( $static_images_title_form_field,
																				 $static_images_detail_form_field,
																				 $big_img_data_for_db,
																				 $thumb_img_data_for_db );

			if($insert_data_to_db == TRUE)
			{
				$message = 'Resim Başarıyla Yüklendi';
				$this->successMessage($message,'editStaticImages');
			}
			else
			{
				$message = 'HATA:: Resim Yüklenemedi :';
				$this->errorMessage($message,'editStaticImages');
			}

		}
		else
		{
			$message = '<h1> HataKodu::1001:: Resim Yükleme Başarısız Oldu : ';
			$this->errorMessage($message,'editStaticImages');
		}
###################################################################################################################
		}
		else
		{
			$message = 'En Fazla 3 Adet Sabit Resim Yükleyebilirsiniz.. Bilgi:: yeni resme yer açmak için bazılarını silin::';
			$this->errorMessage($message,'editStaticImages');
		}


	}



	public function deleteStaticImages($id)
	{
		$big_img_row 	= $this->slider_model->getStaticBigImagePathFromDB($id);
		$thumb_img_row	= $this->slider_model->getStaticThumbImagePathFromDB($id);

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
		$delete_row_from_db = $this->slider_model->deleteStaticImages($id);

		if($delete_row_from_db == TRUE)
		{
			$message = 'Resim Başarıyla Silindi';
			$return_path = '../editStaticImages';
			$this->successMessage($message,$return_path);
		}
		else
		{
			$message = 'HATA:: Veritabanından İlgili Kayit Silinemedi';
			$return_path = '../editStaticImages';
			$this->errorMessage($message,$return_path);
		}
	}

	protected function countOfStaticImages()
	{
		$count = $this->slider_model->countOfStaticImages();
		return $count;
	}

	#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
	#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
	#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
	#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function	editLittleSlider()
	{
		if ($this->is_there_any_little_slider == TRUE)
		{
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/little_slider_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);		
		}
		else
		{
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/little_slider_view_empty',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);	
		}
	}


	public function imageUploadToLittleSlider()
	{
		$little_slider_title_form_field		= $this->input->post('little_slider_title_form_field');
		$little_slider_detail_form_field	= $this->input->post('little_slider_detail_form_field');
		$little_slider_date_form_field		= $this->input->post('little_slider_date_form_field');

		if ( ($little_slider_title_form_field == '')||($little_slider_detail_form_field == '')||($little_slider_date_form_field =='') ) 
		{
			$message = 'HATA:: Lütfen Boş Alan Bırakmayın';
			$this->errorMessage($message,'editLittleSlider'); 			
		}
		else
		{
			$new_image_name = 'resimmm'; //$this->regex($little_slider_title_form_field);
			$array = array(
							'image_form_field'	=>	'little_slider_image_form_field',
							'upload_path'		=>	'assets/images/little_slider_images',
							'image_name'		=>	$new_image_name,
							'big_img_width'		=>	460,
							'big_img_height'	=>	170,
							'thumb_img_width'	=>	80,
							'thumb_img_height'	=>	80
						  );

			$this->load->library('image_upload_resize_library');
			$this->image_upload_resize_library->setBootstrapData($array);
			$this->image_upload_resize_library->display_errors = TRUE;
			$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize();

			if ($image_up_and_resize == TRUE) 
			{
				$big_img_data_for_db	= $this->image_upload_resize_library->getSizedBigImgNameForDB();
				$thumb_img_data_for_db	= $this->image_upload_resize_library->getSizedThumbImgNameForDB();

				$insert_data_to_db = $this->slider_model->insertImageToLittleSlider(
																						$new_image_name,
																						$little_slider_date_form_field,
																						$little_slider_detail_form_field,
																						$big_img_data_for_db,
																						$thumb_img_data_for_db
																					);
				if ($insert_data_to_db == TRUE) 
				{
					$message = 'Resim Başarıyla Yüklendi';
					$this->successMessage($message,'editLittleSlider');
				}
				else
				{
					$message = 'HATA:: Resim Bilgileri Veritabanına Kaydedilemedi :';
					$this->errorMessage($message,'editLittleSlider');
				}
			}
			else
			{
				$message = '<h1> HataKodu::1001:: Resim Yükleme Başarısız Oldu : ';
				$this->errorMessage($message,'editLittleSlider');
			}
		}

	}


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
	

	protected function regex($denek)
	{
		$denek = strtr($denek, array(	'Ü' => 'U', 'Ş' => 'S', 'Ç' => 'C',
										'İ' => 'I', 'Ğ'	=> 'G', 'Ö' => 'O', 
										'ü'	=> 'u', 'ö' => 'o', 'ş' => 's',
										'ç' => 'c', 'ı' => 'i', 'ğ' => 'g'
									));
		
		$denek = preg_replace('/\%/',' percentage',$denek); 
		$denek = preg_replace('/\@/',' at ',$denek); 
		$denek = preg_replace('/\&/',' and ',$denek); 
		$denek = preg_replace('/\s[\s]+/','-',$denek);    // Strip off multiple spaces 
		$denek = preg_replace('/[\s\W]+/','-',$denek);    // Strip off spaces and non-alpha-numeric 
		$denek = preg_replace('/^[\-]+/','',$denek); // Strip off the starting hyphens 
		$denek = preg_replace('/[\-]+$/','',$denek);
		return $denek;
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