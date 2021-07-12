<?php

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

function style_2017_v1()
{
	$html='
	<style>
            @page
            {
                size: 210mm 297mm;
                margin: 3mm 10mm 0mm 10mm;
                margin-header: 10mm;
                margin-footer: 15mm;
                header: html_header_1;
                footer: html_footer_pagenum;
            }
            .page-notend{
                page-break-after: always;
            }

			.field-header
            {
				/*font-size:14px;*/
				padding: 2px 0px 2px 0px;
            }
			
            .content, .content *, td
            {
                font-size: 11px;
            }

            .foot-text
            {
                font-size: 10px;
                font-style: italic;
            }

            .t-border
            {
                border-width: 1px;
                border-style: solid;
                border-color: black;
                border-collapse: collapse;

            }

            #t-nilai
            {
                width: 100%;
            }

            .thead-1{
                vertical-align: middle;
                text-align: center;
				font-size:13px;
            }

			.field-nilai
            {
				font-size:13px;
                padding: 4px 5px 4px 5px;
            }

            .field-nilai2
            {
				font-size:13px;
                padding: 4px 7px 4px 7px;
            }
			
			.field-keluar
            {
				padding: 8px 5px 8px 5px;
            }
			
            #ttd tr td{
                font-size: 14px;
            }
			.sub-kategori{
                font-size: 13px;
            }
			.color-menu{
				background-color:#FFEEDE;
			}
			.style1 {
				font-size: 14px;
				
			}
			
            #profil-siswa tr td{
                font-size: 12px;
            }
            .titik_allwidth{
				border-style: none none dotted none;
            }
            .page_bg0{
				background-image: url('.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.gif);
				background-size: 1200px 1200px;
				background-position: 50% 50%;
				background-repeat: no-repeat;
				position: relative;
            }
			
			
        </style>
      ';
	return $html;
}

function header_2017_v2($row,$row_per_siswa)
{
	$semester_plus=0;
	if($row['kelas_grade']==11){
		$semester_plus=2;
	}elseif($row['kelas_grade']==11){
		$semester_plus=4;
	}
	$semester = 2 + $semester_plus;
	$smster_nama = $semester.' / Genap';
	if($row['semester_nama'] == 'gasal'){
		$semester = $semester-1;
		$smster_nama = $semester.' / Ganjil';
	}
	//$ta_nama = str_replace("/"," - ",$row['ta_nama']);
	$ta_nama = $row['ta_nama'];
	//style="text-transform:uppercase;"
	$html= '
	<div id="header_1" class="header">
		<table width="100%" border="0" style="width: 100%;">
			<tr>
			  <td width="21%"	valign="top"><span class="style1">Nama Sekolah</span> </td>
			  <td width="1%"	valign="top"><span class="style1">:</span></td>
			  <td width="48%" 	valign="top"><span class="style1">'.APP_SCHOOL.'</span></td>
			  
			  <td width="18%" valign="top"><span class="style1">Kelas</span></td>
			  <td width="1%" valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1" style="text-transform:uppercase;">'.$row['kelas_nama'].'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Alamat</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.APP_SCHOOL_ADDRESS.'</span></td>
			  
			  <td valign="top"><span class="style1">Semester</span></td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1" >'.$smster_nama.'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nama</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1" >'.$row_per_siswa['siswa_nama'].'</span></td>
			  
			  <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$ta_nama.'</span></td>
			  '.$smster_nama.'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nomor Induk/NISN</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1" colspan="4">'.$row_per_siswa['siswa_nis'];
			  if($row_per_siswa['siswa_nisn'] != '')
				  $html .=  ' / '.$row_per_siswa['siswa_nisn'];
	$html.= 	'</span> </td>
	
			  
			</tr>
		</table>
		<br/>';
		/*
		<table style="width: 100%;border-top:3px solid;">
		<tr>
		<th ></th>
		</tr>
		</table>
		';*/
		//<p class="titik_allwidth"></p>
	$html .='</div>';
	return $html;
}

