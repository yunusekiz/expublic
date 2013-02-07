<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reference extends CI_Controller {
	
	protected $data;
	protected $base;
	
	protected $imageDataAfterUpload;
	
	protected $path_big_full;
	protected $path_thumb_full;
	
	protected $ref_category_id = NULL;
	
	public function index()
	{
		return null;
	}
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('reference_model');
		
		$this->base = base_url();
		$day = date('d');
		$month = date('m');
		$year = date('Y');
		
		$base = base_url();
		
		$this->data = array('base' => $base,'day'=>$day,'month'=>$month,'year'=>$year);
	}
	
	
	public function addReference()
	{	
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->data);
		$this->parser->parse('backend_views/admin_main_view',$this->data);
		$this->parser->parse('backend_views/reference_view',$this->data);
		$this->parser->parse('backend_views/admin_footer_view',$this->data);
	}
	
	public function controlReference()
	{
		$reference_dropdown_category = $this->input->post('reference_dropdown_category');
		$reference_text_category	 = $this->input->post('reference_text_category');
		$reference_day			 	 = $this->input->post('reference_day');
		$reference_month		 	 = $this->input->post('reference_month');
		$reference_year			 	 = $this->input->post('reference_year');
		$reference_title		 	 = $this->input->post('reference_title');
		$reference_detail		 	 = $this->input->post('reference_detail');
		
		$reference_date = $reference_day.'-'.$reference_month.'-'.$reference_year;
	
		$reference_category = NULL; 
		
		if($reference_dropdown_category != '0') // dropdowndan gelen category value si sıfır(0) değil ise
		{
			$reference_category = $reference_dropdown_category; // dropdowndan gelen value reference_category değişkenine atansın
			// test : echo 'dropdowndan gelen category value si sifir (0) degil : ';
			// test : echo $reference_category;
		}
		else  // dropdowndan gelen category value si sıfır(0) ise
		{
			if($reference_text_category != NULL) // bununla birlikte yine formdan gelen reference_text_category field ı boş değil ise
			{
				$reference_category = $reference_text_category;	// formdan gelen reference_text_category value su  reference_category değişkenine atansın
				// test : echo 'formdan gelen reference_text_category field i bos degil : ';
				// test : echo $reference_category;
			}
			else
			{
				echo 'kategoriyi bos biraktiniz : '; // bununla birlikte yine formdan gelen reference_text_category field ı  da boş ise artık hata bassın
				// test : var_dump($reference_category);
				die();
			}
		}
		
		if(($reference_title != NULL) && ($reference_detail != NULL))
		{
			//echo 'referans basligini ve detayini bos birakmayiniz';
			//die();
			
/*			echo 'formdan gelen referans title ve referans detail bos degil : ';
			echo $reference_title;
			echo '<br>';
			echo $reference_detail;*/
			
		}		
		else
		{
			echo 'formdan gelen referans title ve referans detail bos bom boss : ';
/*			$config['upload_path'] = './assets/images/reference_images/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '1000000';
			$config['max_width'] = '10240';
			$config['max_height'] = '7680';
		
			$this->load->library('upload', $config);
		
			if( ! $this->upload->do_upload("reference_image"))// yeni referans ekleme formundaki <input name="reference_image"> isimli field
			{
				echo 'resim yuklenemedi : <br>';
				echo $this->upload->display_errors();
			}
			else
			{
				echo 'resim basariyla yuklendi : <br>';
				$data = $this->upload->data();
				$full_path = strstr($data['full_path'],'assets');
				$thumb_path = $data['file_path'].'thumb/';
				
				$resize_config['image_library']	= 'gd2';
				$resize_config['source_image']	= $full_path;
				$resize_config['new_image']	= $thumb_path;
				$resize_config['create_thumb']	= TRUE;
				$resize_config['maintain_ratio'] = FALSE;
				$resize_config['width']	= 75;
				$resize_config['height'] = 75;
				
				$this->load->library('image_lib',$resize_config);
				$this->image_lib->resize() or die($this->image_lib->display_errors());
				
				
			}*/
	
		}
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$conditon_ref_text_field = $this->reference_model->isThereAnyRefTextFieldRowLikeIt($reference_title);
		
		if($conditon_ref_text_field == TRUE) // eğer form field larından gelen "referans basligi", veritabanındaki ref_text_field tablosunda daha önceden kayıtlı ise
		{
			echo '<h1> daha once bu kayit varmis lutfen baska kayit ekleyiniz </h1>';
			die();
		}
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$conditon_ref_category = $this->reference_model->isThereAnyRefCategoryRowLikeIt($reference_category);
		
		if($conditon_ref_category == TRUE) // eğer form field larından gelen "referans kategori", veritabanındaki "ref_category" tablosunda daha önceden kayıtlı ise
		{
			$this->ref_category_id = $this->reference_model->getRefCategoryId($reference_category);
		}
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		########### referansın kaydedilecek büyük resminin config bilgileri ###########
		$upload_config['upload_path'] = './assets/images/reference_images/'; 
		$upload_config['allowed_types'] = 'gif|jpg|png';
		$upload_config['max_size']	= '1000000';
		$upload_config['max_width'] = '10240';
		$upload_config['max_height'] = '7680';
			
			$imageUpload = $this->imageUpload('reference_image',$upload_config); // bu class içindeki imageUpload() metodunu çağırır, resim upload işlemini başlatır
		
		if( $imageUpload != FALSE ) // upload işlemi başarısız değil ise, kaydedilen resmin bilgilerini alır	
		{
			$full_path	= $this->imageDataAfterUpload['full_path']; // upload edilen resmin full_path i 
			$thumb_path = $this->imageDataAfterUpload['file_path'].'thumb/'; // resize işlemi sonrası yeni oluşturulacak thumb resmin kaydedileceği dizin		
		}
	
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		########### referansın resize işleminden geçecek küçük resminin config bilgileri ###########
		$resize_config['image_library']	= 'gd2';
		$resize_config['source_image']	= $full_path;
		$resize_config['new_image']	= $thumb_path;
		$resize_config['create_thumb']	= TRUE;
		$resize_config['maintain_ratio'] = FALSE;
		$resize_config['width']	= 270;
		$resize_config['height'] = 135;
		
		$thumb_image_name = strstr($this->imageDataAfterUpload['file_name'],'.',TRUE).'_thumb'.$this->imageDataAfterUpload['file_ext']; // thumb resmin adı 
		
		$do_resize = $this->imageResize($resize_config); // resmi resize işleminden geçirmek için "imageResize()" metodunu çağır, resmi resize eder
		if($do_resize == TRUE) // "imageResize()" metodundan eğer TRUE dönmüş ise büyük ve küçük resmin kayıt bilgilerini tut
		{
			/*echo '<br>resim kaydetme islemi basarili : bilgiler : <br>';*/
			 $this->path_big_full	=  $resize_config['source_image'];
			 $this->path_thumb_full =  $resize_config['new_image'].$thumb_image_name;
		}
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if($this->ref_category_id == NULL) // eğer yeni referans kategorisi eklenecekse, ilk önce yeni referans kategorisi ekle :)
		{
			$add_ref_category = $this->reference_model->add_Ref_Category($reference_category); // yeni referans kategorisi ekler
			if($add_ref_category == FALSE) // eğer yeni kategori ekleme başarılı değil ise hata bas
			{
				echo '<br>yeni referans kategorisi ekleme islemi basarisiz oldu<br>';
				
			}
			
			// reference_text_field tablosuna yeni kayıt ekler
			$add_tef_text_field = $this->reference_model->add_Ref_TextField($reference_title, $reference_date, $reference_title, $reference_detail);
			if($add_tef_text_field == FALSE) // eğer yeni referans text field  ekleme başarılı değil ise hata bas
			{
				echo '<br>yeni referans text field ekleme islemi basarisiz oldu<br>';
			}
			
			// yukarıdaki islemler basarili ise, "reference_image" tablosuna yeni kayıt gir
			$add_ref_image = $this->reference_model->add_Ref_Image($this->path_big_full, $this->path_thumb_full);	
			if($add_ref_image)
			{
				echo '<center><h1>::::TEBRIKLER:::: yeni referans kategorisi text field i ve referans resmi ekleme, resize etme islemi basarili oldu </h1></center>';
			}
					
		}
		else // eğer çok daha önceden referans kategorisi eklenmişse, "id" sini al, referans text field larını ekle
		{
			$add_tef_text_field = $this->reference_model->add_Ref_TextField($reference_title, $reference_date, $reference_title,
																			$reference_detail, TRUE, $this->ref_category_id);
			if(!$add_tef_text_field) // eğer yeni referans text field  ekleme başarılı değil ise hata bas
			{
				echo '<br>yeni referans text field ekleme islemi basarisiz oldu<br>';
			}
			
			// yukarıdaki islemler basarili ise, "reference_image" tablosuna yeni kayıt gir
			$add_ref_image = $this->reference_model->add_Ref_Image($this->path_big_full, $this->path_thumb_full);	
			if($add_ref_image == TRUE)
			{
				echo '<center><h1>::::TEBRIKLER:::: yeni referans kategorisi text field i ve referans resmi ekleme, resize etme islemi basarili oldu </h1></center>';
			}
																			
		}
		
				
	}
	
	
	protected function imageUpload($image_form_field, array $upload_config, $display_errors = FALSE)
	{
		$this->load->library('upload',$upload_config);
		$do_upload = $this->upload->do_upload($image_form_field);  // resmi upload eder, $image_form_field, ref. ekleme formundaki <input name="reference_image"> a eşit.
		
		if( ! $do_upload )
		{
			if($display_errors == TRUE) // resim upload işlemi başarısız ise ve hata bastırma açık ise hata basar
			{
				echo '<center><h3>'.$this->upload->display_errors('<p>', '</p>').'</h3></center>';
				return FALSE;
			}
			else // resim upload işlemi başarısız ise ve hata bastırma açık değil ise sadece FALSE döndürür
			{
				return FALSE;
			}
		}
		else // upload işlemi başarılı ise, kaydedilen resmin bilgilerini "imageAfterUploadData" değişkenine atar	
		{
			return $this->imageDataAfterUpload = $this->upload->data();
		}
	}
	
	
	// bu metod referans resmini, "$resize_config" verilerine göre resize işleminden geçirir
	protected function imageResize(array $resize_config,$display_errors = FALSE)
	{
		$this->load->library('image_lib',$resize_config);
		$do_resize = $this->image_lib->resize(); // referans resminin thumbnail ini oluşturmak için resmi resize işleminden geçirir
		
		if( ! $do_resize ) // eğer resim resize işlemi başarısızsa
		{
			if($display_errors == TRUE) // resim resize işlemi başarısızsa ve  hata bastırma açık ise hata basar 
			{
				echo '<center><h3>'.$this->image_lib->display_errors('<p>', '</p>').'</h3></center>';
			}
			else // resim resize işlemi başarısızsa ve  hata bastırma açık değil ise sadece FALSE döndürür
			{
				return FALSE;
			}	
		}
		else // resim resize işlemi başarılı ise TRUE döndürür
		{
			return TRUE;
		}
	}
	
	

}