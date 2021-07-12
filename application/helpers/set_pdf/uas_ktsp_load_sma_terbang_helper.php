<?php

function int2kata($n) {
    if (is_null($n) or !is_numeric($n))
        return '';

    if ($n == 0)
        return 'Nol';
    if ($n == 1)
        return 'Satu';
    if ($n == 2)
        return 'Dua';
    if ($n == 3)
        return 'Tiga';
    if ($n == 4)
        return 'Empat';
    if ($n == 5)
        return 'Lima';
    if ($n == 6)
        return 'Enam';
    if ($n == 7)
        return 'Tujuh';
    if ($n == 8)
        return 'Delapan';
    if ($n == 9)
        return 'Sembilan';

    return '';
}

function int2huruf($n) {
    if (is_null($n) OR !is_numeric($n))
        return '';

    if ($n >= 90)
        return 'A';

    if ($n >= 70)
        return 'B';

    if ($n >= 60)
        return 'C';

    //if ($n >= 41)
        return 'D';

    //return 'E';
}

function style_ktsp_v1_terbang()
{
	$html='
	<style type="text/css">
		
		.style3 {font-size: 11px}
		
		#halaman {
			/*padding:112px 5px 5px 5px;
			padding:85px 5px 5px 5px;*/
			padding:105px 5px 5px 5px;
			height:1500px;
		}
		.style4 {font-size: 12px}
	
		.style5 {font-size: 14px}
	
		.kecil td{
			font-size: 11px;
			padding: 2px 0px 2px 4px;
	
		}
		.kecil th{
			font-size: 12px;
			padding:2px 4px 2px 4px;
			font-style: bold;
		}
		.style6 {font-size: 12px !important; }
		.style8 {padding:5px 5px 5px 5px; }
	</style>  ';
	return $html;
}

function header_ktsp_v1_terbang($row,$row_per_siswa)
{
	$smster_nama = '2';
	if($row['semester_nama'] == 'gasal'){
		$smster_nama = '1';
	}
	
	$nama = strtolower($row_per_siswa['siswa_nama']); 
	$nama = explode(" ",$nama);
	$cetak_nama ='';
	foreach($nama as $view_nama)
	{
		$cetak_nama .= ucfirst($view_nama)." ";
	}
	
	$width_nama = '40%';
	$width_kelas ='';
	if(strlen($row_per_siswa['siswa_nama'])>36)
	{	
		$width_nama = '52%';
		$width_kelas = 'width="17%"';
	}
	if(strlen($row["kelas_nama"])>18)
	{	
		$width_nama = '37%';	
		$width_kelas = 'width="35%"';
	}
	$html= '
		<table width="100%" border="0" style="width: 100%;" class="style5">
			<tr>
				<td width="14%" valign="top" >
					<b>Nama Siswa</b></td>
				<td width="1%" valign="top">:</td>
				<td valign="top" width="'.$width_nama.'">
					<b>'.$cetak_nama.'</b></td>
				<td width="19%" valign="top"><b>Kelas/Semester</b></td>
				<td width="1%" valign="top">:</td>
				<td '.$width_kelas.' valign="top"><span style="text-transform:uppercase;"><b>'.$row["kelas_nama"].'/'.$smster_nama.'</b></span></td>
			</tr>
			<tr>
				<td valign="top">
					<b>NIS</b>					</td>
				<td valign="top">:</td>
				<td valign="top">
					<b>'.$row_per_siswa["siswa_nis"].'</b></td>
	
				<td valign="top"><b>Tahun Pelajaran</b></td>
				<td valign="top">:</td>
				<td valign="top"><b>'.str_replace("/"," - ",$row["ta_nama"]).'</b></td>
			</tr>
	
		</table>
			
	';
	return $html;
}

function footer_ktsp_v1_terbang($data,$lembar)
{
	if($data['tanggal_uas_nama']=="")
		$data['tanggal_uas_nama'] = "02 Mei 2017";
	
	$html= '
		<table border="0" style="width: 100%;">
			<tr><td height="10" valign="top" align="left" rowspan="3"></td><tr>
			<tr>
				<td width="29%" align="center" valign="top">
					
					<p class="style6">
						<br>
						Orang Tua/Wali<br/>
						<br/>
						<br/><br/><br/>
						.....................			</p>    </td>
				<td width="35%" align="center" valign="top">
					
					<p class="style6">
						<br>
						Wali Kelas<br/>
						<br/>
						<br/><br/><br/>
						'.$data['wali_nama'].'
						</p>    </td>
				<td width="36%" align="center" valign="top">
		<p align="right" class="style6">
			'.$data['kota_nama'].', '.$data['tanggal_uas_nama'].'</p>
					<p class="style6">
						Kepala Sekolah<br/>
						<br/>
						<br/><br/><br/>
						'.$data['kepsek_nama'].'<br />
					</p>    </td>
			</tr>
		</table>
		
	';
	return $html;
}

