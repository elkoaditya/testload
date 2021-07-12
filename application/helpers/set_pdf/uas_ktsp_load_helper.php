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
////////////////////////////
//////////PDF///////////////
////////////////////////////

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
				<td width="35%" valign="top"><span class="style1"><em>'.$row_per_siswa["siswa_nama"].'</em></span></td>
			  
				<td width="21%" valign="top"><span class="style1">Kelas/Semester</span></td>
				<td width="1%" valign="top"><span class="style1">:</span></td>
				<td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$row["kelas_nama"].'/
				'.$smster_nama.'</span></td>
			</tr>
			<tr>
				<td valign="top"><span class="style1">Nomor Induk</span> </td>
				<td valign="top"><span class="style1">:</span></td>
				<td valign="top"><span class="style1">'.$row_per_siswa["siswa_nis"].'</span> </td>
			  
				<td valign="top"><span class="style1">Tahun Pelajaran</span></td>
				<td valign="top"><span class="style1">:</span></td>
				<td valign="top"><span class="style1">'.str_replace("/"," - ",$row["ta_nama"]).'</span></td>
			  
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

function header_ktsp_sma8_v1($row,$row_per_siswa)
{
	/*$smster_nama = '2(dua)';
	if($data['semester_nama'] == 'gasal'){
		$smster_nama = '1(satu)';
	}*/
	$html= '
	
		<table width="100%" border="0" style="width: 100%; padding-top:-27;">
			<tr>
				<td valign="top"><span class="style1"><b>Nama Peserta Didik</b></span> </td>
				<td valign="top"><span class="style1"><b>:</b></span></td>
				<td colspan="4" valign="top"><span class="style1"><em><b>'.$row_per_siswa["siswa_nama"].'</b></em></span></td>
			</tr>
			<tr>
				<td valign="top" width="23%"><span class="style1"><b>Nomor Induk</b></span> </td>
				<td valign="top" width="1%" ><span class="style1"><b>:</b></span></td>
				<td valign="top" width="35%" ><span class="style1"><b>'.$row_per_siswa["siswa_nis"].'</b></span> </td>
			  
			  
				<td width="21%" valign="top"><span class="style1"><b>Kelas/Semester</b></span></td>
				<td width="1%" valign="top"><span class="style1"><b>:</b></span></td>
				<td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;"><b>'.$row["kelas_nama"].'/
				'.strtoupper($row['semester_nama']).'</b></span></td>
			  
			</tr>
			<tr>
				<td valign="top"><span class="style1"><b>Nama Sekolah</b></span> </td>
				<td valign="top"><span class="style1"><b>:</b></span></td>
				<td valign="top"><span class="style1"><b>'.APP_SCHOOL.'</b></span> </td>
				
				<td valign="top"><span class="style1"><b>Tahun Pelajaran</b></span></td>
				<td valign="top"><span class="style1"><b>:</b></span></td>
				<td valign="top"><span class="style1"><b>'.str_replace("/"," - ",$row["ta_nama"]).'</b></span></td>
			</tr>
		</table>
		<br/>
	';
	return $html;
}

function header_ktsp_sma8_v2($row,$row_per_siswa)
{
	/*$smster_nama = '2(dua)';
	if($data['semester_nama'] == 'gasal'){
		$smster_nama = '1(satu)';
	}*/
	$html= '
	
		<table width="100%" border="0" style="width: 100%; padding-top:-27;">
			<tr>
				<td valign="top"><span class="style1"><b>Nama Peserta Didik</b></span> </td>
				<td valign="top"><span class="style1"><b>:</b></span></td>
				<td colspan="4" valign="top"><span class="style1"><em><b>'.$row_per_siswa["siswa_nama"].'</b></em></span></td>
			</tr>
			<tr>
				<td valign="top" width="23%"><span class="style1"><b>Nomor Induk</b></span> </td>
				<td valign="top" width="1%" ><span class="style1"><b>:</b></span></td>
				<td valign="top" width="33%" ><span class="style1"><b>'.$row_per_siswa["siswa_nis"].'</b></span> </td>
			  
			  
				<td width="19%" valign="top"><span class="style1"><b>Kelas/Semester</b></span></td>
				<td width="1%" valign="top"><span class="style1"><b>:</b></span></td>
				<td  valign="top"><span class="style1" style="text-transform:uppercase;"><b>'.$row["kelas_nama"].'/
				'.strtoupper($row['semester_nama']).'</b></span></td>
			  
			</tr>
			<tr>
				<td valign="top"><span class="style1"><b>Nama Sekolah</b></span> </td>
				<td valign="top"><span class="style1"><b>:</b></span></td>
				<td valign="top"><span class="style1"><b>'.APP_SCHOOL.'</b></span> </td>
				
				<td valign="top"><span class="style1"><b>Tahun Pelajaran</b></span></td>
				<td valign="top"><span class="style1"><b>:</b></span></td>
				<td valign="top"><span class="style1"><b>'.str_replace("/"," - ",$row["ta_nama"]).'</b></span></td>
			</tr>
		</table>
		<br/>
	';
	return $html;
}

function header_ktsp_penerbad_v0($row,$row_per_siswa)
{
	$smster_nama = '2(dua)';
	if($row['semester_nama'] == 'gasal'){
		$smster_nama = '1(satu)';
	}
	$nama_pk = explode(" ",$row["kelas_nama"] );
	
	$nama_pk_detail = "AirFrame & PowerPlant";
	if($nama_pk[1] == "KPU"){
		$nama_pk_detail = "Kelistrikan Pesawat Udara";
	}
	$html= '
	
		<table width="100%" border="0" style="width: 100%;">
			<tr>
				<td valign="top"><span class="style1">Nama Peserta Didik</span> </td>
				<td valign="top"><span class="style1">:</span></td>
				<td  valign="top"><span class="style1"><em>'.$row_per_siswa["siswa_nama"].'</em></span></td>
				
				<td valign="top"><span class="style1">Nomor Induk</span></td>
				<td valign="top"><span class="style1">:</span></td>
				<td valign="top" ><span class="style1">'.$row_per_siswa["siswa_nis"].'</span> </td>
			</tr>
			<tr>
				<td valign="top" ><span class="style1">Bidang Studi Keahlian</span> </td>
				<td valign="top"><span class="style1">:</span></td>
				<td colspan="4" valign="top" width="35%" ><span class="style1">Teknologi dan Rekayasa</span> </td>
			</tr>
			<tr>
				<td valign="top" width="23%"><span class="style1">Program Studi Keahlian</span> </td>
				<td valign="top" width="1%" ><span class="style1">:</span></td>
				<td valign="top" width="35%" ><span class="style1">Teknologi Pesawat Udara </span> </td>
			  
			  
				<td width="21%" valign="top"><span class="style1">Program Keahlian</span></td>
				<td width="1%" valign="top"><span class="style1">:</span></td>
				<td width="19%" valign="top">'.$nama_pk_detail.'</td>
			  
			</tr>
			<tr>
				
				<td valign="top"><span class="style1">Tahun Pelajaran</span></td>
				<td valign="top"><span class="style1">:</span></td>
				<td valign="top"><span class="style1">'.str_replace("/"," - ",$row["ta_nama"]).'</span></td>
				
				<td width="21%" valign="top"><span class="style1">Kelas/Semester</span></td>
				<td width="1%" valign="top"><span class="style1">:</span></td>
				<td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$row["kelas_nama"].'/
				'.$smster_nama.'</span></td>
			</tr>
		</table>
	';
	return $html;
}

function header_ktsp_penerbad_v1($row,$row_per_siswa)
{
	$smster_nama = strtoupper($row['semester_nama']);
	$nama_pk = explode(" ",$row["kelas_nama"] );
	
	$nama_pk_detail = "AirFrame & PowerPlant";
	if($nama_pk[1] == "KPU"){
		$nama_pk_detail = "Kelistrikan Pesawat Udara";
	}
	$html= '
	
		<table width="100%" border="0" style="width: 100%;">
			<tr>
				<td valign="top"><span class="style1">Nama Peserta Didik</span> </td>
				<td valign="top"><span class="style1">:</span></td>
				<td  valign="top"><span class="style1"><em>'.$row_per_siswa["siswa_nama"].'</em></span></td>
				
				<td valign="top"><span class="style1">Nomor Induk</span></td>
				<td valign="top"><span class="style1">:</span></td>
				<td valign="top" ><span class="style1">'.$row_per_siswa["siswa_nis"].'</span> </td>
			</tr>
			<tr>
				<td valign="top" ><span class="style1">Bidang Studi Keahlian</span> </td>
				<td valign="top"><span class="style1">:</span></td>
				<td colspan="4" valign="top" width="35%" ><span class="style1">Teknologi dan Rekayasa</span> </td>
			</tr>
			<tr>
				<td valign="top" width="23%"><span class="style1">Program Studi Keahlian</span> </td>
				<td valign="top" width="1%" ><span class="style1">:</span></td>
				<td valign="top" width="35%" ><span class="style1">Teknologi Pesawat Udara </span> </td>
			  
			  
				<td width="21%" valign="top"><span class="style1">Program Keahlian</span></td>
				<td width="1%" valign="top"><span class="style1">:</span></td>
				<td width="19%" valign="top">'.$nama_pk_detail.'</td>
			  
			</tr>
			<tr>
				
				<td valign="top"><span class="style1">Tahun Pelajaran</span></td>
				<td valign="top"><span class="style1">:</span></td>
				<td valign="top"><span class="style1">'.str_replace("/"," - ",$row["ta_nama"]).'</span></td>
				
				<td width="21%" valign="top"><span class="style1">Kelas/Semester</span></td>
				<td width="1%" valign="top"><span class="style1">:</span></td>
				<td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$row["kelas_nama"].'/
				'.$smster_nama.'</span></td>
			</tr>
		</table>
	';
	return $html;
}
function header_ktsp_nusput_v1()
{
	$html= '
		<div class="thead-4">
				KARTU HASIL STUDI
				<br/>
				SMK NUSAPUTERA 1
		</div>
	';
	return $html;
}
function profil_ktsp_nusput_v1($row,$row_per_siswa)
{
	$smster_nama = '2(dua)';
	if($row['semester_nama'] == 'gasal'){
		$smster_nama = '1(satu)';
	}
	$html= '
	
		<table class="t-profil" width="100%" border="0" style="">
			<tr>
				<td valign="top" width="65%">

					<table width="100%" border="0">
						<tr>
							<td>
								Nama Siswa
							</td>
							<td> : </td>
							<td>
								'.$row_per_siswa["siswa_nama"].'
							</td>
						</tr>
						<tr>
							<td>
								Nomor Induk
							</td>
							<td> : </td>
							<td>
								'.$row_per_siswa["siswa_nis"].'
							</td>
						</tr>
						<tr>
							<td>
								Bidang Keahlian
							</td>
							<td> : </td>
							<td>
								TEKNOLOGI INFORMASI DAN KOMUNIKASI
							</td>
						</tr>
						<tr>
							<td>
								Program Keahlian
							</td>
							<td> : </td>
							<td>
								TEKNIK KOMPUTER DAN INFORMATIKA
							</td>
						</tr>
						<tr>
							<td>
								Kompetensi Keahlian
							</td>
							<td> : </td>
							<td>
								TEKNIK KOMPUTER DAN JARINGAN
							</td>
						</tr>
					</table>

				</td>
				<td valign="top" width="35%">

					<table width="100%" border="0">
						<tr>
							<td>
								Tahun Pelajaran
							</td>
							<td> : </td>
							<td>
								'.str_replace("/"," - ",$row["ta_nama"]).'
							</td>
						</tr>
						<tr>
							<td>
								Kelas
							</td>
							<td> : </td>
							<td>
								'.$row["kelas_nama"].'
							</td>
						</tr>
						<tr>
							<td>
								Semester
							</td>
							<td> : </td>
							<td>
								'.$smster_nama.'
							</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>

	';
	return $html;
}
function header_ktsp_v1_terbang($data)
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
				<td width="17%" valign="top" >
					<b>Nama Siswa</b></td>
				<td width="1%" valign="top">:</td>
				<td valign="top" width="33%">
					<b>'.$cetak_nama.'</b></td>
				<td width="20%" valign="top"><b>Kelas/Semester</b></td>
				<td width="1%" valign="top">:</td>
				<td width="29%" valign="top"><span style="text-transform:uppercase;"><b>'.$data["kelas_nama"].'/'.$smster_nama.'</b></span></td>
			</tr>
			<tr>
				<td valign="top">
					<b>NIS</b>					</td>
				<td valign="top">:</td>
				<td valign="top">
					<b>'.$data["siswa_nis"].'</b></td>
	
				<td valign="top"><b>Tahun Pelajaran</b></td>
				<td valign="top">:</td>
				<td valign="top"><b>'.str_replace("/"," - ",$data["ta_nama"]).'</b></td>
			</tr>
	
		</table>
			
	';
	return $html;
}

