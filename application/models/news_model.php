<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_model extends CI_Model {

	public function getNewsRowAsArray()
	{
		$query = $this->db->select('*')->from('news')->get();

		if ($query->num_rows()>0) 
		{
			$row_array = array(
									'news_date' 	=> $query->row()->news_date,
									'news_detail' 	=> $query->row()->news_detail
							  );
			return $row_array;
		}
		else
		{
			return FALSE;
		}
	}


	public function getNewsRowForView()
	{
		$query = $this->db->select('*')->from('news_view_alias')->get();

		if ($query->num_rows()>0) 
		{
			$result = $query->result_array();
			return $result;
		}
		else
		{
			return FALSE;
		}
	}


	public function insertNewNews($news_date, $news_detail)
	{
		$insert_data = array(
								'news_date' 	=> $news_date,
								'news_detail'	=> $news_detail
						   );
		$query = $this->db->insert('news',$insert_data);

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


	public function updateNews($id, $news_date, $news_detail)
	{
		$update_data = array(
								'news_date'		=> $news_date,
								'news_detail'	=> $news_detail
							);

		$query = $this->db->where('id',$id)->update('news',$update_data);

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

	public function deleteNews($id)
	{
		$test_delete_before = $this->db->select('id')->from('news')->where('id',$id)->get();

		if($test_delete_before->num_rows() > 0)
		{
			$query = $this->db->where('id',$id)->delete('news');

			$affected_rows = $this->db->affected_rows();

			if($affected_rows > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}

		}
		else
		{
			return FALSE;
		}


	}

}