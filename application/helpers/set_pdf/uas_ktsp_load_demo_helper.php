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

function style_ktsp_v1_tarcisius()
{
	$html='
	<style type="text/css">
		
		.style3 {font-size: 11px}
		
		#halaman {
			/*padding:112px 5px 5px 5px;*/
			padding:85px 5px 5px 5px;
			height:1500px;
		}
		.style4 {font-size: 12px}
	
		.style5 {font-size: 14px}
	
		.kecil td{
			font-size: 11px;
			padding: 2px 4px 2px 4px;
	
		}
		.kecil th{
			font-size: 12px;
			padding:2px 4px 2px 4px;
			font-style: bold;
		}
		.t-border{
			border-width: 1px;
			border-style: solid;
			border-color: black;
			border-collapse: collapse;
			padding: 2px 5px 2px 5px;

		}
		.t-grey-background{
			background-color:#999999;

		}
		.style6 {font-size: 12px !important; }
		.style8 {padding:5px 5px 5px 5px; }
	</style>  ';
	return $html;
}

function header_ktsp_v1_tarcisius($data)
{
	$smster_nama = '2';
	if($data['semester_nama'] == 'gasal'){
		$smster_nama = '1';
	}
	
	$nama = strtolower($data['siswa_nama']); 
	$nama = explode(" ",$nama);
	$cetak_nama ='';
	foreach($nama as $view_nama)
	{
		$cetak_nama .= ucfirst($view_nama)." ";
	}
	
	$html= '
		<table width="100%" border="0" style="width: 100%;" class="style5">
			<tr>
				<td width="25%" valign="top" >
					Nama Peserta Didik</td>
				<td width="1%" valign="top">:</td>
				<td valign="top" width="33%">
					'.$cetak_nama.'</td>
				<td width="20%" valign="top"></td>
				<td width="1%" valign="top"></td>
				<td valign="top"></td>
			</tr>
			<tr>
				<td valign="top" >
					Bidang Studi Keahlian</td>
				<td valign="top">:</td>
				<td valign="top"> </td>
				<td valign="top">No. Induk</td>
				<td valign="top">:</td>
				<td valign="top"><span style="text-transform:uppercase;">'.$data["siswa_nis"].'</span></td>
			</tr>
			<tr>
				<td valign="top" >
					Program Studi Keahlian</td>
				<td valign="top">:</td>
				<td valign="top"> </td>
				<td valign="top">Kelas/Semester</td>
				<td valign="top">:</td>
				<td valign="top"><span style="text-transform:uppercase;">'.$data["kelas_nama"].'/'.$smster_nama.'</span></td>
			</tr>
			<tr>
				<td valign="top">
					Kompetensi Keahlian</td>
				<td valign="top">:</td>
				<td valign="top">  </td>
	
				<td valign="top">Tahun Pelajaran</td>
				<td valign="top">:</td>
				<td valign="top">'.str_replace("/"," - ",$data["ta_nama"]).'</td>
			</tr>
	
		</table>
			
	';
	return $html;
}

function footer_ktsp_v1_tarcisius($data,$lembar)
{
	$html= '
		<table width="100%" class="style6">
		 <tr>
			<td width="60%"></td>
			<td>Diberikan di</td>
			<td>:  </td>
			<td>Semarang</td>
		 </tr>
		 <tr>
			<td></td>
			<td>Tanggal</td>
			<td>:  </td>
			<td></td>
		 </tr>
		</table>
		<table border="0" style="width: 100%;">
			<tr><td height="10" valign="top" align="left" rowspan="3"></td><tr>
			<tr>
				<td width="29%" align="center" valign="top">
					
					<p class="style6">
						Mengetahui:<br>
						Orang Tua/Wali<br/>
						<br/>
						<br/><br/><br/>
						.....................			</p>    </td>
				<td width="35%" align="center" valign="top">
					
					<p class="style6">
						<br/>Kepala Sekolah<br/>
						<br/>
						<br/><br/><br/>
						'.$data['kepsek_nama'].'<br />
					</p>    
					</td>
				<td width="36%" align="center" valign="top">
				<p class="style6">
						<br>
						Wali Kelas<br/>
						<br/>
						<br/><br/><br/>
						'.$data['wali_nama'].'
						</p>    
		</td>
			</tr>
		</table>
		
	';
	return $html;
}

