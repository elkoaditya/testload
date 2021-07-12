<?php

////////////////////////////
//////////PDF///////////////
////////////////////////////


function induk_style_v1()
{
	$html='
	<style>
            @page
            {
				sheet-size:  330mm 280mm;
				margin: 20px;
            }
			.page-notend{
				page-break-after: always;
			}
            .t-field1a
            {
                width: 100%;
				font-size: 12px;
				border-collapse: collapse;
				vertical-align: top;
            }
            .t-field1_1
            {
                width: 100%;
            }
            .t-field1_2a
            {
                width: 50%;
            }
            .t-field1_2b
            {
                width: 50%;
            }
            .t-field1_left1
            {
				padding-left: 12px;
            }
            .t-field1_left2
            {
				padding-left: 24px;
            }
            .pad_left1
            {
				padding-left: 89px;
            }
            .t-field1b
            {
                width: 100%;
				font-size: 12px;
				border-collapse: collapse;
            }
            .t-field1b tr td
            {
				white-space: nowrap;
            }
            .t-field1c
            {
				font-size: 12px;
				border-collapse: collapse;
            }
            .t_center
            {
				align:center;
            }
            .poto1
            {
				font-size: 10px;
				border-collapse: collapse;
            }
            .thead-1
            {
				font-size: 16px;
				font-weight: bold;
            }
        </style>
      ';
	return $html;
}

function induk_style_v2()
{
	$html='
	<style type="text/css">
		@page {
			sheet-size: 216mm 335mm ;
			margin: 45px 20px 20px 45px;
		}
		.page-notend{
			page-break-after: always;
		}
		#halaman {
			height:1500px;
		}
		.style4 {font-size: 12px}
		.style5 {font-size: 10px}


		.kecil td{
		font-size: 13px;
		padding:5px 2px 5px 2px;

		}
		.style6 {font-size: 16px; }
	</style>
      ';
	return $html;
}
function induk_header1_v1()
{
	
	$html = '<table width="100%">';
	$html .= '	<tr>';
	$html .= '		<td>';
	$html .= 			induk_poto_v1();
	$html .= '		</td>';
	$html .= '		<td>';
	
	$html .= '			<div class="thead-1 pad_left1">';
	$html .= 				'LEMBAR BUKU INDUK SISWA';
	$html .= '			</div>';
	
	$html .= '		</td>';
	$html .= '	</tr>';
	$html .= '</table>';

	return $html;
}
function induk_header2_v1()
{
	$html = '	<div class="thead-1 t_center" width="100%">';
	$html .= 		'TAHUN PELAJARAN ';
	$html .= '	</div>';

	return $html;
}
function induk_header1_v2($row)
{
	$html = '	
		<table width="100%" border="0" style="width: 100%;">
			<tr>
				<td width="26%" valign="top">
					<b>Nama Peserta Didik</b>					
				</td>
				<td width="1%" valign="top">:</td>
				<td colspan="4" valign="top">
					<em><b>'.$row['siswa_nama'].'</b></em>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<b>Nomor Induk</b>					
				</td>
				<td valign="top">:</td>
				<td width="32%" valign="top">
					<b>'.$row['siswa_nis'].'</b>					
				</td>
			</tr>
		</table>';

	return $html;
}
function induk_poto_v1($type = 0)
{
	$ket = "Pas Poto 3x4 Waktu Masuk Sekolah ini";
	if($type == 1){
		$ket = "Pas Poto 3x4 Waktu Meninggalkan Sekolah ini";
	}
	$html = '<table border="1" width="75px" class="poto1">';
	$html .= '	<tr>';
	$html .= '		<td height="95px" align="center" >';
	$html .= 			$ket;
	$html .= '		</td>';
	$html .= '	</tr>';
	$html .= '</table>';
	return $html;
}
function induk_set_titik_v1($value="")
{
	$html = ': '.$value;
	if($value == ""){
		$html = '	: ..............';
	}
	return $html;
}

function induk_view_tabel_v1() {
	
	$html =' 	<table class="t-field1a">';
	$html .=' 		<tr>';
	$html .=' 			<td>';
								$set_array_a = induk_view_data1a_v1();
	$html .= 					induk_table_v1($set_array_a);
								$set_array_b = induk_view_data1b_v1();
	$html .= 					induk_table_v1($set_array_b);
								$set_array_c = induk_view_data1c_v1();
	$html .= 					induk_table_v1($set_array_c);
								$set_array_d = induk_view_data1d_v1();
	$html .= 					induk_table_v1($set_array_d);
	$html .=' 			</td>';
	$html .=' 			<td>';
								$set_array_e = induk_view_data1e_v1();
	$html .= 					induk_table_v1($set_array_e);
								$set_array_f = induk_view_data1f_v1();
	$html .= 					induk_table_v1($set_array_f);
								$set_array_g = induk_view_data1g_v1();
	$html .= 					induk_table_v1($set_array_g);
								$set_array_h = induk_view_data1h_v1();
	$html .= 					induk_table_v1($set_array_h);
	$html .=' 			</td>';
	$html .=' 			<td>';
								$set_array_i = induk_view_data1i_v1();
	$html .= 					induk_table_v1($set_array_i);
								$set_array_j = induk_view_data1j_v1();
	$html .= 					induk_table_v1($set_array_j);
	
	$html .=' 					<br>';
	$html .= 					induk_poto_v1();
	$html .=' 			</td>';
	$html .=' 		</tr>';
	$html .=' 	</table>';
	
	return $html;
}

