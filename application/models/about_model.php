<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class about_model extends CI_Model {
	
	public function getAboutUsRowAsArray()
	{
		$query = $this->db->select('*')->from('about_us')->where('id',1)->get();
		if($query->num_rows()>0)
		{
			$row_array = array ('about'		=> $query->row()->about,
								'vision'	=> $query->row()->vision,
								'mission'	=> $query->row()->mission
							   );
			return $row_array;
		}
		else
		{
			return FALSE;
		}
 	}
	
	
	
	public function getAboutUsRowForView()
	{
		$query = $this->db->select('*')->from('about_us_view_alias')->where('id',1)->get();
		if($query->num_rows()>0)
		{
			$result = $query->result_array();
			return $result;				 						
		}
		else
		{
			return FALSE;
		}
	}
	
	
	
	public function updateAboutUs($about, $vision, $mission)
	{
		$data = array('about'	=> $about,
					  'vision'	=> $vision,
					  'mission'	=> $mission
					  );
					  
		$query = $this->db->where('id',1);
		$query = $this->db->update('about_us',$data);
		
		if($query)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}			  
	}

}