function tablepdf_2017_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return=0,$page_sikap=0,$background = 0,$kkm=70)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '';
	
	if($type_return == 0)
	{
	$html .= '
		<table width="100%">
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2017_v2($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
//     $html .= '<br/><br/>';


    $html .= ' 
				</td>
			</tr>
		</table>';
	$html .= '
	</div>';
	}
	$type_return_subhuruf = "B.";
	$type_return_subkategori = "Pengetahuan dan Keterampilan";
	$type_return_colspan1 = 4;
	$type_return_colspan2 = 5;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	$subkategori_2017_v1 = array(
		"", 
		"Pengetahuan",
		"Keterampilan",
	);
	$subhuruf_2017_v1 = array(
		"", 
		"B. ",
		"C. ",
	);
	$kkm_2017_v1 = 75;
	for ($i = 1; $i <= 2; $i++) {
		if($page_sikap == 0){ 
		$html .= '
		<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
		$html .= 		$header;
		}
		
			$html .= ' 
				<table id="t-nilai" >
					<tr>
						<td class="sub-kategori" width="20px"><b>'.$subhuruf_2017_v1[$i].'</b></td>
						<td class="sub-kategori"><b>'.$subkategori_2017_v1[$i].'</b></td>
					</tr>
					<tr>
						<td class="sub-kategori" width="20px"></td>
						<td class="sub-kategori"><b>Kriteria Ketuntasan Minimal (KKM) = 70</b></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<table cellspacing="0" id="t-nilai" class="t-border" >';
			$html .=	head_table_nilai_2017_v2($type_return);
			
						$ktg_nama = NULL;
						$antr_mapel = 0;
						foreach ($resultset['data'] as $idx => $item)
						{
							$item['kategori_nama'] = str_replace("(Wajib)","(Umum)",$item['kategori_nama']);
							if ($item['kategori_nama'] != $ktg_nama)
							{
								$ktg_ascii++;
								$mp_no = 0;
			$html .=            '<tr>' . NL;
			
								if ($item['kategori_kode'] == "KelC")
								{
			
									$minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
			$html .=             '</tr>
							</table>                                
						</td>
					</tr>
				</table>';
				
			if($page_sikap == 0){ 
			$html .=   '
			</div>';
			}
			$html .=   '
			<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">
			<div id="header_1" class="header">';
			$html .= header_2017_v2($row,$row_per_siswa);
			$html .= '
				</div>
				<table id="t-nilai" >
					<tr>
						<td class="sub-kategori" width="20px"></td>
						<td class="sub-kategori">
							<table cellspacing="0" id="t-nilai" class="t-border" >';
			$html .= 		head_table_nilai_2017_v2($type_return);
			$html .= '			<tr>';
			/*$html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
			$html .=                "</tr><tr>
									<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
									<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
			*/
			$html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2.">
									<b> Peminatan C ( Peminatan {$minat} )</b></td>" . NL;
								}
								else if ($item['kategori_kode'] == 'KelD')
								{
			//$html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
			//						<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
			$html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2.">
									<b>Mata Pelajaran Pilihan ( Lintas Minat )</b></td>" . NL;
								}
							   /* else if ($ktg_nama != NULL)
								{
			$html .=             '</tr>
							</table>                                
						</td>
					</tr>
				</table>';
				
			if($page_sikap == 0){ 
			$html .=   '
			</div>';
			}
			$html .=   '
			<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">
			<div id="header_1" class="header">';
			$html .= header_2017_v2($row,$row_per_siswa);
			$html .= '
				</div>
				<table id="t-nilai" >
					<tr>
						<td class="sub-kategori" width="20px"></td>
						<td class="sub-kategori">
							<table cellspacing="0" id="t-nilai" class="t-border" >';
			$html .= 		head_table_nilai_2017_v2($type_return);
			$html .= '			<tr>';
			$html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
								}*/
								else
								{
			$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"5\"><b>".$item['kategori_nama']."</b></td>" . NL;
			//$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
			//$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
			if($type_return == 0)
			{
			//$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
			//$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
			//$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
			}
			//$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
								}
			$html .=        	'</tr>' . NL;
								$ktg_nama = $item['kategori_nama'];
							}
							$mp_no++;
			$html .=        	'<tr>' . NL;
			$html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
			$type_return_mapelname = $item['mapel_nama'];
			if($type_return == 0)
			{
				//$type_return_mapelname = $item['mapel_nama'].'<br><b>'.$item['guru_nama'].'<b>';
				//TANPA NAMA GURU
				$type_return_mapelname = $item['mapel_nama'];
			}
			$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">".$type_return_mapelname."</td>" . NL;
			if($i == 1)
			{				
							if($mode_range==100)
							{	$cetak_kkm = $kkm;	}
							elseif($mode_range==4)
							{	$cetak_kkm = 2.67;	}
			//$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$i." ddfd </td>" . NL;
							
							// PENGETAHUAN /////////////////////////////////////////////////////////////////////////////////////
							$cetak_nilai = 0;
							if ($item['nipel_teori'])
							{
								if ($item['nas_teori']>0)
								{
									if($mode_range==100)
									{	$cetak_nas_teori = round($item['nas_teori']);	}
									elseif($mode_range==4)
									{	$cetak_nas_teori = round(($item['nas_teori']/25),2);	}
									
									if( ( (
										(($item['mapel_id']=='10')||($item['mapel_id']=='1'))
										&&($item['kategori_kode'] == "KelA"))
										||($item['kategori_kode'] == "KelC")) 
										&&($nilai_catatan_walikelas > $item['nas_teori']))
									{	$nilai_catatan_walikelas = $item['nas_teori'];	}
									
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_teori ."</td>" . NL;
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $item['pred_teori'] . "</td>" . NL;
								}
								else
								{
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
								}
							}
							else
							{
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
							}
			//}else
			//{
							
							//////// DESKRIPSI PENGETAHUAN //////////////////
							$cetak_des = 0;
							if($item['cat_teori']!='')
							{
								$cetak_des = 1;
		$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$item['cat_teori']}</td>" . NL;
							}else{
								foreach ($deskripsi_pelajaran['data'] as $deskripsi)
								{
									if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 1) )
									{
										if(	( $item['pred_teori']=='A' && $deskripsi['kode']==1 )||
											( $item['pred_teori']=='B' && $deskripsi['kode']==2 )||
											( $item['pred_teori']=='C' && $deskripsi['kode']==3 )||
											( $item['pred_teori']=='D' && $deskripsi['kode']==4 )	)
										{							
											if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
											{
												$cetak_des = 1;
				$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
											}
										}
									}
								}
							}
							if ($cetak_des == 0)
							{
			$html .=			"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" . NL;
							}
							
			}
			if($i == 2)
			{
							// KETRAMPILAN //////////////////////////////////////////////////////////////////////////////////////////////////////////
							$cetak_nilai = 0;
							if ($item['nipel_praktek'])
							{
								
								if ($item['nas_praktek']>0)
								{
									if($mode_range==100)
									{	$cetak_nas_praktek = round($item['nas_praktek']);	}
									elseif($mode_range==4)
									{	$cetak_nas_praktek = round(($item['nas_praktek']/25),2);	}
									
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_praktek . "</td>" . NL;
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $item['pred_praktek'] . "</td>" . NL;
								}
								else
								{
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
								}
							}
							else
							{
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
							}
			//}else{ 
							
			
							//////// DESKRIPSI KETRAMPILAN //////////////////
							$cetak_des = 0;
							if($item['cat_praktek']!='')
							{
								$cetak_des = 1;
		$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$item['cat_praktek']}</td>" . NL;
							}else{
								
								foreach ($deskripsi_pelajaran['data'] as $deskripsi)
								{
									if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 2) )
									{
										if(	( $item['pred_praktek']=='A' && $deskripsi['kode']==1 )||
											( $item['pred_praktek']=='B' && $deskripsi['kode']==2 )||
											( $item['pred_praktek']=='C' && $deskripsi['kode']==3 )||
											( $item['pred_praktek']=='D' && $deskripsi['kode']==4 )	)
										{
											if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
											{
												$cetak_des = 1;
				$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
											}
										}
									}
								}
							}
							if ($cetak_des == 0)
							{
			$html .=			"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" . NL;
							}
			}
			
			$html .=		'</tr>' . NL;
							$jml_row++;
						}
			$html .='
							</table>
						</td>
					</tr>
				</table>';
			
	if($i == 2){	
		$html .= 		table_interval_kkm_v2();
	}
			$html .='</div>';
	}
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function head_table_nilai_2017_v2($type=0)
{
	$set_rowspan = 'rowspan="2"';
	
	//if($type == 0){
		$set_rowspan = '';
	//}
	$html ='
	<tr>
		';
		/*
	if($type == 0)
	{	
	$html .='
		<td class="thead-1 t-border " '.$set_rowspan.' width="4%"><b>No</b></td>
        <td class="thead-1 t-border " '.$set_rowspan.'  width="35%"><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border " colspan="2" width="25%"><b>Pengetahuan </b></td>
        <td class="thead-1 t-border " colspan="2" width="25%"><b>Keterampilan </b></td>
       ';
	}else
	{*/
	$html .='
		<td class="thead-1 t-border " '.$set_rowspan.' width="5%"><b>No</b></td>
        <td class="thead-1 t-border " '.$set_rowspan.'  width="23%"><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border " width="12%"><b>Nilai</b></td>
        <td class="thead-1 t-border " width="12%" ><b>Predikat</b></td>
        <td class="thead-1 t-border " ><b>Deskripsi</b></td>
       ';
	//}
	$html .='
    </tr>';

	/*
	if($type == 0){	
	$html .='
    <tr>
        <td class="field-nilai thead-1 t-border " ><b>Nilai</b></td>
        <td class="field-nilai thead-1 t-border " ><b>Predikat</b></td>
        <td class="field-nilai thead-1 t-border " ><b>Nilai</b></td>
        <td class="field-nilai thead-1 t-border " ><b>Predikat</b></td>
        
    </tr>';
	}
	else{
	$html .='
    <tr>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Nilai</b></td>
        
    </tr>';
		
	}*/
	return $html;
}

