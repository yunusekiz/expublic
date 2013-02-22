<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reference_model extends CI_Model {
	
	public $last_category_id;
	public $last_reference_id;

	////////////////////////////////////////////
	// reference_category tablosuna yeni kayıt ekler
	public function add_Ref_Category($cat_name, $seo_friendly_cat_name)
	{
		$data = array(
					'ref_category_name'	=>	$cat_name,
					'ref_category_seofriendly_name' => $seo_friendly_cat_name
					);
		
		$query = $this->db->insert('reference_category',$data);

		$affected_rows = $this->db->affected_rows();

		if($affected_rows > 0)
		{
			$this->last_category_id = $this->db->insert_id();
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	////////////////////////////////////////////

	// reference_text_field tablosuna yeni kayıt ekler
	public function add_Ref_TextField($ref_date, $ref_title, $ref_detail, $isThereAnyCategoryLikeIt = FALSE, $ref_category_id = NULL)
	{
		if($isThereAnyCategoryLikeIt != FALSE) // eğer çok daha önceden referans kategorisi kayıt edilmiş ise, o kategorinin id sini alır
		{
			$this->last_category_id = $ref_category_id;			
		}
		else
		{
			$ref_category_id = $this->last_category_id;
		}	
		
		$data = array(
						'ref_category_id'	=>	$ref_category_id,
						'ref_date'			=>	$ref_date,
						'ref_title'			=>	$ref_title,
						'ref_detail'		=>	$ref_detail
					 );
	
		$query = $this->db->insert('reference_text_field',$data);

		$affected_rows = $this->db->affected_rows();

		if($affected_rows > 0)
		{
			$this->last_reference_id = $this->db->insert_id();
			return TRUE;
		}
		else
		{
			return FALSE;
		}		 
	}
	////////////////////////////////////////////	
	
	// reference_image tablosuna yeni kayıt ekler
	public function add_Ref_Image($path_big_image, $path_thumb_image)
	{
		$ref_id = $this->last_reference_id;
				
		$data = array(
						'ref_id' 			=> $ref_id,
						'path_big_image'	=> $path_big_image,
						'path_thumb_image'	=> $path_thumb_image
					);
						
		$query = $this->db->insert('reference_image',$data);

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
	////////////////////////////////////////////		
	public function create_Ref_View()
	{
		$query = $this->db->query('	CREATE VIEW reference_view AS
									SELECT 
     									reference_category.ref_category_name as kategori,
     									reference_category.ref_category_seofriendly_name as trim_kategori,
 										reference_text_field.ref_date as tarih,
 										reference_text_field.ref_title as baslik,
 										reference_text_field.ref_detail as aciklama,
  										reference_image.path_big_image as buyuk_resim,
     									reference_image.path_thumb_image as kucuk_resim
  									FROM
     									reference_category,reference_text_field,reference_image 
  									WHERE
     									reference_category.ref_category_id = reference_text_field.ref_category_id
  									AND
     									reference_text_field.ref_id = reference_image.ref_id');
		return $query;																	
	}
	////////////////////////////////////////////	
	
	// reference_text_field tablosunda, ref_name sütununda, $record değişkeninin değerinde bir kayıt olup olmadığını kontrol eder
	public function isThereAnyRefTextFieldRowLikeIt($record)
	{
		$query = $this->db->select('ref_title')->from('reference_text_field')->where('ref_title',$record);
		$query = $this->db->get();
		if($query->num_rows()>0) // eğer bu koşulları sağlayan bir kayıt var ise TRUE döndürür
		{
			return TRUE;
		}
		else // eğer bu koşulları sağlayan bi kayıt yok ise FALSE döndürür
		{
			return FALSE;
		}
	}
	////////////////////////////////////////////	
	
	// reference_category tablosunda, ref_category_name sütununda, $record değişkeninin değerinde bir kayıt olup olmadığını kontrol eder
	public function isThereAnyRefCategoryRowLikeIt($record)
	{
		$query = $this->db->select('ref_category_name')->from('reference_category')->where('ref_category_name',$record)->get();
		if($query->num_rows()>0) // eğer bu koşulları sağlayan bir kayıt var ise TRUE döndürür
		{
			return TRUE;
		}
		else // eğer bu koşulları sağlayan bi kayıt yok ise FALSE döndürür
		{
			return FALSE;
		}
	}
	////////////////////////////////////////////
	public function getRefCategoryId($name)
	{
		$query = $this->db->select('ref_category_id')->from('reference_category')->where('ref_category_name',$name)->get();

		if ($query->num_rows()>0) 
		{
			$ref_category_id = $query->row()->ref_category_id;

			return $ref_category_id;
		}
		else
		{
			return NULL;
		}
	}
	////////////////////////////////////////////	
	public function getRefRowsForViewLayer($id= NULL)
	{
		if ($id == NULL) 
		{
			$query = $this->db->select('*')->from('reference_view')->get();

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
		else
		{
			$query = $this->db->select('*')->from('reference_view')->where('ref_id',$id)->get();

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

		
	}
	////////////////////////////////////////////	
	public function getRefCategoryRows()
	{
		$query = $this->db->select('ref_category_name AS kategori, ref_category_seofriendly_name AS trim_kategori ')->from('reference_category')->get();

		if ($query->num_rows()>0)
		{
			$result_array = $query->result_array();
			return $result_array;
		}
		else
		{
			return NULL;
		}

	}



	public function getRefImageRowById($id)
	{
		$query = $this->db->select('path_big_image AS buyuk_resim, path_thumb_image AS kucuk_resim')->from('reference_image')->where('ref_id',$id)->get();

		if ($query->num_rows()>0) 
		{
			$row_array = array(
									'buyuk_resim' 	=> $query->row()->buyuk_resim,
									'kucuk_resim' 	=> $query->row()->kucuk_resim
							  );
			return $row_array;
		}
		else
		{
			var_dump($id);
			die('gelen id');
		}
	}


	public function deleteRefTextFieldFromDB($id)
	{
		$query = $this->db->where('ref_id',$id)->delete('reference_text_field');

		if ($this->db->affected_rows()>0) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function updateRefTextFieldOnDB($ref_id, $ref_date, $ref_title, $ref_detail, $ref_category_id = NULL)
	{
		if ($ref_category_id == NULL) 
		{
			
			$update_data = array(
									'ref_date'		=> $ref_date,
									'ref_title'		=> $ref_title,
									'ref_detail'	=> $ref_detail
								);

			$query = $this->db->where('ref_id',$ref_id)->update('reference_text_field',$update_data);

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
		elseif ($ref_category_id != NULL) 
		{
			$update_data = array(
									'ref_date'			=> $ref_date,
									'ref_title'			=> $ref_title,
									'ref_detail'		=> $ref_detail,
									'ref_category_id' 	=> $ref_category_id
								);

			$query = $this->db->where('ref_id',$ref_id)->update('reference_text_field',$update_data);

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
		else
		{
			return FALSE;
		}


	}


	public function updateRefImgFieldOnDB($ref_id, $path_big_image, $path_thumb_image)
	{
		$update_data = array(
								'path_big_image'		=> $path_big_image,
								'path_thumb_image'		=> $path_thumb_image
							);
		
		$query = $this->db->where('ref_id',$ref_id)->update('reference_image',$update_data);

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

}/* end of reference_model  */