<?php
function int2kata($n) {
	if (is_null($n) or !is_numeric($n))
		return '';

	if ($n == 0)
		return 'Nol';
	if ($n == 1)
		return 'Satu';
	if ($n ==2)
		return 'Dua';
	if ($n ==3)
		return 'Tiga';
	if ($n ==4)
		return 'Empat';
	if ($n ==5)
		return 'Lima';
	if ($n ==6)
		return 'Enam';
	if ($n ==7)
		return 'Tujuh';
	if ($n ==8)
		return 'Delapan';
	if ($n ==9)
		return 'Sembilan';

	return '';
}


function tgl_indo($tgl){
			$tanggal = substr($tgl,0,2);
			$bulan = getBulan(substr($tgl,3,2));
			$tahun = substr($tgl,6,4);
			return $tanggal.' '.$bulan.' '.$tahun;
	}
function getBulan($bln){
				switch ($bln){
					case 1:
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			}


function int2huruf($n) {
	if (is_null($n) OR !is_numeric($n))
		return '';

	if ($n >= 86)
		return 'A';

	if ($n >= 71)
		return 'B';

	if ($n >= 56)
		return 'C';

	if ($n >= 41)
		return 'D';

	return 'E';
}

function style_ktsp_v1()
{
	$html='
	<style type="text/css">
		@page {
			sheet-size: 210mm 297mm ;
			margin: 30px 30px 0px 30px;
            footer: html_footer_pagenum;
		}
        .page-notend{
			page-break-after: always;
		}
		
		.style2 {font-size: 16px;}
		.style3 {font-size: 15px;}
		
		#halaman_akhir {
		/*height:1500px;*/
		padding-top:-45;
		}
		#halaman {
		padding-top:-45;
		page-break-after:always;
		}
		.style1 {font-size: 13px}
		.style4 {
		font-size: 13px;
		}
		.style5 {font-size: 11px}
		
		.kecil td{
		font-size: 12px;
		padding:4px 5px 4px 5px;
		}
		
		.sedang td{
		font-size: 12px;
		padding:10px 5px 10px 5px;
		}
		.sedang_alone{
			padding:20px 5px 8px 5px;
		}
		.mini td{
		padding:2px 5px 2px 5px;
		}
		.besar td{
		padding:8x 5px 8px 5px;
		}
		.style6 {font-size: 13px; }
		.style7 {font-size: 13px;}
		.style8 {
			font-size: 16px;
		}
	</style>
      ';
	return $html;
}

function header_ktsp_v1($row,$row_per_siswa)
{
	$smster_nama = '2(dua)';
	if($row['semester_nama'] == 'gasal'){
		$smster_nama = '1(satu)';
	}
	
	$html= '
	
		<table width="100%" border="0" style="width: 100%;">
			<tr>
				<td width="23%"	valign="top"><span class="style1">Nama Peserta Didik</span> </td>
				<td width="1%" valign="top"><span class="style1">:</span></td>
				<td width="35%" valign="top"><span class="style1">'.$row_per_siswa["siswa_nama"].'</span></td>
			  
				<td width="21%" valign="top"><span class="style1">Kelas/Semester</span></td>
				<td width="1%" valign="top"><span class="style1">:</span></td>
				<td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$row_per_siswa["kelas_nama"].'/
				'.$smster_nama.'</span></td>
			</tr>
			<tr>
				<td valign="top"><span class="style1">Nomor Induk</span> </td>
				<td valign="top"><span class="style1">:</span></td>
				<td valign="top"><span class="style1">'.$row_per_siswa["siswa_nis"].'</span> </td>
			  
				<td valign="top"><span class="style1">Tahun Pelajaran</span></td>
				<td valign="top"><span class="style1">:</span></td>
				<td valign="top"><span class="style1">'.$row["ta_nama"].'</span></td>
			  
			</tr>
			<tr>
				<td valign="top"><span class="style1">Nama Sekolah</span> </td>
				<td valign="top"><span class="style1">:</span></td>
				<td colspan="4" valign="top"><span class="style1">'.APP_SCHOOL.'</span> </td>
			</tr>
		</table>
	';
	return $html;
}