function du_penerbad_v0($row){
	
	if($row['pkl_nama']!=""){
		$no="1.";
		
	}else{
		$no="<br/>";
		$row['pkl_nilai']="";
	}
	$asd = '';
	$html= '
		<table cellspacing="0" id="t-kompetensi" border="1" class="t-border" width="100%">
        <tr>
            <td class=" t-head2 t-border" >No</td>
            <td class=" t-head2 t-border" >Nama DU/DI atau Instansi Relawan</td>
            <td class=" t-head2 t-border" >Alamat</td>
            <td class=" t-head2 t-border" >Lama dan Waktu Pelaksanaan</td>
            <td class=" t-head2 t-border" >Nilai</td>
            <td class=" t-head2 t-border" >Predikat</td>
        </tr>
        <tr>
            <td class=" t-head2 t-border" >
                '.$no.'
            </td>
            <td class=" t-head2 t-border" >
				'.
				$row['pkl_nama']
			//	$presensi['data'][0]['pkl1_instansi']
				.'
            </td>
            <td class=" t-head2 t-border" >
				'.
				$row['pkl_alamat']
			//	$presensi['data'][0]['pkl1_alamat']
				.'
            </td>
            <td class=" t-head2 t-border" >
				'.
				$row['pkl_waktu']
			//	$presensi['data'][0]['pkl1_waktu']
				.'
            </td>
            <td class=" t-head2 t-border" >
				'.
				$row['pkl_nilai']
			//	$presensi['data'][0]['pkl1_nilai']
				.'
            </td>
            <td class=" t-head2 t-border" >
				'.
				$row['pkl_predikat']
			//	$presensi['data'][0]['pkl1_predikat']
				.'
            </td>
        </tr>
    </table>
		
		';
	return $html;
}

function du_penerbad_v1($row){
	
	if($row['pkl_nama']!=""){
		$no="1.";
		
	}else{
		$no="<br/>";
		//$row['pkl_nilai']="";
	}
	$asd = '';
	$html= '
		<table cellspacing="0" id="t-kompetensi" border="1" class="t-border" width="100%">
        <tr>
            <td class=" t-head2 t-border" width="5%" >No</td>
            <td class=" t-head2 t-border" width="25%">Nama DU/DI atau Instansi Relawan</td>
            <td class=" t-head2 t-border" width="30%">Alamat</td>
            <td class=" t-head2 t-border" width="20%">Lama dan Waktu Pelaksanaan</td>
            <td class=" t-head2 t-border" >Nilai</td>
            <td class=" t-head2 t-border" >Predikat</td>
        </tr>
        <tr>
            <td class=" t-head2 t-border" >
                1. 
            </td>
            <td class=" t-head2 t-border" >
				SATKER PUSPENERBAD
            </td>
            <td class=" t-head2 t-border" >
				JL. PUAD A. YANI SEMARANG
            </td>
            <td class=" t-head2 t-border" valign="middle" align="center" rowspan="2">
				1 BULAN (150 Jam)
            </td>
            <td class=" t-head2 t-border" valign="middle" align="center" rowspan="2">
				'.
				$row['pkl_nilai']
			//	$presensi['data'][0]['pkl1_nilai']
				.'
            </td>
            <td class=" t-head2 t-border" valign="middle" align="center" rowspan="2">
				'.
				$row['pkl_predikat']
			//	$presensi['data'][0]['pkl1_predikat']
				.'
            </td>
        </tr>
        <tr>
            <td class=" t-head2 t-border" >
                2. 
            </td>
            <td class=" t-head2 t-border" >
				BUSSINES CENTER SMK <br> PENERBANGAN K.A.B SEMARANG

            </td>
            <td class=" t-head2 t-border" >
				JL. Jembawan Raya 20A Semarang

            </td>
        </tr>
    </table>
		
		';
	return $html;
}
function du_nusput_v1($row){
	
	if($row['pkl_nama']!=""){
		$no="1.";
		
	}else{
		$no="<br/>";
	}
	$html= '
		<table cellspacing="0" id="t-kompetensi" border="1" class="t-border" width="100%">
			<tr>
				<td class=" t-head2 t-border" >No</td>
				<td class=" t-head2 t-border" width="18%" >Nama DU/DI atau Instansi Relawan</td>
				<td class=" t-head2 t-border" >Lokasi</td>
				<td class=" t-head2 t-border" >Jenis Kegiatan</td>
				<td class=" t-head2 t-border" width="34%">Lama dan Waktu</td>
			</tr>';
	
	$html.= '
			<tr>
				<td class=" t-head2 t-border" >'.$no.'</td>
				<td class=" t-head2 t-border" >'.$row['pkl_nama'].'</td>
				<td class=" t-head2 t-border" >'.$row['pkl_alamat'].'</td>
				<td class=" t-head2 t-border" >'.$row['pkl_keterangan'].'</td>
				<td class=" t-head2 t-border" >'.$row['pkl_waktu'].'</td>
			</tr>
		
		';
	
	$html.= '
		</table>';
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

function table2_nusput_v1($row,$ekskul_result){
	
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

function catatan_kenaikan_nusput_ktsp_v1($row)
{
	$html = '
		<table cellspacing="0" cellpadding="3" border="0" style="width:100%; border-collapse: collapse; min-height: 30px; border: 1px solid black;">
			<tr>
				<td height="50" valign="middle"  align="right" width="300px" style="border: none;">
					<b>Keputusan Rapat Dewan Guru</b>
				</td>
				<td valign="middle" style="border: none;">
					<span style="text-transform:uppercase;">: '.$row['ket_kenaikan_kelas'].'</span>
				</td>
			</tr>
		</table>';
	return $html;
	
}

function catatan_penerbad_ktsp_v1($row){
	$asd = '';
	$html= '
	
		<table cellspacing="0" class="t-border" style="width: 100%;">
			<tr>
				<td align="left">'.
				$row['note_walikelas']
					.'<br/><br/><br/>
				</td>
			</tr>
		</table>
	';
	return $html;
}
function catatan_nusput_ktsp_v1($row){
	$asd = '';
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
function catatan_sma8_ktsp_v1($row){
	$catatan = str_replace("\n", "<br/>", $row['note_walikelas']);
	$html= '
	<table cellspacing="0" cellpadding="2" border="1" style="width:100%;border-collapse: collapse;">
		<tr><td height="55" valign="top" align="left" style="padding:5px"><span class="style6"><b>Catatan Wali Kelas</b>
				<br/>'.
				$catatan

					.'<br/><br/><br/>
				</span>
			</td></tr>
	</table>
	';
	return $html;
}
function catatan_sma8_ktsp_v2($row){
	$catatan = str_replace("\n", "<br/>", $row['note_walikelas']);
	$html= '
	<table cellspacing="0" cellpadding="2" border="1" style="width:100%;border-collapse: collapse; margin-top:8px;">
		<tr><td height="55" valign="top" align="left" style="padding:5px"><span class="style6"><b>Catatan Wali Kelas</b>
				<br/>'.
				$catatan

					.'<br/><br/><br/>
				</span>
			</td></tr>
	</table>
	';
	return $html;
}
function Pernyataan_penerbad_ktsp_v1($data){
	
	//$naik_tingkat = $data["kelas_grade"]+1;
	$aray_naik_tingkat = array(10 => "X", 11 => "XI", 12 => "XII");
	$ket_kenaikan_kelas='';
	if($data["kelas_grade"]<=11){
		$ket_kenaikan_kelas = '<b>'.$data['ket_kenaikan_kelas'].'</b> ke kelas '.$aray_naik_tingkat[$data["kelas_grade"]+1];

		if($data['ket_kenaikan_kelas']=="")
		{
			$ket_kenaikan_kelas = '<b>NAIK</b> ke kelas '.$aray_naik_tingkat[$data["kelas_grade"]+1];
		}
	}
	/*			
	$ket_kenaikan_kelas = $data['ket_kenaikan_kelas'];
	if($data['ket_kenaikan_kelas']=='')
	{
		$ket_kenaikan_kelas = $aray_naik_tingkat[$data["kelas_grade"]+1];
	}
	*/
	if($data['tanggal_uas_nama']=="")
		$data['tanggal_uas_nama'] = "02 Mei 2017";
	
	$html= '
	
    <table cellspacing="0" class="t-border" style="width: 100%;">
        <tr>
            <td align="left">
                <br/><br/><br/>
            </td>
        </tr>
    </table>
	
    <table border="0" width="100%">
        <tr>
            <td width="50%">

                <table border="0">
                    <tr>
                        <td width="90px">Diberikan di</td>
                        <td>:</td>
                        <td>Semarang</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>'.$data['tanggal_uas_nama'] .'</td>
                    </tr>
                </table>

                <br/>

                Wali Kelas
                <br/><br/><br/><br/>
				'.$data['wali_nama'].'
                <br/>

                <br/><br/>
                Mengetahui :
                <br/>
                Orang Tua / Wali
                <br/><br/><br/><br/>
				<span style=" text-decoration: underline">...................</span>

			</td>
			<td width="50%" style="vertical-align: top; padding-top: 0.9em;">
			<br/><br/><br/>
			';
			if(strtolower($data['semester_nama'])=='genap'){
				
				$html .= 'Keputusan<br>
				Dengan memperhatikan hasil yang <br>
				Dicapai pada semester Gasal dan Genap<br>
				Maka ditetapkan : '.$ket_kenaikan_kelas;
				
				
			}else{
				$html .= '<br/><br/><br/>';
			}
			$html .= '
                <br/><br/><br/>
                
				Kepala Sekolah
                <br/><br/><br/><br/><br/>
				'.$data['kepsek_nama'].'
			</td>
        </tr>
    </table>
	';
	return $html;
}

function footer_ktsp_v1($data,$lembar)
{
	if($data['tanggal_uas_nama']=="")
		$data['tanggal_uas_nama'] = "02 Mei 2017";
	
	
	$nip=0;
	if(strpos(APP_SCOPE, 'sman') !== false)
	{
		$nip=1;
	}else
	{
		$data['wali_nip']	= ' - ';
		$data['kepsek_nip']	= ' - ';
	}
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
						Wali Kelas '.$data['kelas_nama'].',<br/>
						<br/><br/><br/><br/><br/>
						'.$data['wali_nama'].'<br/> 
						NIP : '.$data['wali_nip'].'
					</p>    
				</td>
			</tr>
		</table>
	';
	return $html;
}

function footer_ktsp_sma8_v1($data,$lembar)
{
	if($data['tanggal_uas_nama']=="")
		$data['tanggal_uas_nama'] = "02 Mei 2017";
	
	
	$nip=0;
	if(strpos(APP_SCOPE, 'sman') !== false)
	{
		$nip=1;
	}else
	{
		$data['wali_nip']	= ' - ';
		$data['kepsek_nip']	= ' - ';
	}
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
				<td align="left" valign="top">
					<p class="style6">
						Wali Kelas '.$data['kelas_nama'].',<br/>
						<br/><br/><br/><br/><br/>
						'.$data['wali_nama'].'<br/> 
						NIP : '.$data['wali_nip'].'
					</p>    
				</td>
				<td  align="left" valign="top">';
				if(($lembar==1)||($lembar==3))
				{
	$html.= '
					<p class="style6">
						Kepala Sekolah<br/>
						<br/><br/><br/><br/><br/>
						'.$data['kepsek_nama'].'<br />
						NIP : '.$data['kepsek_nip'].'</p>';    
				}
	$html.= '	</td>
				
			</tr>
		</table>
	';
	return $html;
}

function footer_penerbad_v0($data,$lembar)
{
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
				<td valign="bottom" align="center" style="width: 30%;">
					<p class="style6">
						Mengetahui,<br/>
						Kepala SMK Penerbangan<br/>
						Kartika Aqasa Bhakti
						<br/><br/><br/><br/>
						'.$data['kepsek_nama'].'<br />
					</p>    
				</td>
				<td ></td>
				<td valign="bottom" align="center" style="width: 30%;">';
				if(($lembar==1)||($lembar==3))
				{
	$html.= '
					<p class="style6">
						Nama Orangtua/Wali Siswa<br/><br/><br/>
						<br/><br/><br/><br/>
                    ...................................';
				}
	$html.= '	</td>
				<td valign="bottom" align="center" style="width: 35%;">
					<p class="style6">
						 Wali Kelas<br/><br/><br/>
						<br/><br/><br/><br/><br/>
						'.$data['wali_nama'].'
					</p>    
				</td>
			</tr>
		</table>
	';
	return $html;
}

function footer_penerbad_v1($data,$lembar)
{
	if($data['tanggal_uas_nama']=="")
		$data['tanggal_uas_nama'] = "02 Mei 2017";
	
	$html= '
		<table border="0" width="100%">
			<tr>
				<td width="35%" align="left" valign="top"></td>
				<td width="30%" align="left" valign="top"></td>
				<td  align="center" valign="top">
				<div align="left" class="style6">
				'.$data['kota_nama'].', '.$data['tanggal_uas_nama'].'</div>
				</td>
			</tr>
			<tr>
				<td valign="bottom" align="center" >
					<p class="style6">
						Mengetahui,<br/>
						Kepala SMK Penerbangan<br/>
						Kartika Aqasa Bhakti
						<br/><br/><br/><br/><br/><br/>
						'.$data['kepsek_nama'].'<br />
					</p>    
				</td>
				<td valign="bottom" align="center" >';
				if(($lembar==1)||($lembar==3))
				{
	$html.= '
					<p class="style6">
						Nama Orangtua/Wali Siswa<br/><br/><br/>
						<br/><br/><br/><br/>
                    ...................................';
				}
	$html.= '	</td>
				<td valign="bottom" align="center" >
					<p class="style6">
						 Wali Kelas<br/><br/>
						<br/><br/><br/><br/><br/>
						'.$data['wali_nama'].'
					</p>    
				</td>
			</tr>
		</table>
	';
	return $html;
}
function footer_ktsp_v1_terbang($data,$lembar)
{
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

function footer_pagenum_v1($data)
{
	if($data['tanggal_uas_nama']=="")
		$data['tanggal_uas_nama'] = "02 Mei 2017";
	
	if(APP_SCOPE=='sma_setiabudhi')
	{
		$font='style="font-size:11px;';
	}else{
		$font='';
	}
	$html= '
	<div id="footer_pagenum" class="footer">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="foot-text" '.$font.'>
						'.$data['kelas_nama'].'
                    </td>
                    <td class="foot-text" align="right" '.$font.'>
                       <!-- Hal. {PAGENO}-->
                       Semester '.$data['semester_nama'].' - '.$data["ta_nama"].'
                    </td>
                </tr>
            </table>
        </div>';
	return $html;
}
function style_ktsp_v1()
{
	$html='
	<style>
        #halaman_akhir {
		/*height:1500px;*/
			padding-top:-45;
		}
		#halaman {
			padding-top:-45;
			page-break-after:always;
		}
		.style1 {font-size: 14px}
		.style4 {
			font-size: 12px;
		}
		.style5 {font-size: 10px}

		.kecil td{
			font-size: 12px;
			padding:3px 5px 3px 5px;
		}
		.mini td{
			padding:2px 5px 2px 5px;
		}
		.besar td{
			padding:8x 5px 8px 5px;
		}
		.style6 {font-size: 12px; }
		.style7 {font-size: 12px;}
		.styleb {font-weight: bold;}
        </style>
      ';
	return $html;
}

function style_ktsp_sma8_v1()
{
	$html='
	<style>
		@page {
			sheet-size: 210mm 290mm ;
			margin: 40px;
            footer: html_footer_pagenum;
		}
        .page-notend{
			page-break-after: always;
		}

		<style type="text/css">
		<!--
		.style3 {font-size: 11px}
		-->
		#halaman {
			height:1500px;
		}
		.style4 {font-size: 11px}
	
		.kecil td{
			font-size: 12px;
			padding:3px 5px 3px 5px;
	
		}
		.style6 {font-size: 13px; }
	</style>
      ';
	return $html;
}

function style_ktsp_sma8_v2()
{
	$html='
	<style>
		@page {
			sheet-size: 210mm 290mm ;
			margin: 40px 60px 40px 60px;
            footer: html_footer_pagenum;
		}
        .page-notend{
			page-break-after: always;
		}

		<style type="text/css">
		<!--
		.style3 {font-size: 11px}
		-->
		#halaman {
			height:1500px;
		}
		.style4 {font-size: 11px}
	
		.kecil td{
			font-size: 12px;
			padding:3px 5px 3px 5px;
	
		}
		.style6 {font-size: 13px; }
	</style>
      ';
	return $html;
}

