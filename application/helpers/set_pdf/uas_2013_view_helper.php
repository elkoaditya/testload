<?php


function pdfview_2013_v1($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$jml = 0;
	$html = style_2013_v1();
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
	$header .= 		header_2013_v1($row,$row_per_siswa);
	$header .= '	</div>';
		
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v1($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background);
					$return_nilai_catatan_walikelas = tablepdf_2013_v1($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	$html .= '			<br/>';
	$html .= 			ttd_2013_v1($row);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
		}
	return $html;
}


/////////////////////////
////// PENERBAD /////////
/////////////////////////
function pdfview_penerbad_2013_v0($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$jml = 0;
	$html = style_2013_v1();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jml++;
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$prestasi_result 	= $prestasi_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];
		
		$deskripsi_array = 	func_deskripsi_sikap_v3($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	$header .= '	</div>';
		
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v1($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,75);
					$return_nilai_catatan_walikelas = tablepdf_2013_v1($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_v0($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	$html .= '			<br/>';
	$html .= 			ttd_2013_v0($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
		}
	return $html;
}

function pdfview_penerbad_2013_v1($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$jml = 0;
	$html = style_2013_v1();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jml++;
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$prestasi_result 	= $prestasi_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];
		
		$deskripsi_array = 	func_deskripsi_sikap_v3($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	$header .= '	</div>';
		
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v1($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,75);
					$return_nilai_catatan_walikelas = tablepdf_2013_v1($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_penerbad_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_penerbad_v1($row,$row_per_siswa,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
		}
	return $html;
}

function pdfview_penerbad_2013_v3($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$jml = 0;
	$html = style_2013_v2();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jml++;
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$prestasi_result 	= $prestasi_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];
		
		$deskripsi_array = 	func_deskripsi_sikap_v3($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	$header .= '	</div>';
		
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v4($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,75);
					$return_nilai_catatan_walikelas = tablepdf_2013_v4($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_v0($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	$html .= '			<br/>';
	$html .= 			ttd_2013_penerbad_v1($row,$row_per_siswa,1);
	//$html .= 			ttd_2013_v0($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
		}
	return $html;
}

function pdfview_penerbad_2013_v4($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$jml = 0;
	$html = style_2013_v2();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jml++;
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$prestasi_result 	= $prestasi_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];
		
		$deskripsi_array = 	func_deskripsi_sikap_v3($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	$header .= '	</div>';
		
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v4($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,75);
					$return_nilai_catatan_walikelas = tablepdf_2013_v4($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or(($row['kelas_grade']== 12)&&($row['semester_nama']=='genap')) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_penerbad_v2($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	$html .= '			<br/>';
	$html .= 			ttd_2013_penerbad_v1($row,$row_per_siswa,1);
	//$html .= 			ttd_2013_v0($row,1);
	$html .= '		</div>';
			
			if(($row['kelas_grade'] == 12)&&($row['semester_nama']=='genap'))
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
		}
	return $html;
}

function pdfview_penerbad_2013_v5($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$jml = 0;
	$html = style_2013_v2();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jml++;
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$prestasi_result 	= $prestasi_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];
		
		$deskripsi_array = 	func_deskripsi_sikap_v3($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	$header .= '	</div>';
		
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_penerbad_v5($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,75);
					$return_nilai_catatan_walikelas = tablepdf_2013_penerbad_v5($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or(($row['kelas_grade']== 12)&&($row['semester_nama']=='genap')) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_penerbad_v3($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	$html .= '			<br/>';
	$html .= 			ttd_2013_penerbad_v2($row,$row_per_siswa,1);
	//$html .= 			ttd_2013_v0($row,1);
	$html .= '		</div>';
			
			if(($row['kelas_grade'] == 12)&&($row['semester_nama']=='genap'))
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
		}
	return $html;
}

function pdfview_2013_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$html = style_2013_v1();
	//$html .= 		$header;
	
	//$html = sikap_2013_v2();
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
	$header .= 		header_2013_v2($row,$row_per_siswa);
	$header .= '	</div>';
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<div id="header_1" class="header">';
	$html .= 		$header;
	//$html .= '		</div>';
	$html .=' 		<br>';

				
	//////////PAGE 1/////////////
	$html .= '		<div align="center" class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,0,$page_sikap,0);
					$return_nilai_catatan_walikelas = tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,2,$page_sikap);
	
	$html .= 		table_interval_kkm_v2();
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 2/////////////
	//$html .= '		<div class="sub-kategori"><b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b></div>';
			
	$html .= 		tablepdf_2013_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,1,$background);
	
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 3/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row);
	
	$html .= '			<br/>';
	$html .= 			ttd_2013_v1($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		//print_r($row_per_siswa);
		}

	return $html;
}

function pdfview_2013_sma8_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$html = style_2013_v1();
	//$html .= 		$header;
	
	//$html = sikap_2013_v2();
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
	
	//$header = '		<div id="header_1" class="header">';
	$header = 		header_2013_sma8_v2($row,$row_per_siswa);
	//$header .= '	</div>';
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<div id="header_1" class="header">';
	$html .= 		$header;
	//$html .= '		</div>';
	$html .=' 		<p class="titik_allwidth"></p><br>';

				
	//////////PAGE 1/////////////
	$html .= '		<div align="center" class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,0,$page_sikap,0);
					$return_nilai_catatan_walikelas = tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,2,$page_sikap);
	
	$html .= 		table_interval_kkm_v2();
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 2/////////////
	//$html .= '		<div class="sub-kategori"><b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b></div>';
			
	$html .= 		tablepdf_2013_sma8_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,1,$background);
	
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 3/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_sma8_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row);
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_sma8_v1($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		//print_r($row_per_siswa);
		}

	return $html;
}

