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
}