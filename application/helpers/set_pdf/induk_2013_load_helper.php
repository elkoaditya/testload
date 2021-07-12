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

function induk_style_2013_v2()
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
                font-size: 10px;
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
				font-size:12px;
            }

			.field-nilai
            {
				font-size:11px;
                padding: 4px 5px 4px 5px;
            }

            .field-nilai2
            {
				font-size:11px;
                padding: 4px 7px 4px 7px;
            }
			
			.field-keluar
            {
				padding: 8px 5px 8px 5px;
            }
			
            #ttd tr td{
                font-size: 12px;
            }
			.sub-kategori{
                font-size: 12px;
            }
			.color-menu{
				background-color:#FFEEDE;
			}
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
function induk_header1_2013_v2($row)
{/*
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

	return $html;*/
	
	$html = '
		<div id="header_1" class="header">
			<table id="profil-siswa" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">

				<tr>
					<td class="field-header" valign="top" width="20%"><b>Nama Sekolah</b></td>
					<td class="field-header" valign="top" width="2%"><b> : </b></td>
					<td class="field-header" valign="top" width="40%" style="font-size: 12px;">
						<b>' . APP_SCHOOL . '</b>
					</td>

					<td class="field-header" valign="top" width="20%"><b>Kelas</b></td>
					<td class="field-header" valign="top" width="2%"><b> : </b></td>
					<td class="field-header" valign="top" width="16%">
                        <b>' . $row["kelas_nama"] . '</b>
					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Alamat</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . APP_SCHOOL_ADDRESS . '</b>
					</td>
					<td class="field-header" valign="top"><b>Tahun Pelajaran</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . $row["ta_nama"] . '</b>
					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Nama Peserta Didik</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . strtoupper($row["siswa_nama"]) . '</b>
					</td>
					<td valign="top"> </td>
					<td valign="top">   </td>
					<td valign="top">

					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Nomor Induk/NISN</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . $row["siswa_nis"] . ' / ' . $row["siswa_nisn"] . '</b>
					</td>
					<td valign="top"> </td>
					<td valign="top">   </td>
					<td valign="top">

					</td>
				</tr>
			</table><br/>
		</div>';
			
	return $html;
}
function induk_header1_2013_v3($row)
{/*
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

	return $html;*/
	
	$html = '
		<div id="header_1" class="header">
			<table id="profil-siswa" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">

				<tr>
					<td class="field-header" valign="top" width="18%"><b>Nama Sekolah</b></td>
					<td class="field-header" valign="top" width="2%"><b> : </b></td>
					<td class="field-header" valign="top" width="48%" style="font-size: 12px;">
						<b>' . APP_SCHOOL . '</b>
					</td>

					<td class="field-header" valign="top" width="16%"><b>Kelas</b></td>
					<td class="field-header" valign="top" width="2%"><b> : </b></td>
					<td class="field-header" valign="top" >
                        <b>' . $row["kelas_nama"] . '</b>
					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Alamat</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . APP_SCHOOL_ADDRESS . '</b>
					</td>
					<td class="field-header" valign="top"><b>Tahun Pelajaran</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . $row["ta_nama"] . '</b>
					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Nama Peserta Didik</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . strtoupper($row["siswa_nama"]) . '</b>
					</td>
					<td valign="top"> </td>
					<td valign="top">   </td>
					<td valign="top">

					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Nomor Induk/NISN</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . $row["siswa_nis"] . ' / ' . $row["siswa_nisn"] . '</b>
					</td>
					<td valign="top"> </td>
					<td valign="top">   </td>
					<td valign="top">

					</td>
				</tr>
			</table>
		</div>';
			
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


function induk_view_tabel_2013_v2($row, $resultset, $nilai_siswa) {
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
	
	$html =	'
	<table> 
         <tr>
          <td class="sub-kategori"><b>B.</b></td>
          <td class="sub-kategori"><b>Nilai Pengetahuan dan Keterampilan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	<table cellspacing="0" id="t-nilai" class="t-border" >
    
                <tr>
					<td class="thead-1 t-border color-menu" rowspan="3" width="20px"><b>NO</b></td>
					<td class="thead-1 t-border color-menu" rowspan="3" ><b>Mata Pelajaran</b></td>
					<td class="thead-1 t-border color-menu" colspan="5" ><b>Semester 1</b></td>
					<td class="thead-1 t-border color-menu" colspan="5" ><b>Semester 2</b></td>
				</tr>
				<tr>
					<td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
					<td class="thead-1 t-border color-menu" colspan="2"><b>Pengetahuan </b></td>
					<td class="thead-1 t-border color-menu" colspan="2"><b>Keterampilan </b></td>
					
					<td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
					<td class="thead-1 t-border color-menu" colspan="2"><b>Pengetahuan </b></td>
					<td class="thead-1 t-border color-menu" colspan="2"><b>Keterampilan </b></td>
					
				</tr>

				<tr>
					<td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
					<td class=" thead-1 t-border color-menu" ><b>Predikat</b></td>
					<!--<td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>-->
					<td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
					<td class=" thead-1 t-border color-menu" ><b>Predikat</b></td>
					<!--<td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>-->
					
					<td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
					<td class=" thead-1 t-border color-menu" ><b>Predikat</b></td>
					<!--<td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>-->
					<td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
					<td class=" thead-1 t-border color-menu" ><b>Predikat</b></td>
					<!--<td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>-->
					
				</tr>
    
               ';
    
				$ktg_ascii=0;
                $ktg_nama = NULL;
                $antr_mapel = 0;
                foreach ($mapel as $idx => $item)
                {
    
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
    
                        $ktg_ascii++;
                        $mp_no = 0;
    
                        $html .=	 '<tr>' ;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
                            $html .=	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"12\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                            $html .=	"</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"11\"><b>Peminatan {$minat}</b></td>" ;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
                            $html .=	"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"11\"><b>" . $item['kategori_nama'] . "</b></td>";
                        }
                        else if ($ktg_nama != NULL)
                        {
							
                            $html .=	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"12\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                        }
                        else
                        {
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
							$html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
							
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
							$html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
                            
                        }
                        $html .= '</tr>' ;
    
                        $ktg_nama = $item['kategori_nama'];
                    }
    
                    $mp_no++;
    
                    $html .=  '<tr>' ;
                    $html .=  "<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" ;
                    $html .=  "<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" ;
					
					
					/////////////////// SEMESTER 1 /////////////////////
					
					$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".round($nilai[1][$item['mapel_id']]['nipel_kkm'])." </td>" ;
    				
    
                    // PENGETAHUAN /////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_teori'])
                    {
                        
                        if ($nilai[1][$item['mapel_id']]['nas_teori']>0)
                        {
                            $cetak_nas_teori = round($nilai[1][$item['mapel_id']]['nas_teori']);
							
							
							$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_teori ."</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" .  $nilai[1][$item['mapel_id']]['pred_teori'] . "</td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        }
                    }
                    else
                    {
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                    }
					
					
					
    
                    // KETRAMPILAN //////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_praktek'])
                    {
                        
                        if ($nilai[1][$item['mapel_id']]['nas_praktek']>0)
                        {
                            $cetak_nas_praktek = round($nilai[1][$item['mapel_id']]['nas_praktek']);
							
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_praktek . "</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $nilai[1][$item['mapel_id']]['pred_praktek'] . "</td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        }
                    }
                    else
                    {
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                    }
    
                   
    
	
					/////////////////// SEMESTER 2 ////////////////////////////////////////////////////////////////////////////////
					
					$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".round($nilai[2][$item['mapel_id']]['nipel_kkm'])." </td>" ;
    				
    
                    // PENGETAHUAN /////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_teori'])
                    {
                        
                        if ($nilai[2][$item['mapel_id']]['nas_teori']>0)
                        {
                            $cetak_nas_teori = round($nilai[2][$item['mapel_id']]['nas_teori']);
							
							
							
							$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_teori ."</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" .  $nilai[2][$item['mapel_id']]['pred_teori'] . "</td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        }
                    }
                    else
                    {
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                    }
					
					
					
    
                    // KETRAMPILAN //////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_praktek'])
                    {
                        
                        if ($nilai[2][$item['mapel_id']]['nas_praktek']>0)
                        {
                            $cetak_nas_praktek = round($nilai[2][$item['mapel_id']]['nas_praktek']);
							
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_praktek . "</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $nilai[2][$item['mapel_id']]['pred_praktek'] . "</td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        }
                    }
                    else
                    {
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                    }
					
                    $html .=  '</tr>' ;
                    
                }
    
                
    
     $html .=  '        </table>
            
       
		  </td>
         </tr>
      </table>';
	
	return $html;
}

function induk_view_tabel_2013_v2_penerbad($row, $resultset, $nilai_siswa) {
	$mapel1		= '';
	$mapel		= '';
	
	
	//kkm 75
	$range12_kelc = array(
		array("min" => 0  , "max" => 74 , "nilai" => "D"),
		array("min" => 75 , "max" => 82 , "nilai" => "C"),
		array("min" => 83 , "max" => 90 , "nilai" => "B"),
		array("min" => 91 , "max" => 100, "nilai" => "A"),
	);
	
	//kkm 70
	$range10 = array(
		array("min" => 0  , "max" => 69 , "nilai" => "D"),
		array("min" => 70 , "max" => 79 , "nilai" => "C"),
		array("min" => 80 , "max" => 89 , "nilai" => "B"),
		array("min" => 90 , "max" => 100, "nilai" => "A"),
	);
	
	
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
	
	$html =	'
	<table> 
         <tr>
          <td class="sub-kategori"><b>B.</b></td>
          <td class="sub-kategori"><b>Nilai Pengetahuan dan Keterampilan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	<table cellspacing="0" id="t-nilai" class="t-border" >
    
                <tr>
					<td class="thead-1 t-border color-menu" rowspan="3" width="20px"><b>NO</b></td>
					<td class="thead-1 t-border color-menu" rowspan="3" ><b>Mata Pelajaran</b></td>
					<td class="thead-1 t-border color-menu" colspan="5" ><b>Semester 1</b></td>
					<td class="thead-1 t-border color-menu" colspan="5" ><b>Semester 2</b></td>
				</tr>
				<tr>
					<td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
					<td class="thead-1 t-border color-menu" colspan="2"><b>Pengetahuan </b></td>
					<td class="thead-1 t-border color-menu" colspan="2"><b>Keterampilan </b></td>
					
					<td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
					<td class="thead-1 t-border color-menu" colspan="2"><b>Pengetahuan </b></td>
					<td class="thead-1 t-border color-menu" colspan="2"><b>Keterampilan </b></td>
					
				</tr>

				<tr>
					<td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
					<td class=" thead-1 t-border color-menu" ><b>Predikat</b></td>
					<!--<td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>-->
					<td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
					<td class=" thead-1 t-border color-menu" ><b>Predikat</b></td>
					<!--<td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>-->
					
					<td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
					<td class=" thead-1 t-border color-menu" ><b>Predikat</b></td>
					<!--<td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>-->
					<td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
					<td class=" thead-1 t-border color-menu" ><b>Predikat</b></td>
					<!--<td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>-->
					
				</tr>
    
               ';
    
				$ktg_ascii=0;
                $ktg_nama = NULL;
                $antr_mapel = 0;
                foreach ($mapel as $idx => $item)
                {
    
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
    
                        $ktg_ascii++;
                        $mp_no = 0;
    
                        $html .=	 '<tr>' ;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
                            $html .=	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"12\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                            $html .=	"</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"11\"><b>Peminatan {$minat}</b></td>" ;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
                            $html .=	"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"11\"><b>" . $item['kategori_nama'] . "</b></td>";
                        }
                        else if ($ktg_nama != NULL)
                        {
							
                            $html .=	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"12\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                        }
                        else
                        {
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
							$html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
							
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
							$html .= "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .= "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
                            
                        }
                        $html .= '</tr>' ;
    
                        $ktg_nama = $item['kategori_nama'];
                    }
    
                    $mp_no++;
    
                    $html .=  '<tr>' ;
                    $html .=  "<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" ;
                    $html .=  "<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" ;
					
					
					if(($row['semester_id']==6)||($row['semester_id']==7)){
						//// SET PREDIKAT 
						if( (($item['kategori_kode'] == 'KelA')||($item['kategori_kode'] == 'KelB')||
							($item['kategori_kode'] == 'MuatanN')||($item['kategori_kode'] == 'MuatanK')) && 
							(($row['kelas_grade'] == 10)||($row['kelas_grade'] == 11)) ){
							$cetak_kkm = 70;
							$nilai[1][$item['mapel_id']]['nipel_kkm'] = $cetak_kkm;
							
							foreach($range10 as $range_kkm){
								$i=1;
								//while($i<=2){
									
									$nilai[$i][$item['mapel_id']]['nas_teori'] = (int)$nilai[$i][$item['mapel_id']]['nas_teori'];
									if( ($range_kkm['max'] >= $nilai[$i][$item['mapel_id']]['nas_teori']) && ($range_kkm['min'] <= $nilai[$i][$item['mapel_id']]['nas_teori']) ){
										$nilai[$i][$item['mapel_id']]['pred_teori'] = $range_kkm['nilai'];
									}
								
									$nilai[$i][$item['mapel_id']]['nas_praktek'] = (int)$nilai[$i][$item['mapel_id']]['nas_praktek'];
									if( ($range_kkm['max'] >= $nilai[$i][$item['mapel_id']]['nas_praktek']) && ($range_kkm['min'] <= $nilai[$i][$item['mapel_id']]['nas_praktek']) ){
										$nilai[$i][$item['mapel_id']]['pred_praktek'] = $range_kkm['nilai'];
									}
									
									
									$i++;
								//}
							}
						}else{
							
							$cetak_kkm = 75;
							$nilai[1][$item['mapel_id']]['nipel_kkm'] = $cetak_kkm;
							foreach($range12_kelc as $range_kkm){
								$i=1;
								//while($i<=2){
									
									$nilai[$i][$item['mapel_id']]['nas_teori'] = (int)$nilai[$i][$item['mapel_id']]['nas_teori'];
									if( ($range_kkm['max'] >= $nilai[$i][$item['mapel_id']]['nas_teori']) && ($range_kkm['min'] <= $nilai[$i][$item['mapel_id']]['nas_teori']) ){
										$nilai[$i][$item['mapel_id']]['pred_teori'] = $range_kkm['nilai'];
									}
								
									$nilai[$i][$item['mapel_id']]['nas_praktek'] = (int)$nilai[$i][$item['mapel_id']]['nas_praktek'];
									if( ($range_kkm['max'] >= $nilai[$i][$item['mapel_id']]['nas_praktek']) && ($range_kkm['min'] <= $nilai[$i][$item['mapel_id']]['nas_praktek']) ){
										$nilai[$i][$item['mapel_id']]['pred_praktek'] = $range_kkm['nilai'];
									}
									
									
									$i++;
								//}
							}
						}
					}
					
					/////////////////// SEMESTER 1 /////////////////////
					
					$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".round($nilai[1][$item['mapel_id']]['nipel_kkm'])." </td>" ;
    				
    
                    // PENGETAHUAN /////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_teori'])
                    {
                        
                        if ($nilai[1][$item['mapel_id']]['nas_teori']>0)
                        {
                            $cetak_nas_teori = round($nilai[1][$item['mapel_id']]['nas_teori']);
							
							
							$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_teori ."</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" .  $nilai[1][$item['mapel_id']]['pred_teori'] . "</td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        }
                    }
                    else
                    {
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                    }
					
					
					
    
                    // KETRAMPILAN //////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_praktek'])
                    {
                        
                        if ($nilai[1][$item['mapel_id']]['nas_praktek']>0)
                        {
                            $cetak_nas_praktek = round($nilai[1][$item['mapel_id']]['nas_praktek']);
							
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_praktek . "</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $nilai[1][$item['mapel_id']]['pred_praktek'] . "</td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        }
                    }
                    else
                    {
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                    }
    
                   
    
	
					/////////////////// SEMESTER 2 ////////////////////////////////////////////////////////////////////////////////
					
					$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".round($nilai[2][$item['mapel_id']]['nipel_kkm'])." </td>" ;
    				
    
                    // PENGETAHUAN /////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_teori'])
                    {
                        
                        if ($nilai[2][$item['mapel_id']]['nas_teori']>0)
                        {
                            $cetak_nas_teori = round($nilai[2][$item['mapel_id']]['nas_teori']);
							
							
							
							$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_teori ."</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" .  $nilai[2][$item['mapel_id']]['pred_teori'] . "</td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        }
                    }
                    else
                    {
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                    }
					
					
					
    
                    // KETRAMPILAN //////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_praktek'])
                    {
                        
                        if ($nilai[2][$item['mapel_id']]['nas_praktek']>0)
                        {
                            $cetak_nas_praktek = round($nilai[2][$item['mapel_id']]['nas_praktek']);
							
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_praktek . "</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $nilai[2][$item['mapel_id']]['pred_praktek'] . "</td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        }
                    }
                    else
                    {
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                        $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" ;
                    }
					
                    $html .=  '</tr>' ;
                    
                }
    
                
    
     $html .=  '        </table>
            
       
		  </td>
         </tr>
      </table>';
	
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

function induk_view_deskripsi_2013_v1($row, $resultset) {
	
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
	
	$html = '
		<table> 
         <tr>
          <td class="sub-kategori"><b>C.</b></td>
          <td class="sub-kategori"><b>Deskripsi Pengetahuan dan Keterampilan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	<table cellspacing="0" id="t-nilai" class="t-border" >
    
                <tr>
					<td class="thead-1 t-border color-menu" width="20px"><b>NO</b></td>
					<td class="thead-1 t-border color-menu" colspan="2" ><b>Mata Pelajaran</b></td>
					<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 1</b></td>
					<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 2</b></td>
				</tr>';
    
                $ktg_nama = NULL;
                $antr_mapel = 0;
                foreach ($mapel  as $idx => $item)
                {
    
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
    
                        $mp_no = 0;
    
                        $html .=  '<tr>' ;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    						$html .= '   </tr>
                                </table>                                
                              </td>
                            </tr>
      </table>
      </div>
      <div id="bg_deskripsi" class="content page-notend">
    	<style>
            #profil-siswa tr td{
                font-size: 12px;
            }
        </style>

        <div id="header_1" class="header">
			'.induk_header1_2013_v2($row).'
        </div>
      <table>
                            <tr>
                              <td class="sub-kategori" width="20px"></td>
                              <td class="sub-kategori">
                            	<table cellspacing="0" id="t-nilai" class="t-border" >
    							
                				 <tr>
									<td class="thead-1 t-border color-menu" width="20px"><b>NO</b></td>
									<td class="thead-1 t-border color-menu" colspan="2" ><b>Mata Pelajaran</b></td>
									<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 1</b></td>
									<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 2</b></td>
								</tr>
								<tr>';
                                
							
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"5\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                            $html .=  "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"4\"><b>Peminatan {$minat}</b></td>" ;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"4\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                        }
                        else if ($ktg_nama != NULL)
                        {
							
                             $html .=  '        </tr>
                                </table>                                
                              </td>
                            </tr>
      </table>
      </div>
      <div id="bg_deskripsi" class="content page-notend">
    	<style>
            #profil-siswa tr td{
                font-size: 12px;
            }
        </style>

        <div id="header_1" class="header">
			 '.induk_header1_2013_v2($row).'
        </div>
      <table>
                            <tr>
                              <td class="sub-kategori" width="20px"></td>
                              <td class="sub-kategori">
                            	<table cellspacing="0" id="t-nilai" class="t-border" >
    							
                				<tr>
									<td class="thead-1 t-border color-menu" width="20px"><b>NO</b></td>
									<td class="thead-1 t-border color-menu" colspan="2" ><b>Mata Pelajaran</b></td>
									<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 1</b></td>
									<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 2</b></td>
								</tr>
    						<tr>';
                                
							
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"5\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
                            
                        }
                        $html .=  '</tr>' ;
    
                        $ktg_nama = $item['kategori_nama'];
                    }
    
                    $mp_no++;
    
                    $html .=  '<tr>' ;
                    $html .=  "<td class=\"field-nilai t-border\" rowspan=\"2\" align=\"right\" valign=\"top\">{$mp_no}.</td>" ;
                    $html .=  "<td class=\"field-nilai t-border\" rowspan=\"2\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" ;
					
					
					$html .=  "<td class=\"field-nilai t-border\"  valign=\"top\">Pengetahuan<b></td>" ;
			
							
					/////////////////// SEMESTER 1 /////////////////////
					//////// DESKRIPSI PENGETAHUAN //////////////////
					
					if ($nilai[1][$item['mapel_id']]['cat_teori']!=''){
						
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">".$nilai[1][$item['mapel_id']]['cat_teori']."</td>" ;
					
					}
					else
					{
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
					}
					
	
					/////////////////// SEMESTER 2 ////////////////////////////////////////////////////////////////////////////////
					//////// DESKRIPSI PENGETAHUAN //////////////////
					if ($nilai[2][$item['mapel_id']]['cat_teori']!=''){
						
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">".$nilai[2][$item['mapel_id']]['cat_teori']."</td>" ;
					
					}
					else
					{
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
					}
					
                    
    
					$html .=  "</tr><tr>";
					$html .=  "<td class=\"field-nilai t-border\"  valign=\"top\">Keterampilan<b></td>" ;
					/////////////////// SEMESTER 1 /////////////////////
                    //////// DESKRIPSI KETRAMPILAN //////////////////
				    if ($nilai[1][$item['mapel_id']]['cat_praktek']!=''){
						
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">".$nilai[1][$item['mapel_id']]['cat_praktek']."</td>" ;
					
					}
					else
					{
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
					}

    
	
					/////////////////// SEMESTER 2 ////////////////////////////////////////////////////////////////////////////////
					 //////// DESKRIPSI KETRAMPILAN //////////////////
				     if ($nilai[2][$item['mapel_id']]['cat_praktek']!=''){
						
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">".$nilai[2][$item['mapel_id']]['cat_praktek']."</td>" ;
					
					}
					else
					{
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
					}
                    $html .=  '</tr>' ;
                    
                }
               
    
    $html .= '         </table>';
    $html .= '   
		  </td>
         </tr>
      </table>';
	 
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

function induk_view_deskripsi_2013_v2($row, $resultset, $deskripsi_pelajaran) {
	
	//kkm 75
	$range12_kelc = array(
		array("min" => 0  , "max" => 74 , "nilai" => "D"),
		array("min" => 75 , "max" => 82 , "nilai" => "C"),
		array("min" => 83 , "max" => 90 , "nilai" => "B"),
		array("min" => 91 , "max" => 100, "nilai" => "A"),
	);
	
	//kkm 70
	$range10 = array(
		array("min" => 0  , "max" => 69 , "nilai" => "D"),
		array("min" => 70 , "max" => 79 , "nilai" => "C"),
		array("min" => 80 , "max" => 89 , "nilai" => "B"),
		array("min" => 90 , "max" => 100, "nilai" => "A"),
	);
	
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
	
	$html = '
		<table> 
         <tr>
          <td class="sub-kategori"><b>C.</b></td>
          <td class="sub-kategori"><b>Deskripsi Pengetahuan dan Keterampilan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	<table cellspacing="0" id="t-nilai" class="t-border" >
    
                <tr>
					<td class="thead-1 t-border color-menu" width="20px"><b>NO</b></td>
					<td class="thead-1 t-border color-menu" colspan="2" ><b>Mata Pelajaran</b></td>
					<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 1</b></td>
					<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 2</b></td>
				</tr>';
    
                $ktg_nama = NULL;
                $antr_mapel = 0;
                foreach ($mapel  as $idx => $item)
                {
    
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
    
                        $mp_no = 0;
    
                        $html .=  '<tr>' ;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    						$html .= '   </tr>
                                </table>                                
                              </td>
                            </tr>
      </table>
      </div>
      <div id="bg_deskripsi" class="content page-notend">
    	<style>
            #profil-siswa tr td{
                font-size: 12px;
            }
        </style>

        <div id="header_1" class="header">
			'.induk_header1_2013_v3($row).'
        </div>
      <table>
                            <tr>
                              <td class="sub-kategori" width="20px"></td>
                              <td class="sub-kategori">
                            	<table cellspacing="0" id="t-nilai" class="t-border" >
    							
                				 <tr>
									<td class="thead-1 t-border color-menu" width="20px"><b>NO</b></td>
									<td class="thead-1 t-border color-menu" colspan="2" ><b>Mata Pelajaran</b></td>
									<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 1</b></td>
									<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 2</b></td>
								</tr>
								<tr>';
                                
							
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"5\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                            $html .=  "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"4\"><b>Peminatan {$minat}</b></td>" ;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"4\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                        }
                        else if ($ktg_nama != NULL)
                        {
							
                             $html .=  '        </tr>
                                </table>                                
                              </td>
                            </tr>
      </table>
      </div>
      <div id="bg_deskripsi" class="content page-notend">
    	<style>
            #profil-siswa tr td{
                font-size: 12px;
            }
        </style>

        <div id="header_1" class="header">
			 '.induk_header1_2013_v3($row).'
        </div>
      <table>
                            <tr>
                              <td class="sub-kategori" width="20px"></td>
                              <td class="sub-kategori">
                            	<table cellspacing="0" id="t-nilai" class="t-border" >
    							
                				<tr>
									<td class="thead-1 t-border color-menu" width="20px"><b>NO</b></td>
									<td class="thead-1 t-border color-menu" colspan="2" ><b>Mata Pelajaran</b></td>
									<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 1</b></td>
									<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 2</b></td>
								</tr>
    						<tr>';
                                
							
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"5\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                        }
                        else
                        {
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>" . $item['kategori_nama'] . "</b></td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" ;
                            $html .=  "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" ;
                            
                        }
                        $html .=  '</tr>' ;
    
                        $ktg_nama = $item['kategori_nama'];
                    }
					
					if ( (($mp_no%2) == 0)&&($mp_no>1) )
					{
						
						 $html .=  '        </tr>
							</table>                                
						  </td>
						</tr>
  </table>
  </div>
  <div id="bg_deskripsi" class="content page-notend">
	<style>
		#profil-siswa tr td{
			font-size: 12px;
		}
	</style>

	<div id="header_1" class="header">
		 '.induk_header1_2013_v3($row).'
	</div>
  <table>
						<tr>
						  <td class="sub-kategori" width="20px"></td>
						  <td class="sub-kategori">
							<table cellspacing="0" id="t-nilai" class="t-border" >
							
							<tr>
								<td class="thead-1 t-border color-menu" width="20px"><b>NO</b></td>
								<td class="thead-1 t-border color-menu" colspan="2" ><b>Mata Pelajaran</b></td>
								<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 1</b></td>
								<td class="thead-1 t-border color-menu" width="35%" ><b>Semester 2</b></td>
							</tr>
						<tr>';
							
						
						$html .=  "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"5\"><b>" . $item['kategori_nama'] . "</b></td>" ;
					}
						
                    $mp_no++;
    
                    $html .=  '<tr>' ;
                    $html .=  "<td class=\"field-nilai t-border\" rowspan=\"2\" align=\"right\" valign=\"top\">{$mp_no}.</td>" ;
                    $html .=  "<td class=\"field-nilai t-border\" rowspan=\"2\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" ;
					
					
					$html .=  "<td class=\"field-nilai t-border\"  valign=\"top\">Pengetahuan<b></td>" ;
			
					if(($row['semester_id']==6)||($row['semester_id']==7)){
						//// SET PREDIKAT 
						if( (($item['kategori_kode'] == 'KelA')||($item['kategori_kode'] == 'KelB')||
							($item['kategori_kode'] == 'MuatanN')||($item['kategori_kode'] == 'MuatanK')) && 
							(($row['kelas_grade'] == 10)||($row['kelas_grade'] == 11)) ){
							$cetak_kkm = 70;
							
							foreach($range10 as $range_kkm){
								$i=1;
								//while($i<=2){
									
									$nilai[$i][$item['mapel_id']]['nas_teori'] = (int)$nilai[$i][$item['mapel_id']]['nas_teori'];
									if( ($range_kkm['max'] >= $nilai[$i][$item['mapel_id']]['nas_teori']) && ($range_kkm['min'] <= $nilai[$i][$item['mapel_id']]['nas_teori']) ){
										$nilai[$i][$item['mapel_id']]['pred_teori'] = $range_kkm['nilai'];
									}
								
									$nilai[$i][$item['mapel_id']]['nas_praktek'] = (int)$nilai[$i][$item['mapel_id']]['nas_praktek'];
									if( ($range_kkm['max'] >= $nilai[$i][$item['mapel_id']]['nas_praktek']) && ($range_kkm['min'] <= $nilai[$i][$item['mapel_id']]['nas_praktek']) ){
										$nilai[$i][$item['mapel_id']]['pred_praktek'] = $range_kkm['nilai'];
									}
									
									
									$i++;
								//}
							}
						}else{
							
							$cetak_kkm = 75;
							foreach($range12_kelc as $range_kkm){
								$i=1;
								//while($i<=2){
									
									$nilai[$i][$item['mapel_id']]['nas_teori'] = (int)$nilai[$i][$item['mapel_id']]['nas_teori'];
									if( ($range_kkm['max'] >= $nilai[$i][$item['mapel_id']]['nas_teori']) && ($range_kkm['min'] <= $nilai[$i][$item['mapel_id']]['nas_teori']) ){
										$nilai[$i][$item['mapel_id']]['pred_teori'] = $range_kkm['nilai'];
									}
								
									$nilai[$i][$item['mapel_id']]['nas_praktek'] = (int)$nilai[$i][$item['mapel_id']]['nas_praktek'];
									if( ($range_kkm['max'] >= $nilai[$i][$item['mapel_id']]['nas_praktek']) && ($range_kkm['min'] <= $nilai[$i][$item['mapel_id']]['nas_praktek']) ){
										$nilai[$i][$item['mapel_id']]['pred_praktek'] = $range_kkm['nilai'];
									}
									
									
									$i++;
								//}
							}
						}
					}
					
					/////////////////// SEMESTER 1 /////////////////////
					//////// DESKRIPSI PENGETAHUAN //////////////////
					
					if ($nilai[1][$item['mapel_id']]['nas_teori']!=''){
						
						//$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">".$nilai[1][$item['mapel_id']]['cat_teori']."</td>" ;
						$cetak_des = 0;
						foreach ($deskripsi_pelajaran[1]['data'] as $deskripsi)
						{
							if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 1) )
							{
								if(	( $nilai[1][$item['mapel_id']]['pred_teori']=='A' && $deskripsi['kode']==1 )||
									( $nilai[1][$item['mapel_id']]['pred_teori']=='B' && $deskripsi['kode']==2 )||
									( $nilai[1][$item['mapel_id']]['pred_teori']=='C' && $deskripsi['kode']==3 )||
									( $nilai[1][$item['mapel_id']]['pred_teori']=='D' && $deskripsi['kode']==4 )	)
								{							
									if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
									{
										$cetak_des = 1;
									$html .= "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
									}
								}
							}
						}
						if ($cetak_des == 0)
						{
							$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
						}
					}
					else
					{
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">bb</td>" ;
					}
					
	
					/////////////////// SEMESTER 2 ////////////////////////////////////////////////////////////////////////////////
					//////// DESKRIPSI PENGETAHUAN //////////////////
					if ($nilai[2][$item['mapel_id']]['nas_teori']!=''){
						
						//$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">".$nilai[2][$item['mapel_id']]['cat_teori']."</td>" ;
						$cetak_des = 0;
						foreach ($deskripsi_pelajaran[2]['data'] as $deskripsi)
						{
							if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 1) )
							{
								if(	( $nilai[2][$item['mapel_id']]['pred_teori']=='A' && $deskripsi['kode']==1 )||
									( $nilai[2][$item['mapel_id']]['pred_teori']=='B' && $deskripsi['kode']==2 )||
									( $nilai[2][$item['mapel_id']]['pred_teori']=='C' && $deskripsi['kode']==3 )||
									( $nilai[2][$item['mapel_id']]['pred_teori']=='D' && $deskripsi['kode']==4 )	)
								{							
									if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
									{
										$cetak_des = 1;
									$html .= "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
									}
								}
							}
						}
						if ($cetak_des == 0)
						{
							$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
						}
					}
					else
					{
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
					}
					
                    
    
					$html .=  "</tr><tr>";
					$html .=  "<td class=\"field-nilai t-border\"  valign=\"top\">Keterampilan<b></td>" ;
					/////////////////// SEMESTER 1 /////////////////////
                    //////// DESKRIPSI KETRAMPILAN //////////////////
				    if ($nilai[1][$item['mapel_id']]['nas_praktek']!=''){
						
						//$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">".$nilai[1][$item['mapel_id']]['cat_praktek']."</td>" ;
						$cetak_des = 0;
						foreach ($deskripsi_pelajaran[1]['data'] as $deskripsi)
						{
							if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 2) )
							{
								if(	( $nilai[1][$item['mapel_id']]['pred_praktek']=='A' && $deskripsi['kode']==1 )||
									( $nilai[1][$item['mapel_id']]['pred_praktek']=='B' && $deskripsi['kode']==2 )||
									( $nilai[1][$item['mapel_id']]['pred_praktek']=='C' && $deskripsi['kode']==3 )||
									( $nilai[1][$item['mapel_id']]['pred_praktek']=='D' && $deskripsi['kode']==4 )	)
								{
									if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
									{
										$cetak_des = 1;
									$html .= "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
									}
								}
							}
						}
						if ($cetak_des == 0)
						{
							$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
						}
					}
					else
					{
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
					}

    
	
					/////////////////// SEMESTER 2 ////////////////////////////////////////////////////////////////////////////////
					 //////// DESKRIPSI KETRAMPILAN //////////////////
				     if ($nilai[2][$item['mapel_id']]['nas_praktek']!=''){
						
						//$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">".$nilai[2][$item['mapel_id']]['cat_praktek']."</td>" ;
						
						$cetak_des = 0;
						foreach ($deskripsi_pelajaran[2]['data'] as $deskripsi)
						{
							if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 2) )
							{
								if(	( $nilai[2][$item['mapel_id']]['pred_praktek']=='A' && $deskripsi['kode']==1 )||
									( $nilai[2][$item['mapel_id']]['pred_praktek']=='B' && $deskripsi['kode']==2 )||
									( $nilai[2][$item['mapel_id']]['pred_praktek']=='C' && $deskripsi['kode']==3 )||
									( $nilai[2][$item['mapel_id']]['pred_praktek']=='D' && $deskripsi['kode']==4 )	)
								{
									if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
									{
										$cetak_des = 1;
									$html .= "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
									}
								}
							}
						}
						if ($cetak_des == 0)
						{
							$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
						}
					}
					else
					{
						$html .=  "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" ;
					}
                    $html .=  '</tr>' ;
                    
                }
               
    
    $html .= '         </table>';
    $html .= '   
		  </td>
         </tr>
      </table>';
	 
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