function pdfview_2013_michael_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$html = style_2013_v1();
	//$html .= 		$header;
	
	//$html = sikap_2013_v2();
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
	$header .= 		header_2013_sma9_v2($row,$row_per_siswa);
	$header .= '	</div>';
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	//$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<div id="header_1" class="header">';
	$html .= 		$header.'<p class="titik_allwidth"></p>';
	//$html .= '		</div>';
	$html .=' 		<br>';

				
	//////////PAGE 1/////////////
	$html .= '		<div align="center" class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_michael_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,0,$page_sikap,0,60);
					$return_nilai_catatan_walikelas = tablepdf_2013_michael_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,2,$page_sikap,0,60);
	
	$html .= 		table_interval_kkm_v2();
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 2/////////////
	//$html .= '		<div class="sub-kategori"><b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b></div>';
			
	$html .= 		tablepdf_2013_michael_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,1,$background,60);
	
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 3/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	//$html .= 			tableextra_2013_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row);
	$html .= 			tableextra_2013_sma9_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row);
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_v2($row,$row_per_siswa,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		//print_r($row_per_siswa);
		}

	return $html;
}

function pdfview_2013_sma9_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$html = style_2013_v1();
	//$html .= 		$header;
	
	//$html = sikap_2013_v2();
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
	$header .= 		header_2013_v2($row,$row_per_siswa);
	$header .= '	</div>';
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	//$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<div id="header_1" class="header">';
	$html .= 		$header;
	//$html .= '		</div>';
	$html .=' 		<br>';

				
	//////////PAGE 1/////////////
	$html .= '		<div align="center" class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,0,$page_sikap);
					$return_nilai_catatan_walikelas = tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,2);
	
	$html .= 		table_interval_kkm_v2();
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 2/////////////
	//$html .= '		<div class="sub-kategori"><b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b></div>';
			
	$html .= 		tablepdf_2013_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,1,$background);
	
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 3/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row);
	
	$html .= '			<br/>';
	$html .= 			ttd_2013_v1($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		//print_r($row_per_siswa);
		}

	return $html;
}

function pdfview_2013_sma9_v3($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$html = style_2013_v1();
	//$html .= 		$header;
	
	//$html = sikap_2013_v2();
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
	$header .= 		header_2013_sma9_v2($row,$row_per_siswa);
	$header .= '	</div>';
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	//$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<div id="header_1" class="header">';
	$html .= 		$header.'<p class="titik_allwidth"></p>';
	//$html .= '		</div>';
	$html .=' 		<br>';

				
	//////////PAGE 1/////////////
	$html .= '		<div align="center" class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,0,$page_sikap);
					$return_nilai_catatan_walikelas = tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,2);
	
	$html .= 		table_interval_kkm_v2();
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 2/////////////
	//$html .= '		<div class="sub-kategori"><b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b></div>';
			
	$html .= 		tablepdf_2013_sma9_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,1,$background);
	
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 3/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_sma9_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row);
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_sma9_v1($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		//print_r($row_per_siswa);
		}

	return $html;
}

