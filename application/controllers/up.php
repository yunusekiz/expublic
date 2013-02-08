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

	public function imageUpAndResize($image_form_field, $upload_path, $image_name, $display_errors = TRUE)
	{
		$this->imageUpload($image_form_field, $upload_path, $image_name, $display_errors = TRUE);

	}

	public function imageUpload($image_form_field, $upload_path, $image_name, $display_errors = TRUE)
	{

		$upload_config['upload_path'] = $upload_path;//'./assets/theme_assets/slider_assets/photo/'; 
		$upload_config['allowed_types'] = 'gif|jpg|png';
		$upload_config['max_size']	= '1000000000';
		$upload_config['max_width'] = '10240';
		$upload_config['max_height'] = '7680';
		$upload_config['file_name'] = $image_name;

		$this->load->library('upload',$upload_config);

		$do_upload = $this->upload->do_upload($image_form_field);

		if ($do_upload)
		{
			$this->data_after_upload = $this->upload->data();
			return TRUE;
		}
		else
		{
			if ($display_errors == TRUE)
			{
				echo '<center><h3>'.$this->upload->display_errors('<p>', '</p>').'</h3></center>';
				return FALSE;
			}
			else
			{
				return FALSE;
			}

		}
	}

	public function imageResize($source_original_img = NULL, $big_img_width, $big_img_height, $thumb_img_width, $thumb_img_height )
	{

		if ($source_original_img == NULL)
		{
			$source_original_img = $this->getUploadedFileFullPath();
		}

		if ($thumb_img_width == NULL)
		{
			 $thumb_img_width = 90;
		}

		if ($thumb_img_height == NULL)
		{
			$thumb_img_height = 90;
		}

		$resize_thumb_img_config['image_library'] = 'gd2';
		$resize_thumb_img_config['source_image'] = $source_original_img;
		$resize_thumb_img_config['create_thumb'] = TRUE;
		$resize_thumb_img_config['maintain_ratio'] = FALSE;
		$resize_thumb_img_config['width'] = $thumb_img_width;
		$resize_thumb_img_config['height'] = $thumb_img_height;

		$img_sourge_parent_directory = dirname($source_original_img);

		$resize_thumb_img_config['new_image']	= $img_sourge_parent_directory.'/thumb'; 

		$this->image_lib->initialize($resize_thumb_img_config);
		
		$create_thumb_image = $this->image_lib->resize();

		$this->image_lib->clear();

		if ($create_thumb_image)
		{
			if ($big_img_width == NULL)
			{
				$big_img_width = 960;
			}
			if ($big_img_height == NULL)
			{
				$big_img_height = 300;
			}

			$resize_big_img_config['image_library'] = 'gd2';	
			$resize_big_img_config['source_image'] = $source_original_img;
			$resize_big_img_config['create_thumb'] = FALSE;
			$resize_big_img_config['maintain_ratio'] = FALSE;
			$resize_big_img_config['width'] = $big_img_width;
			$resize_big_img_config['height'] = $big_img_height; 

			$this->image_lib->initialize($resize_big_img_config);
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


	public function getUploadedFileFullData()
	{
		return $this->data_after_upload;
	}

	public function getUploadedFileFullPath()
	{
		return $this->data_after_upload['full_path'];
	}

	public function getUploadedFilePath()
	{
		return $this->data_after_upload['file_path'];
	}

	public function getUploadedFileSize()
	{
		return $this->data_after_upload['file_size'];
	}

	public function getUploadedFileExtension()
	{
		return $this->data_after_upload['file_ext'];
	}

	public function getUploadedFileType()
	{
		return $this->data_after_upload['file_type'];
	}

	public function getUploadedFileClientName()
	{
		return $this->data_after_upload['client_name'];
	}

	public function getSizedBigImgName()
	{

	}

	public function anan()
	{
		$path = "C:/xampp/htdocs/www/expublic_codelobster/assets/fuck/yeni_isim.jpg";
		$file = dirname($path); 
		echo $path;
		echo('</br>');
		echo $file;
	}

}