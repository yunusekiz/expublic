<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact_model extends CI_Model {
	
	public function getContactRowAsArray()
	{
		$query = $this->db->select('*')->from('contact')->where('id',1)->get();
		
		if($query->num_rows()>0)
		{
			$row_array = array(
								'address'	=> $query->row()->address,
								'phone'		=> $query->row()->phone,
								'fax'		=> $query->row()->fax,
								'email'		=> $query->row()->email,
								'facebook'	=> $query->row()->facebook,
								'twitter'	=> $query->row()->twitter,
								'gplus'		=> $query->row()->gplus
							  );
			return $row_array;				  
		}
		else
		{
			return FALSE;
		}
		
	}

	public function getContactRowForView()
	{
		$query = $this->db->select('*')->from('contact_view_alias')->where('id',1)->get();
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
	
	
	public function updateContact($address, $phone, $fax, $email, $facebook, $twitter, $gplus)
	{
		$data = array(
						'address' 	=> $address,
						'phone'		=> $phone,
						'fax'		=> $fax,
						'email'		=> $email,
						'facebook'	=> $facebook,
						'twitter'	=> $twitter,
						'gplus'		=> $gplus
					 );
		
		$query = $this->db->where('id',1);
		$query = $this->db->update('contact',$data);
		
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