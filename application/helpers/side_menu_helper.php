<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('Fetch_Users_Access_Control_Menu')) {
	function Fetch_Users_Access_Control_Menu($para_user_id = '')
	{
		$CI	= &get_instance();
		$CI->load->database();
		$CI->db->select("mp_menu.id as id,mp_menu.name,mp_menu.icon,mp_menu.order_number");
		$CI->db->from('mp_menu');
		$CI->db->join('mp_multipleroles', "mp_menu.id = mp_multipleroles.menu_Id and mp_multipleroles.user_id = '$para_user_id'");
		$CI->db->order_by('mp_menu.order_number');
		$query = $CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return NULL;
		}
	}
}

if (!function_exists('Fetch_Users_Access_Control_Sub_Menu')) {

	function Fetch_Users_Access_Control_Sub_Menu($para_menu_id = '')
	{
		$CI	= &get_instance();
		$CI->load->database();
		$CI->db->select("*");
		$CI->db->from('mp_menulist');
		$CI->db->where(['menu_id' => $para_menu_id]);
		$query = $CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return NULL;
		}
	}
}


if (!function_exists('Company_Profile')) {

	function Company_Profile()
	{
		$CI	= &get_instance();
		$CI->load->database();
		$CI->db->select("*");
		$CI->db->from('mp_langingpage');
		$query = $CI->db->get();
		return $query->result_array()[0];
	}
}


if (!function_exists('notif_data')) {

	function notif_data($id)
	{


		$CI	= &get_instance();
		$CI->load->database();
		$CI->db->select("*");
		$CI->db->from('notification');
		$CI->db->join('mp_multipleroles', 'notification.to_role = mp_multipleroles.menu_Id', 'LEFT');
		$CI->db->where('mp_multipleroles.user_id = "' . $id . '" OR notification.to_user = "' . $id . '"');
		$CI->db->order_by("date_notification", 'DESC');
		$query = $CI->db->get();
		$data['notif_data'] = $query->result_array();

		$CI	= &get_instance();
		$CI->load->database();
		$CI->db->select("count(*) as not_complete");
		$CI->db->from('notification');
		$CI->db->join('mp_multipleroles', 'notification.to_role = mp_multipleroles.menu_Id', 'LEFT');
		$CI->db->where('(mp_multipleroles.user_id = "' . $id . '" OR notification.to_user = "' . $id . '") AND notification.status = "0"');
		// $CI->db->where('notification.status = "0"');
		$CI->db->order_by("date_notification", 'DESC');
		$query = $CI->db->get();
		$data['not_complete'] = $query->result_array()[0]['not_complete'];

		return $data;
	}
}
// ------------------------------------------------------------------------
/* End of file helper.php */
/* Location: ./system/helpers/Side_Menu_helper.php */