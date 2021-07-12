<?php

function induk_view_v1($row,$data,$jumlah_rapor) {
	$html = 	induk_style_v1();
	
	//$set_array = induk_view_data1a_v1();
	$html .= 	'<div class="page page-notend" id="page-1">';
	
	$html .= 	induk_header1_v1();
	$html .= 	induk_view_tabel_v1();
	$html .= 	'</div>';
	
	$html .= 	'<div class="page" id="page-2">';
	$html .= 	induk_header2_v1();
	$html .=' 	<br>';
	
	$html .= 	induk_set_profil_v1();
	$html .=' 	<br>';
	$html .=' 	<br>';
	$html .= 	induk_set_table_nilai_v1();
	$html .= 	induk_set_table_bea_v1();
	$html .= 	'</div>';
	
	return $html;
}

function induk_view_v1_lama($row,$data,$jumlah_rapor) {
	$html = 	induk_style_v1();
	
	//$html .=' 	<columns column-count="3" vAlign="J" column-gap="1" />';
	$set_array = induk_view_data1_v1();
	$html .= 	induk_table_v1($set_array);
	//$html .=' 	<columnbreak/>';
	
	
	$html .= 	induk_header2_v1();
	$html .=' 	<br>';
	
	$html .= 	induk_set_profil_v1();
	$html .=' 	<br>';
	$html .=' 	<br>';
	$html .= 	induk_set_table_nilai_v1();
	$html .= 	induk_set_table_bea_v1();
	
	return $html;
}

///////////////////////////////////
/////////// TERBANG ///////////////
///////////////////////////////////
function induk_view_v1_terbang($row,$data,$jumlah_rapor) {
	$html = 	induk_style_v2();
	
	$set_mapel = array(
				'Pendidikan Agama',
				'Pendidikan Kewarganegaraan',
				'Bahasa Indonesia',
				'Bahasa Inggris ',
				'Matematika',
				'Seni Budaya',
				'Pendidikan Jasmani Olahraga dan Kesehatan',
				'Sejarah',
				'Geografi',
				'Ekonomi',
				'Sosiologi',
				'Fisika',
				'Kimia',
				'Biologi',
	);
	//$html .= print_r($data['id_nilai_siswa']);
	foreach($data['id_siswa'] as $id_siswa)
	{
		$jumlah_rapor--;
		
		if(array_key_exists(1,$data['id_nilai_siswa'][$id_siswa]))
		{	$row_per_siswa		= $data['id_nilai_siswa'][$id_siswa][1];	}
		else
		{	$row_per_siswa		= $data['id_nilai_siswa'][$id_siswa][2];	}
		
		$nilai_siswa		= $data['id_nilai_siswa'][$id_siswa];
		$resultset 			= $data['resultset_array'][$id_siswa];
		$ekskul_result 		= $data['ekskul_result_array'][$id_siswa];
		$org_result 		= $data['org_result_array'][$id_siswa];
		
		//$set_array = induk_view_data1a_v1();
		$html .= 	'<div class="page page-notend" id="page-1">';
		$html .= 	'<b>LAPORAN PENILAIAN HASIL BELAJAR PESERTA DIDIK SMA</b><br/>';
		$html .= 	induk_header1_v2($row_per_siswa);
		$html .=' 	<br>';
		//$html.= print_r($resultset);
		$html .= 	induk_view_tabel_v2($row, $resultset, $ekskul_result, $nilai_siswa);
		$html .=' 	</div>';
		$html .= 	'<div class="page page-notend" id="page-2">';
		$html .= 	'<b>KETERCAPAIAN KOMPETENSI DIDIK</b><br/>';
		$html .= 	induk_header1_v2($row_per_siswa);
		$html .=' 	<br>';
		$html .= 	induk_view_deskripsi_v1($row, $resultset);
		$html .=' 	</div>';
		$html .= 	'<div class="page" id="page-3">';
		$html .= 	'<b>AKHLAK MULIA DAN KEPRIBADIAN</b><br />';
		$html .= 	induk_header1_v2($row_per_siswa);
		$html .=' 	<br>';
		$html .= 	induk_view_kepribadian_v1_terbang($nilai_siswa);
		$html .=' 	<br>';
		$html .=' 	<br>';
		$html .= 	induk_view_catatan_wali_v1($nilai_siswa);
		$html .=' 	</div>';
	}
	
	//print_r($data);
	return $html;
}

function induk_view_v2($row,$data,$jumlah_rapor) {
	$html = 	induk_style_v2();
	
	$set_mapel = array(
				'Pendidikan Agama',
				'Pendidikan Kewarganegaraan',
				'Bahasa Indonesia',
				'Bahasa Inggris ',
				'Matematika',
				'Seni Budaya',
				'Pendidikan Jasmani Olahraga dan Kesehatan',
				'Sejarah',
				'Geografi',
				'Ekonomi',
				'Sosiologi',
				'Fisika',
				'Kimia',
				'Biologi',
	);
	//$html .= print_r($data['id_nilai_siswa']);
	foreach($data['id_siswa'] as $id_siswa)
	{
		$jumlah_rapor--;
		
		if(array_key_exists(1,$data['id_nilai_siswa'][$id_siswa]))
		{	$row_per_siswa		= $data['id_nilai_siswa'][$id_siswa][1];	}
		else
		{	$row_per_siswa		= $data['id_nilai_siswa'][$id_siswa][2];	}
		
		$nilai_siswa		= $data['id_nilai_siswa'][$id_siswa];
		$resultset 			= $data['resultset_array'][$id_siswa];
		$ekskul_result 		= $data['ekskul_result_array'][$id_siswa];
		$org_result 		= $data['org_result_array'][$id_siswa];
		
		//$set_array = induk_view_data1a_v1();
		$html .= 	'<div class="page page-notend" id="page-1">';
		$html .= 	'<b>LAPORAN PENILAIAN HASIL BELAJAR PESERTA DIDIK SMA</b><br/>';
		$html .= 	induk_header1_v2($row_per_siswa);
		$html .=' 	<br>';
		//$html.= print_r($resultset);
		$html .= 	induk_view_tabel_v2($row, $resultset, $ekskul_result, $nilai_siswa);
		$html .=' 	</div>';
		$html .= 	'<div class="page page-notend" id="page-2">';
		$html .= 	'<b>KETERCAPAIAN KOMPETENSI DIDIK</b><br/>';
		$html .= 	induk_header1_v2($row_per_siswa);
		$html .=' 	<br>';
		$html .= 	induk_view_deskripsi_v1($row, $resultset);
		$html .=' 	</div>';
		$html .= 	'<div class="page" id="page-3">';
		$html .= 	'<b>AKHLAK MULIA DAN KEPRIBADIAN</b><br />';
		$html .= 	induk_header1_v2($row_per_siswa);
		$html .=' 	<br>';
		$html .= 	induk_view_kepribadian_v1($nilai_siswa);
		$html .=' 	<br>';
		$html .=' 	<br>';
		$html .= 	induk_view_catatan_wali_v1($nilai_siswa);
		$html .=' 	</div>';
	}
	
	//print_r($data);
	return $html;
}
