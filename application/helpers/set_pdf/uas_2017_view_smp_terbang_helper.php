<?php

function pdfview_2017_sma_terbang_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$html = style_2017_v1();
	//$html .= 		$header;
	
	//$html = sikap_2017_v2();
	$jml = 0 ;
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jml++;
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$prestasi_result 	= $prestasi_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];
			
	$deskripsi_array = 	func_deskripsi_sikap_v1($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2017_v2($row,$row_per_siswa);
	//$header = 		header_ktsp_v1_terbang($row,$row_per_siswa);
	$header .= '	</div>';
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	//$html .= 	footer_2017_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="halaman" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<div id="header_1" class="header">';
	$html .= 		$header;
	//$html .= '		</div>';
	$html .=' 		<br>';

			
	//////////PAGE 1/////////////
	$html .= '		<div align="center" class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2017_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,0,$page_sikap);
					$return_nilai_catatan_walikelas = tablepdf_2017_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
		
	//////////PAGE 2/////////////
	//$html .= '		<div class="sub-kategori"><b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b></div>';
			
	//$html .= 		tablepdf_2017_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,1,$background);
	
	//$html .= '		</div>';
	///$html .= '	</div>';
	//////////PAGE 3/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="halaman" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="halaman" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2017_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row);
	
	$html .= '			<br/>';
	$html .= 			ttd_2017_v1($row,1);
	//$html .= 			footer_ktsp_v1_terbang($row,3);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="halaman" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="halaman" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		//print_r($row_per_siswa);
		}

	
	return $html;
}

?>