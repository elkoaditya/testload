<?php

//////////////////////////// TERBANG /////////////////////////////////////////////////////////////////////////////////////////////
function pdfview_ktsp_v1_terbang($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	$html = style_ktsp_v1_terbang();

	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

			if($jumlah_rapor>0)
				$html .= '	<div id="bg_deskripsi" class="content page-notend">';
			else
				$html .= '	<div class="page" id="page-1" >';	
			
			$html .= '	<div id="halaman">';
			$html .= 		header_ktsp_v1_terbang($row,$row_per_siswa);
			
			//$html .= 		'<br/>';
			$html .= 		table_nilai_ktsp_v1_terbang($resultset);
			$html .= 		'<br/>';
			$html .= 		akhlak_ktsp_v1_terbang($row_per_siswa);
			$html .= 		footer_ktsp_v1_terbang($row,1);
		
			$html .= '	</div>
		
		
						<!-- ====================================================================================== -->
		
						<div id="halaman" >';
			$html .= 		header_ktsp_v1_terbang($row,$row_per_siswa);
			
			//$html .= '		<br />';
			$html .= '		<b class="style6">Ketercapaian Kompetensi Siswa </b>'; 
			//$html .= '	<br/>';
			$html .= 		ketercapaian_kompetensi_ktsp_v1_terbang($resultset);
		
			//$html .= '		<br />';
			$html .= '		<table width="100%" border="0" class="style6">
								<tr>
									<td width="50">';
			$html .= 		pengembangan_diri_ktsp_v1_terbang($ekskul_result);
			$html .= '		 		</td>
									<td width="5%"></td>
									<td width="45%">
			';
			$html .= 		ketidakhadiran_ktsp_v1_terbang($row_per_siswa);
			
			$html .= '				</td>
								</tr>
							</table>';
			
			//$html .= '		<br/>';
			$html .= 		catatan_ktsp_v1_terbang($row_per_siswa);
			if((strtolower($row['semester_nama']) == 'genap'))
			{
				$html .= 		catatan_kenaikan_kelas_ktsp_v1_terbang($row, $row_per_siswa);
			}
			$html .= '		<br />';
			$html .= 		footer_ktsp_v1_terbang($row,3);
			
			$html .= '	</div>';
			
			$html .= '	</div>';
			
	}
	return $html;
}

?>