function footer_pagenum_v1($data)
{
	$html= '
	<div id="footer_pagenum" class="footer">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="foot-text">
						<span class="style1">'.$data['kelas_nama'].'</span>
                    </td>
                    <td class="foot-text" align="right">
                       <!-- Hal. {PAGENO}-->
                      <span class="style1"> Semeter '.$data['semester_nama'].' - '.$data["ta_nama"].'</span>
                    </td>
                </tr>
            </table>
        </div>';
	return $html;
}

function footer_ktsp_v1($data,$lembar)
{
	if($data['tanggal_uas_nama']=="")
		$data['tanggal_uas_nama'] = "2 Mei 2017";
	$html= '
		<table border="0" style="width: 100%;">
			<tr>
				<td width="24%" align="left" valign="top"></td>
				<td width="10%"></td>
				<td width="38%" align="left" valign="top"></td>
				<td  align="left" valign="top">
				<div align="right" class="style6">
				'.$data['kota_nama'].', '.$data['tanggal_uas_nama'].'</div>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top">
					<p class="style6">
						Orang Tua/Wali<br/>
						Peserta Didik<br/>
						<br/><br/><br/><br/>
						<hr/>			
					</p>    
				</td>
				<td ></td>
				<td  align="left" valign="top">';
				if(($lembar==1)||($lembar==3))
				{
	$html.= '
					<p class="style6">
						Mengetahui,<br/>
						Kepala Sekolah<br/>
						<br/><br/><br/><br/>
						'.$data['kepsek_nama'].'<br />
						NIP : '.$data['kepsek_nip'].'</p>';    
				}
	$html.= '	</td>
				<td align="left" valign="top">
					<p class="style6">
						<br>
						Wali Kelas '.$data['kelas_nama'].',<br/>
						<br/><br/><br/><br/>
						'.$data['wali_nama'].'<br/> 
						NIP : '.$data['wali_nip'].'
					</p>    
				</td>
			</tr>
		</table>
	';
	return $html;
}

function ketercapaian_kompetensi_ktsp_v1($resultset_array)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	
	$html=
	'
		<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="sedang">
			<tr>
				<th height="30px" width="6%"><div class="style3">No.</div></th>
				<th width="34%"><div class="style3">Komponen</div></th>
				<th width="60%"><div class="style3">Ketercapaian Kompetensi</div></th>
			</tr>';
			$bintang='';
			foreach ($resultset_array['data'] as $idx => $item): 
			if ($item['kategori_nama'] != $ktg_nama):
				$ktg_ascii++;
				if(chr($ktg_ascii)=='B')
				{	$bintang = ' **)';	}
				
                $mp_no = 0;

				
	//			if($item['kategori_kode']=='mapel'):
	$html.=
	'
			<tr>
				<td height="30px" align="center" valign="middle"><div class="style3 styleb"><b>'.chr($ktg_ascii).'.</b></div></td>
				<td valign="middle"><div class="style3 styleb"><b>'.$item['kategori_nama'].$bintang.' </b></div></td>
				<td valign="middle" align="center">&nbsp;</td>
			</tr>';/*
				elseif($item['kategori_kode']=='mulok'):
	$html.=
	'
			<tr>
				<td height="30px" align="center" valign="middle"><div class="style3">B.</div></td>
				<td valign="middle"><div class="style3">Mata Pelajaran </div></td>
				<td valign="middle" align="center">&nbsp;</td>
			</tr>';
				endif;*/
				
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
			
	$html.='
				<tr>
					<td height="30px" align="center" valign="middle"><div class="style3">'.$mp_no.'.</div></td>
					<td valign="middle"><div class="style3">'.$item['mapel_nama'].'</div></td>
					<td valign="middle" align="left"><div align="center" class="style3">
					<div align="left">';
					
				//	if ($item['ketuntasan'] != '' and $item['kompetensi']!='') {
	$html.= 			$item['kompetensi'];
				//		} else {}
	$html.='			&nbsp; 
					</div></div>
					</td>
				</tr>';
			endforeach;
			/*
	$html.='<tr>
				<td height="30px" align="center" valign="middle"><div class="style3">B</div></td>
				<td valign="middle"><div class="style3">Muatan Lokal **) </div></td>
				<td valign="middle" align="left"><div align="left"></div></td>
			</tr>';
			foreach ($nilaimulok['data'] as $idx => $item): 
			$no = $idx + 1;
	$html.='
				<tr>
					<td height="30px" align="center" valign="middle"><div class="style3">'.$no.'.</div></td>
					<td valign="middle"><div class="style3">'.$item['mapel_nama'].'</div></td>
					<td valign="middle" align="left"><div align="center" class="style3">
						<div align="left">';
					
				//	if ($item['ketuntasan'] != '' and $item['kompetensi']!='') {
	$html.= 			$item['kompetensi'];
				//		} else {}
	$html.='			&nbsp; 
					</div></div>
					</td>
				</tr>';
			endforeach;*/
	$html.='		
		</table>
	';
	
	return $html;
}

