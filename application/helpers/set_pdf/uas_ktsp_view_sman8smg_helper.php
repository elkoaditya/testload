<?php
/////////////////////////////////////////////
/////////////////SMA 8 //////////////////////
/////////////////////////////////////////////
function pdfview_ktsp_sma8_v1($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	//$html = style_ktsp_v1();

	$html = style_ktsp_penerbad_v1();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

	$html .= '	aa<div class="page page-notend" id="page-1" >';	
	$html .= 		header_ktsp_sma8_v1($row_per_siswa);
	
	$html .= 		'<br/>';
	$html .= 		table_nilai_ktsp_v1($resultset);
	//$html .= 		catatan_ktsp_v1();
	$html .= 		footer_ktsp_v1($row,1);

	$html .= '	</div>

				<!-- ===================================================================================== -->
				<div class="page page-notend" id="page-2" >
	';
	$html .=		header_ktsp_sma8_v1($row_per_siswa);
	$html .= '		<br />
					Ketercapaian Kompetensi Peserta Didik 
					<br/>';
	$html .= 		ketercapaian_kompetensi_ktsp_v1($resultset);

	//$html .= 		catatan_ktsp_v1();
	$html .= 		footer_ktsp_v1($row, 2);
	$html .= '	</div>

				<!-- ====================================================================================== -->

				<div class="page page-notend" id="page-3" >';
	$html .= 		header_ktsp_sma8_v1($row_per_siswa);

	$html .= '		<br/>';
	$html .= '		Pengembangan Diri <br/>';
	$html .= 		pengembangan_diri_sma8_ktsp_v1($ekskul_result, $org_result);
	$html .= '		<br/>
					Akhlak Mulia dan Kepribadian<br />
	';
	$html .= 		akhlak_ktsp_sma8_v1($row_per_siswa);
	$html .= '		<br/>
					Ketidakhadiran<br />
	';
	$html .= 		ketidakhadiran_ktsp_v1($row_per_siswa);
	$html .= '		<br/>';
	$html .= 		catatan_sma8_ktsp_v1($row);
	$html .= '		<br/>';
	$html .= 		kenaikan_sma8_ktsp_v1($row);
	
	$html .= 		catatan_kenaikan_kelas_ktsp_v1($row,$resultset_array);
	$html .= 		footer_ktsp_v1($row,3);
	
	$html .= '	</div>';
	}
	return $html;
}

?>