function footer_ktsp_v2_tarcisius($data,$lembar){
	
}

function ketidakhadiran_ktsp_v1_tarcisius($row)
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

function akhlak_ktsp_v1_tarcisius($row)
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


function pengembangan_diri_ktsp_v1_tarcisius($ekskul_result)
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

function ketercapaian_kompetensi_ktsp_v1_tarcisius($resultset_array)
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


function table_nilai_ktsp_v1_tarcisius($resultset)
{
	$html='
		 <table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
        <tr>
            <th width="4%" rowspan="2">No</th>
            <th width="26%" rowspan="2">Mata Pelajaran</th>
            <th width="6%" rowspan="2">KKM</th>
            <th colspan="4">Nilai Hasil Belajar</th>
        </tr>
        <tr>
            <th width="8%">Angka</th>
            <th width="17%">Huruf</th>
            <th width="10%">Predikat</th>
            <th >Deskripsi Kemajuan Belajar</th>
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

					if ($item['pred_teori']==0 or is_null($item['pred_teori']) or !is_numeric($item['pred_teori']) ) {
	$html.=	'			-';
					} else {
	$html.=				$item['pred_teori'];
					}
	$html.=	'
					&nbsp; </div></td>
					<td valign="middle" align="center"><div align="center" class="style3">';

					
	$html.=				$item['kompetensi'];
					
	
	$html.=	'
					 </div></td>
				</tr>';
				endforeach;
	$html.=	'
		</table>';
		
	return $html;
}

