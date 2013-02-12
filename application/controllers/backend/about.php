<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class about extends CI_Controller {
	
	protected $data;

	protected $base_data;

	protected $row_data;
	
	public function index()
	{
		return null;
	}
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('about_model');

		$this->base_data = base_url();
		
		$base = base_url();
		$this->row_data = $this->about_model->getAboutUsRowAsArray();
		$about_column	= $this->row_data['about'];
		$vision_column	= $this->row_data['vision'];
		$mission_column = $this->row_data['mission'];
		
		$this->data = array('base' => $base, 'about' => $about_column, 'vision' => $vision_column, 'mission' => $mission_column);
		
	}
	
	
	public function editAboutUs()
	{
		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->data);
		$this->parser->parse('backend_views/admin_main_view',$this->data);
		$this->parser->parse('backend_views/about_view',$this->data);
		$this->parser->parse('backend_views/admin_footer_view',$this->data);
				
	}
	
	public function controlAboutUs()
	{
		$about_field	= $this->input->post('about_field');
		$vision_field	= $this->input->post('vision_field');
		$mission_field	= $this->input->post('mission_field');
		/*$textt			= $this->input->post('textt');*/
		
		if(($about_field == '') || ($vision_field == '') || ($mission_field == '') )
		{
			$message = 'Lütfen Boş Alan Bırakmayın';
			$this->errorMessage($message);
		}
		
		$update = $this->about_model->updateAboutUs($about_field, $vision_field, $mission_field);
		
		if($update == TRUE)
		{
			$message = 'Hakkımızda Metni Başarıyla Güncellendi. Yönlendiriliyorsunuz...';
			$this->successMessage($message);
		}
		else
		{
			$message = 'Güncelleme İşlemi Başarısız Oldu';
			$this->errorMessage($message);
		}
				
	}

	public function errorMessage($message)
	{
		$this->parser_data = array(
									'base' 				=> $this->base_data,
									'error_message'		=> $message
								  );

		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/error_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
		echo "<meta http-equiv=\"refresh\" content=\"3; url=../about/editAboutUs\">";	

	}

	public function successMessage($message)
	{
		$this->parser_data = array(
									'base' 				=> $this->base_data,
									'success_message'	=> $message
								  );

		// admin panelinin ilgili view lerini yükler
		$this->parser->parse('backend_views/admin_header_view',$this->parser_data);
		$this->parser->parse('backend_views/success_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_main_view',$this->parser_data);
		$this->parser->parse('backend_views/admin_footer_view',$this->parser_data);
		echo "<meta http-equiv=\"refresh\" content=\"3; url=../about/editAboutUs\">";	

	}
	
}