function induk_set_child1_v1($data,$type = 0)
{
	$margin = "";
	if($type != 0){
		$margin = "t-field1_left".$type;
	}
	$html = '';
		if(isset($data['child'])){
			$html .=' 			<td class="t-field1_1 '.$margin.'" colspan="2">';
		}else{
			$html .=' 			<td class="t-field1_2a '.$margin.'">';
		}
			$html .= 				$data['label'];
			$html .=' 			</td>';
		
	return $html;
}
function induk_set_child1_v2($data)
{
	$html = '';
		if(isset($data['child'])){
			$html .=' 			<td class="t-field1_1 ">';
		}else{
			$html .=' 			<td class="t-field1_2a">';
		}
			$html .= 				$data['label'];
			$html .=' 			</td>';
		
	return $html;
}
function induk_set_child2_v1($data)
{
	$html =' 			<td class="t-field1_2b">';
	$html .= 				induk_set_titik_v1(isset($data['value']));
	$html .=' 			</td>';
		
	return $html;
}
function induk_table_v1($arrays)
{
	
	$html =' 	<table class="t-field1a" >';
	foreach ($arrays as $key1 => $value1)
	{
		$abre1 = $arrays[$key1];
		$set_nbsp = '';
		$html .=' 		<tr>';
		$html .=  		induk_set_child1_v1($abre1);
		
		if(isset($abre1['child']))
			{
				foreach ($abre1['child'] as $key2 => $value2)
				{
					$abre2 = $abre1['child'][$key2];
					$html .=' 		</tr>';
					$html .=' 		<tr>';
					$html .=  			induk_set_child1_v1($abre2,1);
					if(isset($abre2['child']))
					{
						
						foreach ($abre2['child'] as $key3 => $value3)
						{
							$abre3 = $abre2['child'][$key3];
							$html .=' 		</tr>';
							$html .=' 		<tr>';
							$html .=  			induk_set_child1_v1($abre3,2);
							//if(!isset($abre2['child']))
							//{
								$html .=  			induk_set_child2_v1($abre3);
							//}
						}
						
					}
					else
					{
						$html .=  			induk_set_child2_v1($abre2);
					}
				}
			}
		else
			{
				$html .=  			induk_set_child2_v1($abre1);
			}
		
		
		$html .=' 		</tr>';
	}
	$html .=' 	</table>';

	return $html;
}

