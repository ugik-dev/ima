<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



if (!function_exists('fetch_single_qty_item')) {
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN STOCK
	function fetch_single_qty_item($item_id)
	{
		$CI	= &get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_sales');
		$CI->db->where(['mp_sales.product_id' => $item_id]);

		$query = $CI->db->get();
		$result = NULL;
		if ($query->num_rows() > 0) {
			$obj_res =  $query->result();
			if ($obj_res != NULL) {
				foreach ($obj_res as $single_qty) {
					$result = $result + $single_qty->qty;
				}
			}
		}

		return $result;
	}
}

if (!function_exists('fetch_single_pending_item')) {
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN PENDING STOCK
	function fetch_single_pending_item($item_id)
	{
		$CI	= &get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_stock');
		$CI->db->where(['mp_stock.mid' => $item_id]);

		$query = $CI->db->get();
		$result = 0;
		if ($query->num_rows() > 0) {
			$obj_res =  $query->result();
			if ($obj_res != NULL) {
				foreach ($obj_res as $single_qty) {
					$result = $result + $single_qty->qty;
				}
			}
		}

		return $result;
	}
}

if (!function_exists('fetch_single_return_item')) {
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function fetch_single_return_item($item_id)
	{
		$CI	= &get_instance();
		$CI->load->database();
		$CI->db->select("qty");
		$CI->db->from('mp_return_list');
		$CI->db->where(['mp_return_list.product_id' => $item_id]);
		$query = $CI->db->get();
		$result = 0;
		if ($query->num_rows() > 0) {
			$obj_res =  $query->result();
			if ($obj_res != NULL) {
				foreach ($obj_res as $single_qty) {
					$result = $result + $single_qty->qty;
				}
			}
		}

		return $result;
	}
}

if (!function_exists('color_options')) {
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function color_options()
	{
		$CI	= &get_instance();
		$CI->load->database();
		$color_arr = $CI->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0];
		return  array('primary' => $color_arr['primarycolor'], 'hover' => $color_arr['theme_pri_hover']);
	}
}

if (!function_exists('singkatan_bulan')) {
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function singkatan_bulan($i)
	{
		if (empty($i)) return '';
		$BULAN = [0, 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
		return $BULAN[intval($i)];
	}
}
if (!function_exists('tanggal_indonesia')) {
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function tanggal_indonesia($tanggal)
	{
		if (empty($tanggal)) return '';
		$BULAN = [0, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		$t = explode('-', $tanggal);
		return "{$t[2]} {$BULAN[intval($t[1])]} {$t[0]}";
	}
}
if (!function_exists('terbilang')) {
	//USED TO FETCH AND COUNT THE NUMBER OF OCCURANCE IN RETURN STOCK
	function terbilang($nilai)
	{
		if ($nilai < 0) {
			$hasil = "minus " . trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}
		return $hasil;
	}
}
if (!function_exists('bln_romawi')) {
	function bln_romawi($bln)
	{
		$bln = (int) $bln;
		$array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
		return $array_bln[$bln];
		// echo $bln;
	}
}

function penyebut($nilai)
{
	$nilai = abs($nilai);
	$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if (
		$nilai < 20
	) {
		$temp = penyebut($nilai - 10) . " Belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " Seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " Seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}
// ------------------------------------------------------------------------
/* End of file helper.php */
/* Location: ./system/helpers/Side_Menu_helper.php */