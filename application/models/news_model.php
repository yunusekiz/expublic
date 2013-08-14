<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_model extends CI_Model {

	public function getNewsRowById($id)
	{
		$query = $this->db->select('news_date AS haber_tarihi, news_detail AS haber_detayi, id')->from('news')->where('id',$id)->get();

		if ($query->num_rows()>0) 
		{
			$row_array = array(
									'haber_tarihi' 	=> $query->row()->haber_tarihi,
									'haber_detayi' 	=> $query->row()->haber_detayi,
									'id'			=> $query->row()->id
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
			return NULL;
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