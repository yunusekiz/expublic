<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reference extends CI_Controller {
	
	protected $parser_data;
	protected $base_data;

	protected $imageDataAfterUpload;
	
	protected $path_big_image;
	protected $path_thumb_image;
	
	protected $ref_category_id = NULL;
	
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
									'referans_kategorileri'	=> $category_row
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
						'thumb_img_width'	=>	220,
						'thumb_img_height'	=>	110
					  );
	
		$reference_dropdown_category = $this->input->post('reference_dropdown_category');
		$reference_text_category	 = $this->input->post('reference_text_category');
		$reference_day			 	 = $this->input->post('reference_day');
		$reference_month		 	 = $this->input->post('reference_month');
		$reference_year			 	 = $this->input->post('reference_year');
		$reference_title		 	 = $this->input->post('reference_title');
		$reference_detail		 	 = $this->input->post('reference_detail');

		$reference_date = $reference_day.'-'.$reference_month.'-'.$reference_year;
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#		
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#		
		#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#
		if(($reference_title != '') || ($reference_detail != '')) // referans basligi ve  referans aciklamsi bos degil ise
		{
			if($reference_dropdown_category != '0') // dropdowndan gelen category value si sıfır(0) değil ise
			{
				$reference_category = $reference_dropdown_category; // dropdowndan gelen value reference_category değişkenine atansın

				$conditon_ref_text_field = $this->reference_model->isThereAnyRefTextFieldRowLikeIt($reference_title);
				if ($conditon_ref_text_field == FALSE) // formdan gelen referans başlığı daha önceden kayıtlı değil ise 
				{
					$image_lib_array['image_name'] = $reference_title;

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

					$image_lib_array['image_name'] = $reference_title;

					$this->load->library('image_upload_resize_library'); // resim upload ve resize eden library yi çağır
					$this->image_upload_resize_library->display_errors = FALSE; // image_upload_resize_library sınıfının hata gösterme/saklama seçeneğini ayarlar
					$this->image_upload_resize_library->setBootstrapData($image_lib_array); // resim upload ve resize librarysine gerekli verileri set et
					#####################################################################################
					$image_up_and_resize = $this->image_upload_resize_library->imageUpAndResize(); // resmi yükle ve yeniden boyutlandır
					if($image_up_and_resize == TRUE) // eğer image upload ve resize işlemleri başarılı ise, resmin kayıt bilgilerini al
					{
						$this->path_big_image	= $this->image_upload_resize_library->getSizedBigImgNameForDB();
						$this->path_thumb_image	= $this->image_upload_resize_library->getSizedThumbImgNameForDB();

						$add_ref_category = $this->reference_model->add_Ref_Category($reference_category); // bu ketegori daha önceden kayıtlı olmadığı için yeni kategori ekler
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

	public function addcat()
	{
		$category = 'daşşak';
		$this->reference_model->add_Ref_Category($category);
	}

	public function control()
	{
		$category = $this->input->post('reference_dropdown_category');
		echo "<h1> gelen kategori :  $category </h1>";
	}

	public function setView()
	{
		$this->reference_model->create_Ref_View();
	}
	

}