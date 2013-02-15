<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reference_model extends CI_Model {
	
	public $last_category_id;
	public $last_reference_id;

	////////////////////////////////////////////
	// reference_category tablosuna yeni kayıt ekler
	public function add_Ref_Category($cat_name)
	{
		$data = array(
					'ref_category_name'	=>	$cat_name
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
		
		$ref_category_id = $query->row()->ref_category_id;
		return $ref_category_id;
	}
	////////////////////////////////////////////	
	public function getRefViewAlias()
	{
		$query = $this->db->select('*');
		$query = $this->db->from('reference_view_alias');
		$query = $this->db->get();
		
		$result = $query->result_array();
		return $result;
	}
	////////////////////////////////////////////	
	public function getRefCategoryRows()
	{
		$query = $this->db->select('ref_category_name')->from('reference_category')->get();

		if ($query->num_rows>0)
		{
			$result_array = $query->result_array();
			return $result_array;
		}
		else
		{
			return NULL;
		}

	}
	////////////////////////////////////////////	
}	