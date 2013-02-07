<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reference extends CI_Controller {
	
	protected $data;
	protected $base;
	
	public function index()
	{
		return null;
	}
	
	public function __construct()
	{
		parent::__construct();
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
	
		$reference_category = null;
		
		if($reference_dropdown_category=='0')
		{
			if(empty($reference_text_category))
			{
				echo 'kategoriyi bos biraktiniz';
				die();
			}
			else
			{
				$reference_category = $reference_text_category;	
			}
		}
		else
		{
			$reference_category = $reference_dropdown_category;
		}
		
		if(empty($reference_title) || empty($reference_detail))
		{
			echo 'referans basligini ve detayini bos birakmayiniz';
			die();
		}
		else
		{
			$config['upload_path'] = './assets/images/reference_images/';
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
				
				
			}
	
		}
		
		
	}
	
	protected function imageUpload()
	{		
		$config_image['upload_path'] = './assets/images/';
		$config_image['allowed_types'] = 'gif|jpg|png';
		
		$this->load->library('upload',$config_image);
		
		if($this->reference->imageUpload())
		{
			echo 'resim yuklendi : <br>';
			$data = array('upload_data' => $this->upload->data());
			var_dump($data);
		}
		else
		{
			echo 'resim yuklenemedi : <br>';
			$this->upload->display_errors('<p>', '</p>');
		}

	} 
	
	public function saveReference()
	{

	}

}