function style_ktsp_penerbad_v1()
{
	$html='
	<style>
		@page {
			sheet-size: 210mm 330mm ;
			margin: 20px;
            footer: html_footer_pagenum;
		}
        .page-notend{
			page-break-after: always;
		}

		.style7 {font-size: 11px; font-weight: bold; }
		.style8 {font-size: 11px}
		.style11 {font-size: 12px}
		.style14 {
			font-size: 14px;
		}
		.style24 {
			font-size: 24px;
			font-weight: bold;
		}
		.style17 {font-size: 24px}
		.style18 {font-size: 36px}
		.style19 {font-size: 28px}

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
		#t-nilai
		{
			width: 100%;
		}
		.thead-1{
			vertical-align: middle;
			text-align: center;
		}
		.thead-1-red{
			vertical-align: middle;
			text-align: center;
			color:#FF0000;
		}
		.thead-2{
			vertical-align: middle;
			text-align: center;
			padding: 7px;
		}
		.thead-3{
			vertical-align: top;
			text-align: center;
		}
		.thead-4{
			width: 100%;
			font-size: 18px;
			text-align: center;
			font-family: cursive;
		}
		.field-nilai
		{
			font-size: 12px;
			padding: 7px 12px 7px 7px;
		}
		.f-kompetensi{
			font-size: 12px;
			padding: 3px 7px;
		}


		#header-rapor{
			text-align: center;
			font-family: Arial;
			font-size: 120%;
		}
		.t-siswa tr td{
			padding: 2px 5px 2px 2px;
		}

		.t-ekskul{
			margin: 0px;
			width: 245px;
		}
		.thead-ekskul{
			text-align: center;
			margin: 4px;
			font-weight: bold;
		}

		.tx-ekskul{
			font-size: 12px;

		}
		.backgrounds{

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

function style_ktsp_sethiabudhi_v1()
{
	$html='
	<style>
		@page {
			sheet-size: 210mm 290mm ;
			margin: 40px;
            footer: html_footer_pagenum;
		}
        .page-notend{
			page-break-after: always;
		}

		<!--
		.style3 {font-size: 11px}
		-->
		#halaman {
		height:1500px;
		}
		.style4 {font-size: 11px}
		
		.kecil td{
		font-size: 14px;
		padding:5px 5px 5px 5px;
		
		}
		.style6 {font-size: 13px; }
		
		.backgrounds{

				background-image: url('.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.gif);
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position: 90px 90px; 
		}
        </style>
      ';
	return $html;
}

function style_ktsp_v1_terbang()
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
		.style6 {font-size: 12px !important; }
		.style8 {padding:5px 5px 5px 5px; }
	</style>  ';
	return $html;
}

function catatan_kenaikan_kelas_ktsp_v1($row,$data)
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
					
				
	$html.='	
								 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Naik / Tidak Naik *) &nbsp;&nbsp;&nbsp;&nbsp;ke Kelas XI / XII *)
			
							</span>'; 
	//$html.=					$kekelas;
	
	$html.='				</div>
						</td>
					</tr>';
				} 
			/*
			if($row['kelas_grade']==10)
				{
	$html.='		<tr>
						<td align="left"><div class="style6"><b>&nbsp;Program</b></div></td>
						<td><div class="style6"><span style="text-transform:uppercase;">: IPA / IPS </span></div></td>
					</tr>';
				}*/
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

function catatan_kenaikan_kelas_ktsp_v2($row,$data)
{
	$kekelas = "Ke Kelas XII";
	if($row['kelas_grade']==10){
		$kekelas = "Ke Kelas XI";
	}
	$html='
		
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;margin-top:8px" >
			<tr><td height="50" valign="top" align="left">
			<table>';
			
			if($row['kelas_grade']==12)
				{
	$html.='
					<tr>
						<td align="right"><div class="style6"><b>Telah menyelesaikan seluruh program pembelajaran di SMA Negeri 8 Semarang
						sampai kelas XII</b></div></td>
					</tr>';
				}
			if($row['kelas_grade']!=12)
				{
	$html.='
					<tr>
						<td align="right"><div class="style6"><b>&nbsp;Hasil Keputusan Rapat</b></div></td>
					
						<td><div class="style6">
							<span style="text-transform:uppercase;">: ';
					
				
	$html.='	
								 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Naik / Tidak Naik *) &nbsp;&nbsp;&nbsp;&nbsp;ke Kelas XI / XII *)
			
							</span>'; 
	//$html.=					$kekelas;
	
	$html.='				</div>
						</td>
					</tr>';
				} 
			/*
			if($row['kelas_grade']==10)
				{
	$html.='		<tr>
						<td align="left"><div class="style6"><b>&nbsp;Program</b></div></td>
						<td><div class="style6"><span style="text-transform:uppercase;">: IPA / IPS </span></div></td>
					</tr>';
				}*/
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

