<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class up extends CI_Controller {

	//resim upload işlemlerinden sonra resize için gerekli olan dataları tutar;
	private $data_after_upload;

	//  resize işlemlerinden sonra veritabanına kaydedilecek olan resim dosya yollarını tutar
	private $data_after_resize;

	// bu class ı kullanırken gerekli olan image detaylarını tutan array
	private $bootstrap_data = array();

	// class run edildiğinde eğer bi hata oluşursa, hatanın ekrana basılıp basılmayacağını belirler
	private $display_errors;

	public $root;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('image_lib');
		
		$array = array(
						'image_form_field'	=>	'image_form_field',
						'upload_path'		=>	'assets/theme_assets/slider_assets/photo',
						'image_name'		=>	'merhaba_harun_abi',
						'big_img_width'		=>	960,
						'big_img_height'	=>	300,
						'thumb_img_width'	=>	100,
						'thumb_img_height'	=>	100
					  );

		$this->root = strstr(dirname(__FILE__),'\application\controllers',TRUE);

		$this->setBootstrapData($array);
		$this->controlBootstrapData();
	}

	public function index()
	{
		$this->load->view('up_view');
	}

	public function setBootstrapData(array $data)
	{
		$this->bootstrap_data = $data;
	}

	// class ı n çalışabilmesi için gerekli olan bootstrap datalar eksikmi değilmi diye control eder, eksikse gerekli işlemleri yapar
	private function controlBootstrapData()
	{

		if ($this->bootstrap_data['image_form_field'] == NULL)
		{
			echo '</br></br><center> <h3> HATA:: Dosya Yukleme Formundaki Ilgili Field i, class a tanitmadiniz </h3></center>';
			die();
		}


		if ($this->bootstrap_data['upload_path'] == NULL)
		{
			$this->bootstrap_data['upload_path'] = $this->root.'/assets/image_upload_lib_assets';
		}
		else
		{
			$this->bootstrap_data['upload_path'] = $this->root.'/'.$this->bootstrap_data['upload_path'];
		}


		if ($this->bootstrap_data['thumb_img_width'] == NULL)
		{
			$this->bootstrap_data['thumb_img_width'] = 90;
		}
		if ($this->bootstrap_data['thumb_img_height'] == NULL)
		{
			$this->bootstrap_data['thumb_img_height'] = 90;
		}


	}

	public function imageUpAndResize()
	{
		$image_upload = $this->imageUpload();
		
		if ($image_upload == FALSE)
		{
			echo '</br> <center> <h3> HATA:: Resim Yukleme FALSE Dondu </h3> </center></br>';
			echo '</br> upload path i :';
			var_dump($this->bootstrap_data['upload_path']);
			die();
		}

		$this->imageResize();

		echo $this->getSizedBigImgNameForDB();
		echo '</br>';
		echo $this->getSizedThumbImgNameForDB();
	}


	public function imageUpload($display_errors = TRUE)
	{

		$upload_config['upload_path'] = $this->bootstrap_data['upload_path'];
		$upload_config['allowed_types'] = 'gif|jpg|png';
		$upload_config['max_size']	= '20000';
		$upload_config['max_width'] = '10240';
		$upload_config['max_height'] = '7680';
		
		if ($this->bootstrap_data['image_name'] != NULL)
		{
			$upload_config['file_name'] = $this->bootstrap_data['image_name'] ;
		}

		$image_form_field = $this->bootstrap_data['image_form_field'];

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


	public function imageResize($source_of_img = NULL)
	{

		if ($this->getUploadedFileFullPath() == NULL)
		{
			$source_of_img = $this->root.$source_of_img;
		}
		else
		{
			$source_of_img = $this->getUploadedFileFullPath();
		}


		$resize_thumb_img_config['image_library'] = 'gd2';
		$resize_thumb_img_config['source_image'] = $source_of_img;
		$resize_thumb_img_config['create_thumb'] = TRUE;
		$resize_thumb_img_config['maintain_ratio'] = FALSE;
		$resize_thumb_img_config['width'] = $this->bootstrap_data['thumb_img_width'];
		$resize_thumb_img_config['height'] = $this->bootstrap_data['thumb_img_height'];

		$img_sourge_parent_directory = dirname($source_of_img);

		$resize_thumb_img_config['new_image']	= $img_sourge_parent_directory.'/thumb'; 

		$this->image_lib->initialize($resize_thumb_img_config);
		$create_thumb_image = $this->image_lib->resize();

		$this->image_lib->clear();

		if ($create_thumb_image)
		{
			if ($this->bootstrap_data['big_img_width'] == NULL)
			{
				if ($this->getUploadedFileWidth() == NULL)
				{
					echo '</br><center> <h3> HATA:: Buyuk Resim Icın Hic Bir Width Degeri Belirtilmedi </h3> </center>';
					die();	# code...
				}
				else
				{
					$big_img_width = $this->getUploadedFileWidth();
				}
				
			}
			else
			{
				$big_img_width = $this->bootstrap_data['big_img_width'];
			}



			if ($this->bootstrap_data['big_img_height'] == NULL)
			{
				if ($this->getUploadedFileHeight() == NULL)
				{
					echo '</br><center> <h3> HATA:: Buyuk Resim Icın Hic Bir Height Degeri Belirtilmedi </h3> </center>';
					die();
				}
				else
				{
					$big_img_height = $this->getUploadedFileHeight();
				}				
			}
			else
			{
				$big_img_height = $this->bootstrap_data['big_img_height'];
			}



			$resize_big_img_config['image_library'] = 'gd2';	
			$resize_big_img_config['source_image'] = $source_of_img;
			$resize_big_img_config['create_thumb'] = FALSE;
			$resize_big_img_config['maintain_ratio'] = FALSE;
			$resize_big_img_config['width'] = $big_img_width;
			$resize_big_img_config['height'] = $big_img_height; 

			$this->image_lib->initialize($resize_big_img_config);
			$create_big_image = $this->image_lib->resize();

			if ($create_big_image)
			{
				//echo '<br/> resmin buyuk hali olusturuldu </br>';
				//echo '<br/> gecmis olsun : <br/>';
				//echo 'veritabanina kaydedilmesi gerekenler : ';
				//echo '<br/>';
				$this->data_after_resize['db_big_image'] = strstr($source_of_img, 'assets');
				
				$path_parts = pathinfo($this->data_after_resize['db_big_image']);
				$thumb_fullpath = $resize_thumb_img_config['new_image'].'/'.$path_parts['filename'].'_thumb'.$this->getUploadedFileExtension();

				$this->data_after_resize['db_thumb_image'] = strstr($thumb_fullpath, 'assets');

				return TRUE;

			}
			else
			{
				echo '</br> HATA:: resmin buyuk hali olusturulamadi :  </br>';
				echo $this->image_lib->display_errors();
				return FALSE;
			}
		}
		else
		{
			echo '</br> HATA:: resmin thumb i olusturulamadi </br>';
			echo $this->image_lib->display_errors();
			return FALSE;
		}

	}



///////////////////// upload dan sonraki gerekli dataları alan metodlar başlangıç ///////////////////
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

	public function getUploadedFileWidth()
	{
		list($width,$height) = getimagesize($this->getUploadedFileFullPath());
		return $width;
	}

	public function getUploadedFileHeight()
	{
		list($width,$height) = getimagesize($this->getUploadedFileFullPath());
		return $height;
	}
///////////////////// upload dan sonraki gerekli dataları alan metodlar bitiş ///////////////////



//////////////////// resize işleminden sonra gerekli dataları alan metodlar başlangıç //////////////
	public function getSizedBigImgNameForDB()
	{
		return $this->data_after_resize['db_big_image'];
	}

	public function getSizedThumbImgNameForDB()
	{
		return $this->data_after_resize['db_thumb_image'];
	}
////////////////// resize işleminden sonra gerekli dataları alan metodlar bitiş //////////////



	public function dell()
	{
		$victim_1 = base_url('assets/fuck/yeni_isim.jpg');

		$victim_2 = dirname(__FILE__);
		

	 $kelime = strstr($victim_2,'application\controllers',TRUE);

	 echo $kelime;

	}



}