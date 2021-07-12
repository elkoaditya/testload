<?php

function pdfview_ktsp_v1($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	$html = style_ktsp_v1();

	//$html .= '	<htmlpagefooter name="footer_pagenum">';
	//$html .= 	footer_pagenum_v1($row);
	//$html .= '	</htmlpagefooter>';
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

	//	if($jumlah_rapor>0)
//	$html .= '	<div id="bg_deskripsi" class="content page-notend">';
//		 else
//	$html .= '	<div class="page" id="page-1" >';	
	$html .= '	<div class="page page-notend backgrounds" id="page-1" >';	
	$html .= 		header_ktsp_v1($row,$row_per_siswa);
	if(strlen($row_per_siswa["siswa_nama"])<=25)
	{
		$html .= 		'<br/>';
	}
	$html .= 		table_nilai_ktsp_v1($resultset);
	$html .= 		catatan_ktsp_v1();
	$html .= 		'<br><br>';
	$html .= 		footer_ktsp_v1($row,1);

	$html .= '	</div>

				<!-- ===================================================================================== -->
	';
	$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
	$html .=		header_ktsp_v1($row,$row_per_siswa);
	if(strlen($row_per_siswa["siswa_nama"])<=25)
	{
		$html .= 		'<br/>';
	}
	$html .= '		Ketercapaian Kompetensi Peserta Didik 
					<br/>';
	$html .= 		ketercapaian_kompetensi_ktsp_v1($resultset);

	$html .= 		catatan_ktsp_v1();
	//$html .= 		'<br><br/>';
	//$html .=		'<br/><br/><br/><br/><br/>';
	$html .= 		footer_ktsp_v1($row, 2);
	$html .= '	</div>

				<!-- ====================================================================================== -->
';
	if($jumlah_rapor>0)
		$html .= '	<div class="page page-notend backgrounds" id="page-3" >';	
	else
		$html .= '	<div class="page backgrounds" id="page-3" >';
	$html .= 		header_ktsp_v1($row,$row_per_siswa);
	if(strlen($row_per_siswa["siswa_nama"])<=25)
	{
		$html .= 		'<br/>';
	}
	$html .= '		Pengembangan Diri <br/>';
	$html .= 		pengembangan_diri_ktsp_v1($ekskul_result, $org_result);
	
	//$html .= '		<br/>';
	$html .= '		Akhlak Mulia dan Kepribadian<br />';
	$html .= 		akhlak_ktsp_v1($row_per_siswa);
	
	//$html .= '		<br/>';
	$html .= '		Ketidakhadirannnn<br />';
	$html .= 		ketidakhadiran_ktsp_v1($row_per_siswa);
	$html .= 		catatan_kenaikan_kelas_ktsp_v1($row,$row_per_siswa);
	//$html .= 		catatan_wali_kelas_ktsp_v1($row,$resultset_array);
	//$html .= 		'<br>';
	$html .= 		footer_ktsp_v1($row,3);
	
	$html .= '	</div>';
	}
	return $html;
}

function pdfview_ktsp_v2($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	$html = style_ktsp_v1();

	//$html .= '	<htmlpagefooter name="footer_pagenum">';
	//$html .= 	footer_pagenum_v1($row);
	//$html .= '	</htmlpagefooter>';
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

	//	if($jumlah_rapor>0)
//	$html .= '	<div id="bg_deskripsi" class="content page-notend">';
//		 else
//	$html .= '	<div class="page" id="page-1" >';	
	$html .= '	<div class="page page-notend backgrounds" id="page-1" >';	
	$html .= 		header_ktsp_v1($row,$row_per_siswa);
	if(strlen($row_per_siswa["siswa_nama"])<=25)
	{
		$html .= 		'<br/>';
	}
	$html .= 		table_nilai_ktsp_v1($resultset);
	$html .= 		catatan_ktsp_v1();
	$html .= 		'<br><br>';
	$html .= 		footer_ktsp_v1($row,1);

	$html .= '	</div>

				<!-- ===================================================================================== -->
	';
	$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
	$html .=		header_ktsp_v1($row,$row_per_siswa);
	if(strlen($row_per_siswa["siswa_nama"])<=25)
	{
		$html .= 		'<br/>';
	}
	$html .= '		Ketercapaian Kompetensi Peserta Didik 
					<br/>';
	$html .= 		ketercapaian_kompetensi_ktsp_v1($resultset);

	$html .= 		catatan_ktsp_v1();
	//$html .= 		'<br><br/>';
	//$html .=		'<br/><br/><br/><br/><br/>';
	$html .= 		footer_ktsp_v1($row, 2);
	$html .= '	</div>

				<!-- ====================================================================================== -->
';
	if($jumlah_rapor>0)
		$html .= '	<div class="page page-notend backgrounds" id="page-3" >';	
	else
		$html .= '	<div class="page backgrounds" id="page-3" >';
	$html .= 		header_ktsp_v1($row,$row_per_siswa);
	if(strlen($row_per_siswa["siswa_nama"])<=25)
	{
		$html .= 		'<br/>';
	}
	$html .= '		Pengembangan Diri <br/>';
	$html .= 		pengembangan_diri_ktsp_v1($ekskul_result, $org_result);
	
	//$html .= '		<br/>';
	$html .= '		Akhlak Mulia dan Kepribadian<br />';
	$html .= 		akhlak_ktsp_v2($row_per_siswa);
	
	//$html .= '		<br/>';
	$html .= '		Ketidakhadiran<br />';
	$html .= 		ketidakhadiran_ktsp_v1($row_per_siswa);
	$html .= 		catatan_kenaikan_kelas_ktsp_v1($row,$row_per_siswa);
	//$html .= 		catatan_wali_kelas_ktsp_v1($row,$resultset_array);
	$html .= 		'<br>';
	$html .= 		footer_ktsp_v1($row,3);
	
	$html .= '	</div>';
	}
	return $html;
}
?>