function ketidakhadiran_ktsp_v1_terbang($row)
{
	$absen_s = '-';
	$absen_i = '-';
	$absen_a = '-';
	if($row['absen_s']>0){
		$absen_s = $row['absen_s'].' hari';
	}
	if($row['absen_i']>0){
		$absen_i = $row['absen_i'].' hari';
	}
	if($row['absen_a']>0){
		$absen_a = $row['absen_a'].' hari';
	}
	$html='
		<table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse;">
			<tr>
				<td  width="270px" colspan="3" align="center"><div align="center" class="style8"> <strong>Kehadiran Siswa</strong></div></td>  
			</tr>
			<tr>
				<td width="100%" align="center"><div align="center" class="style8" >Sakit</div></td>
				<td width="100%" align="center"><div align="center" class="style8" >Ijin </div></td>
				<td width="100%" align="center"><div align="center" class="style8" >Alpa</div></td>
			<tr>
				<td align="center"><span class="style8" align="center">'.$absen_s.'</span></td>
				<td align="center"><span class="style8" align="center">'.$absen_i.'</span></td>
				<td align="center"><span class="style8" align="center">'.$absen_a.'</span></td>
			</tr>
		</table>
		';
	return $html;
}

function akhlak_ktsp_v1_terbang($row)
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
		
	$kepribadian = (array) json_decode($row['kepribadian'], TRUE);
	$html='
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
        <tr>
            <th width="5%"><span class="style4">No</span></th>
            <th width="20%"><span class="style4">Aspek Yang Dinilai  </span></th>
            <th ><span class="style4">Keterangan</span></th>
        </tr>';
	
	$no_aspek= 0;
	
	foreach ($aspek_array as $idx => $label):
		$no_aspek++;
		$html.='			
			  <tr>
				<td align="center" valign="middle"><span class="style4">'.$no_aspek .'.</div></td>
				<td valign="middle"><div class="style4">'.$label .'</div></td>
				<td valign="middle"><span class="style4">'.array_node($kepribadian, $idx) .'</div></td>
			  </tr>';
	endforeach;
		
	$html.='
		</table>
		';
	return $html;
}


function pengembangan_diri_ktsp_v1_terbang($ekskul_result)
{
	$html='
		<table width="100%" border="1" cellspacing="10" cellpadding="2" style="width:100%;border-collapse: collapse;">
		';
	$html.='
			<tr>
				<td  width="70%"  align="center"><div align="center" class="style8"> <strong>Pengembangan Diri</strong></div></td> 
				<td width="30%" align="center"><div align="center" class="style8" ><B>Nilai</B></div></td> 
			</tr>
	';	
	
	$x=1;
	foreach ($ekskul_result['data'] as $_idx => $_row)
	{
		$html.='
			<tr>
				<td width="100%" align="center"><div align="center" class="style8" >'.$_row['ekskul_nama'].'</div></td>
				<td width="100%" align="center"><div align="center" class="style8" >'.$_row['nilai'].'</div></td>
			</tr>
		';
		$x++;
	}
		
	for ($i = $x; $i <= 3; $i++) {
		
		$html.='
			<tr>
				<td width="100%" align="center"><div align="center" class="style8" >-</div></td>
				<td width="100%" align="center"><div align="center" class="style8" >-</div></td>
			</tr>
		';
	}
	

	$html.='
		</table>
		';
	return $html;
}

function ketercapaian_kompetensi_ktsp_v1_terbang($resultset_array)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	
	$html=
	'
		 <table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
			<tr>
				<th width="4%">No</th>
				<th width="27%">MATA PELAJARAN</th>
				<th width="69%">Keterangan</th>
			</tr>';
			
			foreach ($resultset_array['data'] as $idx => $item): 
				$mp_no++;
	$html.=
	'
			<tr>
				<td align="center" valign="middle"><span class="style4">'.$mp_no.'.</div></td>
				<td valign="middle"><span class="style4">'.$item['mapel_nama'].' </div></td>
				<td valign="middle"><span class="style4">'.$item['kompetensi'].' </td>
			</tr>';
		
			endforeach;
	$html.='		
		</table>
	';
	return $html;
}


