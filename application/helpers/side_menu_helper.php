<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('Fetch_Users_Access_Control_Menu'))
{
	function Fetch_Users_Access_Control_Menu($para_user_id = '') 
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$CI->db->select("mp_menu.id as id,mp_menu.name,mp_menu.icon");
		$CI->db->from('mp_menu');
		$CI->db->join('mp_multipleroles', "mp_menu.id = mp_multipleroles.menu_Id and mp_multipleroles.user_id = '$para_user_id'");
		$CI->db->order_by('mp_menu.name');
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
			return $query->result(); 
		}
		else
		{
			return NULL;
		}	
	}
}

if ( !function_exists('Fetch_Users_Access_Control_Sub_Menu'))
{

	function Fetch_Users_Access_Control_Sub_Menu($para_menu_id = '') 
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$CI->db->select("*");
		$CI->db->from('mp_menulist');
		$CI->db->where(['menu_id'=>$para_menu_id]);
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
			return $query->result(); 
		}
		else
		{
			return NULL;
		}
	}
}
// ------------------------------------------------------------------------
/* End of file helper.php */
/* Location: ./system/helpers/Side_Menu_helper.php */