function pdfview_2013_sma14_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$html = style_2013_sman14_v1();
	//$html .= 		$header;
	
	//$html = sikap_2013_v2();
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
	$header .= 		header_2013_sman14_v2($row,$row_per_siswa);
	$header .= '	</div>';
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	//define('PAGENO', 1);
	$html .= 	footer_2013_sman14_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<div id="header_1" class="header">';
	$html .= 		$header;
	//$html .= '		</div>';
	$html .='
		<table style="width: 100%;border-top:3px solid;">
		 <tr>
			<th ></th>
		 </tr>
		</table>';
	//$html .= '		</div>';
	$html .=' 		<br><br><br><br><br><br>';

				
	//////////PAGE 1/////////////
	$html .= '		<div align="center" class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_sman14_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,0,$page_sikap);
					$return_nilai_catatan_walikelas = tablepdf_2013_sman14_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,2);
	
	$html .= 		table_interval_kkm_sman14_v2();
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 2/////////////
	//$html .= '		<div class="sub-kategori"><b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b></div>';
		
	$html .= 		tablepdf_2013_sman14_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,1,$background);
	
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 3/////////////
				 if(($jumlah_rapor>0) or (($row['kelas_grade']== 12)&&($row['semester_nama']=='genap')) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_sman14_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row);
	
	$html .= '			<br/>';
	$html .= 			ttd_2013_sma14_v1($row,1);
	$html .= '		</div>';
			
			if(($row['kelas_grade'] == 12)&&($row['semester_nama']=='genap'))
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	//$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		//print_r($row_per_siswa);
		}

	return $html;
	
	//echo"a";
}

function pdfview_2013_setiabudhi_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$html = style_2013_v1();
	//$html .= 		$header;
	
	//$html = sikap_2013_v2();
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
			
	$deskripsi_array = 	func_deskripsi_sikap_v2($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2013_sma9_v2($row,$row_per_siswa);
	$header .= '	</div>';
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<div id="header_1" class="header">';
	$html .= 		$header.'<p class="titik_allwidth"></p>';
	//$html .= '		</div>';
	$html .=' 		<br>';

				
	//////////PAGE 1/////////////
	$html .= '		<div align="center" class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_setiabudhi_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,0,$page_sikap);
					$return_nilai_catatan_walikelas = tablepdf_2013_setiabudhi_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,2);
	
	$html .= 		table_interval_kkm_v2();
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 2/////////////
	//$html .= '		<div class="sub-kategori"><b>DESKRIPSI PENGETAHUAN DAN KETERAMPILAN</b></div>';
			
	$html .= 		tablepdf_2013_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,1,$background);
	
	$html .= '		</div>';
	$html .= '	</div>';
	//////////PAGE 3/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_setiabudhi_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_nusput_v1($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		//print_r($row_per_siswa);
		}

	return $html;
}