function pengembangan_diri_ktsp_v1($ekskul_result, $org_result)
{
	$html='
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="mini">
		';
	
	///// EKSKUL
	$html.='
			<tr>
				<th width="5%"><span class="style4">No.</span></th>
				<th ><span class="style4">Jenis Kegiatan </span></th>
				<th width="70%"><span class="style4">Keterangan</span></th>
			</tr>	
			<tr>
				<td align="center" valign="middle"><span class="style4"><strong>A.</strong></span></td>
				<td valign="middle"><span class="style4"><strong>Kegiatan Extrakurikuler </strong></span></td>
				<td valign="middle" align="center"><span class="style4"></span></td>
			</tr>
	';	
	
	$x=1;
	foreach ($ekskul_result['data'] as $_idx => $_row)
	{
		$html.='
			<tr>
				<td align="center" valign="middle"><span class="style4">'.$x.'.</span></td>
				<td valign="middle"><span class="style4">'.$_row['ekskul_nama'].'</span></td>
				<td valign="middle" align="left"><span class="style4">'.$_row['nilai'].' , '.$_row['keterangan'].'</span></td>
			</tr>
		';
		$x++;
	}
		
	for ($i = $x; $i <= 3; $i++) {
		
		$html.='
			<tr>
				<td align="center" valign="middle"><span class="style4">'.$i.'.</span></td>
				<td valign="middle"><span class="style4">-</span></td>
				<td valign="middle" align="left"><span class="style4">-</span></td>
			</tr>
		';
	}
	
	/// ORANISASI
	$html.='
		
			<tr>
				<td align="center" valign="middle"><span class="style4"><strong>B.</strong></span></td>
				<td valign="middle"><span class="style4"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah </strong></span></td>
				<td valign="middle" align="left"><span class="style4"></span></td>
			</tr>';
	$x=1;	
	foreach ($org_result['data'] as $_idx => $_row)
	{
		$html.='
			<tr>
				<td align="center" valign="middle"><span class="style4">'.$x.'.</span></td>
				<td valign="middle"><span class="style4">'.$_row['org_nama'].'</span></td>
				<td valign="middle" align="left"><span class="style4">'.$_row['nilai'].' , '.$_row['keterangan'].'</span></td>
			</tr>
		';
		$x++;
	}
		
	for ($i = $x; $i <= 3; $i++) {
		
		$html.='
			<tr>
				<td align="center" valign="middle"><span class="style4">'.$i.'.</span></td>
				<td valign="middle"><span class="style4">-</span></td>
				<td valign="middle" align="left"><span class="style4">-</span></td>
			</tr>
		';
	}
			
	$html.='
		</table>
		';
	return $html;
	
	
}