function table_nilai_ktsp_v1_terbang($resultset)
{
	$html='
		 <table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
        <tr>
            <th width="5%" rowspan="3">No</th>
            <th width="26%" rowspan="3">Mata Pelajaran</th>
            <th width="12%" rowspan="3">Kriteria Ketuntasan Minimal (KKM)</th>
            <th colspan="4">HASIL PENILAIAN</th>
            <th rowspan="3">Sikap</th>
        </tr>
        <tr>
            <th colspan="2">Pengetahuan</th>
            <th colspan="2">Praktek</th>
        </tr>
        <tr>
            <th width="8%">Angka</th>
            <th width="17%">Huruf</th>
            <th width="8%">Angka</th>
            <th width="17%">Huruf</th>
        </tr>	';
			
				$mp_no = 0;
				$ktg_ascii = 64;
				
				$ktg_nama = NULL;
				$antr_mapel = 0; 
				foreach ($resultset['data'] as $idx => $item): 
					 if ($item['kategori_nama'] != $ktg_nama):
						$ktg_ascii++;
						
						$ktg_nama = $item['kategori_nama'];
					endif;
					$mp_no++;
	$html.='			
				<tr>
					<td align="center" valign="middle">'.$mp_no.'</td>
					<td valign="middle">'.$item['mapel_nama'].'</td>
					<td valign="middle" align="center"><div align="center">'.round($item['nipel_kkm']).'&nbsp; </div></td>
					<td valign="middle" align="center"><div align="center" class="style3">';
	
					if (is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) ) {
	$html.='			-';
					} else {
	$html.=				($item['nas_teori']) ? round($item['nas_teori']) : '';
					}
	$html.=	'				
					&nbsp; </div></td>
					<td valign="middle" align="center"><div align="center" class="style3">';
					
					if (is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) ) {
	$html.=	'			-';
					} else {
						
	$html.=	'				'.int2kata(substr(round($item["nas_teori"]),0,1)).' '
							.int2kata(substr(round($item["nas_teori"]),1,1)).' ' 
							.int2kata(substr(round($item["nas_teori"]),2,1)).' ';
					}
	$html.=	'					
					</div></td>
					<td valign="middle" align="center"><div align="center" class="style3">';

					if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=				($item['nas_praktek']) ? round($item['nas_praktek']) : '-';
					}
	$html.=	'
					&nbsp; </div></td>
					<td valign="middle" align="center"><div align="center" class="style3">';

					if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=	'				'.int2kata(substr(round($item["nas_praktek"]),0,1)).' '
							.int2kata(substr(round($item["nas_praktek"]),1,1)).' ' 
							.int2kata(substr(round($item["nas_praktek"]),2,1)).' ';
					}
	
	$html.=	'
					 </div></td>
					<td valign="middle" align="center"><div align="center">'.int2huruf($item['nas_sikap']).'</div></td>
				</tr>';
				endforeach;
	$html.=	'
		</table>';
		
	return $html;
}

function catatan_ktsp_v1_terbang($row){
	$asd = '';
	$row['note_walikelas'] = str_replace("\n", "<br/>", ($row['note_walikelas']));
    $row['note_walikelas'] = "&nbsp;&nbsp;".$row['note_walikelas'];
	
	$html= '
	
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="style6">
            <tr><td height="75" valign="top" align="left"><b>&nbsp;&nbsp;Catatan Wali Kelas : </b>
                    <br/>
				'.
				$row['note_walikelas'] 
				//	$item['catatan']
					.'<br/><br/><br/>
				</td></tr>
        </table>
	';
	return $html;
}

function catatan_kenaikan_kelas_ktsp_v1_terbang($row, $row_per_siswa)
{
	
	$html='
	<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="style6">
                <tr><td height="30" valign="top" align="left">
                        <table>
                            <tr>
                                <td align="right"><b>&nbsp;Keterangan : </b> ';
								if($row['kelas_grade']!=12)
								{
									$html .='NAIK / TIDAK NAIK';
								}
	$html .=						'</td>
                                
                            </tr>
        
			
                        </table>
                    </td></tr>
                <tr><td height="10" valign="top" align="left"></td><tr>
            </table>';
	
	
	return $html;
}

function catatan_kenaikan_kelas_ktsp_v1_terbang_v2($row, $row_per_siswa)
{
	
	$html='
		Catatan Kenaikan Kelas :
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
			<tr><td height="50" valign="top" align="left">
			<table>';
			
			if($row['kelas_grade']==12)
				{
	$html.='
					<tr>
						<td align="right"><div class="style6"><b>&nbsp;Catatan Wali Kelas</b></div></td>
						<td><div class="style6"><span style="text-transform:uppercase;">: - </span></div></td>
					</tr>';
				}
			
			
	$html.='
				</table>
			</td>
		</tr>
	</table>';
	if($row['semester_nama']=='gasal'){
		$html = '';
	}
	return $html;
}
?>