function pdfview_nusput_v1($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	
	
	$html = style_2013_v1();
	$jml=0;
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
	/*$header .= '	<table width="100%"><tr><td align="center" >
			<h2><b>KARTU HASIL STUDI<br/>SMK NUSAPUTRA 1</b></h2>
			 </td></tr></table>';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	*/
	$header .= 		header_ktsp_nusput_v1();
	$header .= 		profil_ktsp_nusput_v1($row,$row_per_siswa);
	$header .= '	</div>';

		
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_nusput_v1($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,'75');
					$return_nilai_catatan_walikelas = tablepdf_2013_nusput_v1($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	$html .= 		table_interval_kkm_v2();
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_nusput_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_nusput_v1($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		}
	return $html;
}

function pdfview_nusput_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	
	
	$html = style_2013_v1();
	$jml=0;
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
	/*$header .= '	<table width="100%"><tr><td align="center" >
			<h2><b>KARTU HASIL STUDI<br/>SMK NUSAPUTRA 1</b></h2>
			 </td></tr></table>';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	*/
	$header .= 		header_ktsp_nusput_v1();
	$header .= 		profil_ktsp_nusput_v1($row,$row_per_siswa);
	$header .= '	</div>';

		
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_nusput_v2($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,'75');
					$return_nilai_catatan_walikelas = tablepdf_2013_nusput_v1($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	$html .= 		table_interval_kkm_v2();
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	$html .= 			tableextra_2013_nusput_v2($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_nusput_v2($row,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
			
		}
	return $html;
}

/////////////////////////////////////
//////// SMK N 6 SMG ////////////////
/////////////////////////////////////
function pdfview_smkn6smg_2013_v1($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$jml = 0;
	$html = style_2013_v1();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jml++;
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$prestasi_result 	= $prestasi_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];
		
		$deskripsi_array = 	func_deskripsi_sikap_v3($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	$header .= '	</div>';
		
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_smkn6smg_v1($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,75);
					$return_nilai_catatan_walikelas = tablepdf_2013_smkn6smg_v1($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
				 if(($jumlah_rapor>0)or($row['kelas_grade']== 12) )
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	//$html .= 			tableextra_2013_penerbad_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	$html .= 			tableextra_2013_smkn6smg_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_smkn6smg_v1($row,$row_per_siswa,1);
	$html .= '		</div>';
			
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}
		}
	return $html;
}

function pdfview_smkn6smg_2013_v2($id_nilai_siswa,$resultset_array,$deskripsi_pelajaran,$ekskul_result_array,$prestasi_result_array,$org_result_array,$row,$jumlah_rapor,$page_sikap = 0,$background = 0) {
	
	$jml = 0;
	$html = style_2013_v1();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jml++;
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$prestasi_result 	= $prestasi_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];
		
		$deskripsi_array = 	func_deskripsi_sikap_v3($row_per_siswa["siswa_nama"],$deskripsi_pelajaran);
	
	$header = '		<div id="header_1" class="header">';
	$header .= 		header_2013_v1($row,$row_per_siswa);
	$header .= '	</div>';
		
	
	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_2013_v1($row);
	$html .= '	</htmlpagefooter>';
	
	$html .= '	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	
	//$html .= '		<img src="'.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';
	$html .= 		$header;
	//$html .= 		base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png';

				
	$html .= '		<div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>';
			
	$html .= 		tablepdf_2013_smkn6smg_v2($resultset,$row,$row_per_siswa,$deskripsi_array,0,$background,75);
					$return_nilai_catatan_walikelas = tablepdf_2013_smkn6smg_v2($resultset,$row,$row_per_siswa,$deskripsi_array,2);
	
	$html .= '		</div>';
	$html .= '	</div>';
				//////////PAGE 2/////////////
			   if($jumlah_rapor>0)
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				 else
	$html .= '		<div id="bg_nilai" class="page_bg'.$background.'" >';

	$html .= 			$header;
	//$html .= 			tableextra_2013_penerbad_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	$html .= 			tableextra_2013_smkn6smg_v1($ekskul_result,$prestasi_result,$row_per_siswa,$return_nilai_catatan_walikelas,$row, 'color-menu');
	
	//$html .= '			<br/>';
	$html .= 			ttd_2013_smkn6smg_v1($row,$row_per_siswa,1);
	$html .= '		</div>';
			/*
			if($row['kelas_grade'] == 12)
			{    
				if($jumlah_rapor>0)
				{
	$html .= '		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
				}
				else
				{
	$html .= '		<div id="bg_nilai" >';
				}
	$html .= 			pindahkelasv1($row);
	$html .= '		</div>';
			}*/
		}
	return $html;
}