function akhlak_ktsp_v1($row)
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
			'ritualibadah'	 => 'Pelaksanaan Ibadah Ritual',
		);
		
	$kepribadian = (array) json_decode($row['kepribadian'], TRUE);
	$kode_kepribadian = (array) json_decode($row['kode_kepribadian'], TRUE);
	$html='
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="besar">
			<tr>
				<th width="5%"><div class="style4">No.</div></th>
				<th width="25%"><div class="style4">Kepribadian  </div></th>
				<th width="11%"><div class="style4">Nilai</div></th>
				<th ><div class="style4">Keterangan</div></th>
			</tr>';
			
	$no_aspek= 0;
	foreach ($aspek_array as $idx => $label):
		$no_aspek++;
		$html.='			
			  <tr>
				<td align="center" valign="middle"><div class="style4">'.$no_aspek .'.</div></td>
				<td valign="middle"><div class="style4">'.$label .'</div></td>
				<td align="center" valign="middle"><div class="style8"><b>'.array_node($kode_kepribadian, $idx) .'</b></div></td>
				<td valign="middle"><div class="style5">'.array_node($kepribadian, $idx) .'</div></td>
			  </tr>';
	endforeach;
			
	$html.='
		</table>
		';
	return $html;
}

function akhlak_ktsp_v2($row)
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
			'ritualibadah'	 => 'Pelaksanaan Ibadah Ritual',
		);
		
	$kepribadian = (array) json_decode($row['kepribadian'], TRUE);
	$kode_kepribadian = (array) json_decode($row['kode_kepribadian'], TRUE);
	$html='
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
			<tr>
				<th width="5%"><div class="style4">No.</div></th>
				<th width="25%"><div class="style4">Kepribadian  </div></th>
				<th width="11%"><div class="style4">Nilai</div></th>
				<th ><div class="style4">Keterangan</div></th>
			</tr>';
			
	$no_aspek= 0;
	foreach ($aspek_array as $idx => $label):
		$no_aspek++;
		$html.='			
			  <tr>
				<td align="center" valign="middle"><div class="style4">'.$no_aspek .'.</div></td>
				<td valign="middle"><div class="style4">'.$label .'</div></td>
				<td align="center" valign="middle"><div class="style8"><b>'.array_node($kode_kepribadian, $idx) .'</b></div></td>
				<td valign="middle"><div class="style5">'.array_node($kepribadian, $idx) .'</div></td>
			  </tr>';
	endforeach;
			
	$html.='
		</table>
		';
	return $html;
}

function ketidakhadiran_ktsp_v1($row)
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
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
			<tr>
				<th width="5%"><span class="style4">No.</span></th>
				<th ><span class="style4">Alasan</span></th>
				<th width="70%"><span class="style4">Keterangan</span></th>
			</tr>
			<tr>
				<td align="center" valign="middle"><span class="style4">1.</span></td>
				<td valign="middle"><span class="style4">Sakit</span></td>
				<td valign="middle" align="center"><span class="style4">'.$absen_s.'</span></td>
			</tr>
			<tr>
				<td align="center" valign="middle"><span class="style4">2.</span></td>
				<td valign="middle"><span class="style4">Izin</span></td>
				<td valign="middle" align="center"><span class="style4">'.$absen_i.'</span></td>
			</tr>
			<tr>
				<td align="center" valign="middle"><span class="style4">3.</span></td>
				<td valign="middle"><span class="style4">Tanpa Keterangan </span></td>
				<td valign="middle" align="center"><span class="style4">'.$absen_a.'</span></td>
			</tr>
		</table>
		';
	return $html;
}

function catatan_kenaikan_kelas_ktsp_v1($row,$row_per_siswa)
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
	
	if(($row['semester_nama']=='gasal')||($row['kelas_grade']==12)){
		$html = '';
	}
	
	return $html;
}

function catatan_ktsp_v1(){
	$html= '
		<table>
			<tr>
				<td width="60px" align="right"><div class="style1">*)</div></td>
				<td><div class="style1">Diisi dengan Keterampilan / Bahasa Asing yang diikuti peserta didik</div></td>
			</tr>
			<tr>
				<td align="right"><div class="style1">**)</div></td>
				<td><div class="style1">Diisi dengan program muatan lokal yang diikuti peserta didik</div></td>
			</tr>
		</table>';
	return $html;
}