function kenaikan_sma8_ktsp_v1($row){
	
	$html= '';
	if ((strtolower($row["semester_nama"]) == "genap") && ($row['kelas_grade']==12))
	{
		$html.='
			<table cellpadding="2" border="1" style="width:100%;border-collapse: collapse;">
				<tr>
					<td align="left">
					<b> Keterangan kelulusan : </b>
					<b>LULUS</b><br/><br/><br/>
					</td>
				</tr>
			</table>';
	}
	if ((strtolower($row["semester_nama"]) == "genap")&&($row["kelas_grade"] != 12))
	{
		$html= '
		
			<table cellpadding="2" border="1" style="width:100%;border-collapse: collapse;">
				<tr>
					<td align="left">
					<b> Keterangan Kenaikan Kelas : </b>
					'.
					
						$row['ket_kenaikan_kelas']
						.'<br/><br/><br/>
					</td>
				</tr>
			</table>
		';
	}
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
				<th width="4%"><span class="style4">No.</span></th>
				<th width="25%"><span class="style4">Alasan</span></th>
				<th width="71%"><span class="style4">Keterangan</span></th>
			</tr>
			<tr>
				<td align="center" valign="middle"><span class="style4">1.</span></td>
				<td valign="middle"><span class="style4">Sakit</span></td>
				<td valign="middle"><span class="style4">'.$absen_s.'</span></td>
			</tr>
			<tr>
				<td align="center" valign="middle"><span class="style4">2.</span></td>
				<td valign="middle"><span class="style4">Izin</span></td>
				<td valign="middle" ><span class="style4">'.$absen_i.'</span></td>
			</tr>
			<tr>
				<td align="center" valign="middle"><span class="style4">3.</span></td>
				<td valign="middle"><span class="style4">Tanpa Keterangan </span></td>
				<td valign="middle"><span class="style4">'.$absen_a.'</span></td>
			</tr>
		</table>
		';
	return $html;
}

function ketidakhadiran_penerbad_ktsp_v0($row)
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
				<th width="4%"><span class="style4">No.</span></th>
				<th width="25%"><span class="style4">Alasan</span></th>
				<th width="71%"><span class="style4">Keterangan</span></th>
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
function ketidakhadiran_penerbad_ktsp_v1($row)
{
	$absen_s = '0 hari';
	$absen_i = '0 hari';
	$absen_a = '0 hari';
	
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
				<th width="4%"><span class="style4">No.</span></th>
				<th width="25%"><span class="style4">Alasan</span></th>
				<th width="71%"><span class="style4">Keterangan</span></th>
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
				<th width="4%"><div class="style4">No.</div></th>
				<th width="25%"><div class="style4">Kepribadian  </div></th>
				<th width="11%"><div class="style4">Nilai</div></th>
				<th width="60%"><div class="style4">Keterangan</div></th>
			</tr>';
			
	$no_aspek= 0;
	foreach ($aspek_array as $idx => $label):
		$no_aspek++;
		$html.='			
			  <tr>
				<td align="center" valign="middle"><div class="style4">'.$no_aspek .'.</div></td>
				<td valign="middle"><div class="style4">'.$label .'</div></td>
				<td align="center" valign="middle"><div class="style4"><b>'.array_node($kode_kepribadian, $idx) .'</b></div></td>
				<td valign="middle"><div class="style5">'.array_node($kepribadian, $idx) .'</div></td>
			  </tr>';
	endforeach;
			
	$html.='
		</table>
		';
	return $html;
}

function akhlak_ktsp_sma8_v1($row)
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
				<th width="4%"><div class="style4">No.</div></th>
				<th width="25%"><div class="style4">Kepribadian  </div></th>
				<th width="71%"><div class="style4">Keterangan</div></th>
			</tr>';
			
	$no_aspek= 0;
	foreach ($aspek_array as $idx => $label):
		$no_aspek++;
		$html.='			
			  <tr>
				<td align="center" valign="middle"><div class="style4">'.$no_aspek .'.</div></td>
				<td valign="middle"><div class="style4">'.$label .'</div></td>
				<td valign="middle"><div class="style4">'.array_node($kepribadian, $idx) .'</div></td>
			  </tr>';
	endforeach;
			
	$html.='
		</table>
		';
	return $html;
}

