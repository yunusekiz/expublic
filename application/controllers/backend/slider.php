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
			echo "<meta http-equiv=\"refresh\" content=\"0; url=".base_url()."login\">";
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
		
		$this->image_upload_resize_library->display_errors = FALSE;

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
				$this->successMessage($message,NULL,1);
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
			$this->successMessage($message,$return_path,0.5);
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
				$this->successMessage($message,'editStaticImages',1);
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

		// static images leri sildikten sonra veri tabanındaki ilgili kayıtlarıda siler
		$delete_row_from_db = $this->slider_model->deleteStaticImages($id);

		if($delete_row_from_db == TRUE)
		{
			$message = 'Resim Başarıyla Silindi';
			$return_path = '../editStaticImages';
			$this->successMessage($message,$return_path,0.5);
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
			$new_image_name = $this->regex($little_slider_title_form_field);
			$array = array(
							'image_form_field'	=>	'little_slider_image_form_field',
							'upload_path'		=>	'assets/images/little_slider_images',
							'image_name'		=>	$new_image_name,
							'big_img_width'		=>	931,
							'big_img_height'	=>	375,
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
																						$little_slider_title_form_field,
																						$little_slider_date_form_field,
																						$little_slider_detail_form_field,
																						$big_img_data_for_db,
																						$thumb_img_data_for_db
																					);
				if ($insert_data_to_db == TRUE) 
				{
					$message = 'Resim Başarıyla Yüklendi';
					$this->successMessage($message,'editLittleSlider',1);
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


	public function deleteLittleSlider($id)
	{
		$big_img_row 	= $this->slider_model->getLittleSliderBigImageFromDB($id);
		$thumb_img_row	= $this->slider_model->getLittleSliderThumbImageFromDB($id);
		
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

		// küçük slider resimleri silindikten sonra veritabanındaki kayıtlarını da sil	
		$delete_row_from_db = $this->slider_model->deleteLittleSlider($id);

		if($delete_row_from_db == TRUE)
		{
			$message = 'Resim Başarıyla Silindi';
			$return_path = '../editLittleSlider';
			$this->successMessage($message,$return_path,0.5);
		}
		else
		{
			$message = 'HATA:: Veritabanından İlgili Kayit Silinemedi';
			$return_path = '../editLittleSlider';
			$this->errorMessage($message,$return_path);
		}		

	}


	public function updateLittleSlider($id = NULL)
	{
		$id_little_slider_update_form_field = $this->input->post('id_little_slider_update_form_field');

		if ($id != NULL) // küçük slider için resim düzenleme formunu basmadan önde böyle bir "id" olup olmadığını kontrol et
		{
			if($this->slider_model->getLittleSliderBigImageFromDB($id) != NULL)
			{
				$only_one_little_slider_detail = $this->slider_model->getLittleSliderRow($id);
				$this->parser_data['bir_adet_kucuk_slider_detayi_a'] = $only_one_little_slider_detail;
				$this->parser_data['bir_adet_kucuk_slider_detayi_b'] = $only_one_little_slider_detail;

				// admin panelinin ilgili view lerini yükler
				$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
				$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
				$this->parser->parse('backend_views/edit_little_slider_form_view',$this->parser_data);
				$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);	
			}
			else // yönlendirilen "id "veritabanında yoksa ekrana hata bas
			{
				$message = 'HATA:: Bu Sayfaya Erişim Yetkiniz Bulunmuyor...';
				$return_path = '../editLittleSlider';
				$this->errorMessage($message,$return_path,1);
			}
		}
		elseif($id_little_slider_update_form_field != NULL) // eğer id alanı boş ise bu sefer düzenleme formundan bir post gelip gelmediğini kontrol eder
		{
			$id = strtr($id_little_slider_update_form_field, array('0.31' => ''));

			$title_little_slider_update_form_field	= $this->input->post('title_little_slider_update_form_field');
			$detail_little_slider_update_form_field	= $this->input->post('detail_little_slider_update_form_field');
			$date_little_slider_update_form_field	= $this->input->post('date_little_slider_update_form_field');

			if(($title_little_slider_update_form_field=='')||($detail_little_slider_update_form_field=='')||($date_little_slider_update_form_field=='') )
			{
				$message ='Lütfen Boş Alan Bırakmayın';
				$return_path = "updateLittleSlider/$id";
				$this->errorMessage($message,$return_path,1);
			}
			else
			{
				$new_image_name = $this->regex($title_little_slider_update_form_field);
				$array = array(
								'image_form_field'	=>	'little_slider_update_form_field_image',
								'upload_path'		=>	'assets/images/little_slider_images',
								'image_name'		=>	$new_image_name,
								'big_img_width'		=>	971,
								'big_img_height'	=>	375,
								'thumb_img_width'	=>	80,
								'thumb_img_height'	=>	80
							   );

				$this->load->library('image_upload_resize_library');
				$this->image_upload_resize_library->setBootstrapData($array);
				$this->image_upload_resize_library->display_errors = FALSE;
				$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize();

				$big_img_row 	= $this->slider_model->getLittleSliderBigImageFromDB($id);
				$thumb_img_row	= $this->slider_model->getLittleSliderThumbImageFromDB($id);

				$little_slider_images = array($big_img_row,$thumb_img_row);


				if ($this->image_upload_resize_library->getUploadedFileClientName() == NULL) // eğer herhabgi bi resim yüklenmemişse
				{
					$update_little_slider_detail = $this->slider_model->update_little_slider_detail($id,$title_little_slider_update_form_field,
																									$date_little_slider_update_form_field,
																									$detail_little_slider_update_form_field);
					if ($update_little_slider_detail == TRUE) 
					{
						$message = 'Tebrikler. Küçük slider güncellendi.';
						$return_path = 'editLittleSlider';
						$this->successMessage($message,$return_path,1);					
					}
					else
					{
						$message = 'HATA:: Küçük slider güncellenemedi (without-photo)';
						$return_path = "updateLittleSlider/$id";
						$this->errorMessage($message,$return_path,1);						
					}
				}
				elseif ($image_up_and_resize == TRUE) // herhangi bir resim yüklenmiş ve resize işlemi başarılı olmuşsa
				{
					$new_uploaded_images = array($this->image_upload_resize_library->getSizedBigImgNameForDB(),
												 $this->image_upload_resize_library->getSizedThumbImgNameForDB());

					$update_ltl_slider = $this->slider_model->update_little_slider_detail($id,$title_little_slider_update_form_field,
																	 					  $date_little_slider_update_form_field,
																	 					  $detail_little_slider_update_form_field,
																	 					  $new_uploaded_images);
					if ($update_ltl_slider==FALSE) // database update işlemi başarısızsa
					{
						$message = 'HATA:: Küçük slider güncellenemedi (with-photo and new detail)';
						$return_path = "updateLittleSlider/$id";
						$this->errorMessage($message,$return_path,1);
					}
					elseif ($this->deleteItemPhoto($little_slider_images) == TRUE) // eski resimler silindiyse
					{
						$message = 'Tebrikler. Küçük slider güncellendi.';
						$return_path = 'editLittleSlider';
						$this->successMessage($message,$return_path);	
					}
					else
					{
						$message = 'HATA:: Küçük slider güncellenemedi (with-photo)';
						$return_path = "updateLittleSlider/$id";
						$this->errorMessage($message,$return_path,1);						
					}

				}
				else
				{
					$message = 'HATA:: Küçük slider güncellenemedi';
					$return_path = "updateLittleSlider/$id";
					$this->errorMessage($message,$return_path,1);					
				}
			}
		} 
		else // yukarıdaki her iki koşulda sağlanmıyorsa ekrana hata basar
		{
			$message = 'HATA:: Bu Sayfaya Erişim Yetkiniz Bulunmuyor...';
			$return_path = 'editLittleSlider';
			$this->errorMessage($message,$return_path,1);
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


	protected function deleteItemPhoto(array $files)
	{	
		if (unLinkFile($files) == TRUE) 
			return TRUE;
		else
			return FALSE;
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


	public function errorMessage($message, $return_path = NULL, $return_time = NULL)
	{
		if ($return_path == NULL)
		{
			$return_path = 'editBigSlider';
		}
		elseif ($return_time == NULL) 
		{
			$return_time = 4;
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

	public function successMessage($message, $return_path = NULL, $return_time = NULL)
	{
		if ($return_path == NULL)
		{
			$return_path = 'editBigSlider';
		}
		elseif ($return_time == NULL) 
		{
			$return_time = 4;
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
		echo "<meta http-equiv=\"refresh\" content=\"$return_time; url=$return_path\">";	
	}


	protected function sendMail()
	{
		$this->load->library('email');

		$this->email->from('goldenpoisonfrog@hotmail.com', 'Your Name');
		$this->email->to('ynsekiz@gmail.com'); 

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');	

		$config['protocol'] = 'mail';
		$this->email->initialize($config);

		if (@$this->email->send())
		{
			echo "mesaj gittiii <br>";
			echo $this->email->print_debugger();
			//echo $this->email->print_debugger();
			//$this->successMessage('mesaj gönderildi','../send',3);
		}
		else
		{
			echo "HATA::mesaj gitmedi hocuu <br>";
			///echo $this->email->print_debugger();
			//$this->errorMessage('HATA:: Mesaj Gönderilemedi','../send',3);
		}
			
	}

	public function send($id = NULL)
	{
		if ($id == NULL)
			return NULL;
		else
			$this->sendMail();
	}


	public function change($name = 'madem oyle iste boyle canim')
	{
		$name = preg_replace('/\s+/', '_', $name);

		$file_full_pth = FCPATH.'assets\images\son kez son bir kez daha.jsp';


		$file_ext = substr($file_full_pth, -strpos(strrev($file_full_pth), '.'));
		
		$old_name = $file_full_pth;
		
		$new_name = FCPATH."assets\images\\".$name.'.'.$file_ext;

		
		if(rename($old_name, $new_name))
			echo 'isim degisti';
		else
			echo 'isim degisemedi';
	}

	
}