function induk_view_kepribadian_2013_v1($ekskul_result, $prestasi_result, $row_per_siswa, $nilai_siswa){

	$html ='<table>   
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013($ekskul_result).'
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
          
          	  '. prestasi_2013($prestasi_result).'
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
          
          	  '.ketidakhadiran_2013($nilai_siswa).'
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
          
          	  '.catatan_walikelas_2013($nilai_siswa).'
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
          
          	  '.tanggapan_ortu_2013().'
          		
          </td>
         </tr>
         
        </table>';
	return $html;
}

function induk_view_kepribadian_2013_v2( $ekskul_result, $prestasi_result, $row_per_siswa, $nilai_siswa){

	$html ='<table>  
		 <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.du_2013_v2($nilai_siswa, 'color-menu') .'
          		<br/><br/>
          </td>
         </tr>
		 
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013($ekskul_result).'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '. prestasi_2013($prestasi_result).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013($nilai_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>H.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelas_2013($nilai_siswa).'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>I.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013().'
          		
          </td>
         </tr>
         
        </table>';
	return $html;
}

function du_2013_v2($row,$color_menu=''){
	
	$no=0;
	$html = '
      <table cellspacing="0" class="t-border" width="100%" >
		
         <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" width="20px"> 
				<b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" width="25%"> 
				<b>Nama DU/DI atau Instansi Relawan</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" width="30%"> 
				<b>Alamat</b></td>
			<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" width="25%"> 
				<b>Lama dan Waktu Pelaksanaan </b></td>
			<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" > 
				<b>Nilai</b></td>
			<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" > 
				<b>Predikat</b></td>
        </tr>';
		
		
		$html.= '<tr>
					<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" colspan="6"><b> Semester 1 </b></td>
				</tr><tr>
				' . NL;
		
		$semester1=0;
		if($row[1]['pkl_nilai']!='')
		{
			$cetak_ojt=1;
			$no++;
			
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$no."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row[1]['pkl_nama']."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row[1]['pkl_alamat']."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row[1]['pkl_waktu']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$row[1]['pkl_nilai']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$row[1]['pkl_predikat']."</td>" . NL;
			
			
        }else{
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
			
        }
		
		$html.= "</tr>" . NL;
		$html.= '<tr>
					<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" colspan="6"><b> Semester 2 </b></td>
				 </tr><tr>
				' . NL;
		if($row[2]['pkl_nilai']!='')
		{
			$cetak_ojt=1;
			$no++;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$no."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row[2]['pkl_nama']."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row[2]['pkl_alamat']."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row[2]['pkl_waktu']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$row[2]['pkl_nilai']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$row[2]['pkl_predikat']."</td>" . NL;
			
			
        }else{
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
			
        }
		
		$html.= "</tr>" . NL;
		$html.='</table>';
		return $html;
	
	
}

function ekstrakurikuler_2013($ekskul_result)
{
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
   
      $html = '<table cellspacing="0" class="t-border" width="100%" >
         <tr>
        	<td  class="t-border field-nilai color-menu" align="center" valign="middle" width="20px" rowspan="2"> <b>NO</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" colspan="2"> <b>Semester 1</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" colspan="2"> <b>Semester 2</b></td>
        </tr>
        <tr>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width="30%"> <b>Kegiatan Ekstrakurikuler</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width=> <b>Keterangan</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width="30%"> <b>Kegiatan Ekstrakurikuler</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width=> <b>Keterangan</b></td>
        </tr>';
        
        
		 $no=0;
        foreach ($ekskul_result[1]['data'] as $_idx => $_row1)
        {
            $nisixk1['nilai'] = strtoupper($_row1['nilai']);
			
			$ekskul1[$no]['ekskul_nama'] = $_row1['ekskul_nama'];
			$ekskul1[$no]['nilai']		 = $_row1['nilai'];
            if (strpos($nisixk1['nilai'], 'A') !== false)
            {
                $set_ekskul_keterangan1[$no] = 'Sangat Baik';
            }
            elseif (strpos($nisixk1['nilai'], 'B') !== false)
            {
                $set_ekskul_keterangan1[$no] = 'Baik';
            }
            else
            {
                $set_ekskul_keterangan1[$no] = 'Kurang';
            }
			$no++;
		}
		
		$no=0;
        foreach ($ekskul_result[2]['data'] as $_idx => $_row2)
        {
            $nisixk2['nilai'] = strtoupper($_row2['nilai']);

			$ekskul2[$no]['ekskul_nama'] = $_row2['ekskul_nama'];
			$ekskul2[$no]['nilai']		 = $_row2['nilai'];
            if (strpos($nisixk2['nilai'], 'A') !== false)
            {
                $set_ekskul_keterangan2[$no] = 'Sangat Baik';
            }
            elseif (strpos($nisixk2['nilai'], 'B') !== false)
            {
                $set_ekskul_keterangan2[$no] = 'Baik';
            }
            else
            {
                $set_ekskul_keterangan2[$no] = 'Kurang';
            }
			$no++;
		}
		
		$cetak_ekskul=count($ekskul_result[1]['data']);
		if(count($ekskul_result[2]['data'])>$cetak_ekskul)
		{	$cetak_ekskul = count($ekskul_result[2]['data']);	}
		
        $no=0;
		while ($cetak_ekskul > $no)
        {
			$html .= '<tr>' ;
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . ($no + 1) . ".</td>" ;
            $html .= "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">".$ekskul1[$no]['ekskul_nama']."</td>" ;
            $html .= "<td class=\"t-border field-nilai\" valign=\"top\">".$ekskul1[$no]['nilai'].".". $set_ekskul_keterangan1[$no]."</td>" ;
			
			if(isset($ekskul2[$no])){
				$html .= "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">".$ekskul2[$no]['ekskul_nama']."</td>" ;
				$html .= "<td class=\"t-border field-nilai\" valign=\"top\">".$ekskul2[$no]['nilai'].".". $set_ekskul_keterangan2[$no]."</td>" ;
            }else{
				$html .= "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">-</td>" ;
				$html .= "<td class=\"t-border field-nilai\" valign=\"top\" >-</td>" ;
			}
			$html .= '</tr>' ;
			$no++;
        }

        if ((count($ekskul_result[1]['data']) == 0)&&(count($ekskul_result[2]['data']) == 0))
        {
            $html .= '<tr>' ;
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >-</td>" ;
            $html .= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" ;
            $html .= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" ;
			
            $html .= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" ;
            $html .= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" ;
            $html .= '</tr>' ;
        }
       
        

    $html .=' 	</table>';
	
	return $html;

}

function prestasi_2013($prestasi_result){
	
	
	
	$html = ' 
	<table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai color-menu" align="center" valign="middle" width="20px" rowspan="2"> <b>NO</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" colspan="2"> <b>Semester 1</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" colspan="2"> <b>Semester 2</b></td>
        </tr>
        <tr>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width="150"> <b>Jenis Prestasi</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Keterangan</b></td>
            
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width="150"> <b>Jenis Prestasi</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Keterangan</b></td>
        </tr>';
		
		//////////////// SEMESTER 1 ////////////////////////////////////////////////////////////////////////////////////////////////
		$cetak_prestasi1=0;
		$no=0;
        foreach ($prestasi_result[1]['data']  as $_idx => $_row1)
        {
			if($_row1['prestasi_nama']!='')
			{
				$cetak_prestasi1++;
				$prestasi1[$no]['kegiatan_prestasi_nama']	= $_row1['kegiatan_prestasi_nama'];
				$prestasi1[$no]['prestasi_nama']			= $_row1['prestasi_nama'];
				$no++;
				$no++;
				
			}
        }

		//////////////// SEMESTER 2 ////////////////////////////////////////////////////////////////////////////////////////////////
		$cetak_prestasi2=0;
		$no=0;
        foreach ($prestasi_result[2]['data']  as $_idx => $_row2)
        {
			if($_row2['prestasi_nama']!='')
			{
				$cetak_prestasi2++;
				$prestasi2[$no]['kegiatan_prestasi_nama']	= $_row2['kegiatan_prestasi_nama'];
				$prestasi2[$no]['prestasi_nama']			= $_row2['prestasi_nama'];
				$no++;
			}
        }

		$cetak_prestasi=0;
		if( $cetak_prestasi < $cetak_prestasi1 )
		{	$cetak_prestasi = $cetak_prestasi2;	}
		if( $cetak_prestasi < $cetak_prestasi2 )
		{	$cetak_prestasi = $cetak_prestasi2;	}
		
		$no=0;
		while ($cetak_prestasi > $no)
        {
			
			$html .= '<tr>' ;
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . ($no+1) . "</td>" ;
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">".$prestasi1[$no]['kegiatan_prestasi_nama']."</td>" ;
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\">".$prestasi1[$no]['prestasi_nama']."</td>" ;
			
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">".$prestasi2[$no]['kegiatan_prestasi_nama']."</td>" ;
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\">".$prestasi2[$no]['prestasi_nama']."</td>" ;
			$html .= '</tr>' ;
			$no++;
        }

        if (($cetak_prestasi1==0)&&($cetak_prestasi2==0))
        {
            $html .= '<tr>' ;
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >-</td>" ;
            
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" ;
            $html .= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" ;
			
			$html .= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" ;
            $html .= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" ;
            $html .= '</tr>' ;
        }

       
    $html .='</table>';
	return $html;
}

function ketidakhadiran_2013($nilai_siswa){
	
	for($x=1;$x<=2;$x++)
	{
		if(isset($nilai_siswa[$x])){
			$absen_s[$x] = '-';
			$absen_i[$x] = '-';
			$absen_a[$x] = '-';
			if($nilai_siswa[$x]['absen_s']>0){
				$absen_s[$x] = $nilai_siswa[$x]['absen_s'];
			}
			if($nilai_siswa[$x]['absen_i']>0){
				$absen_i[$x] = $nilai_siswa[$x]['absen_i'];
			}
			if($nilai_siswa[$x]['absen_a']>0){
				$absen_a[$x] = $nilai_siswa[$x]['absen_a'];
			}
		}else{
			$absen_s[$x] = ' - ';
			$absen_i[$x] = ' - ';
			$absen_a[$x] = ' - ';
		}
	}
	
	
	$html ='
	 <table cellspacing="0" class="t-border field-nilai" width="80%" >
        
        <tr>
            <td width="50%" class="thead-1 t-border color-menu"></td>
            <td class="thead-1 t-border color-menu" align="center"> <b>Semester 1</b> </td>
            <td class="thead-1 t-border color-menu" align="center"> <b>Semester 2</b> </td>
        </tr>
        <tr>
            <td width="50%" class=" field-nilai">Sakit</td>
            <td class="t-border field-nilai" align="center">  '; 
			if($absen_s[1] > 0) 
				$html .= $absen_s[1] ." hari";
			else
				$html .=  '- hari</td>';
	$html .= '	</td>
            <td class="t-border field-nilai" align="center">  '; 
			if($absen_s[2] > 0) 
				$html .= $absen_s[2] ." hari";
			else
				$html .=  '- hari</td>';
    $html .= '    
		</tr>
        <tr>
            <td class="t-border field-nilai">Ijin</td>
             <td class="t-border field-nilai" align="center">  '; 
			if($absen_i[1] > 0) 
				$html .= $absen_i[1] ." hari";
			else
				$html .=  '- hari</td>';
	$html .= '	</td>
            <td class="t-border field-nilai" align="center">  '; 
			if($absen_i[2] > 0) 
				$html .= $absen_i[2] ." hari";
			else
				$html .=  '- hari</td>';
    $html .= '    
		</tr>
        <tr>
            <td class="t-border field-nilai">Tanpa Keterangan</td>
            <td class="t-border field-nilai" align="center">  '; 
			if($absen_a[1] > 0) 
				$html .= $absen_a[1] ." hari";
			else
				$html .=  '- hari</td>';
	$html .= '	</td>
            <td class="t-border field-nilai" align="center">  '; 
			if($absen_a[2] > 0) 
				$html .= $absen_a[2] ." hari";
			else
				$html .=  '- hari</td>';
    $html .= '    
		</tr>
    </table>';
	
	return $html;
}

function catatan_walikelas_2013($row){
	 
	$html = '
	 <table cellspacing="0" class="t-border" width="100%" >
        <tr>
         <td  width="50%" class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Semester 1</b></td>
         <td  width="50%" class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Semester 2</b></td>
        </tr>
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="<?php $html .= $height;?>"> Deskripsi:
            <br/>';
			  if(isset($row[1])){
				$html .= $row[1]['note_walikelas'];
			  }
	$html .='</td>
            
        	<td class="t-border field-nilai" align="left" valign="top" height="<?php $html .= $height;?>"> Deskripsi:
            <br/>';
			  if(isset($row[2])){
				$html .= $row[2]['note_walikelas'];
			  }
	$html .='</td>
        </tr>
	  </table>';
	  
	return $html;
}

function tanggapan_ortu_2013(){
	$height = '65px';
	
	$html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
         <td  width="50%" class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Semester 1</b></td>
         <td  width="50%" class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Semester 2</b></td>
        </tr>
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"></td>
            <td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"></td>
        </tr>
	  </table>';
	  
	return $html;

}

function induk_view_sikap_2013_v1($nilai_siswa) {
	
	if(isset($nilai_siswa[1]['deskripsi_sikap']))
	{
		$deskripsi_sikap[1] = (array) json_decode($nilai_siswa[1]['deskripsi_sikap'], TRUE);
		$predikat_sikap[1] = (array) json_decode($nilai_siswa[1]['predikat_sikap'], TRUE);
	}else{
		$deskripsi_sikap[1] = '';
		$predikat_sikap[1] = '';
	}
	
	if(isset($nilai_siswa[2]['deskripsi_sikap']))
	{
		$deskripsi_sikap[2] = (array) json_decode($nilai_siswa[2]['deskripsi_sikap'], TRUE);
		$predikat_sikap[2] = (array) json_decode($nilai_siswa[2]['predikat_sikap'], TRUE);
	}else{
		$deskripsi_sikap[2] = '';
		$predikat_sikap[2] = '';
	}
	
	$html =
	'<table>
         <tr>
          <td class="sub-kategori" width="20px"><b>A.</b></td>
          <td class="sub-kategori"><b>Sikap</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          	<br/>
          	
			<div class="thead-1"><b>1.Sikap Spiritual</b></div>
			  <table cellspacing="0" class="t-border" width="100%" >
				<tr>
				 <td  colspan="2" class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Semester 1</b></td>
				 <td  colspan="2" class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Semester 2</b></td>
				</tr>
				<tr>
					<td class="t-border field-nilai color-menu" align="center" valign="top" height="30px" width="20%"> Predikat </td>
					<td class="t-border field-nilai color-menu" align="center" valign="top" height="30px" width="30%">Deskripsi </td>
					<td class="t-border field-nilai color-menu" align="center" valign="top" height="30px" width="20%"> Predikat </td>
					<td class="t-border field-nilai color-menu" align="center" valign="top" height="30px" width="30%">Deskripsi </td>
				</tr>
				<tr>
					<td class="t-border field-nilai" align="center" valign="top" height="180px">
					<br/>';
					
					if(isset($predikat_sikap[1]['spiritual']))
					{
						$html .= $predikat_sikap[1]['spiritual'];
					}else{
						$html .= '-';
					}
				$html .= '<br/>
					</td>
					<td class="t-border field-nilai" align="center" valign="top">
					<br/>';
					
					if(isset($deskripsi_sikap[1]['spiritual']))
					{
						$html .= $deskripsi_sikap[1]['spiritual'];
					}else{
						$html .= '-';
					}
				$html .= '<br/>
					</td>
					
					<td class="t-border field-nilai" align="center" valign="top">
					<br/>';
					
					if(isset($predikat_sikap[2]['spiritual']))
					{
						$html .= $predikat_sikap[2]['spiritual'];
					}else{
						$html .= '-';
					}
				$html .= '<br/>
					</td>
					<td class="t-border field-nilai" align="center" valign="top">
					<br/>';
					
					if(isset($deskripsi_sikap[2]['spiritual']))
					{
						$html .= $deskripsi_sikap[2]['spiritual'];
					}else{
						$html .= '-';
					}
				$html .= '<br/>
					</td>
				</tr>
			  </table>
			  <br/>
			  
			  
			<div class="thead-1"><b>2.Sikap Sosial</b></div>
			  <table cellspacing="0" class="t-border" width="100%" >
				<tr>
				 <td  colspan="2" class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Semester 1</b></td>
				 <td  colspan="2" class="t-border field-nilai color-menu" align="center" valign="middle" > <b>Semester 2</b></td>
				</tr>
				<tr>
					<td class="t-border field-nilai color-menu" align="center" valign="top" height="30px" width="20%"> Predikat </td>
					<td class="t-border field-nilai color-menu" align="center" valign="top" height="30px" width="30%">Deskripsi </td>
					<td class="t-border field-nilai color-menu" align="center" valign="top" height="30px" width="20%"> Predikat </td>
					<td class="t-border field-nilai color-menu" align="center" valign="top" height="30px" width="30%">Deskripsi </td>
				</tr>
				<tr>
					<td class="t-border field-nilai" align="center" valign="top" height="180px">
					<br/>';
					
					if(isset($predikat_sikap[1]['sosial']))
					{
						$html .= $predikat_sikap[1]['sosial'];
					}else{
						$html .= '-';
					}
				$html .= '<br/>
					</td>
					<td class="t-border field-nilai" align="center" valign="top">
					<br/>';
					
					if(isset($deskripsi_sikap[1]['sosial']))
					{
						$html .= $deskripsi_sikap[1]['sosial'];
					}else{
						$html .= '-';
					}
				$html .= '<br/>
					</td>
					
					<td class="t-border field-nilai" align="center" valign="top">
					<br/>';
					
					if(isset($predikat_sikap[2]['sosial']))
					{
						$html .= $predikat_sikap[2]['sosial'];
					}else{
						$html .= '-';
					}
				$html .= '<br/>
					</td>
					<td class="t-border field-nilai" align="center" valign="top">
					<br/>';
					
					if(isset($deskripsi_sikap[2]['sosial']))
					{
						$html .= $deskripsi_sikap[2]['sosial'];
					}else{
						$html .= '-';
					}
					$html .= '<br/>
					</td>
				</tr>
			  </table>
	  
          		<br/><br/>
          </td>
         </tr>
        </table>';
		
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
?>