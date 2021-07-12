<?php


function pdfview_ktsp_v1($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	$html = style_ktsp_penerbad_v1();

	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_pagenum_v1($row);
	$html .= '	</htmlpagefooter>';
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
	
	$html .= 		'<br/>';
	$html .= 		table_nilai_ktsp_v1($resultset);
	//$html .= 		catatan_ktsp_v1();
	$html .= 		footer_ktsp_v1($row,1);

	$html .= '	</div>

				<!-- ===================================================================================== -->
	';
	$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
	$html .=		header_ktsp_v1($row,$row_per_siswa);
	$html .= '		<br />
					Ketercapaian Kompetensi Peserta Didik 
					<br/>';
	$html .= 		ketercapaian_kompetensi_ktsp_v1($resultset);

	//$html .= 		catatan_ktsp_v1();
	$html .= 		footer_ktsp_v1($row, 2);
	$html .= '	</div>

				<!-- ====================================================================================== -->
';
	$html .= '	<div class="page page-notend backgrounds" id="page-3" >';	
	$html .= 		header_ktsp_v1($row,$row_per_siswa);

	$html .= '		Pengembangan Diri <br/>';
	$html .= 		pengembangan_diri_ktsp_v1($ekskul_result, $org_result);
	$html .= '		<br/>
					Akhlak Mulia dan Kepribadian<br />
	';
	$html .= 		akhlak_ktsp_v1($row_per_siswa);
	$html .= '		<br/>
					Ketidakhadiran<br />
	';
	$html .= 		ketidakhadiran_ktsp_v1($row_per_siswa);
	$html .= 		catatan_kenaikan_kelas_ktsp_v1($row_per_siswa,$resultset_array);
	$html .= 		footer_ktsp_v1($row,3);
	
	$html .= '	</div>';
	}
	return $html;
}


/////////////////////////////////////////////
//////////////SETIABUDHI/////////////////////
/////////////////////////////////////////////
function pdfview_ktsp_sethiabudhi_v1($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	$html = style_ktsp_sethiabudhi_v1();

	$html .= '	<htmlpagefooter name="footer_pagenum">';
	$html .= 	footer_pagenum_v1($row);
	$html .= '	</htmlpagefooter>';
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
	$html .= 		header_ktsp_sma8_v1($row,$row_per_siswa);
	
	$html .= 		'<br/>';
	$html .= 		table_nilai_ktsp_v1($resultset);
	//$html .= 		catatan_ktsp_v1();
	$html .= 		footer_ktsp_v1($row,1);

	$html .= '	</div>

				<!-- ===================================================================================== -->
	';
	$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
	$html .=		header_ktsp_v1($row,$row_per_siswa);
	$html .= '		<br />
					Ketercapaian Kompetensi Peserta Didik 
					<br/>';
	$html .= 		ketercapaian_kompetensi_ktsp_v1($resultset);

	//$html .= 		catatan_ktsp_v1();
	//$html .= 		footer_ktsp_v1($row, 2);
	$html .= '	</div>

				<!-- ====================================================================================== -->
';
	if($jumlah_rapor>0)
		$html .= '	<div class="page page-notend backgrounds" id="page-3" >';	
	else
		$html .= '	<div class="page backgrounds" id="page-3" >';
	//$html .= '	<div class="page page-notend backgrounds" id="page-3" >';	
	$html .= 		header_ktsp_v1($row,$row_per_siswa);

	$html .= '		Pengembangan Diri <br/>';
	$html .= 		pengembangan_diri_ktsp_sethiabudhi_v1($ekskul_result, $org_result);
	//$html .= '		<br/>';
	$html .= '		Akhlak Mulia dan Kepribadian<br />
	';
	$html .= 		akhlak_ktsp_sma8_v1($row_per_siswa);
	//$html .= '		<br/>';
	$html .= '		Ketidakhadiran<br />
	';
	$html .= 		ketidakhadiran_ktsp_v1($row_per_siswa);
	$html .='		<br/>';
	$html .= 		catatan_sma8_ktsp_v1($row_per_siswa);
	$html .='		<br/>';
	$html .= 		kenaikan_sma8_ktsp_v1($row_per_siswa);
	$html .= 		footer_ktsp_v1($row,3);
	
	$html .= '	</div>';
	}
	return $html;
}