function extra_aspri_penerbad_v0($ekskul_result,$row)
{
	$aspek_array = array(
			'kedisiplinan'	 => 'Kedisiplinan',
			'kebersihan'	 => 'Kebersihan',
			//'kesehatan'		 => 'Kesehatan',
			'tgjawab'		 => 'Tanggung Jawab',
			//'kesopanan'		 => 'Sopan Santun',
			'percayadiri'	 => 'Percaya Diri',
			//'kompetitif'	 => 'Kompetitif',
			'sosial'		 => 'Hubungan Sosial',
			'kejujuran'		 => 'Kejujuran',
			//'ritualibadah'	 => 'Pelaksanaan Ibadah Ritual',
		);
		
	$kepribadian = (array) json_decode($row['kepribadian'], TRUE);
	$kode_kepribadian = (array) json_decode($row['kode_kepribadian'], TRUE);
	
	foreach ($aspek_array as $idx => $label):
		$aspek_kepribadian[$idx] = array_node($kepribadian, $idx);
	endforeach;
	
	$width_komponen1 = 250;
	$html='
		<table cellspacing="0" class="t-border t-akhlak" width="100%" >
        <tr>
            <td colspan="2" align="center" class="thead-2 t-border">Komponen</td>
            <td align="center" width="'.$width_komponen1.'px" class="thead-2 t-border">Predikat</td>
        </tr>
        <tr>
            <td rowspan="3" align="center" width="'.$width_komponen1.'px" class="thead-2 t-border">
				Kegiatan Pengembangan Diri
			</td>';
			
			$x=1;	
			foreach ($ekskul_result['data'] as $_idx => $_row)
			{
				$html.='
					<td class=" t-border">'.$x.'.'.$_row['ekskul_nama'].'</td>
					<td align="center" class="thead-2 t-border">'.$_row['nilai'].' '.$_row['keterangan'].'</td>
					</tr>
					
				';
				$x++;
				if($x !=3){ 
					$html.='<tr>';
				}
			}
				
			for ($i = $x; $i <= 3; $i++) {
				
				$html.='
					<td class=" t-border"></td>
					<td align="center" class="thead-2 t-border">&nbsp;</td>
					</tr>
				';
				if($x !=3){ 
					$html.='<tr>';
				}
			}
			
	$html.='
        <tr>
            <td rowspan="4" align="center" class="thead-2 t-border">Kepribadian</td>
            <td class=" t-border">1. Keteladanan</td>
            <td align="center"  class="thead-2 t-border">'.
			$aspek_kepribadian['kebersihan']
			//$presensi['data'][0]['aspri_sopansantun']
			.'</td>
        </tr>
        <tr>
            <td class=" t-border">2. Kedisiplinan</td>
            <td align="center"  class="thead-2 t-border">'.
			$aspek_kepribadian['kedisiplinan']
			//$presensi['data'][0]['aspri_kedisiplinan']
			.'</td>
        </tr>
        <tr>
            <td class=" t-border">3. Tanggungjawab</td>
            <td align="center"  class="thead-2 t-border">'.
			$aspek_kepribadian['tgjawab']
			//$presensi['data'][0]['aspri_tanggungjawab']
			.'</td>
        </tr>
        <tr>
            <td class=" t-border">4. Kejujuran</td>
            <td  align="center"  class="thead-2 t-border">'.
			$aspek_kepribadian['kejujuran']
			//$presensi['data'][0]['aspri_kejujuran']
			.'</td>
        </tr>
    </table>';
			
	return $html;
}
function extra_aspri_penerbad_v1($ekskul_result,$row)
{
	$aspek_array = array(
			'kedisiplinan'	 => 'Kedisiplinan',
			'kebersihan'	 => 'Kebersihan',
			//'kesehatan'		 => 'Kesehatan',
			'tgjawab'		 => 'Tanggung Jawab',
			//'kesopanan'		 => 'Sopan Santun',
			'percayadiri'	 => 'Percaya Diri',
			//'kompetitif'	 => 'Kompetitif',
			'sosial'		 => 'Hubungan Sosial',
			'kejujuran'		 => 'Kejujuran',
			//'ritualibadah'	 => 'Pelaksanaan Ibadah Ritual',
		);
		
	$kepribadian = (array) json_decode($row['kepribadian'], TRUE);
	$kode_kepribadian = (array) json_decode($row['kode_kepribadian'], TRUE);
	
	foreach ($aspek_array as $idx => $label):
		$aspek_kepribadian[$idx] = array_node($kepribadian, $idx);
	endforeach;
	
	//$width_komponen1 = 250;
	$width_komponen1 = 150;
	$html='
		<table cellspacing="0" class="t-border t-akhlak" width="100%" >
        <tr>
            <td colspan="2" align="center" class="thead-2 t-border">Komponen</td>
            <td align="center" width="'.$width_komponen1.'px" class="thead-2 t-border" width="60%">Predikat</td>
        </tr>
        <tr>
            <td rowspan="3" align="center" width="'.$width_komponen1.'px" class="thead-2 t-border">
				Kegiatan Pengembangan Diri
			</td>';
			
			$x=1;	
			foreach ($ekskul_result['data'] as $_idx => $_row)
			{
				$html.='
					<td class=" t-border">'.$x.'.'.$_row['ekskul_nama'].'</td>
					<td align="center" class="thead-2 t-border">'.$_row['nilai'].' '.$_row['keterangan'].'</td>
					</tr>
					
				';
				$x++;
				if($x <4){ 
					$html.='<tr>';
				}
			}
				
			for ($i = $x; $i <= 3; $i++) {
				
				$html.='
					<td class=" t-border"></td>
					<td align="center" class="thead-2 t-border">&nbsp;</td>
					</tr>
				';
				if($x !=3){ 
					$html.='<tr>';
				}
			}
			
			if( ($row['semester_id']==2)&&($row['kelas_grade']=='12'))
			{
				$aspek_kepribadian['kebersihan'] = "B";
				
				$aspek_kepribadian['kedisiplinan'] = "B";
				
				$aspek_kepribadian['tgjawab'] = "B";
				
				$aspek_kepribadian['kejujuran'] = "B";
			}
	$html.='
        <tr>
            <td rowspan="4" align="center" class="thead-2 t-border">Kepribadian</td>
            <td class=" t-border">1. Keteladanan</td>
            <td align="center"  class="thead-2 t-border">'.
			$aspek_kepribadian['kebersihan']
			//$presensi['data'][0]['aspri_sopansantun']
			.'</td>
        </tr>
        <tr>
            <td class=" t-border">2. Kedisiplinan</td>
            <td align="center"  class="thead-2 t-border">'.
			$aspek_kepribadian['kedisiplinan']
			//$presensi['data'][0]['aspri_kedisiplinan']
			.'</td>
        </tr>
        <tr>
            <td class=" t-border">3. Tanggungjawab</td>
            <td align="center"  class="thead-2 t-border">'.
			$aspek_kepribadian['tgjawab']
			//$presensi['data'][0]['aspri_tanggungjawab']
			.'</td>
        </tr>
        <tr>
            <td class=" t-border">4. Kejujuran</td>
            <td  align="center"  class="thead-2 t-border">'.
			$aspek_kepribadian['kejujuran']
			//$presensi['data'][0]['aspri_kejujuran']
			.'</td>
        </tr>
    </table>';
			
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

function pengembangan_diri_ktsp_v1($ekskul_result, $org_result)
{
	$html='
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="mini">
		';
	
	///// EKSKUL
	$html.='
			<tr>
				<th width="4%"><span class="style4">No.</span></th>
				<th width="25%"><span class="style4">Jenis Kegiatan </span></th>
				<th width="71%"><span class="style4">Keterangan</span></th>
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
				<td align="center" valign="middle" width="20px"><span class="style4">'.$x.'.</span></td>
				<td valign="middle"><span class="style4">'.$_row['ekskul_nama'].'</span></td>
				<td valign="middle" align="left"><span class="style4">'.$_row['nilai'].' '.$_row['keterangan'].'</span></td>
			</tr>
		';
		$x++;
	}
		
	for ($i = $x; $i <= 3; $i++) {
		
		$html.='
			<tr>
				<td align="center" valign="middle" width="20px"><span class="style4">'.$i.'.</span></td>
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
				<td valign="middle" align="left"><span class="style4">'.$_row['nilai'].' '.$_row['keterangan'].'</span></td>
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

function pengembangan_diri_ktsp_sethiabudhi_v1($ekskul_result, $org_result)
{
	$html='
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="mini">
		';
	
	///// EKSKUL
	$html.='
			<tr>
				<th width="4%"><span class="style4">No.</span></th>
				<th colspan="2"><span class="style4">Jenis Kegiatan </span></th>
				<th width="71%"><span class="style4">Keterangan</span></th>
			</tr>	
			<tr>
				<td align="center" valign="middle"><span class="style4"><strong>A.</strong></span></td>
				<td valign="middle" colspan="2"><span class="style4"><strong>Kegiatan Extrakurikuler </strong></span></td>
				<td valign="middle" align="center"><span class="style4"></span></td>
			</tr>
	';	
	$widths = 20;
	$x=1;	
	foreach ($ekskul_result['data'] as $_idx => $_row)
	{
		$html.='
			<tr>
				<td></td>
				<td align="center" valign="middle" width="'.$widths.'px" class="style4">'.$x.'.</td>
				<td valign="middle"><span class="style4">'.$_row['ekskul_nama'].'</span></td>
				<td valign="middle" align="left"><span class="style4">'.$_row['nilai'].'  '.$_row['keterangan'].'</span></td>
			</tr>
		';
		$x++;
	}
	
		
	for ($i = $x; $i <= 5; $i++) {
		
		$html.='
			<tr>
				<td></td>
				<td align="center" valign="middle" width="'.$widths.'px" class="style4">'.$i.'.</td>
				<td valign="middle"><span class="style4">-</span></td>
				<td valign="middle" align="left"><span class="style4">-</span></td>
			</tr>
		';
	}
	
	/// ORANISASI
	$html.='
		
			<tr>
				<td align="center" valign="middle"><span class="style4"><strong>B.</strong></span></td>
				<td valign="middle" colspan="2"><span class="style4"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah </strong></span></td>
				<td valign="middle" align="left"><span class="style4"></span></td>
			</tr>';
	
	$x=1;
	foreach ($org_result['data'] as $_idx => $_row)
	{
		$html.='
			<tr>
				<td></td>
				<td align="center" valign="middle" width="'.$widths.'px" class="style4">'.$x.'.</td>
				<td valign="middle"><span class="style4">'.$_row['org_nama'].'</span></td>
				<td valign="middle" align="left"><span class="style4">'.$_row['nilai'].'  '.$_row['keterangan'].'</span></td>
			</tr>
		';
		$x++;
	}	
	for ($i = $x; $i <= 1; $i++) {
		
		$html.='
			<tr>
				<td></td>
				<td align="center" valign="middle" width="'.$widths.'px" class="style4">'.$i.'.</td>
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

function pengembangan_diri_sma8_ktsp_v1($ekskul_result, $org_result)
{
	$html='
		<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="mini">
		';
	
	///// EKSKUL
	$html.='
			<tr>
				<th width="4%"><span class="style4">No.</span></th>
				<th colspan="2"><span class="style4">Jenis Kegiatan </span></th>
				<th width="71%"><span class="style4">Keterangan</span></th>
			</tr>	
			<tr>
				<td align="center" valign="middle"><span class="style4"><strong>A.</strong></span></td>
				<td valign="middle" colspan="2"><span class="style4"><strong>Kegiatan Extrakurikuler </strong></span></td>
				<td valign="middle" align="center"><span class="style4"></span></td>
			</tr>
	';	
	$widths = 20;
	$x=1;	
	foreach ($ekskul_result['data'] as $_idx => $_row)
	{
		$html.='
			<tr>
				<td></td>
				<td align="center" valign="middle" width="'.$widths.'px" class="style4">'.$x.'.</td>
				<td valign="middle"><span class="style4">'.$_row['ekskul_nama'].'</span></td>
				<td valign="middle" align="left"><span class="style4">'.$_row['nilai'].' , '.$_row['keterangan'].'</span></td>
			</tr>
		';
		$x++;
	}
	
		
	for ($i = $x; $i <= 3; $i++) {
		
		$html.='
			<tr>
				<td></td>
				<td align="center" valign="middle" width="'.$widths.'px" class="style4">'.$i.'.</td>
				<td valign="middle"><span class="style4">-</span></td>
				<td valign="middle" align="left"><span class="style4">-</span></td>
			</tr>
		';
	}
	
	/// ORANISASI
	$html.='
		
			<tr>
				<td align="center" valign="middle"><span class="style4"><strong>B.</strong></span></td>
				<td valign="middle" colspan="2"><span class="style4"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah </strong></span></td>
				<td valign="middle" align="left"><span class="style4"></span></td>
			</tr>';
	
	$x=1;
	foreach ($org_result['data'] as $_idx => $_row)
	{
		$html.='
			<tr>
				<td></td>
				<td align="center" valign="middle" width="'.$widths.'px" class="style4">'.$x.'.</td>
				<td valign="middle"><span class="style4">'.$_row['org_nama'].'</span></td>
				<td valign="middle" align="left"><span class="style4"> '.$_row['keterangan'].'</span></td>
			</tr>
		';
		$x++;
	}	
	for ($i = $x; $i <= 3; $i++) {
		
		$html.='
			<tr>
				<td></td>
				<td align="center" valign="middle" width="'.$widths.'px" class="style4">'.$i.'.</td>
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

/*
function aaaaaaaaassssssssa($resultset_array){
	foreach ($resultset_array['data'] as $idx => $item): 
		echo "<pre>";
		print_r($item);
		echo "</pre>";
	endforeach;
}*/

function ketercapaian_kompetensi_ktsp_v1($resultset_array)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	
	$html=
	'
		<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
			<tr>
				<th height="30px" width="6%"><div class="style3">No.</div></th>
				<th width="28%"><div class="style3">Komponen</div></th>
				<th><div class="style3">Ketercapaian Kompetensi</div></th>
			</tr>';
			
			foreach ($resultset_array['data'] as $idx => $item): 
			if ($item['kategori_nama'] != $ktg_nama):
				$ktg_ascii++;

                $mp_no = 0;

				
	//			if($item['kategori_kode']=='mapel'):
	$html.=
	'
			<tr>
				<td height="30px" align="center" valign="middle"><div class="style3 styleb">'.chr($ktg_ascii).'.</div></td>
				<td valign="middle"><div class="style3 styleb">'.$item['kategori_nama'].' </div></td>
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
					
				if ($item['kompetensi']!='') {
	$html.= 			$item['kompetensi'];
						} else {
	$html.= 			$item['cat_teori'];
						}
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

function int2huruf_setiabudhi($n) {
	if (is_null($n) OR !is_numeric($n)) return '';
	/*
	if ($n >= 89.5) return 'A';
	if ($n >= 79.5) return 'B';
	if ($n >= 69.5) return 'C';
	
	//if ($n >= 41)
	//	return 'D';
	return 'K';
	*/
	//REVISI TERAKHIR
	if ($n >= 86.5) return 'A';
	if ($n >= 72.5) return 'B';
	if ($n >= 59.5) return 'C';
	
	return 'D';
}

function table_nilai_ktsp_v1($resultset)
{
	$html='
		<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
			<tr>
				<th width="5%" rowspan="3" class="style20">No.</th>
				<th width="220" rowspan="3" class="style20">Komponen</th>
				<th width="70" rowspan="3" class="style20">Kriteria Ketuntasan Minimal (KKM)</th>
				<th colspan="5" class="style20">Nilai Hasil Belajar</th>
			</tr>
			<tr>
				<th colspan="2" class="style20">Pengetahuan</th>
				<th colspan="2" class="style20">Praktek</th>
				<th width="11%" class="style20">Sikap</th>
			</tr>
			<tr>
				<th width="10" class="style20">Angka</th>
				<th class="style20">Huruf</th>
				<th width="10" class="style20">Angka</th>
				<th class="style20">Huruf</th>
				<th class="style20">Predikat</th>
			</tr>';
			
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
						elseif($item['kategori_kode']=='mulok'):
							$set_asci = 'B';
						endif;
	$html.='
						 <tr>
							  <td align="center" valign="middle"><div class="style3"><b>'.chr($ktg_ascii).'.</b></div></td>
							  <td valign="middle"><div class="style3"><b>'.$item['kategori_nama'].'</b></div></td>
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
					<td valign="middle" align="center"><div align="center" class="style3">';
					
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
					<td valign="middle" align="center"><div align="center" class="style3">';

					if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=	'				'.int2kata(substr(round($item["nas_praktek"]),0,1)).' '
							.int2kata(substr(round($item["nas_praktek"]),1,1)).' ' 
							.int2kata(substr(round($item["nas_praktek"]),2,1)).' ';
					}
	$html.=	'
					 </div></td>';
	
	if($item['pred_sikap']!='')
	{	$html.='		<td valign="middle" align="center"><div align="center">'.$item['pred_sikap'].'</div></td>';	}
	else
	{	$html.='		<td valign="middle" align="center"><div align="center">'.int2huruf_setiabudhi($item['nas_sikap']).'</div></td>';	}
	
	$html.='			</tr>';
				endforeach;
	$html.=	'
		</table>';
		
	return $html;
}

function table_nilai_ktsp_setiabudhi_v1($resultset)
{
	$html='
		<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
			<tr>
				<th width="5%" rowspan="3">No</th>
				<th width="34%" rowspan="3">Komponen</th>
				<th width="14%" rowspan="3">Kriteria Ketuntasan Minimal (KKM)</th>
				<th colspan="5">Nilai Hasil Belajar</th>
			  </tr>
			  <tr>
				<th colspan="2">Pengetahuan</th>
				<th colspan="2">Praktek</th>
				<th width="11%">Sikap</th>
			  </tr>
			  <tr>
				<th width="7%">Angka</th>
				<th width="12%">Huruf</th>
				<th width="6%">Angka</th>
				<th width="11%">Huruf</th>
				<th>Predikat</th>
			  </tr>';
			
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
						elseif($item['kategori_kode']=='mulok'):
							$set_asci = 'B';
						endif;
	$html.='
						 <tr>
							  <td align="center" valign="middle"><strong>'.chr($ktg_ascii).'.</strong></td>
							  <td valign="middle"><strong>'.$item['kategori_nama'].'</strong></td>
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
					<td align="center" valign="middle">'.$mp_no.'.</td>
					<td valign="middle">'.$item['mapel_nama'].'</td>
					<td valign="middle" align="center"><div align="center">'.round($item['nipel_kkm']).'&nbsp; </div></td>
					<td valign="middle" align="center">';
					if ($item['nas_teori']==0 or is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) ) {
	$html.='			-';
					} else {
	$html.=				($item['nas_teori']) ? round($item['nas_teori']) : '';
					}
	$html.=	'				
					&nbsp; </td>
					<td valign="middle" align="center"><div align="center" class="style3">';
					
					if ($item['nas_teori']==0 or is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) ) {
	$html.=	'			-';
					} else {
						
	$html.=	'				'.int2kata(substr(round($item["nas_teori"]),0,1)).' '
							.int2kata(substr(round($item["nas_teori"]),1,1)).' ' 
							.int2kata(substr(round($item["nas_teori"]),2,1)).' ';
					}
	$html.=	'					
					</div></td>
					<td valign="middle" align="center">';

					if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=				($item['nas_praktek']) ? round($item['nas_praktek']) : '-';
					}
	$html.=	'
					&nbsp; </td>
					<td valign="middle" align="center"><div align="center" class="style3">';

					if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=	'				'.int2kata(substr(round($item["nas_praktek"]),0,1)).' '
							.int2kata(substr(round($item["nas_praktek"]),1,1)).' ' 
							.int2kata(substr(round($item["nas_praktek"]),2,1)).' ';
					}
	$html.=	'
					 </div></td>';
	
	if($item['pred_sikap']!='')
	{	$html.='		<td valign="middle" align="center"><div align="center">'.$item['pred_sikap'].'</div></td>';	}
	else
	{	$html.='		<td valign="middle" align="center"><div align="center">'.int2huruf_setiabudhi($item['nas_sikap']).'</div></td>';	}
	
	$html.='			</tr>';
				endforeach;
	$html.=	'
		</table>';
		
	return $html;
}

function table_nilai_ktsp_sma8_v1($resultset)
{
	$html='
		<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
			<tr>
				<th width="6%" rowspan="3">No</th>
				<th  rowspan="3">Komponen</th>
				<th width="16%" rowspan="3">Kriteria Ketuntasan Minimal (KKM)</th>
				<th colspan="5">Nilai Hasil Belajar</th>
			</tr>
			<tr>
				<th colspan="2">Pengetahuan</th>
				<th colspan="2">Praktek</th>
				<th width="12%">Sikap</th>
			</tr>
			<tr>
				<th >Angka</th>
				<th width="12%">Huruf</th>
				<th >Angka</th>
				<th width="11%">Huruf</th>
				<th>Predikat</th>
			</tr>';
			
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
						elseif($item['kategori_kode']=='mulok'):
							$set_asci = 'B';
						endif;
	$html.='
						 <tr>
							  <td align="center" valign="middle"><b>'.chr($ktg_ascii).'.</b></td>
							  <td valign="middle"><b>'.$item['kategori_nama'].'</b></td>
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
					<td align="center" valign="middle">'.$mp_no.'.</td>
					<td valign="middle">'.$item['mapel_nama'].'</td>
					<td valign="middle" align="center">'.round($item['nipel_kkm']).'&nbsp; </td>
					<td valign="middle" align="center">';
					if (is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) ) {
	$html.='			-';
					} else {
	$html.=				($item['nas_teori']) ? round($item['nas_teori']) : '';
					}
	$html.=	'				
					&nbsp; </td>
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
					<td valign="middle" align="center">';

					if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) ) {
	$html.=	'			-';
					} else {
	$html.=				($item['nas_praktek']) ? round($item['nas_praktek']) : '-';
					}
	$html.=	'
					&nbsp; </td>
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
					<td valign="middle" align="center"><div align="center">'.$item['pred_sikap'].'</div></td>
				</tr>';
				endforeach;
	$html.=	'
		</table>';
		
	return $html;
}

