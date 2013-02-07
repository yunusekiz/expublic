<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pass_model extends CI_Model{

	public function getPassColumnFromAdmin()
	{
		$query = $this->db->select('pass')->from('admin')->where('id',1)->get();
		$result = $query->row()->pass;
		return $result;
	}

	public function updatePass($new_pas)
	{
		$update_data = array(
								'pass' => $new_pas
							);		
		$query = $this->db->where('id',1)->update('admin',$update_data);

		$affected_rows = $this->db->affected_rows();
		if ($affected_rows > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