/////////////////////////////////////////////
/////////////////SMA 8 //////////////////////
/////////////////////////////////////////////
function pdfview_ktsp_sma8_v1($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	//$html = style_ktsp_v1();

	$html = style_ktsp_sma8_v1();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

	$html .= '	<div class="page page-notend" id="page-1" >';	
	$html .= 		header_ktsp_sma8_v1($row,$row_per_siswa);
	
	$html .= 		'<br/>';
	$html .= 		table_nilai_ktsp_sma8_v1($resultset);
	//$html .= 		catatan_ktsp_v1();
	//$html .= 		footer_ktsp_v1($row,1);
	$html .= 		'<br/>';
	$html .= 		footer_ktsp_sma8_v1($row,1);
	
	$html .= '	</div>

				<!-- ===================================================================================== -->
				<div class="page page-notend" id="page-2" >
	';
	$html .=		header_ktsp_sma8_v1($row,$row_per_siswa);
	$html .= '		<br />
					Ketercapaian Kompetensi Peserta Didik 
					<br/>';
	$html .= 		ketercapaian_kompetensi_ktsp_v1($resultset);

	//$html .= 		catatan_ktsp_v1();
	//$html .= 		footer_ktsp_v1($row, 2);
	$html .= '	</div>

				<!-- ====================================================================================== -->';
	
	if($jumlah_rapor>0)
		$html .= '	<div class="page page-notend backgrounds" id="page-3" >';	
	else
		$html .= '	<div class="page backgrounds" id="page-3" >';
	
	$html .= 		header_ktsp_sma8_v1($row,$row_per_siswa);

	//$html .= '		<br/>';
	$html .= '		Pengembangan Diri <br/>';
	$html .= 		pengembangan_diri_sma8_ktsp_v1($ekskul_result, $org_result);
	//$html .= '		<br/>';
	$html .= '		Akhlak Mulia dan Kepribadian<br />';
	$html .= 		akhlak_ktsp_sma8_v1($row_per_siswa);
	//$html .= '		<br/>';
	$html .= '		Ketidakhadiran<br />';
	$html .= 		ketidakhadiran_ktsp_v1($row_per_siswa);
	//$html .= '		<br/>';
	$html .= 		catatan_sma8_ktsp_v1($row_per_siswa);
	//$html .= '		<br/>';
	//$html .= 		kenaikan_sma8_ktsp_v1($row_per_siswa);
	
	$html .= 		catatan_kenaikan_kelas_ktsp_v1($row,$resultset_array);
	//$html .= 		footer_ktsp_v1($row,3);
	$html .= 		'<br/>';
	$html .= 		footer_ktsp_sma8_v1($row,1);
	
	$html .= '	</div>';
	}
	return $html;
}

