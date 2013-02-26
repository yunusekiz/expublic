<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reference extends CI_Controller {
	
	protected $parser_data;
	protected $base_data;

	protected $imageDataAfterUpload;
	
	protected $path_big_image;
	protected $path_thumb_image;
	
	protected $ref_category_id = NULL;

	protected $denek;

	protected $reference_view_row;
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
		
		$this->load->model('reference_model');

		$category_row = $this->reference_model->getRefCategoryRows();

		if ($category_row == NULL)
		{
			$category_row = array();
		}

		$this->submit_button_css = array(array());

		$this->reference_view_row = $this->reference_model->getRefRowsForViewLayer();
		if ($this->reference_view_row == NULL) 
		{
			$this->reference_view_row = array();
			$this->submit_button_css = array();
		}
		
		$this->base_data = base_url();
		$day = date('d');
		$month = date('m');
		$year = date('Y');
		
		$base = base_url();
		
		$this->parser_data = array(
									'base'	=>	$this->base_data,
									'day'	=>	$day,
									'month'	=>	$month,
									'year'	=>	$year,
									'referans_kategorileri'	=> $category_row,
									'referans_detaylari'	=> $this->reference_view_row,
									'submit_button_css'		=> $this->submit_button_css
								  );
	}
	
	
	public function addReference()
	{	
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/reference_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
	}
	
	## //**\\***//**\\***//**\\***//**\\//**\\***//**\\***//**\\***//**\\//**\\***//**\\
	## +++ controlReference metodu başlangıç +++
	public function controlReference()
	{
		$image_lib_array = array(
						'image_form_field'	=>	'reference_image_form_field',
						'upload_path'		=>	'assets/images/reference_images',
						'big_img_width'		=>	NULL,
						'big_img_height'	=>	NULL,
						'thumb_img_width'	=>	270,
						'thumb_img_height'	=>	135
					  );
	
		$reference_dropdown_category = $this->input->post('reference_dropdown_category');
		$reference_text_category	 = $this->input->post('reference_text_category');
		//$reference_day			 = $this->input->post('reference_day');
		//$reference_month		 	 = $this->input->post('reference_month');
		//$reference_year			 = $this->input->post('reference_year');
		$reference_title		 	 = $this->input->post('reference_title');
		$reference_detail		 	 = $this->input->post('reference_detail');

		$reference_date				 = $this->input->post('reference_date_field');

		//$reference_date = $reference_day.'-'.$reference_month.'-'.$reference_year;
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#		
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#		
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#
		if(($reference_title != '') || ($reference_detail != '') || ($reference_date == '')) // referans basligi ve  referans aciklamsi bos degil ise
		{
			if($reference_dropdown_category != '0') // dropdowndan gelen category value si sıfır(0) değil ise
			{
				$reference_category = $reference_dropdown_category; // dropdowndan gelen value reference_category değişkenine atansın

				$conditon_ref_text_field = $this->reference_model->isThereAnyRefTextFieldRowLikeIt($reference_title);
				if ($conditon_ref_text_field == FALSE) // formdan gelen referans başlığı daha önceden kayıtlı değil ise 
				{
					$image_lib_array['image_name'] = $this->regex($reference_title);

					$this->load->library('image_upload_resize_library'); // resim upload ve resize eden library yi çağır
					$this->image_upload_resize_library->setBootstrapData($image_lib_array);
					########################################################################################
					$this->image_upload_resize_library->display_errors = TRUE; // image_upload_resize_library sınıfının hata gösterme/saklama seçeneğini ayarlar
					$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize(); // resmi yükle ve yeniden boyutlandır
					
					if($image_up_and_resize == TRUE) // eğer image upload ve resize işlemleri başarılı ise, resmin kayıt bilgilerini al
					{
						$this->path_big_image	= $this->image_upload_resize_library->getSizedBigImgNameForDB();
						$this->path_thumb_image	= $this->image_upload_resize_library->getSizedThumbImgNameForDB();

						// dropdowndaki kategorinin id sini al
						$this->ref_category_id = $this->reference_model->getRefCategoryId($reference_category);
						##########################################################
						// reference_text_field tablosuna yeni kayıt ekle
						$add_tef_text_field = $this->reference_model->add_Ref_TextField($reference_date, $reference_title, $reference_detail, TRUE, $this->ref_category_id);
						if($add_tef_text_field == FALSE) // eğer yeni referans text field  ekleme başarılı değil ise hata bas
						{
							$message = 'HATA:: Referans Detayları Veritabanına Kaydedilemedi...';
							$this->errorMessage($message);
						}
						elseif($this->reference_model->add_Ref_Image($this->path_big_image, $this->path_thumb_image) == FALSE)
						{
							$message = 'HATA:: Resim Bilgileri Veritabanına Kaydedilemedi...';
							$this->errorMessage($message);

						}
						else
						{	// Referans, tüm detayları ve resimleriyle başarılıbirlikte veritabanına kaydedilince
							$message = 'Yeni Referans Eklendi';
							$this->successMessage($message);
						}
						##########################################################
					}
					else // eğer image upload ve resize işlemleri başarısız ise hata bas 
					{
						$message =  'Resim Upload Ve Resize Edilirken Bi Sorunla Karşılaşıldı...';
						$this->errorMessage($message);
					}
					########################################################################################	
				}
				else
				{	// formdan gelen referans başlığı daha önceden kayıtlı ise
					$message = 'HATA:: Bu Referans Başlığına Ait Bir Kayıt Var. Lütfen Yeni Bir Başlık Girin';
					$this->errorMessage($message);
				}

			}
			elseif($reference_text_category != '')  // formdan gelen reference_text_category field ı boş değil ise
			{
				// veritabanındaki referans kategorisi tablosunda, formdan gelen reference_text_category field ile eşleşen bir kayıt olup olmadığına bakar, varsa hata basar
				$conditon_ref_category = $this->reference_model->isThereAnyRefCategoryRowLikeIt($reference_text_category);
				//////////////***********//////////////***********//////////////***********//////////////***********//////////////
				//////////////***********//////////////***********//////////////***********//////////////***********//////////////
				if ($conditon_ref_category == TRUE)
				{
					$message = 'HATA:: Bu Kategori Kayıtlı. Lütfen Yeni Bir Kategori Ekleyin, Veya Kayıtlı Kategorilerden Birini Seçin';
					$this->errorMessage($message);
				}
				elseif($this->reference_model->isThereAnyRefTextFieldRowLikeIt($reference_title) == FALSE) // daha önce böyle bir kategori  ve reference title kayitli değil ise
				{
					$reference_category = $reference_text_category;

					$image_lib_array['image_name'] = $this->regex($reference_title);

					$this->load->library('image_upload_resize_library'); // resim upload ve resize eden library yi çağır
					$this->image_upload_resize_library->display_errors = FALSE; // image_upload_resize_library sınıfının hata gösterme/saklama seçeneğini ayarlar
					$this->image_upload_resize_library->setBootstrapData($image_lib_array); // resim upload ve resize librarysine gerekli verileri set et
					#####################################################################################
					$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize(); // resmi yükle ve yeniden boyutlandır
					if($image_up_and_resize == TRUE) // eğer image upload ve resize işlemleri başarılı ise, resmin kayıt bilgilerini al
					{
						$this->path_big_image	= $this->image_upload_resize_library->getSizedBigImgNameForDB();
						$this->path_thumb_image	= $this->image_upload_resize_library->getSizedThumbImgNameForDB();
						$seo_friendly_category_name = $this->regex($reference_category);	
						$add_ref_category = $this->reference_model->add_Ref_Category($reference_category,$seo_friendly_category_name); // bu ketegori daha önceden kayıtlı olmadığı için yeni kategori ekler
						if ($add_ref_category != TRUE) // eğer yeni kategori ekleme başarısız olmuşsa hata bas
						{
							$message = 'HATA:: Yeni Kategori Eklenirken Bir Hatayla Karşılaşıldı';
							$this->errorMessage($message);
						}
						elseif ($this->reference_model->add_Ref_TextField($reference_date, $reference_title, $reference_detail, $isThereAnyCategoryLikeIt = FALSE, $ref_category_id = NULL) != TRUE) // yeni kategori eklenmişse, daha sonra  referans detayı ekle, başarısız olmuş ise hata bas
						{
							$message = 'HATA:: Referans Detayları Veritabanına Kaydedilemedi...';
						}
						elseif ($this->reference_model->add_Ref_Image($this->path_big_image, $this->path_thumb_image) != TRUE)
						{
							$message = 'HATA:: Resim Bilgileri Veritabanına Kaydedilemedi...';
						}
						else
						{// Referans, tüm detayları ve resimleriyle başarılı şekilde veritabanına kaydedilince
							$message = 'Yeni Referans Eklendi';
							$this->successMessage($message);
						}
					}
					else // eğer image upload ve resize işlemleri başarısız ise hata bas 
					{
						$message =  'Resim Upload Ve Resize Edilirken Bi Sorunla Karşılaşıldı...';
						$this->errorMessage($message);
					}
					#####################################################################################
				}
				else // daha önce böyle bir reference title kayitli ise hata bas
				{
					$message = 'HATA:: Bu Referans Başlığına Ait Bir Kayıt Var. Lütfen Yeni Bir Başlık Girin';
					$this->errorMessage($message);
				}
				//////////////***********//////////////***********//////////////***********//////////////***********//////////////
				//////////////***********//////////////***********//////////////***********//////////////***********//////////////
			}
			else
			{
				$message = 'Lütfen Bir Kategori Seçin Veya Yeni Bir Kategori Ekleyin'; // bununla birlikte yine formdan gelen reference_text_category field ı  da boş ise artık hata bassın
				$this->errorMessage($message);
				//var_dump($reference_category);
			}
		}
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#				
		else
		{   //formdan gelen referans title veya referans detail bos ise
			$message = 'HATA:: Referans Başlığını Ve Referans Açıklamasını Boş Bırakmayın';
			$this->errorMessage($message);
		}	
	}	## +++/ controlReference metodu bitiş /+++