function table_nilai_ktsp_v1($resultset)
{
	$html='
		<table cellspacing="0" cellpadding="4" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
		  <tr>
			<th width="5%" rowspan="3">No.</th>
			<th width="35%" rowspan="3">Komponen</th>
			<th width="14%" rowspan="3">Kriteria Ketuntasan Minimal (KKM)</th>
			<th colspan="5">Nilai Hasil Belajar</th>
		  </tr>
		  <tr>
			<th colspan="2">Pengetahuan</th>
			<th colspan="2">Praktek</th>
			<th width="11%">Sikap</th>
		  </tr>
		  <tr>
			<th width="8%">Angka</th>
			<th width="10%">Huruf</th>
			<th width="8%">Angka</th>
			<th width="10%">Huruf</th>
			<th>Predikat</th>
		  </tr>	';
			
				$mp_no = 0;
				$ktg_ascii = 64;
				
				$ktg_nama = NULL;
				$antr_mapel = 0; 
				foreach ($resultset['data'] as $idx => $item): 
					 if ($item['kategori_nama'] != $ktg_nama):
						$ktg_ascii++;
						$mp_no = 0;
						//chr($i)
						$set_asci = 'A';
						if($item['kategori_kode']=='mapel'):
							$set_asci = 'A';
							$bintang = '';
						elseif($item['kategori_kode']=='mulok'):
							$set_asci = 'B';
							$bintang = ' **)';
						endif;
	$html.='
						 <tr>
							  <td align="center" valign="middle" >
								<div class="sedang_alone style3"><b>'.chr($ktg_ascii).'.</b></div></td>
							  <td valign="middle"><div class="style3"><b>'.$item['kategori_nama'].$bintang.'</b></div></td>
							  <td valign="middle" align="center">&nbsp;</td>
							  <td valign="middle" align="center">&nbsp;</td>
							  <td valign="middle" align="center">&nbsp;</td>
							  <td valign="middle" align="center">&nbsp;</td>
							  <td valign="middle" align="center">&nbsp;</td>
							  <td valign="middle" align="center">&nbsp;</td>
						  </tr>';
						$ktg_nama = $item['kategori_nama'];
					endif;
					$mp_no++;
	$html.='			
				<tr>
					<td align="center" valign="middle"><div class="style3">'.$mp_no.'.</div></td>
					<td valign="middle"><div class="style3">'.$item['mapel_nama'].'</div></td>
					<td valign="middle" align="center"><div align="center" class="style2">'.round($item['nipel_kkm']).'&nbsp; </div></td>
					<td valign="middle" align="center"><div align="center" class="style2">';
					if ($item['nas_teori']==0 or is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) ) {
	$html.='			-';
					} else {
	$html.=				($item['nas_teori']) ? round($item['nas_teori']) : '';
					}
	$html.=	'				
					&nbsp; </div></td>
					<td valign="middle" align="center"><div align="center" class="style7">';
					
					if ($item['nas_teori']==0 or is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) ) {
	$html.=	'			-';
					} else {
						
	$html.=	'				'.int2kata(substr(round($item["nas_teori"]),0,1)).' '
							.int2kata(substr(round($item["nas_teori"]),1,1)).' ' 
							.int2kata(substr(round($item["nas_teori"]),2,1)).' ';
					}
	$html.=	'					
					</div></td>
					<td valign="middle" align="center"><div align="center" class="style2">';

					if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=				($item['nas_praktek']) ? round($item['nas_praktek']) : '-';
					}
	$html.=	'
					&nbsp; </div></td>
					<td valign="middle" align="center"><div align="center" class="style7">';

					if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=	'				'.int2kata(substr(round($item["nas_praktek"]),0,1)).' '
							.int2kata(substr(round($item["nas_praktek"]),1,1)).' ' 
							.int2kata(substr(round($item["nas_praktek"]),2,1)).' ';
					}
	$html.=	'
					 </div></td>
					<td valign="middle" align="center"><div align="center" class="style2">'.$item['pred_sikap'].'</div></td>
				</tr>';
				endforeach;
	$html.=	'
		</table>';
		
	return $html;
}

function catatan_wali_kelas_ktsp_v1($row,$resultset_array){
	$html ='<table cellspacing="0" cellpadding="4" border="1" >
			<tr>
            <td align="right"><div class="style6"><b>&nbsp;Catatan Wali Kelas</b></div></td>
            <td><div class="style6"><span style="text-transform:uppercase;">: </span></div></td>
           </tr>
		   </table>';
	return $html;	   
}
?>