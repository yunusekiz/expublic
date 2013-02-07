<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class up extends CI_Controller {

	//resim upload işlemlerinden sonra resize için gerekli olan dataları tutar;
	private $data_after_upload;

	//  resize işlemlerinden sonra veritabanına kaydedilecek olan resim dosya yollarını tutar
	private $data_after_resize; 

	public function __construct()
	{
		parent::__construct();
		$this->load->library('image_lib');
	}

	public function index()
	{
		$this->load->view('up_view');
	}

	public function imageUp()
	{
		$upload_path;

		$upload_config['upload_path'] = './assets/theme_assets/slider_assets/photo/'; 
		$upload_config['allowed_types'] = 'gif|jpg|png';
		$upload_config['max_size']	= '1000000';
		$upload_config['max_width'] = '10240';
		$upload_config['max_height'] = '7680';
		$upload_config['file_name'] = 'yeni_isim';

		$this->load->library('upload',$upload_config);

		$do_upload = $this->upload->do_upload('image_form_field');

		if ($do_upload)
		{
			echo 'resim başarıyla yüklendi : </br>';
			$this->data_after_upload = $this->upload->data();

			$this->data_after_upload['file_type'];
			$this->data_after_upload['file_path'];
			$this->data_after_upload['full_path'];
			echo 'dosya raw name i :'.$data_after_upload['raw_name'].'</br>';
			echo 'dosya orig name i : '.$data_after_upload['orig_name'].'</br>';
			$this->data_after_upload['client_name'].'</br>';
			$this->data_after_upload['file_ext'].'</br>';
			$this->data_after_upload['file_size'].'</br>';
			

			$resize_config['image_library'] = 'gd2';
			$resize_config['source_image'] = $upload_data['full_path'];
			$resize_config['create_thumb'] = TRUE;
			$resize_config['maintain_ratio'] = FALSE;
			$resize_config['width'] = 960;
			$resize_config['height'] = 300;
			

			$this->image_lib->initialize($resize_config);
			$do_resize = $this->image_lib->resize();

			if ($do_resize)
			{
				echo 'resim resize edildi : </br>';
			}
			else
			{
				echo $this->image_lib->display_errors();
			}
		}
		else
		{
			echo 'resim yükleme başarısız oldu : </br>';
			echo '<center><h3>'.$this->upload->display_errors('<p>', '</p>').'</h3></center>';

		}
	}

	public function resize()
	{
		$thumbing_config['image_library'] = 'gd2';
		$thumbing_config['source_image'] = 'C:/xampp/htdocs/www/expublic_codelobster/assets/fuck/yeni_isim.jpg';
		$thumbing_config['create_thumb'] = TRUE;
		$thumbing_config['maintain_ratio'] = FALSE;
		$thumbing_config['width'] = 90;
		$thumbing_config['height'] = 90;
		$thumbing_config['new_image']	= 'C:/xampp/htdocs/www/expublic_codelobster/assets/fuck/thumb'; 

		$this->image_lib->initialize($thumbing_config);
		
		$create_thumb = $this->image_lib->resize();

		$this->image_lib->clear();

		if ($create_thumb)
		{
			echo 'resmin thumb i olusturuldu : </br>';
			$resize_config['image_library'] = 'gd2';	
			$resize_config['source_image'] = 'C:/xampp/htdocs/www/expublic_codelobster/assets/fuck/yeni_isim.jpg';
			$resize_config['create_thumb'] = FALSE;
			$resize_config['maintain_ratio'] = FALSE;
			$resize_config['width'] = 960;
			$resize_config['height'] = 300; 

			//$this->load->library('image_lib',$resize_config);
			$this->image_lib->initialize($resize_config);
			$create_big_image = $this->image_lib->resize();

			if ($create_big_image)
			{
				echo '</br> resmin buyuk hali olusturuldu </br>';
			}
			else
			{
				echo '</br> HATA:: resmin buyuk hali olusturulamadi :  </br>';
				echo $this->image_lib->display_errors();
			}
		}
		else
		{
			echo '</br> HATA:: resmin thumb i olusturulamadi </br>';
			echo $this->image_lib->display_errors();
		}

	}

	public function dell()
	{
		$victim_1 = base_url('assets/fuck/yeni_isim.jpg');

		$victim_2 = $_SERVER['DOCUMENT_ROOT'].'/resim.jpg';
		

	 $kelime = strstr('C:/xampp/htdocs/www/expublic_codelobster/assets/theme_assets/slider_assets/photo/yeni_isim.jpg','assets');

	 echo $kelime;

	}

	public function getUploadData()
	{
		return $this->data_after_upload;
	}

	public function getResizeData()
	{
		$this->data_after_resize;
	}

}