function sikap_2017_v2($data,$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array)
{
	if(isset($row_per_siswa['deskripsi_sikap']))
	{
		$deskripsi_sikap = (array) json_decode($row_per_siswa['deskripsi_sikap'], TRUE);
		$predikat_sikap = (array) json_decode($row_per_siswa['predikat_sikap'], TRUE);
	}else{
		$deskripsi_sikap = '';
		$predikat_sikap = '';
	}
	
	$deskripsi_sikap_sosial = $deskripsi_array['sikap_sosial'];
	$deskripsi_sikap_spiritual = $deskripsi_array['sikap_spiritual'];
	
	for($x=1;$x<=3;$x++)
	{
		$nilai_sosial[$x]		= 0;
		$nilai_spiritual[$x]	= 0;
	}
	
	foreach ($data as $idx => $item)
	{
		if(($item['pred_sikap']=='A')||($item['pred_sikap']=='a')||($item['pred_sikap']=='SB')||($item['pred_sikap']=='sb')){
			$nilai_sosial[1]++;
			$nilai_spiritual[1]++;
		}elseif(($item['pred_sikap']=='B')||($item['pred_sikap']=='b')){
			$nilai_sosial[2]++;
			$nilai_spiritual[2]++;
		}elseif(($item['pred_sikap']=='C')||($item['pred_sikap']=='c')){
			$nilai_sosial[3]++;
			$nilai_spiritual[3]++;
		}
		
		if ($item['kategori_nama'] != $ktg_nama){
			$ktg_nama = $item['kategori_nama'];
			$jml_row++;
		}
		$jml_row++;
	}
	
	//nilai sikap BK
	//if(isset($row_per_siswa["nilai_sikap_bk"))
	//{
		if(($row_per_siswa["nilai_sikap_bk"]=='A')||($row_per_siswa["nilai_sikap_bk"]=='a')||($row_per_siswa["nilai_sikap_bk"]=='SB')||($row_per_siswa["nilai_sikap_bk"]=='sb')){
			$nilai_sosial[1]++;
			$nilai_spiritual[1]++;
		}elseif(($row_per_siswa["nilai_sikap_bk"]=='B')||($row_per_siswa["nilai_sikap_bk"]=='b')){
			$nilai_sosial[2]++;
			$nilai_spiritual[2]++;
		}elseif(($row_per_siswa["nilai_sikap_bk"]=='C')||($row_per_siswa["nilai_sikap_bk"]=='c')){
			$nilai_sosial[3]++;
			$nilai_spiritual[3]++;
		}
		//nilai sikap WALI
		if(($row_per_siswa["nilai_sikap_wali"]=='A')||($row_per_siswa["nilai_sikap_wali"]=='a')||($row_per_siswa["nilai_sikap_wali"]=='SB')||($row_per_siswa["nilai_sikap_wali"]=='sb')){
			$nilai_sosial[1]++;
			$nilai_spiritual[1]++;
		}elseif(($row_per_siswa["nilai_sikap_wali"]=='B')||($row_per_siswa["nilai_sikap_wali"]=='b')){
			$nilai_sosial[2]++;
			$nilai_spiritual[2]++;
		}elseif(($row_per_siswa["nilai_sikap_wali"]=='C')||($row_per_siswa["nilai_sikap_wali"]=='c')){
			$nilai_sosial[3]++;
			$nilai_spiritual[3]++;
		}
	//}			
				
	$html ='
    <!-- Sikap -->
    <div class="thead-1" ><b>1.Sikap Spiritual</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="center" valign="top" height="30px" width="20%"> Predikat </td>
        	<td class="t-border field-nilai" align="center" valign="top" height="30px" >Deskripsi </td>
			
        </tr>
        <tr>
        	<td class="t-border field-nilai" align="center" valign="top">'; 
			if(isset($predikat_sikap['spiritual']))
			{
				$html .= $predikat_sikap['spiritual'];
			}/*else{
				if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
					$html .= ' A ';
				}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
					$html .= ' B ';
				}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
					$html .= ' C ';
				}
			}*/
			
		$html .= '</td>
        	<td class="t-border field-nilai" align="left" valign="top" height="180px"> 
            ';
			if(isset($deskripsi_sikap['spiritual']))
			{
				$html .= $deskripsi_sikap['spiritual'];
			}/*else{
			
				if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
					$html .= $deskripsi_sikap_spiritual[1];
				}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
					$html .= $deskripsi_sikap_spiritual[2];
				}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
					$html .= $deskripsi_sikap_spiritual[3];
				}
			
			}*/
			$html .='
            </td>
        </tr>
	  </table>
      <br/>
    <div class="thead-1"><b>2.Sikap Sosial</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="center" valign="top" height="30px" width="20%"> Predikat </td>
        	<td class="t-border field-nilai" align="center" valign="top" height="30px">Deskripsi </td>
			
        </tr>
        <tr>
        	<td class="t-border field-nilai" align="center" valign="top">'; 
			if(isset($predikat_sikap['sosial']))
			{
				$html .= $predikat_sikap['sosial'];
			}/*else{
				
				if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
					$html .= ' A ';
				}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
					$html .= ' B ';
				}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
					$html .= ' C ';
				}
			}*/
			
		$html .= '</td>
        	<td class="t-border field-nilai" align="left" valign="top" height="180px"> 
            ';
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(isset($deskripsi_sikap['sosial']))
			{
				$html .= $deskripsi_sikap['sosial'];
			}/*else{
				if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
					$html .= $deskripsi_sikap_sosial[1];
				}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
					$html .= $deskripsi_sikap_sosial[2];
				}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
					$html .= $deskripsi_sikap_sosial[3];
				}
			}*/
	$html .= '
            </td>
        </tr>
	  </table>';
	  return $html;
}