function pdfview_ktsp_sma8_v2($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	//$html = style_ktsp_v1();

	$html = style_ktsp_sma8_v2();
	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

	$html .= '	<div class="page page-notend" id="page-1" >';	
	$html .= 		header_ktsp_sma8_v2($row,$row_per_siswa);
	
	$html .= 		'<br/>';
	$html .= 		table_nilai_ktsp_sma8_v1($resultset);
	//$html .= 		catatan_ktsp_v1();
	//$html .= 		footer_ktsp_v1($row,1);
	$html .= 		'<br/>';
	$html .= 		footer_ktsp_sma8_v1($row,1);
	
	$html .= '	</div>

				<!-- ===================================================================================== -->
				<div class="page page-notend" id="page-2" >
	';
	$html .=		header_ktsp_sma8_v2($row,$row_per_siswa);
	$html .= '		<br />
					Ketercapaian Kompetensi Peserta Didik 
					<br/>';
	$html .= 		ketercapaian_kompetensi_ktsp_v1($resultset);

	//$html .= 		catatan_ktsp_v1();
	//$html .= 		footer_ktsp_v1($row, 2);
	$html .= '	</div>

				<!-- ====================================================================================== -->';
	
	if($jumlah_rapor>0)
		$html .= '	<div class="page page-notend backgrounds" id="page-3" >';	
	else
		$html .= '	<div class="page backgrounds" id="page-3" >';
	
	$html .= 		header_ktsp_sma8_v2($row,$row_per_siswa);

	//$html .= '		<br/>';
	$html .= '		Pengembangan Diri <br/>';
	$html .= 		pengembangan_diri_sma8_ktsp_v1($ekskul_result, $org_result);
	//$html .= '		<br/>';
	$html .= '		Akhlak Mulia dan Kepribadian<br />';
	$html .= 		akhlak_ktsp_sma8_v1($row_per_siswa);
	//$html .= '		<br/>';
	$html .= '		Ketidakhadiran<br />';
	$html .= 		ketidakhadiran_ktsp_v1($row_per_siswa);
	//$html .= '		<br/>';
	$html .= 		catatan_sma8_ktsp_v2($row_per_siswa);
	//$html .= '		<br/>';
	//$html .= 		kenaikan_sma8_ktsp_v1($row_per_siswa);
	
	$html .= 		catatan_kenaikan_kelas_ktsp_v2($row,$resultset_array);
	//$html .= 		footer_ktsp_v1($row,3);
	$html .= 		'<br/>';
	$html .= 		footer_ktsp_sma8_v1($row,1);
	
	$html .= '	</div>';
	}
	return $html;
}
/////////////////////////////////////////////
/////////////////Penerbad //////////////////////
/////////////////////////////////////////////

function pdfview_ktsp_penerbad_v0($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$rerata,$jumlah_rapor) {
	//$html = '';
	$html = style_ktsp_penerbad_v1();

	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

	//	if($jumlah_rapor>0)
	//$html .= '	<div id="bg_deskripsi" class="content page-notend">';
	//	 else
	$html .= '	<div class="page page-notend backgrounds" id="page-1" >';	
	//$html .= '	<div id="halaman">';
	//$html .= 		header_ktsp_penerbad_v0($row,$row_per_siswa);
	$html .= 		header_ktsp_penerbad_v1($row,$row_per_siswa);
	
	$html .= 		'<br/>';
	//$html .= 		table_nilai_ktsp_penerbad_v0($resultset,$rerata);
	$html .= 		table_nilai_ktsp_penerbad_v1($resultset,$rerata);
	$html .= 		'<br/>';
	$html .= 		footer_penerbad_v0($row,1);

	$html .= '	</div>';
	/////////// --------------------------------------------------///////////////////////
	//$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
	
	if($jumlah_rapor>0)
		$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
	else
		$html .= '	<div class="page backgrounds" id="page-2" >';
		
	//$html .= 		header_ktsp_penerbad_v0($row,$row_per_siswa);
	$html .= 		header_ktsp_penerbad_v1($row,$row_per_siswa);
	
	$html .= '		<br />
					<p align="center"><b>CATATAN AKHIR SEMESTER</b></p>
					<b>1. Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relawan:</b>
					<br/>';
	$html .= 		du_penerbad_v0($row_per_siswa);

	$html .= '		<br/><b>2. Pengembangan Diri dan Kepribadian:</b>
					<br/>
					';
	$html .= 		extra_aspri_penerbad_v0($ekskul_result,$row_per_siswa);
	$html .= '		 <br/>
					<b>3. Ketidakhadiran</b>
					<br/>
					';
	$html .= 		ketidakhadiran_penerbad_ktsp_v0($row_per_siswa);
	$html .= '		<br/>
					<b>4. Catatan untuk perhatian orang tua/wali</b>
					<br/>
					';
	$html .= 		catatan_penerbad_ktsp_v1($row_per_siswa);
	$html .= '		 <br/>
					<b>5. Pernyataan</b>
					<br/>
					';
	$html .= 		Pernyataan_penerbad_ktsp_v1($row);
	$html .= '	</div>
			';
	}
	return $html;
}

