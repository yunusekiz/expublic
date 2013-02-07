<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kayit_gir extends CI_Model {
	public $last_category_id;
	public $last_reference_id;


	// reference_category tablosuna yeni kayıt ekler
	public function add_Ref_Category($cat_name)
	{
		$data = array(
					'ref_category_name'	=>	$cat_name
					);
		
		$query = $this->db->insert('reference_category',$data);
		$this->last_category_id = $this->db->insert_id();
		if($query)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	// reference_text_field tablosuna yeni kayıt ekler
	public function add_Ref_TextField($ref_name, $ref_date, $ref_title, $ref_detail, $isThereAnyCategoryLikeIt = FALSE, $ref_category_id = NULL)
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
						'ref_name'			=>	$ref_name,
						'ref_date'			=>	$ref_date,
						'ref_title'			=>	$ref_title,
						'ref_detail'		=>	$ref_detail
					 );
	
		$query = $this->db->insert('reference_text_field',$data);
		$this->last_reference_id = $this->db->insert_id();
		if($query)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}		 
	}
	
	
	// reference_image tablosuna yeni kayıt ekler
	public function add_Ref_Image($path_big_full, $path_thumb_full)
	{
		$ref_id = $this->last_reference_id;
				
		$data = array(
						'ref_id' 			=> $ref_id,
						'path_big_full'		=> $path_big_full,
						'path_thumb_full'	=> $path_thumb_full
					);
						
		$query = $this->db->insert('reference_image',$data);
		if($query)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}			
	}
	
		
	public function create_Ref_View()
	{
		$query = $this->db->query('	CREATE VIEW reference_view AS
									SELECT 
     									reference_category.ref_category_name,
 										reference_text_field.ref_name,reference_text_field.ref_date,reference_text_field.ref_title,reference_text_field.ref_detail,
  										reference_image.path_full,
     									reference_image.path_thumb
  									FROM
     									reference_category,reference_text_field,reference_image 
  									WHERE
     									reference_category.ref_category_id = reference_text_field.ref_category_id
  									AND
     									reference_text_field.ref_id = reference_image.ref_id');
		return $query;																	
	}
	
	
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
	
	
	// reference_category tablosunda, ref_category_name sütununda, $record değişkeninin değerinde bir kayıt olup olmadığını kontrol eder
	public function isThereAnyRefCategoryRowLikeIt($record)
	{
		$query = $this->db->select('ref_category_name')->from('reference_category')->where('ref_category_name',$record);
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
	
	
	public function getRefCategoryId($name)
	{
		$query = $this->db->select('ref_category_id')->from('reference_category')->where('ref_category_name',$name)->get();
		
		$ref_category_id = $query->row()->ref_category_id;
		return $ref_category_id;
	}
	
	
	public function getRefViewAlias()
	{
		$query = $this->db->select('*')->from('reference_view_alias')->get();
		
		$result = $query->result_array();
		return $result;
	}
	

}	