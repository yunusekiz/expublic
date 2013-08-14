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
////////////////////////////////////////////////////////////////////////////////
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
////////////////////////////////////////////////////////////////////////////////
	public function isThereAnyRowInDB()
	{
		$query = $this->db->select('*')->from('big_slider')->get();
		
		if ($query->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}

////////////////////////////////////////////////////////////////////////////////
	public function insertImageToStaticImages($image_title, $image_detail, $big_image_path, $thumb_image_path)
	{
		$insert_data = array(
								'image_title' 		=> $image_title,
								'image_detail'		=> $image_detail,
								'big_image_path'	=> $big_image_path,
								'thumb_image_path'	=> $thumb_image_path
							);

		$query = $this->db->insert('home_static_images',$insert_data);

		if($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
////////////////////////////////////////////////////////////////////////////////

	public function getStaticBigImagePathFromDB($id)
	{
		$query = $this->db->select('big_image_path')->from('home_static_images')->where('id',$id)->get();
		if($query->num_rows()>0)
			return  $query->row()->big_image_path;
		else
			return FALSE;			
	}

////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////

	public function getStaticThumbImagePathFromDB($id)
	{
		$query = $this->db->select('thumb_image_path')->from('home_static_images')->where('id',$id)->get();
		if($query->num_rows()>0)
			return  $query->row()->thumb_image_path;
		else
			return FALSE;			
	}

////////////////////////////////////////////////////////////////////////////////

	public function deleteStaticImages($id)
	{
		$test_delete_before = $this->db->select('id')->from('home_static_images')->where('id',$id)->get();

		if($test_delete_before->num_rows() > 0)
		{
			$query = $this->db->where('id',$id)->delete('home_static_images');

			if($this->db->affected_rows() > 0)
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}
////////////////////////////////////////////////////////////////////////////////

	public function isThereAnyStaticImages()
	{
		$query = $this->db->select('*')->from('home_static_images')->get();

		if ($query->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
////////////////////////////////////////////////////////////////////////////////

	public function countOfStaticImages()
	{
		$query = $this->db->select('*')->from('home_static_images')->get();
		if ($query->num_rows()>0)
		{
			return $this->db->count_all('home_static_images');
		}
			
		else
			return 0;
	}
////////////////////////////////////////////////////////////////////////////////

	public function getStaticImagesRow()
	{
		$query = $this->db->select('id AS id, image_title AS resim_baslik, image_detail AS resim_detay, big_image_path AS buyuk_resim, thumb_image_path AS kucuk_resim ')->from('home_static_images')->get();

		if ($query->num_rows()>0) 
		{
			$result = $query->result_array();
			return $result;
		}
		else
			return NULL;
	}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

	public function insertImageToLittleSlider($image_title, $image_date, $image_detail, $big_image_path, $thumb_image_path)
	{
		$insert_data = array(
								'image_title'		=> $image_title,
								'image_date'		=> $image_date,
								'image_detail'		=> $image_detail,
								'big_image_path'	=> $big_image_path,
								'thumb_image_path'	=> $thumb_image_path
							);

		$query = $this->db->insert('little_slider', $insert_data);
		if ($this->db->affected_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
////////////////////////////////////////////////////////////////////////////////
	public function getLittleSliderRow($id = NULL)
	{
		if ($id == NULL) 
		{
			$query = $this->db->select('id AS id, image_title AS resim_baslik, image_date AS resim_tarih, image_detail AS resim_detay, big_image_path AS buyuk_resim, thumb_image_path AS kucuk_resim')->from('little_slider')->get();

		 	if ($query->num_rows()>0)
		 		return $query->result_array();
		 	else
		 		return NULL;
		}
		elseif ($id != NULL)
		{
			$query = $this->db->select('id AS id, image_title AS resim_baslik, image_date AS resim_tarih, image_detail AS resim_detay, big_image_path AS buyuk_resim, thumb_image_path AS kucuk_resim')->from('little_slider')->where('id',$id)->get();

		 	if ($query->num_rows()>0)
		 		return $query->result_array();
		 	else
		 		return NULL;
		}

	}
////////////////////////////////////////////////////////////////////////////////
	public function getLittleSliderBigImageFromDB($id)
	{
		$query = $this->db->select('big_image_path')->from('little_slider')->where('id', $id)->get();
		if ($query->num_rows()>0)
			return $query->row()->big_image_path;
		else
			return NULL;
	}
////////////////////////////////////////////////////////////////////////////////
	public function getLittleSliderThumbImageFromDB($id)
	{
		$query = $this->db->select('thumb_image_path')->from('little_slider')->where('id', $id)->get();
		if ($query->num_rows()>0)
			return $query->row()->thumb_image_path;
		else
			return NULL;
	}
////////////////////////////////////////////////////////////////////////////////
	public function isThereAnyLittleSliderRow()
	{
		$query = $this->db->select('id')->from('little_slider')->get();
		if ($query->num_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
////////////////////////////////////////////////////////////////////////////////
	public function deleteLittleSlider($id)
	{
		$test_delete_before = $this->db->select('id')->from('little_slider')->where('id', $id)->get();
		if ($test_delete_before->num_rows()>0) 
		{
			$query = $this->db->where('id', $id)->delete('little_slider');

			if ($this->db->affected_rows()>0)
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}
////////////////////////////////////////////////////////////////////////////////

	public function update_little_slider_detail($id,$image_title,$image_date,$image_detail, $image_paths = NULL)
	{
		if ($image_paths == NULL) 
		{
			$update_data = array('image_title'=>$image_title, 'image_date'=>$image_date, 'image_detail'=>$image_detail);
			$query = $this->db->where('id',$id)->update('little_slider',$update_data);
			if ($this->db->affected_rows()>0)
				return TRUE;
			else
				return FALSE;
		}
		else
		{
			$update_data = array('image_title'=>$image_title, 'image_date'=>$image_date, 'image_detail'=>$image_detail,
								 'big_image_path'=>$image_paths[0], 'thumb_image_path'=>$image_paths[1]);
			$query = $this->db->where('id',$id)->update('little_slider',$update_data);
			if ($this->db->affected_rows()>0)
				return TRUE;
			else
				return FALSE;				 			
		}
	}
}