function table_nilai_ktsp_penerbad_v0($resultset,$rerata)
{
	
		$set_classs_grey = "class=' t-border t-grey-background'";
		$set_classs = "class=' t-border '";
		$set_classs1 = "class='thead-1 t-border'";
		$set_classs1_red = "class='thead-1-red t-border'";

		$set_classs2 = "class='thead-2 t-border'";
		$set_classs3 = "class='thead-3 t-border'";
		$keseluruhan_rata2nilai = 0;
		$no_kategori = 0;
		
		
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;

	$jml_judul_pel = 0;
	$jml_judul_per_pel = 0;
	$type_judul_sementara = "";

	foreach ($resultset['data'] as $idx => $item):

		if ($item['kategori_kode'] != $ktg_nama):
			$ktg_nama = $item['kategori_kode'];
			$jml_row++;
		endif;

		$jml_row++;

	endforeach;

	$ktg_nama = NULL;
	$antr_mapel = 0;
	$jml_mapel[1] = 0;
	$keseluruhan_rata2nilai = 0;
	$no_judul_mapel = 0;
	foreach ($resultset['data'] as $idx => $item):
		$no_judul_mapel++;
		
		$mapel_jenis[$no_judul_mapel] = $item['kategori_id'];
		$mapel_kategori[$no_judul_mapel] = $item['kategori_nama'];

		$mapel_nama[$no_judul_mapel] = $item['mapel_nama'];
		$mapel_kkm[$no_judul_mapel] = round(75, 0);
		
		
		if(($item['nas_teori']=="")||($item['nas_teori']==0))
		{
			$mapel_nilai[$no_judul_mapel] = '-';
		}else
		{
			$mapel_nilai[$no_judul_mapel] = round($item['nas_teori'], 0);
		}
		////////// RENTANG PREDIKAT ////////////////
		if ($mapel_kategori[$no_judul_mapel] == "pdk")
		{
			// 100 - 70
			if ($mapel_nilai[$no_judul_mapel] >= 70)
			{
				$mapel_predikat[$no_judul_mapel] = "Kompeten";
			}
			else
			{ // 69-0
				$mapel_predikat[$no_judul_mapel] = "Belum Kompeten";
			}
		}
		else
		{
			// 100 - 90
			if ($mapel_nilai[$no_judul_mapel] >= 90)
			{
				$mapel_predikat[$no_judul_mapel] = "Amat Baik";
			}
			else if ($mapel_nilai[$no_judul_mapel] >= 75)
			{ // 89-75
				$mapel_predikat[$no_judul_mapel] = "Baik";
			}
			else if ($mapel_nilai[$no_judul_mapel] >= 60)
			{ // 74-60
				$mapel_predikat[$no_judul_mapel] = "Cukup";
			}
			else
			{ // 59-0
				$mapel_predikat[$no_judul_mapel] = "Kurang";
			}
		}

		//////////////sing kene bermasalah. nilai mesti 0/////////////////
		//if(($item['nas_ppk']=="")||($item['nas_ppk']==0))
		//{
		//	$mapel_rata_kelas[$no_judul_mapel] = round($rerata_mapel_kelas_uas[$item['mapel_id']]['data'][0]['rerata_uas'], 0);
		//	$mapel_rata_kelas[$no_judul_mapel] = '-';
		//}else
		//{
		//	$mapel_rata_kelas[$no_judul_mapel] = round($rerata_mapel_kelas[$item['mapel_id']]['data'][0]['rerata_nas_ppk'], 0);
			$mapel_rata_kelas[$no_judul_mapel] = $rerata[$item['pelajaran_id']];;
		//}

	endforeach;
	$max_mapel = 0;
	if ($no_judul_mapel != 0)
	{
		$max_mapel = max($mapel_jenis);
	}
		
		
	$html='
		<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
			<tr>
				<td  class="thead-2 t-border">No</td>
				<td  class="thead-2 t-border">Mata Pelajaran</td>
				<td  class="thead-2 t-border"> (KKM) </td>
				<td  class="thead-2 t-border"> NILAI</td>
				<td  class="thead-2 t-border"> PREDIKAT </td>
				<td  class="thead-2 t-border"> RATA KELAS </td>
			</tr>';
		for ($set_a = 1; $set_a <= $max_mapel; $set_a++)
		{
			$jml_row = 0;
			for ($set_b = 1; $set_b <= $no_judul_mapel; $set_b++)
			{
				if ($mapel_jenis[$set_b] == $set_a)
				{
					$mapel_array[$set_a] = $mapel_kategori[$set_b];
					$jml_row++;
				}
			}
			if ($jml_row != 0)
			{
				$no_kategori++;
	$html.="		<tr>";
	$html.="			<td rowspan=" . ($jml_row + 1) . " " . $set_classs3 . " >";
	$html.="				<b>" . $no_kategori . "</b>";
	$html.="			</td>";
	$html.="			<td colspan=5 " . $set_classs_grey . " >";
	$html.="				<b>" . $mapel_array[$set_a] . "</b>";
	$html.="			</td>";
	$html.="		</tr>";
				$no_mapel = 0;
				$no_mapel_nilai = 0;
				for ($set_b = 1; $set_b <= $no_judul_mapel; $set_b++)
				{
					if ($mapel_jenis[$set_b] == $set_a)
					{
						$no_mapel++;
	$html.="		<tr>";
	$html.="			<td " . $set_classs . " width='50%' >";
	$html.=					$no_mapel . ". " . $mapel_nama[$set_b];
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_kkm[$set_b];
	$html.="			</td>";
						if ($mapel_kkm[$set_b] > $mapel_nilai[$set_b])
						{
	$html.="				<td " . $set_classs1_red . " >";
						}
						else
						{
	$html.="				<td " . $set_classs1 . " >";
						}
	$html.=					$mapel_nilai[$set_b];
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_predikat[$set_b];
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_rata_kelas[$set_b];
	$html.="			</td>";
	$html.="		</tr>";
						$no_mapel_nilai += $mapel_nilai[$set_b];
					}
				}

	$html.="		<tr>";
	$html.="			<td " . $set_classs . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="				<b>RATA - RATA</b>";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
							$rata_mapel = round(($no_mapel_nilai / $no_mapel), 0);
	$html.=					$rata_mapel;
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="		</tr>";

				if ($set_a == 3)
				{
					$keseluruhan_rata2nilai += (2 * $rata_mapel);
				}
				else
				{
					$keseluruhan_rata2nilai += $rata_mapel;
				}
			}
		}
	$html.=	'
		</table>';
		
	return $html;
}

