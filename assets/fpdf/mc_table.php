<?php
require('fpdf.php');

class PDF_MC_Table extends FPDF
{
	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function row_absensi($no, $ttl, $jl, $data)
	{
		// $this->cell(30, 4, '23', 1, 1);

		$x_origin = $this->GetX();
		$y_origin = $this->GetY();
		$i = 0;
		$total_hight = 0;
		// foreach ($data['child'] as $child) {
		$nb = 0;
		$nb = max($nb, $this->NbLines(56, $data['nama']));
		$nb = max($nb, $this->NbLines(26, $data['nama_ptk']));
		// $nb = max($nb, $this->NbLines(40, $data['satuan']));
		// $nb = max($nb, $this->NbLines(40, $data['vol']));
		$h = 5 * $nb;
		$total_hight = $total_hight + $nb;
		// $i++;
		// $nb_iki = $this->NbLines(35, $data['iki_kuantitas']);
		// echo json_encode($child);
		// die();
		// }
		$this->CheckPageBreak($total_hight * 5);
		// $this->Cell(7, $total_hight * 5, $no, 1, 'C');
		$this->Rect($x_origin, $y_origin, 7, $total_hight * 5);
		$this->Rect($x_origin + 7, $y_origin, 56, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56, $y_origin, 26, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56 + 26, $y_origin, 14, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56 + 26 + 14, $y_origin, 11, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56 + 26 + 14 + 11, $y_origin, 21, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56 + 26 + 14 + 11 + 21, $y_origin, 11, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56 + 26 + 14 + 11 + 21 + 11, $y_origin, 11, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56 + 26 + 14 + 11 + 21 + 11 + 11, $y_origin, 11, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56 + 26 + 14 + 11 + 21 + 11 + 11 + 11, $y_origin, 13, $total_hight * 5);
		$this->Rect($x_origin + 7 + 56 + 26 + 14 + 11 + 21 + 11 + 11 + +11 + 13, $y_origin, 26, $total_hight * 5);
		// $this->Rect($x_origin + 7 + 56 + 14 + 11, $y_origin, 11, $total_hight * 5);
		$this->MultiCell(7, 5, $no, 0, 'C');
		$this->SetXY($x_origin + 7, $y_origin);
		$this->MultiCell(56, 5, $data['nama'], 0, 'L');
		$this->SetXY($x_origin + 7 + 56, $y_origin);
		$this->MultiCell(26, 5, $data['nama_ptk'], 0, 'L');
		$this->SetXY($x_origin + 7 + 56 + 26, $y_origin);
		$this->MultiCell(14, 5, $jl, 0, 'C');
		$this->SetXY($x_origin + 7 + 56 + 26 + 14, $y_origin);
		$this->MultiCell(11, 5, $data['h'], 0, 'C');
		$this->SetXY($x_origin + 7 + 56 + 26 + 14 + 11, $y_origin);
		$this->MultiCell(21, 5, $data['htf'], 0, 'C');
		$this->SetXY($x_origin + 7 + 56 + 26 + 14 + 11 + 21, $y_origin);
		$this->MultiCell(11, 5, $data['i'], 0, 'C');
		$this->SetXY($x_origin + 7 + 56 + 26 + 14 + 11 + 21 + 11, $y_origin);
		$this->MultiCell(11, 5, $data['s'], 0, 'C');
		$this->SetXY($x_origin + 7 + 56 + 26 + 14 + 11 + 21 + 11 + 11, $y_origin);
		$this->MultiCell(11, 5, $data['c'], 0, 'C');
		$this->SetXY($x_origin + 7 + 56 + 26 + 14 + 11 + 21 + 11 + 11 + 11, $y_origin);
		$this->MultiCell(13, 5, $data['dl'], 0, 'C');
		$this->SetXY($x_origin + 7 + 56 + 26 + 14 + 11 + 21 + 11 + 11 + 11 + 13, $y_origin);
		$this->MultiCell(26, 5, $ttl, 0, 'C');
		// $this->Cell(56, $total_hight * 4, $data['nama'], 1, 'C');
		// $this->Cell(26, $total_hight * 4, $data['nama_ptk'], 1, 'C');
		// $this->Cell(14, $total_hight * 4, $jl, 1, 0, 'C');
		// $this->Cell(11, $total_hight * 4, $data['h'], 1, 1, 'C');
		// $this->SetX($this->getX() - 37);
		// $x_origin = $this->GetX();
		// $y_origin = $this->GetY();
		// }
		// $this->cell(30, 4, '23', 1, 1);
		// 
		$this->SetXY($x_origin, $y_origin + $h);
		// foreach ($data['child'] as $child) {
		// 	$cur_x = $this->GetX() + 37;
		// 	$this->SetX($cur_x);
		// 	$cur_y = $this->GetY();
		// 	// $this->SetX($cur_x + 38);
		// 	// $this->cell(30, 4, '23', 1, 1);
		// 	$this->Rect($cur_x, $cur_y, $row_2, $h[$j]);
		// 	$this->Rect($cur_x + $row_2, $cur_y, $row_3, $h[$j]);
		// 	$this->Rect($cur_x + $row_2 + $row_3, $cur_y, $row_4, $h[$j]);
		// 	$this->Rect($cur_x + $row_2 + $row_3 + $row_4, $cur_y, $row_5, $h[$j]);
		// 	$this->Rect($cur_x + $row_2 + $row_3 + $row_4 + $row_5, $cur_y, $row_6, $h[$j]);
		// 	$this->Rect($cur_x + $row_2 + $row_3 + $row_4 + $row_5 + $row_6, $cur_y, $row_7, $h[$j]);
		// 	$this->Rect($cur_x + $row_2 + $row_3 + $row_4 + $row_5 + $row_6 + $row_7, $cur_y, $row_8, $h[$j]);
		// 	$this->MultiCell($row_2, 4, $child['kegiatan_skp'], 0, 'L');
		// 	$this->SetXY($cur_x + $row_2, $cur_y);
		// 	$this->MultiCell($row_3, 4, $child['kegiatan_aktifitas'], 0, 'L');
		// 	if ($child['jenis_keg'] == 'KU') {
		// 		$this->SetXY($cur_x + $row_2 + $row_3, $cur_y);
		// 		$this->MultiCell($row_4, 4, 'v', 0, 'C');
		// 	} else if ($child['jenis_keg'] == 'KT') {
		// 		$this->SetXY($cur_x + $row_2 + $row_3 + $row_4, $cur_y);
		// 		$this->MultiCell($row_5, 4, 'v', 0, 'C');
		// 	} else {
		// 		$this->SetXY($cur_x + $row_2 + $row_3 + $row_4 + $row_5, $cur_y);
		// 		$this->MultiCell($row_6, 4, 'v', 0, 'C');
		// 	}

		// 	$this->SetXY($cur_x + $row_2 + $row_3 + $row_4 + $row_5 + $row_6, $cur_y);
		// 	$this->MultiCell($row_7, 4, $child['vol'], 0, 'C');
		// 	$this->SetXY($cur_x + $row_2 + $row_3 + $row_4 + $row_5 + $row_6 + $row_7, $cur_y);
		// 	$this->MultiCell($row_8, 4, $child['satuan'], 0, 'C');
		// 	// $this->SetXY($cur_x + $h[$j], $cur_y);
		// 	$this->SetX($cur_x - 37);
		// 	$this->SetY($cur_y + $h[$j]);

		// 	// if ($j == 3)
		// 	// 	return;
		// 	$j++;
		// return;
		// }
		// 

		// $this->Ln($h);

		// print_r($h);
		// $this->Cell($w, 4, 'xxxxxxxx', 0, 'C');
	}
	function row_shp($data)
	{
		// $this->cell(30, 4, '23', 1, 1);

		$x_origin = $this->GetX() + 30;
		$y_origin = $this->GetY();
		$i = 0;
		$total_hight = 0;
		// foreach ($data['child'] as $child) {
		$nb = 0;
		$nb = max($nb, $this->NbLines(40, $data['kode_timah']));
		$nb = max($nb, $this->NbLines(20, floatval($data['kadar'])));
		$nb = max($nb, $this->NbLines(45, $data['harga']));
		// $nb = max($nb, $this->NbLines(40, $data['satuan']));
		// $nb = max($nb, $this->NbLines(40, $data['vol']));
		$h = 7 * $nb;
		$total_hight = $total_hight + $nb;
		// $i++;
		// $nb_iki = $this->NbLines(35, $data['iki_kuantitas']);
		// echo json_encode($child);
		// die();
		// }
		$this->CheckPageBreak($total_hight * 7);
		// $this->Cell(7, $total_hight * 5, $no, 1, 'C');
		$this->Rect($x_origin, $y_origin, 40, $total_hight * 7);
		$this->Rect($x_origin + 40, $y_origin, 20, $total_hight * 7);
		$this->Rect($x_origin + 40 + 20, $y_origin, 45, $total_hight * 7);
		$this->Rect($x_origin + 40 + 20 + 45, $y_origin, 50, $total_hight * 7);
		// $this->Rect($x_origin + 40 + 20, $y_origin, 26, $total_hight * 5);
		// $this->Rect($x_origin + 40 + 20 + 45, $y_origin, 26, $total_hight * 5);
		// $this->Rect($x_origin + 7 + 56 + 14 + 11, $y_origin, 11, $total_hight * 5);
		$this->SetXY($x_origin, $y_origin);
		$this->MultiCell(40, 7, floatval($data['berat']), 0, 'C');
		$this->SetXY($x_origin + 40, $y_origin);
		$this->MultiCell(20, 7, floatval($data['kadar']), 0, 'C');
		$this->SetXY($x_origin + 40 + 20, $y_origin);
		$this->MultiCell(43, 7, number_format($data['harga'], 0, ',', '.'), 0, 'R');
		$this->SetXY($x_origin + 40 + 20 + 45, $y_origin);
		$this->MultiCell(48, 7, number_format($data['amount'], 0, ',', '.'), 0, 'R');

		$this->SetXY($x_origin - 30, $y_origin + $h);
	}
	function row_shp2($data)
	{
		// $this->cell(30, 4, '23', 1, 1);

		$x_origin = $this->GetX() + 30;
		$y_origin = $this->GetY();
		$i = 0;
		$total_hight = 0;
		// foreach ($data['child'] as $child) {
		$nb = 0;
		$nb = max($nb, $this->NbLines(30, $data['kode_timah']));
		$nb = max($nb, $this->NbLines(20, floatval($data['berat'])));
		$nb = max($nb, $this->NbLines(20, floatval($data['kadar'])));
		$nb = max($nb, $this->NbLines(20, ($data['terak'] == 'Y' ? 'Ada' : 'Tidak')));
		$nb = max($nb, $this->NbLines(32, number_format($data['harga'], 0, ',', '.')));
		$nb = max($nb, $this->NbLines(33, number_format($data['amount'], 0, ',', '.')));
		// $nb = max($nb, $this->NbLines(40, $data['satuan']));
		// $nb = max($nb, $this->NbLines(40, $data['vol']));
		$h = 7 * $nb;
		$total_hight = $total_hight + $nb;

		$this->CheckPageBreak($total_hight * 7);
		$this->Rect($x_origin, $y_origin, 30, $total_hight * 7);
		$this->Rect($x_origin + 30, $y_origin, 20, $total_hight * 7);
		$this->Rect($x_origin + 50, $y_origin, 20, $total_hight * 7);
		$this->Rect($x_origin + 70, $y_origin, 20, $total_hight * 7);
		$this->Rect($x_origin + 90, $y_origin, 32, $total_hight * 7);
		$this->Rect($x_origin + 122, $y_origin, 33, $total_hight * 7);
		// $this->Rect($x_origin + 40 + 20 + 45, $y_origin, 50, $total_hight * 7);

		$this->SetXY($x_origin + 1, $y_origin);
		$this->MultiCell(30, 7, $data['kode_timah'], 0, 'L');
		$this->SetXY($x_origin + 30, $y_origin);
		$this->MultiCell(20, 7, floatval($data['berat']), 0, 'C');
		$this->SetXY($x_origin + 50, $y_origin);
		$this->MultiCell(20, 7, floatval($data['kadar']), 0, 'C');
		$this->SetXY($x_origin + 70, $y_origin);
		$this->MultiCell(20, 7, ($data['terak'] == 'Y' ? 'Ada' : 'Tidak'), 0, 'C');
		$this->SetXY($x_origin + 90, $y_origin);
		$this->MultiCell(31, 7, number_format($data['harga'], 0, ',', '.'), 0, 'R');
		$this->SetXY($x_origin + 122, $y_origin);
		$this->MultiCell(32, 7, number_format($data['amount'], 0, ',', '.'), 0, 'R');

		$this->SetXY($x_origin - 30, $y_origin + $h);
	}