function pdfview_ktsp_penerbad_v1($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$rerata,$jumlah_rapor) {
	//$html = '';
	$html = style_ktsp_penerbad_v1();

	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

		//	if($jumlah_rapor>0)
		//$html .= '	<div id="bg_deskripsi" class="content page-notend">';
		//	 else
		$html .= '	<div class="page page-notend backgrounds" id="page-1" >';	
		//$html .= '	<div id="halaman">';
		$html .= 		header_ktsp_penerbad_v1($row,$row_per_siswa);
		
		$html .= 		'<br/>';
		//$html .=        print_r($rerata);
		$html .= 		table_nilai_ktsp_penerbad_v1($resultset,$rerata);
		$html .= 		'<br/>';
		$html .= 		footer_penerbad_v1($row,1);

		$html .= '	</div>';
		/////////// --------------------------------------------------///////////////////////
		//$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
		
		//// KELAS 12
		if($row["kelas_grade"]!=12){
			if($jumlah_rapor>0)
				$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
			else
				$html .= '	<div class="page backgrounds" id="page-2" >';
		}else{
			$html .= '	<div class="page backgrounds" id="page-2" >';
		}
		$html .=		header_ktsp_penerbad_v1($row,$row_per_siswa);
		$html .= '		<br />
						<p align="center"><b>CATATAN AKHIR SEMESTER</b></p>
						<b>1. Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relawan:</b>
						<br/>';
		$html .= 		du_penerbad_v1($row_per_siswa);

		$html .= '		<br/><b>2. Pengembangan Diri dan Kepribadian:</b>
						<br/>
						';
		$html .= 		extra_aspri_penerbad_v1($ekskul_result,$row_per_siswa);
		$html .= '		 <br/>
						<b>3. Ketidakhadiran</b>
						<br/>
						';
		$html .= 		ketidakhadiran_penerbad_ktsp_v1($row_per_siswa);
		$html .= '		<br/>
						<b>4. Catatan untuk perhatian orang tua/wali</b>
						<br/>
						';
		$html .= 		catatan_penerbad_ktsp_v1($row_per_siswa);
		$html .= '		 <br/>
						<b>5. Pernyataan</b>
						<br/>
						';
		$html .= 		Pernyataan_penerbad_ktsp_v1($row);
		$html .= '	</div>';
		
		//// KELAS 12
		if($row["kelas_grade"]==12)
		{
			$html .= '	<div class="page page-notend backgrounds " id="page-9">';
			$html .= 	lembar_kelulusan_lembar3_penerbad_V1($row);
			$html .= '	</div>';

		
			if($jumlah_rapor>0)
				$html .= '	<div class="page page-notend backgrounds" id="page-10" >';	
			else
				$html .= '	<div class="page backgrounds" id="page-10" >';
			$html .= 	lembar_kelulusan_lembar4_penerbad_V1($row);
			$html .= '	</div>';
		}
	}
	return $html;
}
function pdfview_ktsp_penerbad_v2($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$rerata,$jumlah_rapor) {
	//$html = '';
	$html = style_ktsp_penerbad_v1();

	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

		//	if($jumlah_rapor>0)
		//$html .= '	<div id="bg_deskripsi" class="content page-notend">';
		//	 else
		$html .= '	<div class="page page-notend backgrounds" id="page-1" >';	
		//$html .= '	<div id="halaman">';
		$html .= 		header_ktsp_penerbad_v1($row,$row_per_siswa);
		
		$html .= 		'<br/>';
		//$html .=        print_r($rerata);
		$html .= 		table_nilai_ktsp_penerbad_v2($resultset,$rerata);
		$html .= 		'<br/>';
		$html .= 		footer_penerbad_v1($row,1);

		$html .= '	</div>';
		/////////// --------------------------------------------------///////////////////////
		//$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
		
		//// KELAS 12
		if($row["kelas_grade"]!=12){
			if($jumlah_rapor>0)
				$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
			else
				$html .= '	<div class="page backgrounds" id="page-2" >';
		}else{
			$html .= '	<div class="page backgrounds" id="page-2" >';
		}
		$html .=		header_ktsp_penerbad_v1($row,$row_per_siswa);
		$html .= '		<br />
						<p align="center"><b>CATATAN AKHIR SEMESTER</b></p>
						<b>1. Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relawan:</b>
						<br/>';
		$html .= 		du_penerbad_v1($row_per_siswa);

		$html .= '		<br/><b>2. Pengembangan Diri dan Kepribadian:</b>
						<br/>
						';
		$html .= 		extra_aspri_penerbad_v1($ekskul_result,$row_per_siswa);
		$html .= '		 <br/>
						<b>3. Ketidakhadiran</b>
						<br/>
						';
		$html .= 		ketidakhadiran_penerbad_ktsp_v1($row_per_siswa);
		$html .= '		<br/>
						<b>4. Catatan untuk perhatian orang tua/wali</b>
						<br/>
						';
		$html .= 		catatan_penerbad_ktsp_v1($row_per_siswa);
		$html .= '		 <br/>
						<b>5. Pernyataan</b>
						<br/>
						';
		$html .= 		Pernyataan_penerbad_ktsp_v1($row);
		$html .= '	</div>';
		
		//// KELAS 12
		if($row["kelas_grade"]==12)
		{
			$html .= '	<div class="page page-notend backgrounds " id="page-9">';
			$html .= 	lembar_kelulusan_lembar3_penerbad_V1($row);
			$html .= '	</div>';

		
			if($jumlah_rapor>0)
				$html .= '	<div class="page page-notend backgrounds" id="page-10" >';	
			else
				$html .= '	<div class="page backgrounds" id="page-10" >';
			$html .= 	lembar_kelulusan_lembar4_penerbad_V1($row);
			$html .= '	</div>';
		}
	}
	return $html;
}
function pdfview_ktsp_penerbad_v3($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$rerata,$jumlah_rapor) {
	//$html = '';
	$html = style_ktsp_penerbad_v1();

	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

		//	if($jumlah_rapor>0)
		//$html .= '	<div id="bg_deskripsi" class="content page-notend">';
		//	 else
		$html .= '	<div class="page page-notend backgrounds" id="page-1" >';	
		//$html .= '	<div id="halaman">';
		$html .= 		header_ktsp_penerbad_v1($row,$row_per_siswa);
		
		$html .= 		'<br/>';
		//$html .=        print_r($rerata);
		$html .= 		table_nilai_ktsp_penerbad_v1($resultset,$rerata);
		$html .= 		'<br/>';
		$html .= 		footer_penerbad_v1($row,1);

		$html .= '	</div>';
		/////////// --------------------------------------------------///////////////////////
		//$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
		
		//// KELAS 12
		if(($row["kelas_grade"]==12)&&(strtoupper($row['semester_nama'])=='GENAP')){
			$html .= '	<div class="page page-notend backgrounds" id="page-2" >';
		}else{
			if($jumlah_rapor>0)
				$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
			else
				$html .= '	<div class="page backgrounds" id="page-2" >';
		}
		$html .=		header_ktsp_penerbad_v1($row,$row_per_siswa);
		$html .= '		<br />
						<p align="center"><b>CATATAN AKHIR SEMESTER</b></p>
						<b>1. Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relawan:</b>
						<br/>';
		$html .= 		du_penerbad_v0($row_per_siswa);

		$html .= '		<br/><b>2. Pengembangan Diri dan Kepribadian:</b>
						<br/>
						';
		$html .= 		extra_aspri_penerbad_v1($ekskul_result,$row_per_siswa);
		$html .= '		 <br/>
						<b>3. Ketidakhadiran</b>
						<br/>
						';
		$html .= 		ketidakhadiran_penerbad_ktsp_v1($row_per_siswa);
		$html .= '		<br/>
						<b>4. Catatan untuk perhatian orang tua/wali</b>
						<br/>
						';
		$html .= 		catatan_penerbad_ktsp_v1($row_per_siswa);
		$html .= '		 <br/>
						<b>5. Pernyataan</b>
						<br/>
						';
		$html .= 		Pernyataan_penerbad_ktsp_v1($row);
		$html .= '	</div>';
		
		//// KELAS 12
		if(($row["kelas_grade"]==12)&&(strtoupper($row['semester_nama'])=='GENAP'))
		{
			$html .= '	<div class="page page-notend backgrounds " id="page-9">';
			$html .= 	lembar_kelulusan_lembar3_penerbad_V1($row);
			$html .= '	</div>';

		
			if($jumlah_rapor>0)
				$html .= '	<div class="page page-notend backgrounds" id="page-10" >';	
			else
				$html .= '	<div class="page backgrounds" id="page-10" >';
			$html .= 	lembar_kelulusan_lembar4_penerbad_V1($row);
			$html .= '	</div>';
		}
	}
	return $html;
}
/////////////////////////////////////////////
/////////////////nusput //////////////////////
/////////////////////////////////////////////
function pdfview_ktsp_nusput_v1($id_nilai_siswa,$resultset_array,$ekskul_result_array,$org_result_array,$row,$aspek_result_array,$jumlah_rapor) {
	//$html = '';
	$html = style_ktsp_penerbad_v1();

	foreach($id_nilai_siswa['data'] as $cetak)
	{
		$jumlah_rapor--;
		$row_per_siswa=$cetak;
		
		$resultset 			= $resultset_array[$cetak['id']];
		$ekskul_result 		= $ekskul_result_array[$cetak['id']];
		$org_result 		= $org_result_array[$cetak['id']];

	//	if($jumlah_rapor>0)
	//$html .= '	<div id="bg_deskripsi" class="content page-notend">';
	//	 else
	$html .= '	<div class="page page-notend backgrounds" id="page-1" >';	
	//$html .= '	<div id="halaman">';
	$html .= 		header_ktsp_nusput_v1();
	$html .= 		profil_ktsp_nusput_v1($row,$row_per_siswa);
	$html .= 		'<br/>';
	$html .= 		table_nilai_ktsp_nusput_v1($resultset);
	$html .= 		'<br/>';
	$html .= 		ttd_nusput_v1($row);
	$html .= '	</div>';
	/////////// --------------------------------------------------///////////////////////
	//$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
	if($jumlah_rapor>0)
		$html .= '	<div class="page page-notend backgrounds" id="page-2" >';	
	else
		$html .= '	<div class="page backgrounds" id="page-2" >';
		
	$html .= 		profil_ktsp_nusput_v1($row,$row_per_siswa);
	$html .= 		'<br/>';
	$html .= 		'Kegiatan Belajar di dunia usaha/industri dan instansi relevan';
	$html .= 		du_nusput_v1($row_per_siswa);
	$html .= 		'<br/>';
	$html .= 		'Pengembangan diri, kepribadian dan ketidakhadiran';
	$html .= 		'<br/>';
	$html .= 		table2_nusput_v1($row,$ekskul_result);
	$html .= 		'<br/>';
	$html .= 		catatan_nusput_ktsp_v1($row);
	$html .= 		'<br/>';
	
		$html .= 		catatan_kenaikan_nusput_ktsp_v1($row);
		$html .= 		'<br/>';
	

	$html .= 		ttd_nusput_v1($row);
	
	$html .= '	</div>';
	}
	return $html;
}
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
			$html .= 		header_ktsp_v1_terbang($row_per_siswa);
			
			$html .= 		'<br/>';
			$html .= 		table_nilai_ktsp_v1_terbang($resultset);
			$html .= 		'<br/>';
			$html .= 		akhlak_ktsp_v1_terbang($row_per_siswa);
			$html .= 		footer_ktsp_v1_terbang($row,1);
		
			$html .= '	</div>
		
		
						<!-- ====================================================================================== -->
		
						<div id="halaman" >';
			$html .= 		header_ktsp_v1_terbang($row_per_siswa);
			
			$html .= '		<br />
							<b class="style6">Ketercapaian Kompetensi Siswa </b> 
							<br/>';
			$html .= 		ketercapaian_kompetensi_ktsp_v1_terbang($resultset);
		
			$html .= '		<br />
							<table width="100%" border="0" class="style6">
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
			$html .= 		catatan_kenaikan_kelas_ktsp_v1($row_per_siswa,$resultset_array);	
			$html .= 		footer_ktsp_v1_terbang($row,3);
			
			$html .= '	</div>';
			
	}
	return $html;
}