function func_deskripsi_sikap_v1($siswa,$deskripsi_pelajaran) {
	
			
	$deskripsi_sikap_spiritual = array(

		'1' =>	'Sangat baik, '.$siswa.' selalu berdoa saat awal dan akhir kegiatan belajar , '.
				'selalu memberi salam pada saat awal dan akhir presentasi sesuai agama yang dianut '.
				'serta senantiasa menghormati orang lain dalam menjalankan ibadah sesuai dengan agamanya.',
				
		'2' =>	'Baik, '.$siswa.' mengawali dan mengakhiri kegiatan belajar dengan berdoa, '.
				'memberi salam pada saat awal dan akhir presentasi sesuai agama yang dianut.',
			
		'3' => '',	
	);


	$deskripsi_sikap_sosial = array(

		'1' =>	'Sangat baik, '.$siswa.' selalu percaya diri dalam mengerjakan ujian / ulangan , '.
				'selalu tertib dan patuh pada peraturan , selalu rajin dan bertanggung jawab dalam tugas - tugasnya , '.
				'selalu santun terhadap guru - guru dan teman - teman , selalu sopan dalam menyampaikan pendapat dan '.
				'selalu dapat bekerja sama dalam suatu tim.',
				
		'2' =>	'Baik, '.$siswa.' memiliki percaya diri dalam mengerjakan ujian / ulangan , '.
				'tertib dan patuh pada peraturan , mampu bertanggung jawab dalam tugas tugasnya , '.
				'bersikap santun terhadap guru - guru dan teman - teman , mampu menyampaikan pendapat dengan sopan.',
				
		'3' => '',
	);
	
	$deskripsi_array = array(

		'sikap_spiritual'=>$deskripsi_sikap_spiritual,
		
		'sikap_sosial'=>$deskripsi_sikap_sosial,
		
		'deskripsi_pelajaran'=>$deskripsi_pelajaran
	);
	
	return $deskripsi_array;
}

function func_deskripsi_sikap_v2($siswa,$deskripsi_pelajaran) {
	
			
	$deskripsi_sikap_spiritual = array(

		'1' =>	'Sangat baik, selalu berdoa saat awal dan akhir kegiatan belajar , '.
				'selalu memberi salam pada saat awal dan akhir presentasi sesuai agama yang dianut '.
				'serta senantiasa menghormati orang lain dalam menjalankan ibadah sesuai dengan agamanya.',
				
		'2' =>	'Baik, mengawali dan mengakhiri kegiatan belajar dengan berdoa, '.
				'memberi salam pada saat awal dan akhir presentasi sesuai agama yang dianut.',
			
		'3' => '',	
	);


	$deskripsi_sikap_sosial = array(

		'1' =>	'Sangat baik, selalu percaya diri dalam mengerjakan ujian / ulangan , '.
				'selalu tertib dan patuh pada peraturan , selalu rajin dan bertanggung jawab dalam tugas - tugasnya , '.
				'selalu santun terhadap guru - guru dan teman - teman , selalu sopan dalam menyampaikan pendapat dan '.
				'selalu dapat bekerja sama dalam suatu tim.',
				
		'2' =>	'Baik, memiliki percaya diri dalam mengerjakan ujian / ulangan , '.
				'tertib dan patuh pada peraturan , mampu bertanggung jawab dalam tugas tugasnya , '.
				'bersikap santun terhadap guru - guru dan teman - teman , mampu menyampaikan pendapat dengan sopan.',
				
		'3' => '',
	);
	
	$deskripsi_array = array(

		'sikap_spiritual'=>$deskripsi_sikap_spiritual,
		
		'sikap_sosial'=>$deskripsi_sikap_sosial,
		
		'deskripsi_pelajaran'=>$deskripsi_pelajaran
	);
	
	return $deskripsi_array;
}

function func_deskripsi_sikap_v3($siswa,$deskripsi_pelajaran) {
	
			
	$deskripsi_sikap_spiritual = array(

		'1' =>	'Sangat baik, '.$siswa.' selalu berdoa saat awal dan akhir kegiatan belajar , ',
				
		'2' =>	'Baik, '.$siswa.' mengawali dan mengakhiri kegiatan belajar dengan berdoa, ',
			
		'3' => ' ffffffffffff ',	
	);


	$deskripsi_sikap_sosial = array(

		'1' =>	'Sangat baik, '.$siswa.' selalu percaya diri dalam mengerjakan ujian / ulangan , ',
				
		'2' =>	'Baik, '.$siswa.' memiliki percaya diri dalam mengerjakan ujian / ulangan , ',
				
		'3' => 'sssssssssssss',
	);
	
	$deskripsi_array = array(

		'sikap_spiritual'=>$deskripsi_sikap_spiritual,
		
		'sikap_sosial'=>$deskripsi_sikap_sosial,
		
		'deskripsi_pelajaran'=>$deskripsi_pelajaran
	);
	
	return $deskripsi_array;
}