## //**\\***//**\\***//**\\***//**\\//**\\***//**\\***//**\\***//**\\//**\\***//**\\


	public function allReferences()
	{
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/all_references_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);		
	}


	public function operation($id = NULL)
	{
		$reference_radio_field = $this->input->post('reference_radio_field');

		if ($reference_radio_field != '') 
		{
			$operation_option = $reference_radio_field[0];
			switch ($operation_option) 
			{
				case '0':
					$reference_radio_id = strtr($reference_radio_field, array('0.31' => '')); // formdan gelen id numarasını alır
					$this->editReference($reference_radio_id);
					//echo $reference_radio_id.' nolu referans duzenlenecek';
					break;

				case '1':
					$reference_radio_id = strtr($reference_radio_field, array('1.31' => '')); // formdan gelen id numarasını alır
					$this->deleteReferences($reference_radio_id);
					//echo $reference_radio_id.' nolu referans silinecek';
					break;	
			
				default:
					$message = 'HATA:: İşlem Yapabilmek Bir Eylem Seçmelisiniz, Yönlendiriliyorsunuz... ';
					$this->errorMessage($message,'allReferences');
					break;
			}

		}
		elseif ($id != NULL) 
		{
			$operation_option = $id[0];
			switch ($operation_option) 
			{
				case '0':
					$id = strtr($id, array('0.31' => '')); // formdan gelen id numarasını alır
					$this->editReference($id);
					//echo $reference_radio_id.' nolu referans duzenlenecek';
					break;

				case '1':
					$id = strtr($id, array('1.31' => '')); // formdan gelen id numarasını alır
					$this->deleteReferences($id);
					//echo $reference_radio_id.' nolu referans silinecek';
					break;	
			
				default:
					$message = 'HATA:: İşlem Yapabilmek Bir Eylem Seçmelisiniz, Yönlendiriliyorsunuz... ';
					$this->errorMessage($message,'../allReferences');
					break;
			}

		}
		else
		{
			$message = 'HATA:: İşlem Yapabilmek Bir Eylem Seçmelisiniz, Yönlendiriliyorsunuz... ';
			$this->errorMessage($message,'allReferences');			
		}		

	}

		

	protected function deleteReferences($id)
	{
		$img_paths = $this->reference_model->getRefImageRowById($id);

		$big_img_path = $img_paths['buyuk_resim'];
		$thumb_img_path = $img_paths['kucuk_resim'];

		if ( $this->unLinkImage($big_img_path) == TRUE ) 
		{
			if ( $this->unLinkImage($thumb_img_path) == TRUE ) 
			{
				if ( $this->reference_model->deleteRefTextFieldFromDB($id) == TRUE ) 
				{
					$message = 'Referans Silindi';
					$this->successMessage($message,'allReferences');
				}
				else
				{
					$message = 'HATA:: Referans Kaydı Veritabandan Silinemedi';
					$this->errorMessage($message);
				}
			}
			else
			{
				$message = 'HATA:: Küçük Resim Silinemedi';
				$this->errorMessage($message,'allReferences');
			}
		}
		else
		{
			$message = 'HATA:: Büyük Resim Silinemedi';
			$this->errorMessage($message,'allReferences');
		} 
	}


	protected function unLinkImage($victim)
	{
		
		$full_victim = strstr(dirname(__FILE__),'\application',TRUE).'/'.$victim;
		//$full_victim = $_SERVER['DOCUMENT_ROOT'].'/'.$victim; // hostdaki(Allahın cezası hostmana.com ) php versiyonu 5.2.17 olduğu için strstr fonksiyonuna üçüncü parametre tanımlanamıyor, bu yüzden eski usul devam edeceğiz
		if (unlink($full_victim))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}


	protected function editReference($id)
	{

		$get_reference_by_id = $this->getReferenceById($id);
		
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/edit_reference_form_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
	}

	public function getReferenceById($id = NULL)
	{
		if ($id == NULL) 
		{
			$message = 'HATA:: Buraya Erişim Yetkiniz Bulunmamaktadır';
			$this->errorMessage($message,'../../home');
		}
		else
		{
			$reference_array = $this->reference_model->getRefRowsForViewLayer($id);

			$this->parser_data['referans_detaylari_update'] = $reference_array;
			$this->parser_data['referans_kategori_update'] = $reference_array;		
		}
	}


	public function updateReference()
	{
				$image_lib_array = array(
						'image_form_field'	=>	'reference_image_form_field',
						'upload_path'		=>	'assets/images/reference_images',
						'big_img_width'		=>	NULL,
						'big_img_height'	=>	NULL,
						'thumb_img_width'	=>	220,
						'thumb_img_height'	=>	110
					  );

		$reference_dropdown_category_field = $this->input->post('reference_dropdown_category_field');
		
		$reference_date_field 	= $this->input->post('reference_date_field');
		$reference_title_field	= $this->input->post('reference_title_field');
		$reference_detail_field	= $this->input->post('reference_detail_field');
		
		$id_field		= $this->input->post('id_field');
		$id_field 		= strtr($id_field, array('0.31' => ''));
		
		$img_paths 		= $this->reference_model->getRefImageRowById($id_field);

		$big_img_path 	= $img_paths['buyuk_resim'];
		$thumb_img_path = $img_paths['kucuk_resim'];


		if ($reference_dropdown_category_field == '0') // update formunda kategori de bi değişiklik yapılmamışsa
		{

			if ( ($reference_date_field != '') && ($reference_title_field != '') && ($reference_detail_field != '') ) 
			{
				$image_lib_array['image_name'] = $this->regex($reference_title_field);
				//////////////////////////////////////////////////////////////

				$this->load->library('image_upload_resize_library'); // resim upload ve resize eden library yi çağır
				$this->image_upload_resize_library->setBootstrapData($image_lib_array);
				############
				$this->image_upload_resize_library->display_errors = FALSE; // image_upload_resize_library sınıfının hata gösterme/saklama seçeneğini ayarlar
				$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize(); // resmi yükle ve yeniden boyutlandır
				############
				if ($this->image_upload_resize_library->getUploadedFileClientName() == NULL) // Eğer herhangi bir dosya yüklenmemişse
				{
					if (($this->reference_model->updateRefTextFieldOnDB($id_field, $reference_date_field, $reference_title_field, $reference_detail_field) == TRUE)) 
					{
						$message = 'Referans Güncellendi';
						$this->successMessage($message,'allReferences');
					}
					else
					{
						$message = 'HATA:: Referans Text Alanları Güncellenemedi';
						$this->errorMessage($message,'operation');
					}						
				}
				elseif ($image_up_and_resize == TRUE) // herhangi bir resim yüklenmişse 
				{
					$this->path_big_image	= $this->image_upload_resize_library->getSizedBigImgNameForDB();
					$this->path_thumb_image	= $this->image_upload_resize_library->getSizedThumbImgNameForDB();

					$path_big_image 	= $this->path_big_image;
					$path_thumb_image 	= $this->path_thumb_image;

					//$old_big_image_path = 
				
					$update_ref_text_field	= $this->reference_model->updateRefTextFieldOnDB($id_field, $reference_date_field, $reference_title_field, $reference_detail_field);
					$update_ref_img_field	= $this->reference_model->updateRefImgFieldOnDB($id_field, $path_big_image, $path_thumb_image);

					if ($update_ref_text_field == FALSE)
					{
						die('referans text field i guncellenirken bir ariza verdi');
					}
					elseif ($update_ref_img_field == FALSE) 
					{
						die('referans resim alani  guncellenirken bir ariza verdi');
					}
					else
					{
						$message = 'Referans Güncellendi';
						$this->successMessage($message,'allReferences');
					}

				}
				else
				{
					$message = 'HATA:: Referans Güncellenemedi';
					$this->errorMessage($message,'operation/'.$this->input->post("id_field").'');
				}

			}
			else
			{
				$message = 'HATA:: Lütfen Boş Alan Bırakmayın';
				$this->errorMessage($message,'operation/'.$this->input->post("id_field").'');
			}
		
		}
		elseif ($this->reference_model->getRefCategoryId($reference_dropdown_category_field) != NULL) // update formundaki güncellenen kategori seçeneği veritabanında varsa id sini al yoksa hata bas 
		{
			$ref_category_id = $this->reference_model->getRefCategoryId($reference_dropdown_category_field);

			if ( ($reference_date_field != '') && ($reference_title_field != '') && ($reference_detail_field != '') ) 
				{
					$image_lib_array['image_name'] = $this->regex($reference_title_field);
					//////////////////////////////////////////////////////////////

					$this->load->library('image_upload_resize_library'); // resim upload ve resize eden library yi çağır
					$this->image_upload_resize_library->setBootstrapData($image_lib_array);
					############
					$this->image_upload_resize_library->display_errors = FALSE; // image_upload_resize_library sınıfının hata gösterme/saklama seçeneğini ayarlar
					$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize(); // resmi yükle ve yeniden boyutlandır
					############
					if ($this->image_upload_resize_library->getUploadedFileClientName() == NULL) // Eğer herhangi bir dosya yüklenmemişse
					{
						if (($this->reference_model->updateRefTextFieldOnDB($id_field, $reference_date_field, $reference_title_field, $reference_detail_field, $ref_category_id) == TRUE)) 
						{
							$message = 'Referans Güncellendi';
							$this->successMessage($message,'allReferences');
						}
						else
						{
							$message = 'HATA:: Referans Text Alanları Güncellenemedi';
							$this->errorMessage($message,'operation');
						}						
					}
					elseif ($image_up_and_resize == TRUE) // herhangi bir resim yüklenmişse 
					{
						$this->path_big_image	= $this->image_upload_resize_library->getSizedBigImgNameForDB();
						$this->path_thumb_image	= $this->image_upload_resize_library->getSizedThumbImgNameForDB();
				
						if ($this->reference_model->updateRefTextFieldOnDB($id_field, $reference_date_field, $reference_title_field, $reference_detail_field, $ref_category_id) == FALSE)
						{
							//$this->errorMessage($message,'operation/'.$this->input->post("id_field").'');
							//var_dump($id_field, $reference_date_field, $reference_title_field, $reference_detail_field, $ref_category_id);
							die('referans text field i guncellenirken bir ariza verdi');
						}
						elseif ($this->reference_model->updateRefImgFieldOnDB($id_field, $this->path_big_image, $this->path_thumb_image) == FALSE) 
						{
							die('referans resim alani  guncellenirken bir ariza verdi');
						}
						else
						{
							$message = 'Referans Güncellendi';
							$this->successMessage($message,'allReferences');
						}
					}
					else
					{
						$message = 'HATA:: Referans Güncellenemedi';
						$this->errorMessage($message,'operation/'.$this->input->post("id_field").'');
					}

				}
				else
				{
					$message = 'HATA:: Lütfen Boş Alan Bırakmayın';
					$this->errorMessage($message,'operation/'.$this->input->post("id_field").'');
				}		

		}
		else
		{
			$message = 'HATA:: Buraya Erişim Yetkiniz Bulunmamaktadır';
			$this->errorMessage($message,'allReferences');
		}
		



	}


	public function allCategories()
	{
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/all_categories_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);		
	}


	public function operationCategory($ref_id = NULL)
	{
		$category_radio_field = $this->input->post('category_radio_field');

		if ($category_radio_field != '') 
		{
			$ref_id = strtr($category_radio_field, array('0.32' => ''));
			$this->editCategories($ref_id);
		}
		elseif ($ref_id != NULL) 
		{
			$ref_id = strtr($ref_id, array('0.32' => '')); // formdan gelen ref_id numarasını alır
			$this->editCategories($ref_id);
		}
		else
		{
			$message = 'HATA:: İşlem Yapabilmek Bir Eylem Seçmelisiniz, Yönlendiriliyorsunuz... ';
			$this->errorMessage($message,'allCategories');			
		}			
	}


	protected function editCategories($ref_id)
	{

		$get_category_by_id = $this->reference_model->getRefCategoryRows($ref_id);

		$this->parser_data['referans_kategorisi'] = $get_category_by_id;
		$this->parser_data['referans_kategorisi_update'] = $get_category_by_id;
		
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/edit_category_form_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
	}

	public function updateCategory()
	{
		$category_name_field = $this->input->post('category_name_field');

		$id_field = $this->input->post('id_field');
		$salt_id = strtr($id_field, array('0.32' => '')); // id field ını 0.32 prefixinden arındırır

		if ($category_name_field == '')
		{
			$message = 'Lütfen Boş Alan Bırakmayın';
			$this->errorMessage($message,"operationCategory/$id_field");
		}
		else
		{
			$update_ref_category = $this->reference_model->updateRefCategoryOnDB($salt_id, $category_name_field);
			if ($update_ref_category)
			{
				$message = 'Referans Kategorisi Güncellendi';
				$this->successMessage($message,'allCategories');
			}
			else
			{
				$message = 'HATA::Referans Kategorisi Güncellenemedi';
				$this->errorMessage($message,"operationCategory/$id_field");
			}
		}

	}

	public function addCategory()
	{
		$category_name_field = $this->input->post('category_name_field');
		if ($category_name_field != '' )
		{
			$seo_friendly_cat_name = $this->regex($category_name_field);

			$is_there_any_category_like_it = $this->reference_model->isThereAnyRefCategoryRowLikeIt($category_name_field);
			// daha önce böyle bir kayıtlı kategori olup olmadığına bakar / varsa hat basar, forma geri yönlendirir
			if ($is_there_any_category_like_it != TRUE)
			{
				$add_ref_category = $this->reference_model->add_Ref_Category($category_name_field, $seo_friendly_cat_name);
				if ($add_ref_category == TRUE) 
				{
					$message = 'Yeni Kategori Eklendi';
					$this->successMessage($message,'allCategories');
				}
				else
				{
					$message = 'KAtegori Eklenirken Bir Sorunla Karşılaşıldı';
					$this->errorMessage($message,'addCategory');
				}
			}
			else
			{
				$message = 'Bu Kategori Daha Önceden Eklenmiş.. Lütfen Yeni Bir Kategori Ekleyin..';
				$this->errorMessage($message,'addCategory');
			}
		}
		elseif ($category_name_field === FALSE)
		{
			// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/add_category_form_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);				
		}
		else
		{
			$message = 'Lütfen Boş Alan Bırakmayın';
			$this->errorMessage($message,'addCategory');
		}
	
	}


	public function deleteCategory()
	{
		$category_radio_field = $this->input->post('category_radio_field');
		if ($category_radio_field != '') 
		{
			$cat_id = strtr($category_radio_field, array('0.32' => ''));
			
			$deleteCategory = $this->reference_model->deleteNullCategory($cat_id);
			if($deleteCategory == TRUE)
			{
				$message = 'Kategori Silindi';
				$this->successMessage($message,'allCategories');
			}
			else
			{
				$message = 'Kategori Silinemedi';
				$this->errorMessage($message,'deleteCategory');
			}
		}
		elseif ($category_radio_field === FALSE) 
		{
			$this->parser_data['null_referans_kategorileri'] = $this->reference_model->getNullRefCategoryRows();
						// admin panelinin ilgili view lerini yükler
			$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
			$this->parser->parse('backend_views/all_null_categories_view',$this->parser_data);
			$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);	
		}
	}


		
	public function errorMessage($message, $return_path = NULL)
	{
		if ($return_path == NULL)
		{
			$return_path = 'addReference';
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
			$return_path = 'addReference';
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


	public function gel()
	{
		$ref_id = '25';
		$ref_date = '02/02/2013';
		$ref_title = 'yeni referans basligi';
		$ref_detail = 'referans aciklamasi';

		$path_big_image = 'buyuk_resim_yolu';
		$path_thumb_image = 'kucuk_resim_yolu';

		$cat_id = '10';

		$update = $this->reference_model->updateRefTextFieldOnDB($ref_id, $ref_date, $ref_title, $ref_detail);
		if ($update == TRUE) 
		{
			echo 'basarili';
		}
		else
		{
			echo 'basarisiz.......';
		}
	}




}