function catatan_ktsp_v1_tarcisius($row){
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

function catatan_kenaikan_kelas_ktsp_v1_tarcisius($row,$data)
{
	$kekelas = "Ke Kelas XII";
	if($row['kelas_grade']==10){
		$kekelas = "Ke Kelas XI";
	}
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
			if($row['kelas_grade']!=12)
				{
	$html.='
					<tr>
						<td align="right"><div class="style6"><b>&nbsp;Hasil Keputusan Rapat</b></div></td>
					
						<td><div class="style6">
							<span style="text-transform:uppercase;">: ';
					
				//	if(($resultset_array['data']['siswa_id']==4462)||
				//	($resultset_array['data']['siswa_id']==4137)||
				//	($resultset_array['data']['siswa_id']==4066))
				//	TIDAK NAIK
	$html.='	
								NAIK 
							</span>'; 
	$html.=					$kekelas;
	
	$html.='				</div>
						</td>
					</tr>';
				} 
			if($row['kelas_grade']==10)
				{
	$html.='		<tr>
						<td align="left"><div class="style6"><b>&nbsp;Program</b></div></td>
						<td><div class="style6"><span style="text-transform:uppercase;">: IPA / IPS </span></div></td>
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

function du_tarcisius_v1($row){
	
	if(isset($row['pkl_nama'])){
		$no="1.";
		
	}else{
		$no="<br/>";
	}
	$html= '
		<table cellspacing="0" id="t-kompetensi" border="1" class="t-border" width="100%">
			<tr>
				<td class=" t-head2 t-border" >No</td>
				<td class=" t-head2 t-border" >Nama DU/DI atau Instansi Relawan</td>
				<td class=" t-head2 t-border" >Lokasi</td>
				<td class=" t-head2 t-border" >Jenis Kegiatan</td>
				<td class=" t-head2 t-border" >Lama dan Waktu</td>
			</tr>';
	
	if(isset($row['pkl_nama'])){
		$html.= '
			<tr>
				<td class=" t-head2 t-border" >'.$no.'</td>
				<td class=" t-head2 t-border" >'.$row['pkl_nama'].'</td>
				<td class=" t-head2 t-border" >'.$row['pkl_alamat'].'</td>
				<td class=" t-head2 t-border" >'.$row['pkl_keterangan'].'</td>
				<td class=" t-head2 t-border" >'.$row['pkl_waktu'].'</td>
			</tr>
		
		';
	}
	
	$html.= '
		</table>';
	return $html;
}

function table2_tarcisius_v1($row,$ekskul_result){
	
	if(isset($row['kode_kepribadian'])){
	
		$aspek_array = array(
				'kedisiplinan'	 => 'Kedisiplinan',
				'kebersihan'	 => 'Kebersihan',
				//'kesehatan'		 => 'Kesehatan',
				//'tgjawab'		 => 'Tanggung Jawab',
				//'kesopanan'		 => 'Sopan Santun',
				//'percayadiri'	 => 'Percaya Diri',
				//'kompetitif'	 => 'Kompetitif',
				//'sosial'		 => 'Hubungan Sosial',
				//'kejujuran'		 => 'Kejujuran',
				//'ritualibadah'	 => 'Pelaksanaan Ibadah Ritual',
			);
			
		$kepribadian = (array) json_decode($row['kepribadian'], TRUE);
		$kode_kepribadian = (array) json_decode($row['kode_kepribadian'], TRUE);
		
		$no=0;
		foreach ($aspek_array as $idx => $label):
			$no++;
			$aspek_kepribadian[$no] = array_node($kode_kepribadian, $idx);
		endforeach;
		
		////////////////////////////////////////////////////////////////////////////////////////
		
		$absen[1] = '-';
		$absen[2] = '-';
		$absen[3] = '-';
		if($row['absen_s']>0){
			$absen[1]  = $row['absen_s'].' hari';
		}
		if($row['absen_i']>0){
			$absen[2]  = $row['absen_i'].' hari';
		}
		if($row['absen_a']>0){
			$absen[3]  = $row['absen_a'].' hari';
		}
		
		$html = '';
		$html.= '
		
					<table cellspacing="0" id="t-kompetensi" border="1"  class="t-border" style="width: 100%;">
						<tr>
							<td align="center" colspan="2" class=" t-head2 t-border" >Komponen</td>
							<td align="center" class="t-head2 t-border">Predikat</td>
						</tr>
						<tr>
							<td rowspan="4" class="t-head2 t-border">Kegiatan Pengembangan Diri</td>';
				
		
		$x=0;	
		foreach ($ekskul_result['data'] as $_idx => $_row)
		{
		$html.= '			<td class="t-head2 t-border">'.$_row['ekskul_nama'].'</td>';
		$html.= '			<td class="t-head2 t-border" align="center" >'.$_row['nilai'].'</td>';
		$html.= '		</tr>';
			
			if($x != 3)
			{
			$html.= '	<tr>';
			}
			$x++;
		}
			
		for ($i = $x; $i <= 3; $i++) {
			
		$html.= '			<td class="t-head2 t-border">&nbsp; </td>';
		$html.= '			<td class="t-head2 t-border">&nbsp; </td>';
		$html.= '		</tr>';
			if($i != 3)
			{
			$html.= '	<tr>';
			}
		}
		
		$html.= '		<tr>';
		$set_array1 = array(
			1 	=>	"1. Akhlak",
					"2. Kepribadian",
					" "
		);
		$html.= '			<td rowspan="3" class="t-head2 t-border">Akhlak dan kepribadian</td>';
		
		for ($a = 1; $a <= 3; $a++) {
		$html.= '			<td class="t-head2 t-border">'.$set_array1[$a].' </td>';
		
		if(isset($aspek_kepribadian[$a])){
			$html.= '			<td class="t-head2 t-border" align="center">'.$aspek_kepribadian[$a].'</td>';
		}else{
			$html.= '			<td class="t-head2 t-border">&nbsp; </td>';
		}
		
		$html.= '		</tr>';
			if($a != 3)
			{
			$html.= '	<tr>';
			}
		}
		$set_array2 = array(
			1 	=>	"1. Sakit",
					"2. Izin",
					"3. Tanpa Keterangan",
		);
		$html.= '		<tr>';
		$html.= '			<td rowspan="3" class="t-head2 t-border">Ketidakhadiran</td>';
		for ($a = 1; $a <= 3; $a++) {
		$html.= '			<td class="t-head2 t-border"> '.$set_array2[$a].' </td>';
		$html.= '			<td class="t-head2 t-border" align="center">'.$absen[$a].'</td>';
		$html.= '		</tr>';
			if($a != 3)
			{
			$html.= '	<tr>';
			}
		}
		
		$html.= '		</table>';
					
		return $html;
	}
}

function catatan_tarcisius_ktsp_v1($row){
	
	$html= '
	
		<table cellspacing="0" class="t-border" style="width: 100%;">
			<tr>
				<td align="left" style="padding:5px;">
				<b> Catatan Untuk Perhatian Orang tua/Wali</b><br>
				'.
				$row['note_walikelas']
					.'<br/>
				</td>
			</tr>
		</table>
	';
	return $html;
}
?>