function table_interval_kkm_v2()
{
	$html ='
	<table cellspacing="0" width="100%" >
	<tr>
		<td width="20px"></td>
		<td >
		<br/><div style="font-size:14;"><b>Tabel interval berdasarkan KKM.</b></div><br/>
		<table width="90%" cellspacing="0" >
			<tr>
				<td class="field-nilai t-border" rowspan="2" width="20px" align="center">KKM</td>
				<td class="field-nilai t-border" colspan="4" align="center">Predikat </td>
				
			</tr>

			<tr>
				<td class="field-nilai t-border" align="center">D=Kurang</td>
				<td class="field-nilai t-border" align="center">C=Cukup</td>
				<td class="field-nilai t-border" align="center">B=Baik</td>
				<td class="field-nilai t-border" align="center">A=Sangat Baik</td>
				
			</tr>';
			
	
	/*$html .='		<tr>
			<td class="field-nilai t-border" align="center"> 70 </td>
			<td class="field-nilai t-border" align="center"> < 69 </td>
			<td class="field-nilai t-border" align="center"> 70 - 75</td>
			<td class="field-nilai t-border" align="center"> 76 - 90 </td>
			<td class="field-nilai t-border" align="center"> 91 - 100</td>
		';*/

	$html .='		<tr>
			<td class="field-nilai t-border" align="center"> 70 </td>
			<td class="field-nilai t-border" align="center"> < 70 </td>
			<td class="field-nilai t-border" align="center"> 70 ≤ n < 79</td>
			<td class="field-nilai t-border" align="center"> 80 ≤ n < 89 </td>
			<td class="field-nilai t-border" align="center"> 90 ≤ n < 100</td>
		';			
	
	
	$html .='</tr>
		</table>
		
		</td>
		</tr>
	</table>';
	return $html;
}