function induk_view_tabel_v2($row, $resultset, $ekskul_result, $nilai_siswa) {
	
	
	$html =' 	<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">';
	
	$html .=' 		
					<tr>
						<th width="5%" rowspan="6"></th>
						<th width="34%" >Tahun Pelajaran</th>
						<th colspan="12">'.strtoupper($row["ta_nama"]).'</th>
					<tr/>
	';
	$html .=' 		
					<tr>
						<th >Kelas</th>
						<th colspan="12">'.$row["kelas_nama"].'</th>
					<tr/>
	';
	$html .=' 		
					<tr>
						<th >Semester</th>
						<th colspan="5" align="center"> 1(satu) </th>
						<th width="11%" rowspan="4">Kriteria Ketuntas -an Minimal (KKM)</th>
						<th colspan="5" align="center"> 2(dua) </th>
						<th width="11%" rowspan="4">Kriteria Ketuntas -an Minimal (KKM)</th>
					<tr/>
	';
	
	$html .=' 		
					<tr> 
						<th rowspan="3">Komponen</th>
						<th colspan="5">Nilai Hasil Belajar</th>
						<th colspan="5">Nilai Hasil Belajar</th>
					</tr>
	';
	
	$html .=' 		
					 <tr>
						<th colspan="2">Pengetahuan</th>
						<th colspan="2">Praktek</th>
						<th width="11%">Sikap</th>
						
						<th colspan="2">Pengetahuan</th>
						<th colspan="2">Praktek</th>
						<th width="11%">Sikap</th>
					 </tr>
	';
	$html .=' 		
					<tr>
						<th width="7%">Angka</th>
						<th width="10%">Huruf</th>
						<th width="7%">Angka</th>
						<th width="10%">Huruf</th>
						<th>Predikat</th>
						
						<th width="7%">Angka</th>
						<th width="10%">Huruf</th>
						<th width="7%">Angka</th>
						<th width="10%">Huruf</th>
						<th>Predikat</th>
					</tr>
	';
	$html .=' 		
					<tr>
						<td align="center" valign="middle"><div align="center" class="style6"><strong>A</strong></div></td>
						<td valign="middle"><div align="center" class="style6"><strong>Mata Pelajaran </strong></div></td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
						<td valign="middle" align="center">&nbsp;</td>
					</tr>
	';
	//$html .= print_r();
	$mapel1		= '';
	$mapel		= '';
	
	if(array_key_exists(1,$resultset))
	{	
		$mapel 		= $resultset[1]['data'];
		foreach ($resultset[1]['data'] as $idx => $item)
		{
			$nilai[1][$item['mapel_id']] =$item;
		}
	}
	if(array_key_exists(2,$resultset))
	{	
		if($mapel=='')
		{	$mapel 		= $resultset[2]['data'];	}
	
		foreach ($resultset[2]['data'] as $idx => $item)
		{
			$nilai[2][$item['mapel_id']] =$item;
		}
	}
	
	//$html.= print_r($resultset);
	
	foreach ($mapel as $idx => $item): 
		$set_no = $idx+1;
	
	$html .=' 		
					<tr>
						<td align="center" valign="middle"><div align="center" class="style6"><strong>'.$set_no.'</strong></div></td>
						<td valign="middle"><div align="center" class="style6"><strong>'.$item['mapel_nama'].' </strong></div></td>
						<td valign="middle" align="center">';
	
					if (is_null($nilai[1][$item['mapel_id']]['nas_teori']) or !is_numeric($nilai[1][$item['mapel_id']]['nas_teori']) ) {
	$html.='			-';
					} else {
	$html.=				($nilai[1][$item['mapel_id']]['nas_teori']) ? round($nilai[1][$item['mapel_id']]['nas_teori']) : '';
					}	
					
	$html.=				'</td>
						<td valign="middle" align="center">';
						if (is_null($nilai[1][$item['mapel_id']]['nas_teori']) or !is_numeric($nilai[1][$item['mapel_id']]['nas_teori']) ) {
	$html.=	'			-';
					} else {
						
	$html.=	'				'.int2kata(substr(round($nilai[1][$item['mapel_id']]["nas_teori"]),0,1)).' '
							.int2kata(substr(round($nilai[1][$item['mapel_id']]["nas_teori"]),1,1)).' ' 
							.int2kata(substr(round($nilai[1][$item['mapel_id']]["nas_teori"]),2,1)).' ';
					}
	$html.=				'</td>
						<td valign="middle" align="center">';
						
						if ($nilai[1][$item['mapel_id']]['nas_praktek']==0 or is_null($nilai[1][$item['mapel_id']]['nas_praktek']) or !is_numeric($nilai[1][$item['mapel_id']]['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=				($nilai[1][$item['mapel_id']]['nas_praktek']) ? round($nilai[1][$item['mapel_id']]['nas_praktek']) : '-';
					}
	$html.=	'			</td>
						<td valign="middle" align="center">';
						if ($nilai[1][$item['mapel_id']]['nas_praktek']==0 or is_null($nilai[1][$item['mapel_id']]['nas_praktek']) or !is_numeric($nilai[1][$item['mapel_id']]['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=	'				'.int2kata(substr(round($nilai[1][$item['mapel_id']]["nas_praktek"]),0,1)).' '
							.int2kata(substr(round($nilai[1][$item['mapel_id']]["nas_praktek"]),1,1)).' ' 
							.int2kata(substr(round($nilai[1][$item['mapel_id']]["nas_praktek"]),2,1)).' ';
					}
	
	$html.=	'			</td>
						<td valign="middle" align="center">'.int2huruf($nilai[1][$item['mapel_id']]['nas_sikap']).'</td>
						<td valign="middle" align="center">'.round($nilai[1][$item['mapel_id']]['nipel_kkm']).'</td>
						
						
						
						<td valign="middle" align="center">';
	if(isset($nilai[2][$item['mapel_id']])){
					if (is_null($nilai[2][$item['mapel_id']]['nas_teori']) or !is_numeric($nilai[2][$item['mapel_id']]['nas_teori']) ) {
	$html.='			-';
					} else {
	$html.=				($nilai[2][$item['mapel_id']]['nas_teori']) ? round($nilai[2][$item['mapel_id']]['nas_teori']) : '';
					}	
	}
					
	$html.=				'</td>
						<td valign="middle" align="center">';
	
	if(isset($nilai[2][$item['mapel_id']])){					
						if (is_null($nilai[2][$item['mapel_id']]['nas_teori']) or !is_numeric($nilai[2][$item['mapel_id']]['nas_teori']) ) {
	$html.=	'			-';
					} else {
						
	$html.=	'				'.int2kata(substr(round($nilai[2][$item['mapel_id']]["nas_teori"]),0,1)).' '
							.int2kata(substr(round($nilai[2][$item['mapel_id']]["nas_teori"]),1,1)).' ' 
							.int2kata(substr(round($nilai[2][$item['mapel_id']]["nas_teori"]),2,1)).' ';
					}
	}
	$html.=				'</td>
						<td valign="middle" align="center">';
	
	if(isset($nilai[2][$item['mapel_id']])){						
						if ($nilai[2][$item['mapel_id']]['nas_praktek']==0 or is_null($nilai[2][$item['mapel_id']]['nas_praktek']) or !is_numeric($nilai[2][$item['mapel_id']]['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=				($nilai[2][$item['mapel_id']]['nas_praktek']) ? round($nilai[2][$item['mapel_id']]['nas_praktek']) : '-';
					}
	}
	$html.=	'			</td>
						<td valign="middle" align="center">';
	
	if(isset($nilai[2][$item['mapel_id']])){	
						if ($nilai[2][$item['mapel_id']]['nas_praktek']==0 or is_null($nilai[2][$item['mapel_id']]['nas_praktek']) or !is_numeric($nilai[2][$item['mapel_id']]['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=	'				'.int2kata(substr(round($nilai[2][$item['mapel_id']]["nas_praktek"]),0,1)).' '
							.int2kata(substr(round($nilai[2][$item['mapel_id']]["nas_praktek"]),1,1)).' ' 
							.int2kata(substr(round($nilai[2][$item['mapel_id']]["nas_praktek"]),2,1)).' ';
					}
	}
	
	
	$html.=	'			</td>
						<td valign="middle" align="center">';
	if(isset($nilai[2][$item['mapel_id']])){	
						$html.=	 int2huruf($nilai[2][$item['mapel_id']]['nas_sikap']);
	}
	$html.=	'			</td>
						<td valign="middle" align="center">';
	if(isset($nilai[2][$item['mapel_id']])){	
						$html.=	round($nilai[2][$item['mapel_id']]['nipel_kkm']);
	}
	$html.=	'			</td>
					</tr>
				';
			
		endforeach;
	

	$set_min = '	<tr>';
	for ($x = 1; $x <= 2; $x++) {
		$set_min .= '		<td valign="middle" align="center">-</td>';
	}	
	for ($x = 1; $x <= 2; $x++) {
		$set_min .= '		<td colspan="6" valign="middle" align="center">-</td>';
	}
	$set_min .= '	</tr>';	


	$html .=' 		
					<tr>
						<td align="center" valign="middle"><span class="style6"><strong>A</strong></span></td>
						<td valign="middle"><span class="style6"><strong>Pengembangan Diri / Kegiatan Extrakurikuler </strong></span></td>
						<td colspan="6" valign="middle" align="center"><span class="style6"><strong>Nilai</strong></span></td>
						<td colspan="6" valign="middle" align="center"><span class="style6"><strong>Nilai</strong></span></td>
					</tr>
	';
	
	if(array_key_exists(1,$ekskul_result))
	{	
		foreach ($ekskul_result[1]['data'] as $idx => $item)
		{
			$ekskul[$item['ekskul_id']] 		 = $item;
			$nilai_ekskul[1][$item['ekskul_id']] = $item;
		}
	}
	if(array_key_exists(2,$ekskul_result))
	{	
		foreach ($ekskul_result[2]['data'] as $idx => $item)
		{
			$ekskul[$item['ekskul_id']] 		 = $item;
			$nilai_ekskul[2][$item['ekskul_id']] = $item;
		}
	}
	
	$jml=0;
	foreach($ekskul as $item)
	{
		$jml++;
		if(!isset($nilai_ekskul[1][$item['ekskul_id']]))
		{	$nilai_ekskul[1][$item['ekskul_id']]['nilai'] = '-';	}
		if(!isset($nilai_ekskul[2][$item['ekskul_id']]))
		{	$nilai_ekskul[2][$item['ekskul_id']]['nilai'] = '-';	}
		
		$html .=' 		
				<tr>
					<td align="center" valign="middle"><span class="style6"><strong>'.$jml.'</strong></span></td>
					<td valign="middle"><span class="style6"><strong> '.$item['ekskul_nama'].'</strong></span></td>
					<td colspan="6" valign="middle" align="center"> '.$nilai_ekskul[1][$item['ekskul_id']]['nilai'].'</td>
					<td colspan="6" valign="middle" align="center"> '.$nilai_ekskul[2][$item['ekskul_id']]['nilai'].'</td>
				</tr>
		';
	}

	while($jml <3)
	{
		$jml++;
		$html .=' 		
				<tr>
					<td align="center" valign="middle"><span class="style6"><strong>- </strong></span></td>
					<td valign="middle"><span class="style6"><strong> - </strong></span></td>
					<td colspan="6" valign="middle" align="center"> - </td>
					<td colspan="6" valign="middle" align="center"> - </td>
				</tr>
		';
	}

	$html .=' 		
					<tr>
						<td align="center" valign="middle"><span class="style6"><strong>B</strong></span></td>
						<td valign="middle"><span class="style6"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah  </strong></span></td>
						<td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
						<td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
					</tr>
	';
	
	
	$html .=	$set_min;	
	$html .=	$set_min;	
	$html .=	$set_min;
	
	$html .=' 		
					<tr>
						<td align="center" valign="middle"><span class="style6"></span></td>
						<td valign="middle"><span class="style6"><strong>Bimbingan dan Konseling </strong></span></td>
						<td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
						<td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
					</tr>
	';
	$html .=	$set_min;	
	$html .=	$set_min;	
	$html .=	$set_min;
	
	
	
	//////Ketidakhadiran
	
	for($x=1;$x<=2;$x++)
	{
		if(isset($nilai_siswa[$x])){
			$absen_s[$x] = '-';
			$absen_i[$x] = '-';
			$absen_a[$x] = '-';
			if($nilai_siswa[$x]['absen_s']>0){
				$absen_s[$x] = $nilai_siswa[$x]['absen_s'].' hari';
			}
			if($nilai_siswa[$x]['absen_i']>0){
				$absen_i[$x] = $nilai_siswa[$x]['absen_i'].' hari';
			}
			if($nilai_siswa[$x]['absen_a']>0){
				$absen_a[$x] = $nilai_siswa[$x]['absen_a'].' hari';
			}
		}else{
			$absen_s[$x] = ' - ';
			$absen_i[$x] = ' - ';
			$absen_a[$x] = ' - ';
		}
	}
	
	$html .=' 		
					
					 <tr>
						<th ><span class="style6"></span></th>
						<th ><span class="style6">Ketidakhadiran </span></th>
						<th colspan="6" ><span class="style6">Keterangan</span></th>
						<th colspan="6" ><span class="style6">Keterangan</span></th>
					 </tr>
					 
					 <tr>
						<td align="center" valign="middle"><span class="style6">1</span></td>
						<td valign="middle"><span class="style6">Sakit</span></td>
						<td colspan="6" valign="middle" align="left"><span class="style6"> '.$absen_s[1].'</span></td>
						<td colspan="6" valign="middle" align="left"><span class="style6"> '.$absen_s[2].'</span></td>
					</tr>
					 <tr>
						<td align="center" valign="middle"><span class="style6">2</span></td>
						<td valign="middle"><span class="style6">Izin</span></td>
						<td colspan="6" valign="middle" align="left"><span class="style6"> '.$absen_i[1].'</span></td>
						<td colspan="6" valign="middle" align="left"><span class="style6"> '.$absen_i[2].'</span></td>
					</tr>
					 <tr>
						<td align="center" valign="middle"><span class="style6">3</span></td>
						<td valign="middle"><span class="style6">Tanpa Keterangan </span></td>
						<td colspan="6" valign="middle" align="left"><span class="style6"> '.$absen_a[1].'</span></td>
						<td colspan="6" valign="middle" align="left"><span class="style6"> '.$absen_a[2].'</span></td>
					</tr>
	';
	
	$html .=	'
					<tr>
						<td align="center" valign="middle"><span class="style6"><strong></strong></span></td>
						<td valign="middle"				rowspan="2"><span class="style6"><strong>Status Akhir Tahun </strong></span></td>
						<td colspan="6" valign="middle"	rowspan="2"><span class="style6"></td>
						<td colspan="6" valign="middle"	rowspan="2"><span class="style6">
							Nama Wali Kelas : '.$row['wali_nama'].'
							<br/>Tanda Tangan &nbsp;&nbsp;&nbsp;&nbsp;:</span>
						</td>
					</tr>
	';
	$html .='  </table> 	
	
	';
	
	return $html;
}


function induk_view_deskripsi_v1($row, $resultset) {
	
	if(array_key_exists(1,$resultset))
	{	
		$mapel 		= $resultset[1]['data'];
		foreach ($resultset[1]['data'] as $idx => $item)
		{
			$nilai[1][$item['mapel_id']] =$item;
		}
	}
	if(array_key_exists(2,$resultset))
	{	
		if($mapel=='')
		{	$mapel 		= $resultset[2]['data'];	}
	
		foreach ($resultset[2]['data'] as $idx => $item)
		{
			$nilai[2][$item['mapel_id']] =$item;
		}
	}
	
	$html ='  <table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">';
	
	$html .='  
				<tr>
				
					<th colspan="2" width="30%">Kelas</th>
					<th colspan="2">'.$row['kelas_nama'].'</th>
				</tr>
	';
	$html .='  
				<tr>
				
					<td align="center" colspan="2" valign="middle" width="26%"><strong>Semester</strong></td>
					<td align="center" valign="middle" width="37%"><strong>1 (SATU)</strong></td>
					<td align="center" valign="middle" width="37%"><strong>2 (DUA)</strong></td>
				</tr>
	';
	$html .='  
				<tr>
					<td align="center" valign="middle"><strong>A</strong></td>
					<td valign="middle"><strong>Mata Pelajaran </strong></td>
					<td valign="middle" align="center" colspan="2">&nbsp;</td>
				</tr>
	';
	
	foreach ($mapel as $idx => $item): 
		$set_no = $idx+1;
		
	$html .='  
  
				<tr>
					<td align="center" valign="middle">'.$set_no.'</td>
					<td valign="middle">'.$item['mapel_nama'].'</td>
					<td valign="middle" align="center">'.$nilai[1][$item['mapel_id']]['kompetensi'].'</td>
					<td valign="middle" align="center">';
					if(isset($nilai[2][$item['mapel_id']])){
						$html .= $nilai[2][$item['mapel_id']]['kompetensi'];
					}
	$html .=' 		</td>
				</tr>
	';
	endforeach;
  
	$html .='  </table> 	
	';
	return $html;
}

function induk_view_kepribadian_v1_terbang($row)
{
	$aspek_array = array(
			'kedisiplinan'	 => 'Kedisiplinan',
			'kebersihan'	 => 'Kebersihan',
			'kesehatan'		 => 'Kesehatan',
			'tgjawab'		 => 'Tanggung Jawab',
			'kesopanan'		 => 'Sopan Santun',
			'percayadiri'	 => 'Percaya Diri',
			'kompetitif'	 => 'Kompetitif',
			'sosial'		 => 'Hubungan Sosial',
			'kejujuran'		 => 'Kejujuran',
			'ritualibadah'	 => 'Ibadah',
		);
		
	$kepribadian[1] = (array) json_decode($row[1]['kepribadian'], TRUE);
	if(isset($row[2])){	
		$kepribadian[2] = (array) json_decode($row[2]['kepribadian'], TRUE);
	}
	$html =' 	<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">';
	$html .=' 		
				<tr>
					<th width="2%" rowspan="2"><span class="style4">No</span></th>
					<th width="28%" rowspan="2"><span class="style4">Aspek Yang Dinilai  </span></th>
					<th width="35%"><span class="style4">Semester 1</span></th>
					<th width="35%"><span class="style4">Semester 2</span></th>
				</tr>
				<tr>
					<td align="center"><span class="style4"><strong>Keterangan</strong></span></td>
					<td align="center"><span class="style4"><strong>Keterangan</strong></span></td>
				</tr>
	';
	
	$no_aspek= 0;
	
	foreach ($aspek_array as $idx => $label):
		$no_aspek++;
		
		$html .=' 		
				<tr>
					<td valign="middle" align="center"><span class="style4">' .$no_aspek. '</span></td>
					<td valign="middle"><span class="style4">' . $label . '</span></td>
					<td valign="middle"><span class="style4">'.array_node($kepribadian[1], $idx) .'</span></td>
					<td valign="middle"><span class="style4">';
					if(isset($row[2])){
						$html .= array_node($kepribadian[2], $idx) ;
					}
		$html .=		'</span></td>
				</tr>
		';
	endforeach;
		
	$html.='
		</table>
		';
	return $html;
}

function induk_view_kepribadian_v1($row){
	$set_kepri = array(
		/*'Kedisiplinan',
		'Kebersihan',
		'Kerja sama',
		'Kesopanan',
		'Kemandirian',
		'Kerajinan',
		'Kejujuran',
		'Kepemimpinan',
		'Ketaatan',
		'kedisiplinan'	 => 'Kedisiplinan',*/
		
		'kedisiplinan'	 => 'Kedisiplinan',
		'kebersihan'	 => 'Kebersihan',
		'kesehatan'		 => 'Kesehatan',
		'tgjawab'		 => 'Tanggung Jawab',
		'kesopanan'		 => 'Sopan Santun',
		'percayadiri'	 => 'Percaya Diri',
		'kompetitif'	 => 'Kompetitif',
		'sosial'		 => 'Hubungan Sosial',
		'kejujuran'		 => 'Kejujuran',
		'ritualibadah'	 => 'Pelaksanaan Ibadah Ritual',
	);
	$kepribadian[1] = (array) json_decode($row[1]['kepribadian'], TRUE);
	if(isset($row[2])){	
		$kepribadian[2] = (array) json_decode($row[2]['kepribadian'], TRUE);
		//print_r($kepribadian[2]);
	}
	$html =' 	<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">';
	$html .=' 		
				<tr>
					<th width="4%" rowspan="2"><span class="style4">No</span></th>
					<th  rowspan="2"><span class="style4">Aspek Yang Dinilai  </span></th>
					<th width="38%"><span class="style4">Semester 1</span></th>
					<th width="38%"><span class="style4">Semester 2</span></th>
				</tr>
				<tr>
					<td align="center"><span class="style4"><strong>Keterangan</strong></span></td>
					<td align="center"><span class="style4"><strong>Keterangan</strong></span></td>
				</tr>
	';
	$set_no=0;
	foreach ($set_kepri as $idx => $kepri):
	$set_no++;
		$html .=' 		
				<tr>
					<td valign="middle" align="center"><span class="style4">' .$set_no. '</span></td>
					<td valign="middle"><span class="style4">' . $kepri . '</span></td>
					<td valign="middle"><span class="style4">'.array_node($kepribadian[1], $idx) .'</span></td>
					<td valign="middle"><span class="style4">';
					if(isset($row[2])){
						$html .= array_node($kepribadian[2], $idx) ;
					}
		$html .=		'</span></td>
				</tr>
		';
	endforeach;
	$html .=' 	</table>';
	return $html;
}
function induk_view_catatan_wali_v1($row)
{
	$html =' 	
		<b>CATATAN WALI KELAS</b>
		<br/>
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
		  <tr><td height="140" align="left" valign="top">
			<table>
			 <tr>
			  <td align="left" valign="top"><b>Semester 1 :</b></td>
			  <td align="left" valign="top"> '.$row[1]['note_walikelas'].'</td>
			 </tr>
			 <tr>
			  <td align="left" valign="top"><b>Semester 2 :</b></td>
			  <td align="left" valign="top"> ';
			  if(isset($row[2])){
				$html .= $row[2]['note_walikelas'];
			  }
	$html .=	'</td>
			 </tr>
			</table>
		  </td></tr>
		</table>  
	';
	return $html;
}

function induk_set_profil_v1()
{
	$html =' 	<table class="t-field1_1">';
	$html .=' 		<tr>';
	$html .=' 			<td>';
	$html .=' 				Bidang Keahlian';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 				Teknologi Pesawat Udara';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 				Nama';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .= 				induk_set_titik_v1();
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 				STTB Th';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .= 				induk_set_titik_v1();
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 				SKHUN Th';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .= 				induk_set_titik_v1();
	$html .=' 			</td>';
	$html .=' 		</tr>';
	$html .=' 		<tr>';
	$html .=' 			<td>';
	$html .=' 				Prog. Keahlian';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 				Kelistrikan Pesawat Udara';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .= 				induk_set_titik_v1();
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 				No';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .= 				induk_set_titik_v1();
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 			</td>';
	$html .=' 		</tr>';
	$html .=' 		<tr>';
	$html .=' 			<td>';
	$html .=' 				Kelas';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .= 				induk_set_titik_v1();
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 				NO. ABSEN';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .= 				induk_set_titik_v1();
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 			</td>';
	$html .=' 		</tr>';
	$html .=' 	</table>';
		
	return $html;
}
function induk_set_table_nilai_v1()
{
	$setarray = array( 1 =>'Nilai','Pebaikan','Tanggal');
	$html =' 	<table border="1" class="t-field1b">';
	$html .=' 		<tr>';
	$html .=' 			<td rowspan="2">';
	$html .=' 				Tingkat';
	$html .=' 			</td>';
	$html .=' 			<td rowspan="2" colspan="2">';
	$html .=' 				Semester';
	$html .=' 			</td>';
	$html .=' 			<td colspan="5">';
	$html .=' 				NORMATIP';
	$html .=' 			</td>';
	$html .=' 			<td colspan="8">';
	$html .=' 				ADAPTIP';
	$html .=' 			</td>';
	$html .=' 			<td colspan="16">';
	$html .=' 				PRODUKTIP';
	$html .=' 			</td>';
	$html .=' 			<td rowspan="2">';
	$html .=' 				JUMLAH';
	$html .=' 			</td>';
	$html .=' 			<td rowspan="2">';
	$html .=' 				PERINGKAT';
	$html .=' 			</td>';
	$html .=' 			<td colspan="4">';
	$html .=' 				KEPRIBADIAN';
	$html .=' 			</td>';
	$html .=' 			<td colspan="3">';
	$html .=' 				ABSENSI';
	$html .=' 			</td>';
	$html .=' 			<td colspan="3">';
	$html .=' 				KEGIATAN KHUSUS';
	$html .=' 			</td>';
	$html .=' 			<td colspan="2">';
	$html .=' 				OUT';
	$html .=' 			</td>';
	$html .=' 			<td rowspan="2">';
	$html .=' 				KETERANGAN';
	$html .=' 			</td>';
	$html .=' 		</tr>';
	$html .=' 		<tr>';
	for ($i = 1; $i <= 29; $i++) {
		$html .=' 			<td>';
		$html .=' 				mp '.$i;
		$html .=' 			</td>';
	}
	for ($i = 1; $i <= 4; $i++) {
		$html .=' 			<td>';
		$html .=' 				kepribadian '.$i;
		$html .=' 			</td>';
	}
	for ($i = 1; $i <= 3; $i++) {
		$html .=' 			<td>';
		$html .=' 				absen '.$i;
		$html .=' 			</td>';
	}
	for ($i = 1; $i <= 3; $i++) {
		$html .=' 			<td>';
		$html .=' 				keg '.$i;
		$html .=' 			</td>';
	}
	for ($i = 1; $i <= 2; $i++) {
		$html .=' 			<td>';
		$html .=' 				out '.$i;
		$html .=' 			</td>';
	}
	$html .=' 		</tr>';
	$html .=' 		<tr>';
	for ($i = 1; $i <= 47; $i++) {
		$html .=' 			<td>';
		$html .= 				$i;
		$html .=' 			</td>';
	}
	$html .=' 		</tr>';
	$no_loop = 0;
	for ($i = 1; $i <= 3; $i++) {
		
		$html .=' 		<tr>';
		$html .=' 			<td rowspan="6">';
		$html .= 				$i;
		$html .=' 			</td>';
		for ($j = 1; $j <= 2; $j++) {
			$no_loop++;
			if($j != 1){
				$html .=' 		<tr>';
			}
			$html .=' 			<td rowspan="3">';
			$html .= 				$j;
			$html .=' 			</td>';
			for ($k = 1; $k <= 3; $k++) {
				if($k != 1){
					$html .=' 		<tr>';
				}
				$html .=' 			<td>';
				$html .= 				$setarray[$k];
				$html .=' 			</td>';
				for ($l = 1; $l <= 43; $l++) {	
					$html .=' 			<td>';
					$html .=' 			</td>';
				}
				if($k == 1){
					if(($no_loop <= 4)&&($j == 1)){
						$html .=' 			<td rowspan="6">';
						$html .=' 				Naik / Tidak Naik';
						$html .=' 			</td>';
					}
					if(($no_loop >= 5)&&($j == 1)){
						$html .=' 			<td rowspan="3">';
						$html .=' 				Naik / Tidak Naik';
						$html .=' 			</td>';
					}
					if(($no_loop >= 5)&&($j == 2)){
						$html .=' 			<td rowspan="3">';
						$html .=' 				L / TL';
						$html .=' 			</td>';
					}
				}
				$html .=' 		</tr>';
			}
			$html .=' 		</tr>';
		}
		$html .=' 		</tr>';
	}
	/////// 4
	$html .=' 		<tr>';
	$html .=' 			<td colspan="3">';
	$html .=' 				KKM';
	$html .=' 			</td>';
	$html .=' 			<td colspan="5">';
	$html .=' 			</td>';
	$html .=' 			<td colspan="8">';
	$html .=' 			</td>';
	$html .=' 			<td colspan="16">';
	$html .=' 			</td>';
	$html .=' 			<td colspan="2">';
	$html .=' 			</td>';
	$html .=' 			<td colspan="4">';
	$html .=' 			</td>';
	$html .=' 			<td colspan="3">';
	$html .=' 			</td>';
	$html .=' 			<td colspan="3">';
	$html .=' 			</td>';
	$html .=' 			<td colspan="2">';
	$html .=' 			</td>';
	$html .=' 			<td colspan="2">';
	$html .=' 			</td>';
	$html .=' 		</tr>';
	/////// 5
	$html .=' 		<tr>';
	$html .=' 			<td rowspan="3">';
	$html .=' 			</td>';
	$html .=' 			<td rowspan="3">';
	$html .=' 			</td>';
	
	$setarray2 = array( 1 =>'PRK/UKK','US','UN');
	for ($i = 1; $i <= 3; $i++) {
		
		if($i != 1){
			$html .=' 			<tr>';
		}
		$html .=' 			<td>';
		$html .= 				$setarray2[$i];
		$html .=' 			</td>';
		for ($j = 1; $j <= 13; $j++) {
			$html .=' 			<td>';
			$html .=' 			</td>';
		}
		$html .=' 			<td colspan="3">';
		$html .=' 			</td>';
		$html .=' 		</tr>';
	}
	//////
	$html .=' 	</table>';
		
	return $html;
}

function induk_set_table_bea_v1()
{
	$html =' 	<table border="1" class="t-field1c">';
	$html .=' 		<tr>';
	$html .=' 			<td colspan="4">';
	$html .=' 				BEASISWA DARI';
	$html .=' 			</td>';
	$html .=' 			<td>';
	$html .=' 				SEMESTER';
	$html .=' 			</td>';
	$html .=' 		</tr>';
	for ($i = 1; $i <= 3; $i++) {
		$html .=' 		<tr>';
		$html .=' 			<td>';
		$html .= 				$i .'. ';
		$html .=' 			</td>';
		$html .=' 			<td>';
		$html .=' 				.............................';
		$html .=' 			</td>';
		$html .=' 			<td width="30px">';
		$html .=' 			</td>';
		$html .=' 			<td width="30px">';
		$html .=' 			</td>';
		$html .=' 			<td>';
		$html .=' 			</td>';
		$html .=' 		</tr>';
		
	}
	$html .=' 	</table>';
		
	return $html;
}