function table_nilai_ktsp_penerbad_v1($resultset,$rerata)
{
	
		$set_classs_grey = "class=' t-border t-grey-background'";
		$set_classs = "class=' t-border '";
		$set_classs1 = "class='thead-1 t-border'";
		$set_classs1_red = "class='thead-1-red t-border'";

		$set_classs2 = "class='thead-2 t-border'";
		$set_classs3 = "class='thead-3 t-border'";
		$keseluruhan_rata2nilai = 0;
		$no_kategori = 0;
		
		
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;

	$jml_judul_pel = 0;
	$jml_judul_per_pel = 0;
	$type_judul_sementara = "";

	foreach ($resultset['data'] as $idx => $item):

		if ($item['kategori_kode'] != $ktg_nama):
			$ktg_nama = $item['kategori_kode'];
			$jml_row++;
		endif;

		$jml_row++;

	endforeach;

	$ktg_nama = NULL;
	$antr_mapel = 0;
	$jml_mapel[1] = 0;
	$keseluruhan_rata2nilai = 0;
	$no_judul_mapel = 0;
	foreach ($resultset['data'] as $idx => $item):
		$no_judul_mapel++;
		
		$mapel_jenis[$no_judul_mapel] = $item['kategori_nourut'];
		$mapel_kategori[$no_judul_mapel] = $item['kategori_nama'];

		$mapel_nama[$no_judul_mapel] = $item['mapel_nama'];
		$mapel_kkm[$no_judul_mapel] = round(75, 0);
		
		
		if(($item['nas_teori']=="")||($item['nas_teori']==0))
		{
			$mapel_nilai[$no_judul_mapel] = '-';
		}else
		{
			$mapel_nilai[$no_judul_mapel] = round($item['nas_teori'], 0);
		}
		////////// RENTANG PREDIKAT ////////////////
		if ($mapel_kategori[$no_judul_mapel] == "pdk")
		{
			// 100 - 70
			if ($mapel_nilai[$no_judul_mapel] >= 70)
			{
				$mapel_predikat[$no_judul_mapel] = "Kompeten";
			}
			else
			{ // 69-0
				$mapel_predikat[$no_judul_mapel] = "Belum Kompeten";
			}
		}
		else
		{
			// 100 - 90
			if ($mapel_nilai[$no_judul_mapel] >= 90)
			{
				$mapel_predikat[$no_judul_mapel] = "Amat Baik";
			}
			else if ($mapel_nilai[$no_judul_mapel] >= 75)
			{ // 89-75
				$mapel_predikat[$no_judul_mapel] = "Baik";
			}
			else if ($mapel_nilai[$no_judul_mapel] >= 60)
			{ // 74-60
				$mapel_predikat[$no_judul_mapel] = "Cukup";
			}
			else
			{ // 59-0
				$mapel_predikat[$no_judul_mapel] = "Kurang";
			}
		}

		//////////////sing kene bermasalah. nilai mesti 0/////////////////
		//if(($item['nas_ppk']=="")||($item['nas_ppk']==0))
		//{
		//	$mapel_rata_kelas[$no_judul_mapel] = round($rerata_mapel_kelas_uas[$item['mapel_id']]['data'][0]['rerata_uas'], 0);
		//	$mapel_rata_kelas[$no_judul_mapel] = '-';
		//}else
		//{
		//	$mapel_rata_kelas[$no_judul_mapel] = round($rerata_mapel_kelas[$item['mapel_id']]['data'][0]['rerata_nas_ppk'], 0);
			$mapel_rata_kelas[$no_judul_mapel] = $rerata[$item['pelajaran_id']];;
		//}

	endforeach;
	$max_mapel = 0;
	if ($no_judul_mapel != 0)
	{
		$max_mapel = max($mapel_jenis);
	}
		
		
	$html='
		<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
			<tr>
				<td  class="thead-2 t-border">No</td>
				<td  class="thead-2 t-border">Mata Pelajaran</td>
				<td  class="thead-2 t-border"> (KKM) </td>
				<td  class="thead-2 t-border"> NILAI</td>
				<td  class="thead-2 t-border"> PREDIKAT </td>
				<td  class="thead-2 t-border"> RATA KELAS </td>
			</tr>';
		for ($set_a = 1; $set_a <= $max_mapel; $set_a++)
		{
			$jml_row = 0;
			for ($set_b = 1; $set_b <= $no_judul_mapel; $set_b++)
			{
				if ($mapel_jenis[$set_b] == $set_a)
				{
					$mapel_array[$set_a] = $mapel_kategori[$set_b];
					$jml_row++;
				}
			}
			if ($jml_row != 0)
			{
				$no_kategori++;
	$html.="		<tr>";
	$html.="			<td rowspan=" . ($jml_row + 1) . " " . $set_classs3 . " >";
	$html.="				<b>" . $no_kategori . "</b>";
	$html.="			</td>";
	$html.="			<td colspan=5 " . $set_classs_grey . " >";
	$html.="				<b>" . $mapel_array[$set_a] . "</b>";
	$html.="			</td>";
	$html.="		</tr>";
				$no_mapel = 0;
				$no_mapel_nilai = 0;
				for ($set_b = 1; $set_b <= $no_judul_mapel; $set_b++)
				{
					if ($mapel_jenis[$set_b] == $set_a)
					{
						$no_mapel++;
	$html.="		<tr>";
	$html.="			<td " . $set_classs . " width='50%' >";
	$html.=					$no_mapel . ". " . $mapel_nama[$set_b];
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_kkm[$set_b];
	$html.="			</td>";
						if ($mapel_kkm[$set_b] > $mapel_nilai[$set_b])
						{
	$html.="				<td " . $set_classs1_red . " >";
						}
						else
						{
	$html.="				<td " . $set_classs1 . " >";
						}
	$html.=					$mapel_nilai[$set_b];
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_predikat[$set_b];
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_rata_kelas[$set_b];
	$html.="			</td>";
	$html.="		</tr>";
						$no_mapel_nilai += $mapel_nilai[$set_b];
					}
				}

	$html.="		<tr>";
	$html.="			<td " . $set_classs . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="				<b>RATA - RATA</b>";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
							$rata_mapel = round(($no_mapel_nilai / $no_mapel), 0);
	$html.=					$rata_mapel;
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="		</tr>";

				if ($set_a == 3)
				{
					$keseluruhan_rata2nilai += (2 * $rata_mapel);
				}
				else
				{
					$keseluruhan_rata2nilai += $rata_mapel;
				}
			}
		}
	$html.=	'
		</table>';
		
	return $html;
}
function table_nilai_ktsp_penerbad_v2($resultset,$rerata)
{
	
		$set_classs_grey = "class=' t-border t-grey-background'";
		$set_classs = "class=' t-border '";
		$set_classs1 = "class='thead-1 t-border'";
		$set_classs1_red = "class='thead-1-red t-border'";

		$set_classs2 = "class='thead-2 t-border'";
		$set_classs3 = "class='thead-3 t-border'";
		$keseluruhan_rata2nilai = 0;
		$no_kategori = 0;
		
		
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;

	$jml_judul_pel = 0;
	$jml_judul_per_pel = 0;
	$type_judul_sementara = "";

	foreach ($resultset['data'] as $idx => $item):

		if ($item['kategori_kode'] != $ktg_nama):
			$ktg_nama = $item['kategori_kode'];
			$jml_row++;
		endif;

		$jml_row++;

	endforeach;

	$ktg_nama = NULL;
	$antr_mapel = 0;
	$jml_mapel[1] = 0;
	$keseluruhan_rata2nilai = 0;
	$no_judul_mapel = 0;
	foreach ($resultset['data'] as $idx => $item):
		$no_judul_mapel++;
		
		$mapel_jenis[$no_judul_mapel] = $item['kategori_nourut'];
		$mapel_kategori[$no_judul_mapel] = $item['kategori_nama'];

		$mapel_nama[$no_judul_mapel] = $item['mapel_nama'];
		$mapel_kkm[$no_judul_mapel] = round(75, 0);
		
		
		if(($item['nas_teori']=="")||($item['nas_teori']==0))
		{
			$mapel_nilai[$no_judul_mapel] = '-';
		}else
		{
			$mapel_nilai[$no_judul_mapel] = round($item['nas_teori'], 0);
		}
		////////// RENTANG PREDIKAT ////////////////
		if ($mapel_kategori[$no_judul_mapel] == "pdk")
		{
			// 100 - 70
			if ($mapel_nilai[$no_judul_mapel] >= 70)
			{
				$mapel_predikat[$no_judul_mapel] = "Kompeten";
			}
			else
			{ // 69-0
				$mapel_predikat[$no_judul_mapel] = "Belum Kompeten";
			}
		}
		else
		{
			// 100 - 90
			if ($mapel_nilai[$no_judul_mapel] >= 90)
			{
				$mapel_predikat[$no_judul_mapel] = "Amat Baik";
			}
			else if ($mapel_nilai[$no_judul_mapel] >= 75)
			{ // 89-75
				$mapel_predikat[$no_judul_mapel] = "Baik";
			}
			else if ($mapel_nilai[$no_judul_mapel] >= 60)
			{ // 74-60
				$mapel_predikat[$no_judul_mapel] = "Cukup";
			}
			else
			{ // 59-0
				$mapel_predikat[$no_judul_mapel] = "Kurang";
			}
		}

		//////////////sing kene bermasalah. nilai mesti 0/////////////////
		//if(($item['nas_ppk']=="")||($item['nas_ppk']==0))
		//{
		//	$mapel_rata_kelas[$no_judul_mapel] = round($rerata_mapel_kelas_uas[$item['mapel_id']]['data'][0]['rerata_uas'], 0);
		//	$mapel_rata_kelas[$no_judul_mapel] = '-';
		//}else
		//{
		//	$mapel_rata_kelas[$no_judul_mapel] = round($rerata_mapel_kelas[$item['mapel_id']]['data'][0]['rerata_nas_ppk'], 0);
			$mapel_rata_kelas[$no_judul_mapel] = $rerata[$item['pelajaran_id']];;
		//}

	endforeach;
	$max_mapel = 0;
	if ($no_judul_mapel != 0)
	{
		$max_mapel = max($mapel_jenis);
	}
		
		
	$html='
		<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
			<tr>
				<td  class="thead-2 t-border">No</td>
				<td  class="thead-2 t-border">Mata Pelajaran</td>
				<td  class="thead-2 t-border"> (KKM) </td>
				<td  class="thead-2 t-border"> NILAI</td>
				<td  class="thead-2 t-border"> PREDIKAT </td>
				<td  class="thead-2 t-border"> RATA KELAS </td>
			</tr>';
		for ($set_a = 1; $set_a <= $max_mapel; $set_a++)
		{
			$jml_row = 0;
			for ($set_b = 1; $set_b <= $no_judul_mapel; $set_b++)
			{
				if ($mapel_jenis[$set_b] == $set_a)
				{
					$mapel_array[$set_a] = $mapel_kategori[$set_b];
					$jml_row++;
				}
			}
			if ($jml_row != 0)
			{
				$no_kategori++;
	$html.="		<tr>";
	$html.="			<td rowspan=" . ($jml_row + 1) . " " . $set_classs3 . " >";
	$html.="				<b>" . $no_kategori . "</b>";
	$html.="			</td>";
	$html.="			<td colspan=5 " . $set_classs_grey . " >";
	$html.="				<b>" . $mapel_array[$set_a] . "</b>";
	$html.="			</td>";
	$html.="		</tr>";
				$no_mapel = 0;
				$no_mapel_nilai = 0;
				for ($set_b = 1; $set_b <= $no_judul_mapel; $set_b++)
				{
					if ($mapel_jenis[$set_b] == $set_a)
					{
						$no_mapel++;
	$html.="		<tr>";
	$html.="			<td " . $set_classs . " width='50%' >";
	$html.=					$no_mapel . ". " . $mapel_nama[$set_b];
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_kkm[$set_b];
	$html.="			</td>";
	$nilai_set_kkm = $mapel_nilai[$set_b];
						if ($mapel_kkm[$set_b] > $mapel_nilai[$set_b])
						{
	//$html.="				<td " . $set_classs1_red . " >";
							$nilai_set_kkm = $mapel_nilai[$set_b];
						}
						else
						{
	//$html.="				<td " . $set_classs1 . " >";
						}
	$html.="				<td " . $set_classs1 . " >";
	$html.=					$nilai_set_kkm;
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_predikat[$set_b];
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.=					$mapel_rata_kelas[$set_b];
	$html.="			</td>";
	$html.="		</tr>";
						$no_mapel_nilai += $mapel_nilai[$set_b];
					}
				}

	$html.="		<tr>";
	$html.="			<td " . $set_classs . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="				<b>RATA - RATA</b>";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
							$rata_mapel = round(($no_mapel_nilai / $no_mapel), 0);
	$html.=					$rata_mapel;
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="			<td " . $set_classs1 . " >";
	$html.="			</td>";
	$html.="		</tr>";

				if ($set_a == 3)
				{
					$keseluruhan_rata2nilai += (2 * $rata_mapel);
				}
				else
				{
					$keseluruhan_rata2nilai += $rata_mapel;
				}
			}
		}
	$html.=	'
		</table>';
		
	return $html;
}

