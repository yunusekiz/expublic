<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class datee extends CI_Controller {
	
	function index()
	{
/*		// yeni eklenecek referansın kategorisi
		$new_category_name = 'ornek_kategori_3'; 
		///////////////////////////////////////////
		
		// yeni eklenecek referansin text field ları
		$new_ref_name 	=	'ornek_referans_ismi_3'; 
		$new_ref_date 	=	'ornek_referans_tarihi_3';
		$new_ref_title	=	'ornek_referans_basligi_3';
		$new_ref_detail	= 	'ornek_referans_detayi_3';
		////////////////////////////////////////////
		
		// yeni eklenecek referansın resimleri
		$new_ref_image 			=	'ornek_referans_resmi_3';
		$new_ref_image_thumb	=	'ornek_referans_thumbı_3';
		//////////////////////////////////////////////////////*/
		
		// Kayit_gir isimli modeli yükle 		
		$this->load->model('kayit_gir');
		////////////////////////////////
/*		
		// yeni refereans kategorisi ekle
		$this->kayit_gir->add_Ref_Category($new_category_name);
		////////////////////////////////////////////////////////
		
		// yeni referans text field ı ekle
		$this->kayit_gir->add_Ref_TextField($new_ref_name,$new_ref_date,$new_ref_title,$new_ref_detail);
		////////////////////////////////////////////////////////////////////////////////////////////////
		
		// yeni referans resmi ekle
		$this->kayit_gir->add_Ref_Image($new_ref_image,$new_ref_image_thumb);
		/////////////////////////////////////////////////////////////////////*/
			
		$kayit_getir = $this->kayit_gir->getRefViewAlias();
	
		
		$data = array(
						'referans_sütunları' => $kayit_getir
					 );
		
		
		$this->parser->parse('denek',$data);
		
		

/*		$name = 'ornek_kategori_2';
		
		$id = $this->kayit_gir->getRefCategoryId($name);
		echo $id;*/
	}
	
}



