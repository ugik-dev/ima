<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( !function_exists('fetch_single_qty_item'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN STOCK
	function fetch_single_qty_item($item_id)
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_sales');
		$CI->db->where(['mp_sales.product_id'=> $item_id]);

		$query = $CI->db->get();
		$result = NULL;
		if($query->num_rows()>0)
		{
			$obj_res =  $query->result();
			if($obj_res != NULL)
			{
				foreach ($obj_res as $single_qty) 
				{
					$result = $result + $single_qty->qty;
				}
			} 
		}
		
		return $result;

	}
}

if ( !function_exists('fetch_single_pending_item'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN PENDING STOCK
	function fetch_single_pending_item($item_id)
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_stock');
		$CI->db->where(['mp_stock.mid'=> $item_id]);

		$query = $CI->db->get();
		$result = 0;
		if($query->num_rows()>0)
		{
			$obj_res =  $query->result();
			if($obj_res != NULL)
			{
				foreach ($obj_res as $single_qty) 
				{
					$result = $result + $single_qty->qty;
				}
			} 
		}
		
		return $result;

	}
}

if ( !function_exists('fetch_single_return_item'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function fetch_single_return_item($item_id)
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_return_list');
		$CI->db->where(['mp_return_list.product_id'=> $item_id]);
		$query = $CI->db->get();
		$result = 0;
		if($query->num_rows()>0)
		{
			$obj_res =  $query->result();
			if($obj_res != NULL)
			{
				foreach ($obj_res as $single_qty) 
				{
					$result = $result + $single_qty->qty;
				}
			} 
		}
		
		return $result;

	}
}

if (!function_exists('color_options'))
{
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function color_options()
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$color_arr = $CI->db->get_where('mp_langingpage', array('id' =>1))->result_array()[0];
		return  array('primary' =>$color_arr['primarycolor'],'hover' =>$color_arr['theme_pri_hover']);
	}
}


// ------------------------------------------------------------------------
/* End of file helper.php */
/* Location: ./system/helpers/Side_Menu_helper.php */