function table_nilai_ktsp_nusput_v1($resultset)
{
	$html='';
	$html.='	<table cellspacing="0" cellpadding="7" border="1" style="width:100%; border-collapse: collapse;" class="kecil">
		
					<tr>
						<th width="45px" rowspan="2">No</th>
						<th rowspan="2">Mata Pelajaran</th>
			
						<th width="90px" rowspan="2">
							Kriteria<br/>
							Ketuntasan<br/>
							Minimal
						</th>
						<th colspan="2">Nilai</th>
					</tr>
					<tr>
						<th width="60px">Angka</th>
						<th width="60px">Huruf</th>
					</tr>
			';

        $mp_no = 0;
		$kmp_no= 0;
        $ktg_ascii = 64;
        $ktg_nama = NULL;
        $jml_row = 0;

        foreach ($resultset['data'] as $idx => $item):
            if ($item['kategori_nama'] != $ktg_nama):
                $ktg_nama = $item['kategori_nama'];
                $jml_row++;
            endif;
            $jml_row++;
        endforeach;
		foreach ($resultset['data'] as $idx => $item): 
			if ($item['kategori_nama'] != $ktg_nama):
	
				$ktg_ascii++;
				$mp_no = 0;
				$kmp_no++;
	$html.='		<tr>';
	$html.='			<td align="left" valign="middle"><strong>&nbsp;&nbsp;'.$kmp_no.'</strong></td>';
	$html.='			<td colspan="4"><strong>'.$item["kategori_nama"].'</strong></td>';
				
	$html.='		</tr>';
				$ktg_nama = $item['kategori_nama'];
			endif;
				
			$mp_no++;
			$mapel_nomor = $kmp_no . "." . $mp_no;
			$kkm = round($item['nipel_kkm']);
			$pembagi = (($item['nas_teori']>0) and ($item['nas_praktek']>0)) ? 2 : 1 ;
			$nilai = (is_numeric($item['nas_teori'])or is_numeric($item['nas_praktek'])) ? round(($item['nas_teori']+$item['nas_praktek'])/$pembagi) : '-';
			$kompetensi = ($nilai >= $kkm) ? 'K' : 'BK';
	
	$html.='		<tr>';
	$html.='			<td align=\"left\" valign=\"middle\">&nbsp;&nbsp;'.$mapel_nomor.'</td>';
			
	$html.='			<td valign=\"middle\">'.$item["mapel_nama"].'</td>';
	$html.='			<td valign=\"middle\" align="center">'.$kkm.'&nbsp; </td>';
	$html.='			<td valign=\"middle\" align="center">'.$nilai.'&nbsp; </td>';
	$html.='			<td valign=\"middle\" align="center"><div class=\"style3\">'.$kompetensi.'</div></td>';
	$html.='		</tr>';
			
		 endforeach;
	$html.='
					<tr>
						<td colspan="5">
							Keterangan nilai huruf: K = Kompeten, BK = Belum Kompeten
						</td>
					</tr>
				</table>';
		
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

function ttd_nusput_v1($data)
{
	$html='';
	
	$html.='
	
			<p align="right" class="style6">
				Semarang, '.$data['tanggal_uas_nama'] .'
			</p>

			<table border="0" style="width: 100%;">
				<tr>
					<td width="31%" align="center" valign="top">
						<p class="style6">
							Orang Tua/Wali
							<br/>
							Peserta Didik
							<br/>
							<br/>
							<br/>
							.....................
						</p>
					</td>
					<td width="31%" align="center" valign="top">
						<p class="style6">
							Wali Kelas
							<br/>
							<br/>
							<br/>
							<br/>
							'.$data['wali_nama'] .'
						</p>    </td>
					<td width="38%" align="center" valign="top">
						<p class="style6">
							Kepala Sekolah
							<br/>
							<br/>
							<br/>
							<br/>
							'.$data['kepsek_nama'].'
						</p>
					</td>
				</tr>
			</table>';
	return $html;
}


function lembar_kelulusan_lembar3_penerbad_V1($row)
{
	
	$tanggal_mutasi = $row["tanggal_mutasi"];
	$set_titik = "............................";
	
	$html='
		<p align="center"><b>KETERANGAN PINDAH/KELUAR SEKOLAH</b></p>
		<br/>
		<b>1. Diisi oleh Sekolah yang Ditinggalkan/Sekolah Lama</b>
		<br/><br/>
		<table cellspacing="0" id="t-kompetensi" border="1" class="t-border" width="100%">
			<tr>
				<td class=" t-head2 t-border" >Tanggal</td>
				<td class=" t-head2 t-border" >Kelas / yang Ditinggalkan</td>
				<td class=" t-head2 t-border" >Alasan Keluar (Tertulis) dari</td>
				<td class=" t-head2 t-border" >
					Tanda Tangan dan
					<br/>
					Stempel Kepala Sekolah,
					<br/>
					Tanda Tangan Orang
					<br/>
					Tua/Wali
				</td>


			</tr>
			<tr>
				<td class=" t-head2 t-border" >'. $tanggal_mutasi .'</td>
				<td class=" t-head2 t-border" >'. $row["kelas_nama"] .'</td>
				<td class=" t-head2 t-border" >LULUS</td>
				<td class=" t-head2 t-border" >
					Semarang, '. $tanggal_mutasi .' <br/>
					Kepala Sekolah,
					<br/><br/><br/><br/>
					'. $row['kepsek_nama'] .'
					<br/>
					NIP
					<br/>
					Orang Tua/Wali,
					<br/><br/><br/><br/>';
					
	$html .=		 	$set_titik ;
	$html .='</td>
			</tr>
			<tr>
				<td class=" t-head2 t-border" > </td>
				<td class=" t-head2 t-border" > </td>
				<td class=" t-head2 t-border" > </td>
				<td class=" t-head2 t-border" >
					.......................... 20 ..... <br/>
					Kepala Sekolah,
					<br/><br/><br/><br/>';
	$html .=		 	$set_titik ;
	$html .='		<br/>
					NIP
					<br/>
					Orang Tua/Wali,
					<br/><br/><br/><br/>';
	$html .=		 	$set_titik ;
	$html .=  '</td>
			</tr>
		</table>
		<br/><br/>
		<b>2. Diisi oleh Sekolah yang Menerima/Sekolah Baru:</b>
		<br/><br/>
		<table cellspacing="0" id="t-kompetensi" border="1" class="t-border" width="100%">
			<tr align="center">
				<td class=" t-head2 t-border" >No</td>
				<td class=" t-head2 t-border" >Data Peserta Diklat</td>
				<td class=" t-head2 t-border" >Tanda Tangan dan <br/> Stempel Kepala Sekolah</td>

			</tr>';
			
	for ($a = 1; $a <= 2; $a++)
	{

				
	$html .= 	'<tr>
					<td class=" t-head2 t-border" >
						<table cellspacing="0" id="t-kompetensi" border="0" width="100%">
							<tr>
								<td>1.</td>
							</tr>
							<tr>
								<td>2.</td>
							</tr>
							<tr>
								<td>3.</td>
							</tr>
							<tr>
								<td>4.</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
					<td class=" t-head2 t-border" >
						<table cellspacing="0" id="t-kompetensi" border="0" width="100%">
							<tr>
								<td width="40%">Nama</td><td width="60%">:</td>
							</tr>
							<tr>
								<td>Nomor Induk</td><td>:</td>
							</tr>
							<tr>
								<td>Sekolah Asal</td><td>:</td>
							</tr>
							<tr>
								<td>Masuk di Sekolah ini</td><td>:</td>
							</tr>
							<tr>
								<td>a. Tanggal</td><td>:</td>
							</tr>
							<tr>
								<td>b. Tahun Pelajaran</td><td>:</td>
							</tr>
						</table>
					</td>
					<td class=" t-head2 t-border" >
						<br/>';
	$html .=		 	$set_titik ;
	$html .='		 <br/>
						Kepala Sekolah,
						<br/><br/><br/><br/>';
	$html .=		 	$set_titik ;
	$html .='			<br/>
						NIP.

					</td>
				</tr>';

	}

	$html .='

		</table>';
	return $html;
}

	
function lembar_kelulusan_lembar4_penerbad_V1($row)
{
	$tanggal_mutasi = $row["tanggal_mutasi"];
	$html = '
		<p align="center"><b>CATATAN AKHIR MASA PENDIDIKAN</b></p>
		<br/><br/>
		Berdasarkan rekaman hasil belajar yang telah ditempuh selama masa pendidikan, peserta didik yang bersangkutan dinyatakan berprestasi khusus:
		<br/><br/>
		
		<table width="100%" cellpadding="0" cellspacing="0" border="1">
				<tr>
					<td  align="center" width="18%">Kelas / <br>Semester</td>
					<td  align="center" width="64%">Lomba/ Karya Ilmiah</td>
					<td  align="center" width="18%">Paraf Wali</td>
				</tr>';
	 
					for ($loop_mutasi = 1; $loop_mutasi <= 7; $loop_mutasi++){ 
					
	$html .= '			<tr>
							<td height="40px">   </td>
							<td> </td>
							<td> </td>
						</tr>';
					}
	$html .= '</table>
		<br><br>
		
		<table width="100%" height="100%" border="0">
			<tr>
				<td width="50%"></td>
				<td width="50%">
				Semarang, '.$tanggal_mutasi.'<br>
				Kepala SMK Penerbangan Kartika Aqasa Bhakti
				<br/><br/><br/><br/>
				' .$row['kepsek_nama']. '<br>
				NIP. ----

				</td>
			</tr>
		</table>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	';
	return $html;
}
