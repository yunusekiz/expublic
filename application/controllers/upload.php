<?php
class Upload extends CI_Controller {
	
	protected $base;
	
	function __construct()
	{
		parent::__construct();
		$this->load->view('upload_form');
	}

	function index()
	{
		return NULL;
	}

	public function upandresize()
	{

		$array = array(
							'image_form_field'	=>	'big_slider_image_form_field',
							'upload_path'		=>	'assets/theme_assets/slider_assets/photo',
							'image_name'		=>	NULL,
							'big_img_width'		=>	960,
							'big_img_height'	=>	300,
							'thumb_img_width'	=>	20,
							'thumb_img_height'	=>	20
					  );

		$this->load->library('image_upload_resize_library');
		$this->image_upload_resize_library->setBootstrapData($array);
		$this->image_upload_resize_library->imageUpAndResize();

/*		echo $this->image_upload_resize_library->getSizedBigImgNameForDB();
		echo '</br>';
		echo $this->image_upload_resize_library->getSizedThumbImgNameForDB();*/
	}

}















