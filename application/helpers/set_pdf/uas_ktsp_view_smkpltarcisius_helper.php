<?php
//////////////////////////// tarcisius /////////////////////////////////////////////////////////////////////////////////////////////
function pdfview_ktsp_v1_tarcisius($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	$html = style_ktsp_v1_tarcisius();

	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

			$html .= '	<div class="page page-notend" id="page-1" >';	
			//$html .= '	<div id="halaman">';
			$html .= 		header_ktsp_v1_tarcisius($row_per_siswa);
			
			//$html .= 		'<br/>';
			$html .= 		table_nilai_ktsp_v1_tarcisius($resultset);
			$html .= 		'<br/>';
			//$html .= 		akhlak_ktsp_v1_tarcisius($row_per_siswa);
			$html .= 		footer_ktsp_v1_tarcisius($row,1);
		
			$html .= '	</div>
		
		
						<!-- ====================================================================================== -->
		
						';
			if($jumlah_rapor>0)
				$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
			else
				$html .= '	<div class="page backgrounds" id="page-2" >';
				
			$html .= 		header_ktsp_v1_tarcisius($row,$row_per_siswa);
			$html .= 		'<br/>';
			$html .= 		'Kegiatan Belajar di dunia usaha/industri dan instansi relevan';
			$html .= 		du_tarcisius_v1($row_per_siswa);
			$html .= 		'<br/>';
			$html .= 		'Pengembangan diri, kepribadian dan ketidakhadiran';
			$html .= 		'<br/>';
			$html .= 		table2_tarcisius_v1($row,$ekskul_result);
			$html .= 		'<br/>';
			$html .= 		absensi_tarcisius_v1($row);
			$html .= 		'<br/>';
			$html .= 		catatan_tarcisius_ktsp_v1($row);
			$html .= 		'<br/>';
	
			$html .= 		footer_ktsp_v2_tarcisius($row,3);
			
			$html .= '	</div>';
			
	}
	return $html;
}
?>