	function row_skp_head($label, $str_1, $label_2, $str_2)
	{
		$r = [30, 65, 30, 65];
		$nb = 1;
		$nb = max($nb, $this->NbLines($r[1], $str_1));
		$nb = max($nb, $this->NbLines($r[3], $str_2));
		$h = 6 * $nb;
		$this->CheckPageBreak($h);



		$w = $r[0];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h);
		$this->MultiCell($w, 5, $label, 0, 'L');
		$this->SetXY($x + $w, $y);

		$w = $r[1];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h);
		$this->MultiCell($w, 5, $str_1, 0, 'L');
		$this->SetXY($x + $w, $y);

		$w = $r[2];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h,);
		$this->MultiCell($w, 5, $label_2, 0, 'L');
		$this->SetXY($x + $w, $y);
		$w = $r[3];
		$x = $this->GetX();
		$y = $this->GetY();
		$this->Rect($x, $y, $w, $h);
		$this->MultiCell($w, 5, $str_2, 0, 'L');
		$this->SetXY($x + $w, $y);
		$this->Ln($h);
	}
	function Row($no, $data)
	{
		$x_origin = $this->GetX();
		$y_origin = $this->GetY();

		//Calculate the height of the row
		$nb = 0;
		// for ($i = 0; $i < count($dt_width); $i++)
		$nb = max($nb, $this->NbLines(40, $data['kegiatan']));
		$nb = max($nb, $this->NbLines(50, $data['kegiatan_atasan']));
		$nb_iki = $this->NbLines(35, $data['iki_kuantitas']);
		$nb_iki2 = $this->NbLines(35, $data['iki_kualitas']);
		$nb_iki3 = $this->NbLines(35, $data['iki_waktu']);
		$nb_iki_final = $nb_iki + $nb_iki2 + $nb_iki3;
		$nb = max($nb, $nb_iki_final);

		// print_r('iki = ' . $nb_iki3 . "<br>");
		if ($nb_iki_final < $nb) {
			$nb_iki3 = $nb - $nb_iki - $nb_iki2;
		}
		// print_r('iki = ' . $nb_iki3 . "<br>");
		// print_r($nb);
		// die();
		$h = 4 * $nb;
		$h_2 = 4 * $nb_iki;
		$h_3 = 4 * $nb_iki2;
		$h_4 = 4 * $nb_iki3;
		// print_r($nb);
		// die();
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		// if ($new_page) {
		$x_origin = $this->GetX();
		$y_origin = $this->GetY();
		// }
		// 
		{
			$w = 10;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h);
			$this->MultiCell($w, 4, $no, 0, $a);
			$this->SetXY($x + $w, $y);

			// kg atasan
			$w = 50;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h);
			$this->MultiCell($w, 4, $data['kegiatan_atasan'], 0, $a);
			$this->SetXY($x + $w, $y);

			// keg
			$w = 40;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h);
			$this->MultiCell($w, 4, $data['kegiatan'], 0, $a);
			$this->SetXY($x + $w, $y);
		}
		// kuant 
		{
			$w = 16;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$x2 = $x;
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_2);
			$this->MultiCell($w, 4, "Kuantitas", 0, $a);
			$this->SetXY($x + $w, $y);

			$w = 35;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_2);
			$this->MultiCell($w, 4, $data['iki_kuantitas'], 0, $a);
			$this->SetXY($x + $w, $y);

			$w = 10;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_2);
			$this->MultiCell($w, 4, (empty($data['min_kuantitas']) ? '-' : $data['min_kuantitas']), 0, 'C');
			$this->SetXY($x + $w, $y);

			$w = 11;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect(
				$x,
				$y,
				$w,
				$h_2
			);
			$this->MultiCell($w, 4, $data['max_kuantitas'], 0, 'C');
			$this->SetXY($x + $w, $y);

			$w = 21;
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_2);
			$this->MultiCell($w, 4, $data['ket_kuantitas'], 0, 'C');
			$this->SetXY($x2, $y + $h_2);
		}

		// kuant 
		{
			$w = 16;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_3);
			$this->MultiCell(
				$w,
				4,
				"Kualitas",
				0,
				$a
			);
			$this->SetXY($x + $w, $y);

			$w = 35;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_3);
			$this->MultiCell($w, 4, $data['iki_kualitas'], 0, $a);
			$this->SetXY($x + $w, $y);

			$w = 10;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_3);
			$this->MultiCell($w, 4, (empty($data['min_kualitas']) ? '-' : $data['min_kualitas']), 0, 'C');
			$this->SetXY($x + $w, $y);

			$w = 11;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect(
				$x,
				$y,
				$w,
				$h_3
			);
			$this->MultiCell(
				$w,
				4,
				$data['max_kualitas'],
				0,
				'C'
			);
			$this->SetXY($x + $w, $y);

			$w = 21;
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_3);
			$this->MultiCell($w, 4, $data['ket_kualitas'], 0, 'C');
			// $this->SetXY($x + $w, $y);
			$this->SetXY($x2, $y + $h_3);
		}
		// WAKTU
		{
			$w = 16;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_4);
			$this->MultiCell(
				$w,
				4,
				"Waktu",
				0,
				$a
			);
			$this->SetXY($x + $w, $y);

			$w = 35;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_4);
			$this->MultiCell($w, 4, $data['iki_waktu'], 0, $a);
			$this->SetXY($x + $w, $y);

			$w = 10;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_4);
			$this->MultiCell($w, 4, (empty($data['min_waktu']) ? '-' : $data['min_waktu']), 0, 'C');
			$this->SetXY($x + $w, $y);

			$w = 11;
			$a = isset($this->aligns[0]) ? $this->aligns[0] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect(
				$x,
				$y,
				$w,
				$h_4
			);
			$this->MultiCell(
				$w,
				4,
				$data['max_waktu'],
				0,
				'C'
			);
			$this->SetXY($x + $w, $y);

			$w = 21;
			$x = $this->GetX();
			$y = $this->GetY();
			$this->Rect($x, $y, $w, $h_4);
			$this->MultiCell($w, 4, $data['ket_waktu'], 0, 'C');
			// if ($h == 12)
			// 	$this->cell(20, 2, 'xxx' . $h, 1);
			$this->SetXY($x_origin, $y_origin);
		}
		$this->Ln($h);

		// print_r($h);
		// $this->Cell($w, 4, 'xxxxxxxx', 0, 'C');
	}

	function CheckPageBreak($h)
	{
		if ($this->GetY() + $h > $this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
		}
	}

	function NbLines($w, $txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n")
			$nb--;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i++;
				} else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else
				$i++;
		}
		return $nl;
	}

	function tgl_indo($tanggal)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);

		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun

		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}
}
