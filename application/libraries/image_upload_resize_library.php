<?php

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class image_upload_resize_library {
	
	// codeigniter ın orijinal class larına ulaşmak için bu değişken kullanılacak
	public $CI;
	
	// resim upload edildikten sonraki gerekli dataların tutulduğu değişken
	public $imageDataAfterUpload;
	
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	
	public function image_upload($image_form_field, array $upload_config, $display_errors = FALSE);
	{
		// ilk olarak codeigniter ın orijinal upload library sini çağırır
		$this->CI->load->library('upload',$upload_config);
		
		// resim yükleyen metod olan do_upload() metodunu çağırır
		$this->upload->do_upload($image_form_field);
		
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
	
	
	// resmi '$resize_config' verilerine göre resize işleminden geçirir
	public function imageResize(array $resize_config, $display_errors = FALSE)
	{
		$this->CI->load->library('image_lib',$resize_config);
		
		$do_resize = $this->image_lib->resize();
		
		
	}
}



?>