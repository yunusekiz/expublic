<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slider_model extends CI_Model {

	public function insertImageToBigSlider($image_title, $big_image_path, $thumb_image_path)
	{
		$insert_data = array(
								'image_title'		=>  $image_title,
								'big_image_path'	=>	$big_image_path,
								'thumb_image_path'	=>	$thumb_image_path
							);
		$query = $this->db->insert('big_slider',$insert_data);

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

	public function getBigSliderRowForAdminPanel()
	{
		$query = $this->db->select('*')->from('big_slider')->get();

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

	public function deleteBigSlider($id)
	{

		$test_delete_before = $this->db->select('id')->from('big_slider')->where('id',$id)->get();

		if($test_delete_before->num_rows() > 0)
		{
			$query = $this->db->where('id',$id)->delete('big_slider');

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

	public function getBigImagePathFromDB($id)
	{
		$query = $this->db->select('big_image_path')->from('big_slider')->where('id',$id)->get();
		if($query->num_rows()>0)
		{
			$row =  $query->row()->big_image_path;
			return $row;		  
		}
		else
		{
			return FALSE;
		}
	}

	public function getThumbImagePathFromDB($id)
	{
		$query = $this->db->select('thumb_image_path')->from('big_slider')->where('id',$id)->get();
		if($query->num_rows()>0)
		{
			$row =  $query->row()->thumb_image_path;
			return $row;		  
		}
		else
		{
			return FALSE;
		}		
	}

	public function isThereAnyRowInDB()
	{
		$query = $this->db->select('*')->from('big_slider')->get();
		
		if ($query->num_rows()>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}

}