function tableextra_2017_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%" >   
         <tr>
          <td class="sub-kategori" width="20px"><b>D.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler / Organisasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2017_v1($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2017_v1($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2017_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv1($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>H.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2017_v1($ekskul_result,$row).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2017_v2($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%" >   
         <tr>
          <td class="sub-kategori" width="20px"><b>D.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler / Organisasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2017_v2($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2017_v1($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2017_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv1($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>H.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2017_v1($ekskul_result,$row).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function ekstrakurikuler_2017_v1($ekskul_result,$color_menu='')
{
	$html='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="6%"> <b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="30%"> <b>Kegiatan</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" > <b>Keterangan</b></td>
        </tr>
        ';

        foreach ($ekskul_result['data'] as $_idx => $_row)
        {
            $nisixk['nilai'] = strtoupper($_row['nilai']);

            if (strpos($nisixk['nilai'], 'A') !== false)
            {
                $set_ekskul_keterangan = 'Sangat Baik';
            }
            elseif (strpos($nisixk['nilai'], 'B') !== false)
            {
                $set_ekskul_keterangan = 'Baik';
            }
            elseif (strpos($nisixk['nilai'], 'C') !== false)
            {
                $set_ekskul_keterangan = 'Cukup';
            }else
            {
                $set_ekskul_keterangan = 'Kurang';
            }
            
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . ($_idx + 1) . ".</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" >{$_row['ekskul_nama']}</td>" . NL;
			/*if($_row['keterangan']!='')
			{	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$_row['keterangan']}</td>" . NL;	}
            else
            {	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$set_ekskul_keterangan} </td>" . NL;	}
            */
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$set_ekskul_keterangan} dalam {$_row['keterangan']}</td>" . NL;	
			$html.= '</tr>' . NL;
        }

        if (count($ekskul_result['data']) == 0)
        {
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" . NL;
            $html.= '</tr>' . NL;
        }

    $html.='</table>';
	return $html;
}

function ekstrakurikuler_2017_v2($ekskul_result,$color_menu='')
{
	$html='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="20px"> <b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="26%"> <b>Kegiatan</b></td>
			<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="14%"> <b>Predikat</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width=> <b>Deskripsi</b></td>
        </tr>
        ';
		
		////////////////////////// PRAMUKA ////////////////////////////////////////////
		$no=0;
		$ekskul1 = $ekskul_result['data'];
		foreach ($ekskul1 as $_idx => $_row)
        {
			if(strtolower($_row['ekskul_nama'])=='pramuka')
			{
				$no++;
				$nisixk['nilai'] = strtoupper($_row['nilai']);

				if (strpos($nisixk['nilai'], 'A') !== false)
				{
					$set_ekskul_keterangan = 'Sangat Baik';
				}
				elseif (strpos($nisixk['nilai'], 'B') !== false)
				{
					$set_ekskul_keterangan = 'Baik';
				}
				elseif (strpos($nisixk['nilai'], 'C') !== false)
				{
					$set_ekskul_keterangan = 'Cukup';
				}else
				{
					$set_ekskul_keterangan = 'Kurang';
				}
				
				$html.= '<tr>' . NL;
				$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . $no . ".</td>" . NL;
				$html.= "<td class=\"t-border field-nilai\" valign=\"top\" >{$_row['ekskul_nama']}</td>" . NL;
				/*if($_row['keterangan']!='')
				{	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$_row['keterangan']}</td>" . NL;	}
				else
				{	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$set_ekskul_keterangan} </td>" . NL;	}
				*/
				//$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$nisixk['nilai']." </td>" . NL;
				$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" > {$set_ekskul_keterangan}</td>" . NL;	
				$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >{$_row['keterangan']}</td>" . NL;
				$html.= '</tr>' . NL;
			}
		}
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
        foreach ($ekskul_result['data'] as $_idx => $_row)
        {
            if(strtolower($_row['ekskul_nama'])!='pramuka')
			{
				$no++;
				$nisixk['nilai'] = strtoupper($_row['nilai']);

				if (strpos($nisixk['nilai'], 'A') !== false)
				{
					$set_ekskul_keterangan = 'Sangat Baik';
				}
				elseif (strpos($nisixk['nilai'], 'B') !== false)
				{
					$set_ekskul_keterangan = 'Baik';
				}
				elseif (strpos($nisixk['nilai'], 'C') !== false)
				{
					$set_ekskul_keterangan = 'Cukup';
				}else
				{
					$set_ekskul_keterangan = 'Kurang';
				}
				
				$html.= '<tr>' . NL;
				$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . $no . ".</td>" . NL;
				$html.= "<td class=\"t-border field-nilai\" valign=\"top\" >{$_row['ekskul_nama']}</td>" . NL;
				/*if($_row['keterangan']!='')
				{	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$_row['keterangan']}</td>" . NL;	}
				else
				{	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$set_ekskul_keterangan} </td>" . NL;	}
				*/
				//$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$nisixk['nilai']." </td>" . NL;
				$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" > {$set_ekskul_keterangan}</td>" . NL;	
				$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >{$_row['keterangan']}</td>" . NL;
				$html.= '</tr>' . NL;
			}
        }

        if (count($ekskul_result['data']) == 0)
        {
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" . NL;
            $html.= '</tr>' . NL;
        }

    $html.='</table>';
	return $html;
}

function prestasi_2017_v1($prestasi_result,$color_menu='')
{
	$html = '
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="20px"> <b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="30%"> <b>Jenis Prestasi</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width=> <b>Keterangan</b></td>
        </tr>';

		$cetak_prestasi=0;
		$no=0;
        foreach ($prestasi_result['data'] as $_idx => $_row)
        {
			if($_row['prestasi_nama']!='')
			{
				$cetak_prestasi=1;
				$no++;
				$html.= '<tr>' . NL;
				$html.= '<td class="t-border field-nilai" valign="top" align="right" >' . $no . '</td> '. NL;
				$html.= '<td class="t-border field-nilai" valign="top" >'. $_row['kegiatan_prestasi_nama'].'</td>' . NL;
				$html.= '<td class="t-border field-nilai" valign="top">'.$_row['prestasi_nama'].'</td>' . NL;
				$html.= '</tr>" . NL';
			}
        }

        if ($cetak_prestasi==0)
        {
            $html.= '<tr>' . NL;
			$html.= '<td class="t-border field-nilai" valign="top" align="center" >-</td>' . NL;
            $html.= '<td class="t-border field-nilai" valign="top" align="center">-</td>' . NL;
            $html.= '<td class="t-border field-nilai" valign="top">-</td>' . NL;
            $html.= '</tr>' . NL;
        }
		$html.='</table>';
		return $html;
}

function ketidakhadiran_2017_v1($ketidakhadiran)
{
	$absen_s = '-';
	$absen_i = '-';
	$absen_a = '-';
	if($ketidakhadiran['absen_s'] > 0){
		$absen_s = $ketidakhadiran['absen_s'].' hari';
	}
	if($ketidakhadiran['absen_i'] > 0){
		$absen_i = $ketidakhadiran['absen_i'].' hari';
	}
	if($ketidakhadiran['absen_a'] > 0){
		$absen_a = $ketidakhadiran['absen_a'].' hari';
	}
	$html ='
	<table cellspacing="0" class="t-border field-nilai" width="50%" >
        
        <tr>
            <td width="50%" class=" field-nilai">Sakit</td>
            <td class="t-border field-nilai"> :  '.$absen_s .'</td>
        </tr>
        <tr>
            <td class="t-border field-nilai">Ijin</td>
            <td class="t-border field-nilai"> :  '.$absen_i .'</td>
        </tr>
        <tr>
            <td class="t-border field-nilai">Tanpa Keterangan</td>
            <td class="t-border field-nilai"> : '.$absen_a .'</td>
        </tr>
    </table>';
	return $html;
}

function catatan_walikelasv1($row_per_siswa , $nilai_catatan_walikelas,$row,$ekskul_result)
{
	if ((strtolower($row["semester_nama"]) == "genap"))
	{
		$keterangan_walikelas = array(
	
			'1' =>	$row_per_siswa['siswa_nama'].' pertahankan prestasimu dan tetap semangat untuk melakukan yang terbaik dalam meraih cita - citamu.',
					
			'2' =>	$row_per_siswa['siswa_nama'].' tingkatkan prestasimu dan tetap semangat untuk melakukan yang terbaik dalam meraih cita - citamu.',
				
			'3' => $row_per_siswa['siswa_nama'].' berusahalah lebih keras dan tetap semangat untuk meraih cita - citamu.',	
		);
	
	}else{
	
		$keterangan_walikelas = array(
	
			'1' =>	$row_per_siswa['siswa_nama'].' pertahankan prestasimu dan tetap semangat untuk melakukan yang terbaik di semester depan.',
					
			'2' =>	$row_per_siswa['siswa_nama'].' tingkatkan prestasimu dan tetap semangat untuk melakukan yang terbaik di semester depan.',
				
			'3' => $row_per_siswa['siswa_nama'].' berusahalah lebih keras dan tetap semangat untuk meraih hasil yang lebih baik.',	
		);
	
	}
	
	$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	if($jumlah_ekskul>3){
		$height = '50px';
	}else{
		$height = '65px';
	}
	
    $html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"> '; 
			if($row_per_siswa['note_walikelas']!='')
			{
				//$html.= "Deskripsi:<br/>";
				$html.= $row_per_siswa['note_walikelas'];
			}else{
				if( (APP_SCOPE=='smk_nusaputera')||(APP_SCOPE=='sma_michael') )
				{
					if($nilai_catatan_walikelas>=90)
						$html.= $keterangan_walikelas['1'];
					elseif($nilai_catatan_walikelas>=80)
						$html.= $keterangan_walikelas['2'];
					else
						$html.= $keterangan_walikelas['3'];
				}
			}
			$html.= '</td>
        </tr>
	  </table>';
	  return $html;
}

function tanggapan_ortu_2017_v1($ekskul_result ,$row)
{
	$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	if($jumlah_ekskul>3){
		$height = '35px';
	}else{
		$height = '65px';
	}

	$html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"></td>
        </tr>
	  </table>';
	
	if ((strtolower($row["semester_nama"]) == "genap") && ($row['kelas_grade']!=12))
	{	
	  $html .='
      <br/>
	  <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="40px" 
			style="padding-left:10px; padding-top:5px">
			<b>Keterangan Kenaikan Kelas:</b> &nbsp;&nbsp;&nbsp;NAIK/TIDAK NAIK*) ke kelas XI XII*)</td>
        </tr>
	  </table><br/>
	  *)Coret yang tidak perlu';
	}
      if($jumlah_ekskul>3){
     
       }else{ 
      $html.= '<br/>';
	   }
	return $html;
}


function ttd_2017_v1($data,$type_ttd = 0)
{
	$nip=0;
	if(strpos(APP_SCOPE, 'sman') !== false) 
	{
		$nip=1;
	}
	
	
	$html ='
        <table id="ttd" border="0" style="width: 100%;">
        <tr>
        	<td width="18px"></td>
        	<td valign="top" width="40%">
            	Mengetahui:<br/>
            	Orang Tua/Wali,
				<br/><br/><br/><br/><br/>

				...............................
            </td>
            <td width="200px"></td>
            <td valign="top">
                '.$data["kota_nama"].', '.$data["tanggal_uas_nama"].'<br/>
					Wali Kelas
					<p>
						<br/><br/><br/><br/>';
	$html .='			<u>' . $data["wali_nama"] . '</u>';
	
	if(($nip==1)&& (strlen($data["wali_nip"])>12) ){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}else{
		$html .='			<br/>
							NIP : -';
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		
		/*
		if ((strtolower($data["semester_nama"]) == "genap")&&($data["kelas_grade"] != 12))
			{
    $html .='       
		<tr>
            <td colspan="2"></td>
			<td colspan="3">
				<table>
					<tr>
						<td style="padding:0px 20px 0px 20px;width: 100%;" >
								<b>Keputusan:</b> 
								<br>
								Berdasar hasil yang dicapai pada <br>
								semester 1 dan 2, peserta didik ditetapkan <br>
                                <br>dinyatakan <b>LULUS</b> <br>
                                naik ke kelas '.($data["kelas_grade"]+1).'<br>
								tinggal di kelas '.$data["kelas_grade"].'<br>
								<br>
                                Mengetahui,<br/>
                                Kepala Sekolah
                                <br><br><br><br>
                                <u>'.$data["kepsek_nama"].'</u>';
								
								if($nip==1){
								$html .='<br>'.$data["kepsek_nip"];
								}
                                
		$html .='       											
						</td>
					</tr>
				</table>
			</td>
            <td></td>
		</tr>';
			}else{*/
				if($type_ttd == 1){
	$html .='       
		<tr>
            <td colspan="2"></td>
			<td colspan="3">
				<table>
					<tr>
						<td style="padding-left:-40px;width: 100%;" >
							Mengetahui,<br>
							Kepala Sekolah
							<p>
								<br/><br/><br/><br/>';
				$html .='		<u>' . $data["kepsek_nama"] . '</u>';
				if($nip==1){
					$html .='		<br/>
									NIP : ' . $data["kepsek_nip"];
				}
				$html .='	</p></b>
							<br>
                                
							
							
						</td>
					</tr>
				</table>
			</td>
            <td></td>
		</tr>';
		}
			//}
			
	$html .='    
	</table>';
	return $html;
}

function footer_2017_3_v1($data)
{
	$html= '
	<div id="footer_pagenum" class="footer">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="foot-text">
						'.$data['kelas_nama'].' Semester '.$data['semester_nama'].' - '.$data["ta_nama"].'
                    </td>
                    <td class="foot-text" align="right">
                        Hal. {PAGENO}
                    </td>
                </tr>
            </table>
        </div>';
	return $html;
}