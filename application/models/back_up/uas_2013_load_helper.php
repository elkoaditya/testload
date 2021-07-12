<?php

////////////////////////////
//////////PDF///////////////
////////////////////////////
function header_ktsp_nusput_v1()
{
	$html= '
		<style>
			.thead-4{
				width: 100%;
				font-size: 18px;
				text-align: center;
				font-family: cursive;
			}
		</style>
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
function profil_ktsp_nusput_v2($row,$row_per_siswa)
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
							<td><span class="style1">
								Nama Siswa</span>
							</td>
							<td> : </td>
							<td><span class="style1">
								'.$row_per_siswa["siswa_nama"].'</span>
							</td>
						</tr>
						<tr>
							<td><span class="style1">
								Nomor Induk</span>
							</td>
							<td> : </td>
							<td><span class="style1">
								'.$row_per_siswa["siswa_nis"].'</span>
							</td>
						</tr>
						<tr>
							<td><span class="style1">
								Bidang Keahlian</span>
							</td>
							<td> : </td>
							<td><span class="style1">
								TEKNOLOGI INFORMASI DAN KOMUNIKASI</span>
							</td>
						</tr>
						<tr>
							<td><span class="style1">
								Program Keahlian</span>
							</td>
							<td> : </td>
							<td><span class="style1">
								TEKNIK KOMPUTER DAN INFORMATIKA</span>
							</td>
						</tr>
						<tr>
							<td><span class="style1">
								Kompetensi Keahlian</span>
							</td>
							<td> : </td>
							<td><span class="style1">
								TEKNIK KOMPUTER DAN JARINGAN</span>
							</td>
						</tr>
					</table>

				</td>
				<td valign="top" width="35%">

					<table width="100%" border="0">
						<tr>
							<td><span class="style1">
								Tahun Pelajaran</span>
							</td>
							<td> : </td>
							<td><span class="style1">
								'.str_replace("/"," - ",$row["ta_nama"]).'</span>
							</td>
						</tr>
						<tr>
							<td><span class="style1">
								Kelas</span>
							</td>
							<td> : </td>
							<td><span class="style1">
								'.$row["kelas_nama"].'</span>
							</td>
						</tr>
						<tr>
							<td><span class="style1">
								Semester</span>
							</td>
							<td> : </td>
							<td><span class="style1">
								'.$smster_nama.'</span>
							</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>

	';
	return $html;
}

function header_2013_v1($data,$row_per_siswa)
{
	$smster_nama = '2(dua)';
	if($data['semester_nama'] == 'gasal'){
		$smster_nama = '1(satu)';
	}
	$ta_nama = str_replace("/"," - ",$data['ta_nama']);
	
	if(APP_SCOPE=='smk_nusput')
	{
		$html= '
			<table width="100%"><tr><td align="center" >
			<h2><b>KARTU HASIL STUDI<br/>SMK NUSAPUTRA 1</b></h2>
			 </td></tr></table>';
	} 
	$html= '
	<div id="header_1" class="header">
		<table width="100%" border="0" style="width: 100%;">
			<tr>
			  <td width="23%"	valign="top"><span class="style1">Nama Peserta Didik</span> </td>
			  <td width="1%"	valign="top"><span class="style1">:</span></td>
			  <td width="35%" 	valign="top"><span class="style1"><em>'.$row_per_siswa['siswa_nama'].'</em></span></td>
			  
			  <td width="21%" valign="top"><span class="style1">Kelas/Semester</span></td>
			  <td width="1%" valign="top"><span class="style1">:</span></td>
			  <td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$data['kelas_nama'].'/
			  '.strtoupper($data['semester_nama']).'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nomor Induk</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$row_per_siswa['siswa_nis'].'</span> </td>
			  
			  <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$ta_nama.'</span></td>
			  
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nama Sekolah</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td colspan="4" valign="top"><span class="style1">'.APP_SCHOOL.'</span> </td>
			  
			</tr>
		</table>
	</div>';
	return $html;
}

function header_2013_v2($row,$row_per_siswa)
{
	$smster_nama = '2 / Genap';
	if($row['semester_nama'] == 'gasal'){
		$smster_nama = '1 / Ganjil';
	}
	$ta_nama = str_replace("/"," - ",$row['ta_nama']);
	//style="text-transform:uppercase;"
	$html= '
	<div id="header_1" class="header">
		<table width="100%" border="0" style="width: 100%;">
			<tr>
			  <td width="23%"	valign="top"><span class="style1">Nama Sekolah</span> </td>
			  <td width="1%"	valign="top"><span class="style1">:</span></td>
			  <td width="35%" 	valign="top"><span class="style1">'.APP_SCHOOL.'</span></td>
			  
			  <td width="21%" valign="top"><span class="style1">Kelas</span></td>
			  <td width="1%" valign="top"><span class="style1">:</span></td>
			  <td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$row['kelas_nama'].'</span></td>
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
			  <td valign="top"><span class="style1"><em>'.$row_per_siswa['siswa_nama'].'</em></span></td>
			  
			  <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$ta_nama.'</span></td>
			  '.$smster_nama.'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nomor Induk/NISN</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$row_per_siswa['siswa_nis'].'</span> </td>
			  
			  <td valign="top" colspan="3"></td>
			</tr>
		</table>
		<hr/>
		<p class="titik_allwidth"></p>
	</div>';
	return $html;
}

function header_2013_sman14_v2($row,$row_per_siswa)
{
	$smster_nama = '2 / Genap';
	if($row['semester_nama'] == 'gasal'){
		$smster_nama = '1 / Ganjil';
	}
	$ta_nama = str_replace("/"," - ",$row['ta_nama']);
	//style="text-transform:uppercase;"
	$html= '
	<div id="header_1" class="header">
		<table width="100%" border="0" style="width: 100%;">
			<tr>
			  <td width="17%"	valign="top"><span class="style1">Nama Sekolah</span> </td>
			  <td width="1%"	valign="top"><span class="style1">:</span></td>
			  <td width="46%" 	valign="top"><span class="style1">'.APP_SCHOOL.'</span></td>
			  
			  <td width="18%" valign="top"><span class="style1">Kelas</span></td>
			  <td width="1%" valign="top"><span class="style1">:</span></td>
			  <td  valign="top"><span class="style1" style="text-transform:uppercase;">'.$row['kelas_nama'].'</span></td>
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
			  <td valign="top"><span class="style1">'.$row_per_siswa['siswa_nama'].'</span></td>
			  
			  <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$ta_nama.'</span></td>
			  '.$smster_nama.'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">NIS/NISN</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$row_per_siswa['siswa_nis'].'</span> </td>
			  
			  <td valign="top" colspan="3"></td>
			</tr>
		</table>
		<!--<hr/>
		<p class="titik_allwidth"></p>-->
		
		<br/>
	</div>';
	return $html;
}

function header_2013_sma9_v2($row,$row_per_siswa)
{
	$smster_nama = '2 / Genap';
	if($row['semester_nama'] == 'gasal'){
		$smster_nama = '1 / Ganjil';
	}
	$ta_nama = str_replace("/"," - ",$row['ta_nama']);
	//style="text-transform:uppercase;"
	$html= '
	<div id="header_1" class="header">
		<table width="100%" border="0" style="width: 100%;">
			<tr>
			  <td width="23%"	valign="top"><span class="style1">Nama Sekolah</span> </td>
			  <td width="1%"	valign="top"><span class="style1">:</span></td>
			  <td width="35%" 	valign="top"><span class="style1">'.APP_SCHOOL.'</span></td>
			  
			  <td width="21%" valign="top"><span class="style1">Kelas</span></td>
			  <td width="1%" valign="top"><span class="style1">:</span></td>
			  <td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$row['kelas_nama'].'</span></td>
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
			  <td valign="top"><span class="style1">'.$row_per_siswa['siswa_nama'].'</span></td>
			  
			  <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$ta_nama.'</span></td>
			  '.$smster_nama.'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nomor Induk/NISN</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$row_per_siswa['siswa_nis'].'</span> </td>
			  
			  <td valign="top" colspan="3"></td>
			</tr>
		</table>
		<hr/>
		
	</div>';
	return $html;
}

function header_2013_sma8_v2($row,$row_per_siswa)
{
	$smster_nama = '2 / Genap';
	if($row['semester_nama'] == 'gasal'){
		$smster_nama = '1 / Ganjil';
	}
	$ta_nama = str_replace("/"," - ",$row['ta_nama']);
	//style="text-transform:uppercase;"
	
	$html= '
	<div id="header_1" class="header" style="padding-top:-12;">
		<table width="100%" border="0" style="width: 100%; ">
			<tr>
			  <td width="23%"	valign="top"><span class="style1">Nama Sekolah</span> </td>
			  <td width="1%"	valign="top"><span class="style1">:</span></td>
			  <td width="35%" 	valign="top"><span class="style1">'.APP_SCHOOL.'</span></td>
			  
			  <td width="21%" valign="top"><span class="style1">Kelas</span></td>
			  <td width="1%" valign="top"><span class="style1">:</span></td>
			  <td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$row['kelas_nama'].'</span></td>
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
			  <td valign="top"><span class="style1"><em>'.$row_per_siswa['siswa_nama'].'</em></span></td>
			  
			  <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$ta_nama.'</span></td>
			  '.$smster_nama.'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nomor Induk/NISN</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$row_per_siswa['siswa_nis'].'</span> </td>
			  
			  <td valign="top" colspan="3"></td>
			</tr>
		</table>
		<hr/>
		
	</div>';
	//<p class="titik_allwidth"></p>
	return $html;
}

function footer_2013_v1($data)
{
	$html= '
	<div id="footer_pagenum" class="footer">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="foot-text">
						'.$data['kelas_nama'].'
                    </td>
                    <td class="foot-text" align="right">
                        <!--Hal. {PAGENO}-->
                       Semester '.$data['semester_nama'].' - '.$data["ta_nama"].'
                    </td>
                </tr>
            </table>
        </div>';
	return $html;
}

function footer_2013_sman14_v1($data)
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

function head_table_nilai_2013_v1()
{
	$html ='
	<tr>
        <td class="thead-1 t-border color-menu" rowspan="2" width="20px"><b>NO</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Pengetahuan </b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Keterampilan </b></td>
        
    </tr>

    <tr>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        
    </tr>';
	return $html;
}

function head_table_nilai_2013_v2($type=0)
{
	$set_rowspan = 'rowspan="2"';
	if($type != 0){
		$set_rowspan = '';
	}
	$html ='
	<tr>
		';
	if($type == 0)
	{	
	$html .='
		<td class="thead-1 t-border " '.$set_rowspan.' width="4%"><b>No</b></td>
        <td class="thead-1 t-border " '.$set_rowspan.'  width="35%"><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border " rowspan="2" ><b>KKM</b></td>
        <td class="thead-1 t-border " colspan="2" width="25%"><b>Pengetahuan </b></td>
        <td class="thead-1 t-border " colspan="2" width="25%"><b>Keterampilan </b></td>
       ';
	}else
	{
	$html .='
		<td class="thead-1 t-border " '.$set_rowspan.' width="3%"><b>No</b></td>
        <td class="thead-1 t-border " '.$set_rowspan.'  width="16%"><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border " width="12%"><b>Aspek</b></td>
        <td class="thead-1 t-border " ><b>Deskripsi</b></td>
       ';
	}
	$html .='
    </tr>';

	if($type == 0){	
	$html .='
    <tr>
        <td class="field-nilai thead-1 t-border " ><b>Nilai</b></td>
        <td class="field-nilai thead-1 t-border " ><b>Predikat</b></td>
        <td class="field-nilai thead-1 t-border " ><b>Nilai</b></td>
        <td class="field-nilai thead-1 t-border " ><b>Predikat</b></td>
        
    </tr>';
	}
	/*
	else{
	$html .='
    <tr>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Nilai</b></td>
        
    </tr>';
		
	}*/
	return $html;
}

function head_table_nilai_2013_v3()
{
	$html ='
	<tr>
        <td class="thead-1 t-border color-menu" rowspan="2" width="20px"><b>NO</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Pengetahuan </b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Keterampilan </b></td>
        
    </tr>

    <tr>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="165px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="165px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        
    </tr>';
	return $html;
}

function head_table_nilai_2013_smkn6smg_v1()
{
	$html ='
	<tr>
        <td class="thead-1 t-border color-menu" rowspan="2" width="20px"><b>NO</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Pengetahuan </b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Keterampilan </b></td>
        
    </tr>

    <tr>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="210px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="210px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        
    </tr>';
	return $html;
}

function sikap_2013_v1($data,$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array)
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
				
				
	$html ='
    <!-- Sikap -->
    <div class="thead-1"><b>1.Sikap Spiritual</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="80px"> Deskripsi:
            <br/>';
			//echo $nilai_spiritual[1]." ". $nilai_spiritual[2]." ". $nilai_spiritual[3]."<br/>";
		if(isset($deskripsi_sikap['spiritual']))
		{
			$html .= $deskripsi_sikap['spiritual'];
		}else{
			if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[1];
			}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[2];
			}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
				$html .= $deskripsi_sikap_spiritual[3];
			}
		}
			$html .='
            </td>
        </tr>
	  </table>
      <br/>
    <div class="thead-1"><b>2.Sikap Sosial</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="80px"> Deskripsi:
            <br/>
			';
		if(isset($deskripsi_sikap['sosial']))
		{
			$html .= $deskripsi_sikap['sosial'];
		}else{
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[1];
			}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[2];
			}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
				$html .= $deskripsi_sikap_sosial[3];
			}
		}
	$html .= '
            </td>
        </tr>
	  </table>';
	  return $html;
}



function sikap_2013_v2($data,$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array)
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
			}else{
				if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
					$html .= ' A ';
				}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
					$html .= ' B ';
				}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
					$html .= ' C ';
				}
			}
			
		$html .= '</td>
        	<td class="t-border field-nilai" align="left" valign="top" height="180px"> 
            ';
			if(isset($deskripsi_sikap['spiritual']))
			{
				$html .= $deskripsi_sikap['spiritual'];
			}else{
			
				if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
					$html .= $deskripsi_sikap_spiritual[1];
				}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
					$html .= $deskripsi_sikap_spiritual[2];
				}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
					$html .= $deskripsi_sikap_spiritual[3];
				}
			
			}
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
			}else{
				
				if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
					$html .= ' A ';
				}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
					$html .= ' B ';
				}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
					$html .= ' C ';
				}
			}
			
		$html .= '</td>
        	<td class="t-border field-nilai" align="left" valign="top" height="180px"> 
            ';
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(isset($deskripsi_sikap['sosial']))
			{
				$html .= $deskripsi_sikap['sosial'];
			}else{
				if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
					$html .= $deskripsi_sikap_sosial[1];
				}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
					$html .= $deskripsi_sikap_sosial[2];
				}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
					$html .= $deskripsi_sikap_sosial[3];
				}
			}
	$html .= '
            </td>
        </tr>
	  </table>';
	  return $html;
}

function sikap_2013_v3($data,$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array)
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
				
				
	$html ='
    <!-- Sikap -->
    <div class="thead-1"><b>1.Sikap Spiritual</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="50px"> ';
			//echo $nilai_spiritual[1]." ". $nilai_spiritual[2]." ". $nilai_spiritual[3]."<br/>";
		if(isset($deskripsi_sikap['spiritual']))
		{
			$html .= $deskripsi_sikap['spiritual'];
		}else{
			if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[1];
			}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[2];
			}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
				$html .= $deskripsi_sikap_spiritual[3];
			}
		}
			$html .='
            </td>
        </tr>
	  </table>
      <br/>
    <div class="thead-1"><b>2.Sikap Sosial</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="50px"> ';
		if(isset($deskripsi_sikap['sosial']))
		{
			$html .= $deskripsi_sikap['sosial'];
		}else{
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[1];
			}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[2];
			}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
				$html .= $deskripsi_sikap_sosial[3];
			}
		}
	$html .= '
            </td>
        </tr>
	  </table>';
	  return $html;
}

function sikap_2013_nusput_v1($data,$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array)
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
				
				
	$html ='
    <!-- Sikap -->
    <div class="thead-1"><b>1.Sikap Spiritual</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="50px"> Deskripsi:
            <br/>';
			//echo $nilai_spiritual[1]." ". $nilai_spiritual[2]." ". $nilai_spiritual[3]."<br/>";
		if(isset($deskripsi_sikap['spiritual']))
		{
			$html .= $deskripsi_sikap['spiritual'];
		}else{
			if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[1];
			}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[2];
			}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
				$html .= $deskripsi_sikap_spiritual[3];
			}
		}
			$html .='
            </td>
        </tr>
	  </table>
      <br/>
    <div class="thead-1"><b>2.Sikap Sosial</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="50px"> Deskripsi:
            <br/>
			';
		if(isset($deskripsi_sikap['sosial']))
		{
			$html .= $deskripsi_sikap['sosial'];
		}else{
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[1];
			}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[2];
			}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
				$html .= $deskripsi_sikap_sosial[3];
			}
		}
	$html .= '
            </td>
        </tr>
	  </table>';
	  return $html;
}

function sikap_2013_setiabudhi_v2($data,$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array)
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
    <div class="thead-1"><b>1.Sikap Spiritual</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="center" valign="top" height="30px" width="20%"> Predikat </td>
        	<td class="t-border field-nilai" align="center" valign="top" height="30px">Deskripsi </td>
			
        </tr>
        <tr>
        	<td class="t-border field-nilai" align="center" valign="top"><b>'; 
			if(isset($predikat_sikap['spiritual']))
			{
				$html .= $predikat_sikap['spiritual'];
			}else{
				if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
					$html .= ' A ';
				}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
					$html .= ' B ';
				}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
					$html .= ' C ';
				}
			}
			
		$html .= '</b></td>
        	<td class="t-border field-nilai" align="left" valign="top" height="180px"> 
            ';
			if(isset($deskripsi_sikap['spiritual']))
			{
				$html .= $deskripsi_sikap['spiritual'];
			}else{
			
				if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
					$html .= $deskripsi_sikap_spiritual[1];
				}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
					$html .= $deskripsi_sikap_spiritual[2];
				}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
					$html .= $deskripsi_sikap_spiritual[3];
				}
			
			}
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
        	<td class="t-border field-nilai" align="center" valign="top"><b>'; 
			if(isset($predikat_sikap['sosial']))
			{
				$html .= $predikat_sikap['sosial'];
			}else{
				
				if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
					$html .= ' A ';
				}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
					$html .= ' B ';
				}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
					$html .= ' C ';
				}
			}
			
		$html .= '</b></td>
        	<td class="t-border field-nilai" align="left" valign="top" height="180px"> 
            ';
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(isset($deskripsi_sikap['sosial']))
			{
				$html .= $deskripsi_sikap['sosial'];
			}else{
				if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
					$html .= $deskripsi_sikap_sosial[1];
				}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
					$html .= $deskripsi_sikap_sosial[2];
				}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
					$html .= $deskripsi_sikap_sosial[3];
				}
			}
	$html .= '
            </td>
        </tr>
	  </table>';
	  return $html;
}

function sikap_2013_smkn6smg_v1($data,$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array)
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
				
				
	$html ='
    <!-- Sikap -->
    <div class="thead-1"><b>1.Sikap Spiritual</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="80px"> Deskripsi:
            <br/>';
			//echo $nilai_spiritual[1]." ". $nilai_spiritual[2]." ". $nilai_spiritual[3]."<br/>";
		if(isset($deskripsi_sikap['spiritual']))
		{
			$html .= $deskripsi_sikap['spiritual'];
		}else{
			if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[1];
			}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[2];
			}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
				$html .= $deskripsi_sikap_spiritual[3];
			}
		}
			$html .='
            </td>
        </tr>
	  </table>
      <br/>
  <div class="thead-1"><b>2.Sikap Sosial</b></div>';
    $html ='  <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="65px"> Deskripsi:
            <br/>
			';
		if(isset($deskripsi_sikap['sosial']))
		{
			$html .= $deskripsi_sikap['sosial'];
		}else{
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[1];
			}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[2];
			}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
				$html .= $deskripsi_sikap_sosial[3];
			}
		}
	$html .= '
            </td>
        </tr>
	  </table>';
	  return $html;
}


function catatan_kenaikan_kelas_2013_v1($row,$ekskul_result)
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
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'">
			Berdasarkan hasil yang dicapai pada semester 1 dan 2, peserta didik ditetapkan:
			'.$row['ket_kenaikan_kelas'].'</td>
        </tr>
	  </table>';
      if($jumlah_ekskul>3){
     
       }else{ 
      $html.= '<br/><br/>';
	   }
	return $html;
}

function catatan_kenaikan_kelas_2013_v2($row,$ekskul_result)
{
	$jumlah_ekskul =0;
	

	$html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="35px">
			<b>Keterangan Kenaikan Kelas : </b>
			'.$row['ket_kenaikan_kelas'].'</td>
        </tr>
	  </table>';
      if($jumlah_ekskul>3){
     
       }else{ 
      $html.= '<br/><br/>';
	   }
	return $html;
}

function catatan_kenaikan_kelas_2013_v3($row,$ekskul_result)
{
	$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	$height = '35px';

	$html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'">
			Berdasarkan hasil yang dicapai pada semester 1 dan 2, peserta didik ditetapkan:
			'.$row['ket_kenaikan_kelas'].'</td>
        </tr>
	  </table>';
    
	return $html;
}

function tanggapan_ortu_2013_v1($ekskul_result)
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
      if($jumlah_ekskul>3){
     
       }else{ 
      $html.= '<br/>';
	   }
	return $html;
}

function tanggapan_ortu_2013_v2($ekskul_result)
{
	$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	if($jumlah_ekskul>3){
		$height = '20px';
	}else{
		$height = '30px';
	}

	$html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"></td>
        </tr>
	  </table>';
      if($jumlah_ekskul>3){
     
       }else{ 
      $html.= '<br/><br/>';
	   }
	return $html;
}


function ketidakhadiran_2013_v1($ketidakhadiran)
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

function ketidakhadiran_2013_v2($ketidakhadiran)
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
            <td class="t-border field-nilai">  '.$absen_s .'</td>
        </tr>
        <tr>
            <td class="t-border field-nilai">Ijin</td>
            <td class="t-border field-nilai">  '.$absen_i .'</td>
        </tr>
        <tr>
            <td class="t-border field-nilai">Tanpa Keterangan</td>
            <td class="t-border field-nilai"> '.$absen_a .'</td>
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
				$html.= "Deskripsi:<br/>";
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

function catatan_walikelasv2($row_per_siswa , $nilai_catatan_walikelas,$row,$ekskul_result)
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
		$height = '20px';
	}else{
		$height = '30px';
	}
	
    $html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"> '; 
			if($row_per_siswa['note_walikelas']!='')
			{
				$html.= "Deskripsi:<br/>";
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

function catatan_walikelas_sman14_v1($row_per_siswa , $nilai_catatan_walikelas,$row,$ekskul_result)
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
	/*
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
	*/
	$height = '40px';
    $html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"> '; 
			if($row_per_siswa['note_walikelas']!='')
			{
				$html.= "Deskripsi:<br/>";
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

function tanggapan_ortu_2013_sman14_v1($ekskul_result)
{
	/*$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	if($jumlah_ekskul>3){
		$height = '20px';
	}else{
		$height = '30px';
	}*/
	$height = '30px';
	$html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"></td>
        </tr>
	  </table>';
	  /*
      if($jumlah_ekskul>3){
     
       }else{ 
      $html.= '<br/><br/>';
	   }*/
	return $html;
}

function du_2013_v1($row,$color_menu='')
{
	$no='-';
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

		if($row['pkl_nilai']!='')
		{
			$cetak_ojt=1;
			$no=1;
			$html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >1.</td> ". NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\">SATKER PUSPENERBAD</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\">JL. PUAD A. YANI SEMARANG</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"middle\" align=\"center\" rowspan='2'>1 BULAN (150 Jam)</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"middle\" align=\"center\" rowspan='2'>".$row['pkl_nilai']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"middle\" align=\"center\" rowspan='2'>".$row['pkl_predikat']."</td>" . NL;
			$html.= "</tr>" . NL;
			$html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >2.</td> ". NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\">BUSSINES CENTER SMK <br> PENERBANGAN K.A.B SEMARANG</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\">JL. Jembawan Raya 20A Semarang</td>" . NL;
			$html.= "</tr>" . NL;
			
        }else{
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html.= "</tr>" . NL;
        }
		$html.='</table>';
		return $html;
}

function du_2013_v2($row,$color_menu='')
{
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

		if($row['pkl_nilai']!='')
		{
			$cetak_ojt=1;
			$no++;
			$html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$no."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row['pkl_nama']."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row['pkl_alamat']."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row['pkl_waktu']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$row['pkl_nilai']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$row['pkl_predikat']."</td>" . NL;
			$html.= "</tr>" . NL;
			
        }else{
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html.= "</tr>" . NL;
        }
		$html.='</table>';
		return $html;
}

function du_2013_v3($row,$color_menu='')
{
	$no=0;
	$html = '
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" width="20px"> 
				<b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" width="25%"> 
				<b>Nama DU/DI atau Instansi Relevan</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" width="30%"> 
				<b>Alamat</b></td>
			<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" width="25%"> 
				<b>Lama dan Waktu Pelaksanaan </b></td>
			<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" > 
				<b>Nilai</b></td>
			<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="top" > 
				<b>Predikat</b></td>
        </tr>';

		if($row['pkl_nilai']!='')
		{
			$cetak_ojt=1;
			$no++;
			$html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$no."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row['pkl_nama']."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row['pkl_alamat']."</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">".$row['pkl_waktu']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$row['pkl_nilai']."</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >".$row['pkl_predikat']."</td>" . NL;
			$html.= "</tr>" . NL;
			
        }else{
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
			$html.= "</tr>" . NL;
        }
		$html.='</table>';
		return $html;
}

function prestasi_2013_v1($prestasi_result,$color_menu='')
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

function prestasi_2013_v2($prestasi_result,$color_menu='')
{
	$html = '
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="20px"> <b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="25%"> <b>Jenis Prestasi</b></td>
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

function ekstrakurikuler_2013_v1($ekskul_result,$color_menu='')
{
	$html='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="20px"> <b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="30%"> <b>Kegiatan Ekstrakurikuler</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width=> <b>Keterangan</b></td>
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
            else
            {
                $set_ekskul_keterangan = 'Kurang';
            }
            
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . ($_idx + 1) . ".</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">{$_row['ekskul_nama']}</td>" . NL;
			if($_row['keterangan']!='')
			{	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$_row['keterangan']}</td>" . NL;	}
            else
            {	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$set_ekskul_keterangan}</td>" . NL;	}
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

function ekstrakurikuler_2013_sman14_v1($ekskul_result,$color_menu='')
{
	$html='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="20px"> <b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="30%"> <b>Kegiatan</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width=> <b>Keterangan</b></td>
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

function ekstrakurikuler_2013_smkn6smg_v1($ekskul_result,$color_menu='')
{
	$html='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="20px"> <b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="30%"> <b>Kegiatan Ekstrakurikuler</b></td>
			<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="10%"> <b>Predikat</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width=> <b>Keterangan</b></td>
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
            else
            {
                $set_ekskul_keterangan = 'Kurang';
            }
            
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . ($_idx + 1) . ".</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">{$_row['ekskul_nama']}</td>" . NL;
			/*if($_row['keterangan']!='')
			{	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$_row['keterangan']}</td>" . NL;	}
            else
            {	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$set_ekskul_keterangan}</td>" . NL;	}*/
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}</td>" . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['keterangan']}</td>" . NL;
            $html.= '</tr>' . NL;
        }

        if (count($ekskul_result['data']) == 0)
        {
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\" >-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
			 $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" . NL;
            $html.= '</tr>' . NL;
        }

    $html.='</table>';
	return $html;
}

function ekstrakurikuler_2013_v2($ekskul_result,$color_menu='')
{
	$html='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="20px"><b>No</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width="25%"><b>Kegiatan Ekstrakurikuler</b></td>
            <td  class="t-border field-nilai '.$color_menu.'" align="center" valign="middle" width=><b>Keterangan</b></td>
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
            else
            {
                $set_ekskul_keterangan = 'Kurang';
            }
            
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . ($_idx + 1) . ".</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" >{$_row['ekskul_nama']}</td>" . NL;
			if($_row['keterangan']!='')
			{	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$_row['keterangan']}</td>" . NL;	}
            else
            {	$html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$set_ekskul_keterangan}</td>" . NL;	}
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

function style_2013_sman14_v1()
{
	$html='
	<style>
            @page
            {
                size: 210mm 297mm;
                margin: 24mm 10mm 0mm 10mm;
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

function style_2013_v1()
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
				font-size:12px;
                padding: 4px 5px 4px 5px;
            }

            .field-nilai2
            {
				font-size:12px;
                padding: 4px 7px 4px 7px;
            }
			
			.field-keluar
            {
				padding: 8px 5px 8px 5px;
            }
			
            #ttd tr td{
                font-size: 13px;
            }
			.sub-kategori{
                font-size: 13px;
            }
			.color-menu{
				background-color:#FFEEDE;
			}
			.style1 {font-size: 14px}
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
				position: center;
			}
		</style>
	';
	return $html;
}

function style_2013_v2()
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
				background-image: url('.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.png);
				
				background-position: 50% 50%;
				background-repeat: no-repeat;
				position: relative;
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
				font-size:12px;
                padding: 4px 5px 4px 5px;
            }

            .field-nilai2
            {
				font-size:12px;
                padding: 4px 7px 4px 7px;
            }
			
			.field-keluar
            {
				padding: 8px 5px 8px 5px;
            }
			
            #ttd tr td{
                font-size: 13px;
            }
			.sub-kategori{
                font-size: 13px;
            }
			.color-menu{
				background-color:#FFEEDE;
			}
			.style1 {font-size: 14px}
            #profil-siswa tr td{
                font-size: 12px;
            }
            .titik_allwidth{
				border-style: none none dotted none;
            }';
            /*.page_bg0{
				background-image: url('.base_url("").'/images/logo/'.APP_SCOPE.'/bg_school.gif);
				background-size: 1200px 1200px;
				background-position: 50% 50%;
				background-repeat: no-repeat;
				position: center;
				//position: relative;
			}*/
    $html.='
			
			
        </style>
	 ';
	return $html;
}

function tableextra_2013_v0($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%">   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
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
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v1($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%" >   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
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
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v1($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_sman14_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%" >   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler / Organisasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td style="padding-bottom:6px">
          
          	  '.ekstrakurikuler_2013_sman14_v1($ekskul_result,$color_menu) .'
          		
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td style="padding-bottom:6px">
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td style="padding-bottom:6px">
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td style="padding-bottom:6px">
          
          	  '.catatan_walikelas_sman14_v1($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_sman14_v1($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_setiabudhi_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%">   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv1($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		<br/><br/>
          </td>
         </tr>';
		 
       $html .= '
			<tr>
			  <td class="sub-kategori"><b>G.</b></td>
			  <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
			</tr>
			<tr>
			  <td></td>
			  <td>
			  
				  '.tanggapan_ortu_2013_v1($ekskul_result).'
					
			  </td>
			 </tr>';
		if ((strtolower($row["semester_nama"]) == "genap")&&($row["kelas_grade"] != 12))
		{
		$html .= '
			
			<tr>
			  <td></td>
			  <td><br/>
			  
				  '.catatan_kenaikan_kelas_2013_v2($row_per_siswa,$ekskul_result).'
					
			  </td>
			 </tr>';
		}
         
     $html .= '    </table>
	';
	return $html;
}

function tableextra_2013_sma8_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%" >   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
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
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v1($ekskul_result);
		
		if ((strtolower($row["semester_nama"]) == "genap")&&($row["kelas_grade"] != 12))
		{
	$html .= keterangan_kenaikan_sma_8();
		}
	$html .='
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_sma9_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%" >   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v2($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v2($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv2($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v2($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_nusput_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%">   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv1($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		<br/><br/>
          </td>
         </tr>';
       
		if ((strtolower($row["semester_nama"]) == "genap")&&($row["kelas_grade"] != 12))
		{
		$html .= '
			<tr>
			  <td class="sub-kategori"><b>G.</b></td>
			  <td class="sub-kategori"><b>Keputusan Rapat Dewan Guru</b></td>
			</tr>
			<tr>
			  <td></td>
			  <td>
			  
				  '.catatan_kenaikan_kelas_2013_v1($row_per_siswa,$ekskul_result).'
					
			  </td>
			 </tr>';
		}else{
		$html .= '
			<tr>
			  <td class="sub-kategori"><b>G.</b></td>
			  <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
			</tr>
			<tr>
			  <td></td>
			  <td>
			  
				  '.tanggapan_ortu_2013_v1($ekskul_result).'
					
			  </td>
			 </tr>';
		}
         
     $html .= '    </table>
	';
	return $html;
}

function tableextra_2013_nusput_v2($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%">  
		<tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relevan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.du_2013_v3($row_per_siswa,$color_menu) .'
          		
          </td>
         </tr>
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
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
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
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
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
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
          
          	  '.catatan_walikelasv2($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		<br/><br/>
          </td>
         </tr>';
       
		if ((strtolower($row["semester_nama"]) == "genap")&&($row["kelas_grade"] != 12))
		{
		$html .= '
			<tr>
			  <td class="sub-kategori"><b>H.</b></td>
			  <td class="sub-kategori"><b>Keputusan Rapat Dewan Guru</b></td>
			</tr>
			<tr>
			  <td></td>
			  <td>
			  
				  '.catatan_kenaikan_kelas_2013_v3($row_per_siswa,$ekskul_result).'
					
			  </td>
			 </tr>';
		}else{
		$html .= '
			<tr>
			  <td class="sub-kategori"><b>H.</b></td>
			  <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
			</tr>
			<tr>
			  <td></td>
			  <td>
			  
				  '.tanggapan_ortu_2013_v2($ekskul_result).'
					
			  </td>
			 </tr>';
		}
         
     $html .= '    </table>
	';
	return $html;
}

function tableextra_2013_penerbad_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%">   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relawan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.du_2013_v1($row_per_siswa,$color_menu) .'
          		
          </td>
         </tr>
		 
		 <tr>
          <td class="sub-kategori" width="20px"><b>D.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
          		
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv2($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>H.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v2($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_penerbad_v2($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%">   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relawan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.du_2013_v2($row_per_siswa,$color_menu) .'
          		
          </td>
         </tr>
		 
		 <tr>
          <td class="sub-kategori" width="20px"><b>D.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
          		
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv2($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>H.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v2($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_smkn6smg_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%">   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Kegiatan Belajar di Dunia Usaha/Industri dan Instansi Relawan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.du_2013_v2($row_per_siswa,$color_menu) .'
          		
          </td>
         </tr>
		 
		 <tr>
          <td class="sub-kategori" width="20px"><b>D.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_smkn6smg_v1($ekskul_result,$color_menu) .'
          		
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv2($row_per_siswa,$nilai_catatan_walikelas,$row,$ekskul_result).'
          		
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>H.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v2($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_v2($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row)
{ 
	$html = '
	<table id="t-nilai">   
         <tr>
          <td class="sub-kategori"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
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
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v1($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tableextra_2013_v3($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row, $color_menu='')
{ 
	$html = '
	<table id="t-nilai" width="100%">   
         <tr>
          <td class="sub-kategori" width="20px"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result,$color_menu) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result,$color_menu).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v2($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
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
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v1($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}

function tablepdf_2013_nusput_v1($resultset,$row,$row_per_siswa,$deskripsi_array,$type_return,$background = 0 ,$input_kkm = 70)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '
		<table>
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2013_v1($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
//     $html .= '<br/><br/>';
     $html .= ' 
				</td>
			</tr>
			<tr>
				<td class="sub-kategori"><b>B.</b></td>
				<td class="sub-kategori"><b>Pengetahuan dan Keterampilan</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v1();
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelC1')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>C1</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelC3')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>C3</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL)
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= profil_ktsp_nusput_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v1();
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" . NL;
					
					if($mode_range==100)
    				{	
						$cetak_kkm = $input_kkm;	
					}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
					
    $html .=		'</tr>' . NL;
                    $jml_row++;
                }
    $html .='
					</table>
				</td>
			</tr>
		</table>';
	  if($type_return == 1){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_nusput_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$type_return,$background = 0 ,$input_kkm = 70)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '
		<table>
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2013_nusput_v1($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
//     $html .= '<br/><br/>';
     $html .= ' 
				</td>
			</tr>
			<tr>
				<td class="sub-kategori"><b>B.</b></td>
				<td class="sub-kategori"><b>Pengetahuan dan Keterampilan</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v1();
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if (($item['kategori_nama'] != $ktg_nama)||(($item['kategori_kode'] == "C3. Dasar")&&($mp_no==2)) )
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelC1')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>C1</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelC3')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>C3</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
						else if (($item['kategori_kode'] == 'mulok')&&($item['kategori_nama'] != $ktg_nama))
                        {
    $html .=                "
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
						else if (($item['kategori_kode'] == 'C3. Dasar')&&($item['kategori_nama'] != $ktg_nama))
                        {
    $html .=                "
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL) 
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= profil_ktsp_nusput_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v1();
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" . NL;
					
					if($mode_range==100)
    				{	
						$cetak_kkm = $input_kkm;	
					}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
					
    $html .=		'</tr>' . NL;
                    $jml_row++;
                }
    $html .='
					</table>
				</td>
			</tr>
		</table>';
	  if($type_return == 1){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_smkn6smg_v1($resultset,$row,$row_per_siswa,$deskripsi_array,$type_return,$background = 0 ,$input_kkm = 70)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '
		<table>
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2013_smkn6smg_v1($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
//     $html .= '<br/><br/>';
     $html .= ' 
				</td>
			</tr>
			<tr>
				<td class="sub-kategori"><b>B.</b></td>
				<td class="sub-kategori"><b>Pengetahuan dan Keterampilan</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    //$html .=	head_table_nilai_2013_v1();
	$html .=	head_table_nilai_2013_smkn6smg_v1();
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ( ($item['kategori_nama'] != $ktg_nama) || (($item['kategori_kode'] == 'KelA')&& ($mp_no==5)) )
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if (($item['kategori_kode'] == 'C1. XI')||($item['kategori_kode'] == 'C1 X'))
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
						else if (($item['kategori_kode'] == 'C2. X')||(($item['kategori_kode'] == 'KelB')&&($row['kelas_grade'] == 11)))
                        {
							
	$html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= header_2013_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_smkn6smg_v1();
	$html .= '			<tr>';
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'C3 XI-XII')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
						else if ($item['kategori_kode'] == 'KelB')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if (($ktg_nama != NULL)&&($item['kategori_kode'] == 'KelA'))
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= header_2013_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_smkn6smg_v1();
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}</td>" . NL;
					
					if($mode_range==100)
    				{	
						$cetak_kkm = $input_kkm;	
					}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
					
					$cetak_kkm = round($item['nipel_kkm']);
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
					
					//////// DESKRIPSI PENGETAHUAN //////////////////
					$cetak_des = 0;
					if($item['cat_teori']!='')
					{
						$cetak_des = 1;
$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">{$item['cat_teori']}</td>" . NL;
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
		$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">{$deskripsi['deskripsi']}</td>" . NL;
									}
								}
							}
						}
					}
					if ($cetak_des == 0)
					{
	$html .=			"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">-</td>" . NL;
					}
					
    
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
    
                    //////// DESKRIPSI KETRAMPILAN //////////////////
				    $cetak_des = 0;
					if($item['cat_praktek']!='')
					{
						$cetak_des = 1;
$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">{$item['cat_praktek']}</td>" . NL;
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
		$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">{$deskripsi['deskripsi']}</td>" . NL;
									}
								}
							}
						}
					}
					if ($cetak_des == 0)
					{
	$html .=			"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">-</td>" . NL;
					}
					
    $html .=		'</tr>' . NL;
                    $jml_row++;
                }
    $html .='
					</table>
				</td>
			</tr>
		</table>';
	  if($type_return == 1){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_smkn6smg_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$type_return,$background = 0 ,$input_kkm = 70)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '
		<table>
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2013_smkn6smg_v1($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
//     $html .= '<br/><br/>';
     $html .= ' 
				</td>
			</tr>
			<tr>
				<td class="sub-kategori"><b>B.</b></td>
				<td class="sub-kategori"><b>Pengetahuan dan Keterampilan</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    //$html .=	head_table_nilai_2013_v1();
	$html .=	head_table_nilai_2013_smkn6smg_v1();
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ( ($item['kategori_nama'] != $ktg_nama) || (($item['kategori_kode'] == 'KelA')&& ($mp_no==4)) )
                    {
                        $ktg_ascii++;
                        
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
							$mp_no = 0;
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
							$mp_no = 0;
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if (($item['kategori_kode'] == 'C1. XI')||($item['kategori_kode'] == 'C1 X'))
                        {
							$mp_no = 0;
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
						else if ($item['kategori_kode'] == 'C2. X')
                        {
							$mp_no = 0;
	$html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= header_2013_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_smkn6smg_v1();
	$html .= '			<tr>';
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
						else if ($item['kategori_kode'] == 'C3 XI-XII')
                        {
							$mp_no = 0;
	$html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= header_2013_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_smkn6smg_v1();
	$html .= '			<tr>';
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                       /* else if ($item['kategori_kode'] == 'C3 XI-XII')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }*/
						else if ($item['kategori_kode'] == 'KelB')
                        {
							$mp_no = 0;
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if (($ktg_nama != NULL)&&($item['kategori_kode'] == 'KelA'))
                        {
							$mp_no = 0;
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= header_2013_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_smkn6smg_v1();
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}</td>" . NL;
					
					if($mode_range==100)
    				{	
						$cetak_kkm = $input_kkm;	
					}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
					
					$cetak_kkm = round($item['nipel_kkm']);
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
					
					//////// DESKRIPSI PENGETAHUAN //////////////////
					$cetak_des = 0;
					if($item['cat_teori']!='')
					{
						$cetak_des = 1;
$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">{$item['cat_teori']}</td>" . NL;
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
		$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">{$deskripsi['deskripsi']}</td>" . NL;
									}
								}
							}
						}
					}
					if ($cetak_des == 0)
					{
	$html .=			"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">-</td>" . NL;
					}
					
    
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
    
                    //////// DESKRIPSI KETRAMPILAN //////////////////
				    $cetak_des = 0;
					if($item['cat_praktek']!='')
					{
						$cetak_des = 1;
$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">{$item['cat_praktek']}</td>" . NL;
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
		$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">{$deskripsi['deskripsi']}</td>" . NL;
									}
								}
							}
						}
					}
					if ($cetak_des == 0)
					{
	$html .=			"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"justify\">-</td>" . NL;
					}
					
    $html .=		'</tr>' . NL;
                    $jml_row++;
                }
    $html .='
					</table>
				</td>
			</tr>
		</table>';
	  if($type_return == 1){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_v1($resultset,$row,$row_per_siswa,$deskripsi_array,$type_return,$background = 0 ,$input_kkm = 70)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '
		<table>
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2013_v1($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
//     $html .= '<br/><br/>';
     $html .= ' 
				</td>
			</tr>
			<tr>
				<td class="sub-kategori"><b>B.</b></td>
				<td class="sub-kategori"><b>Pengetahuan dan Keterampilan</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v1();
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelC1')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>C1</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelC3')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>C3</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL)
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= header_2013_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v1();
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" . NL;
					
					if($mode_range==100)
    				{	
						$cetak_kkm = $input_kkm;	
					}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
					
    $html .=		'</tr>' . NL;
                    $jml_row++;
                }
    $html .='
					</table>
				</td>
			</tr>
		</table>';
	  if($type_return == 1){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return=0,$page_sikap=0,$background = 0,$kkm=70)
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
			sikap_2013_v2($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
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
	$type_return_colspan1 = 6;
	$type_return_colspan2 = 7;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	if($page_sikap == 0){ 
	$html .= '
	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	$html .= 		$header;
	}
    $html .= ' 
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"><b>'.$type_return_subhuruf.'</b></td>
				<td class="sub-kategori"><b>'.$type_return_subkategori.'</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v2($type_return);
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
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
	$html .= header_2013_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        }*/
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
	if($type_return == 0)
	{
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
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
	if($type_return != 1)
	{				
					if($mode_range==100)
    				{	$cetak_kkm = $kkm;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
	}else
	{
					
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
	if($type_return != 1)
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
	}else{ 
					
    
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
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_michael_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return=0,$page_sikap=0,$background = 0,$kkm=70)
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
		<table width="100%" >
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2013_v2($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
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
	$type_return_colspan1 = 6;
	$type_return_colspan2 = 7;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	if($page_sikap == 0){ 
	$html .= '
	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	$html .= 		$header;
	}
    $html .= ' 
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"><b>'.$type_return_subhuruf.'</b></td>
				<td class="sub-kategori"><b>'.$type_return_subkategori.'</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v2($type_return);
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
					////////////////////// cek KKM /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					if($item['nas_teori']<$kkm)
					{	$item['nas_teori'] = $kkm;	}
					if(($item['pred_teori']=='D')||($item['pred_teori']=='d'))
					{	$item['pred_teori'] = 'C';	}
					
					if($item['nas_praktek']<$kkm)
					{	$item['nas_praktek'] = $kkm;	}
					if(($item['pred_praktek']=='D')||($item['pred_praktek']=='d'))
					{	$item['pred_praktek'] = 'C';	}
	
	
	
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
						
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
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
	$html .= header_2013_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        }*/
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
	if($type_return == 0)
	{
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
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
	
	
	if($type_return != 1)
	{				
					if($mode_range==100)
    				{	$cetak_kkm = $kkm;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
					
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
	}else
	{
					
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
	if($type_return != 1)
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
	}else{ 
					
    
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
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_setiabudhi_v2($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return=0,$page_sikap=0,$background = 0, $kkm=65 )
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
			sikap_2013_setiabudhi_v2($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
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
	$type_return_colspan1 = 6;
	$type_return_colspan2 = 7;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	if($page_sikap == 0){ 
	$html .= '
	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	$html .= 		$header;
	}
    $html .= ' 
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"><b>'.$type_return_subhuruf.'</b></td>
				<td class="sub-kategori"><b>'.$type_return_subkategori.'</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v2($type_return);
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
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
	$html .= header_2013_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        }*/
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
	if($type_return == 0)
	{
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
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
	if($type_return != 1)
	{				
					if($mode_range==100)
    				{	$cetak_kkm = $kkm;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
	}else
	{
					
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
	if($type_return != 1)
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
	}else{ 
					
    
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
		$html .=						"</tr><tr><td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
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
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return,$background)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '';
	
	$type_return_subhuruf = "B.";
	$type_return_subkategori = "Pengetahuan dan Keterampilan";
	$type_return_colspan1 = 6;
	$type_return_colspan2 = 7;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	
	$html .= '
	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	$html .= 		$header;
	
    $html .= ' 
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"><b>'.$type_return_subhuruf.'</b></td>
				<td class="sub-kategori"><b>'.$type_return_subkategori.'</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v2($type_return);
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL)
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

    <div id="header_1" class="header">';
	$html .= header_2013_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
	if($type_return == 0)
	{
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
	}
    //$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\" rowspan='2'>{$mp_no}.</td>" . NL;
	$type_return_mapelname = $item['mapel_nama'];
	if($type_return == 0)
	{
		$type_return_mapelname = $item['mapel_nama'].'<br><b>'.$item['guru_nama'].'<b>';
	}
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" rowspan='2'>".$type_return_mapelname."</td>" . NL;
	if($type_return != 1)
	{				
					if($mode_range==100)
    				{	$cetak_kkm = $kkm;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
	}else
	{
					
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Pengetahuan</td>" . NL;
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
	if($type_return != 1)
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
	}else{ 
					
    $html .=        		"</tr><tr>";
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Keterampilan</td>" . NL;
    
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
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_sman14_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return,$background)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '';
	
	$type_return_subhuruf = "B.";
	$type_return_subkategori = "Pengetahuan dan Keterampilan";
	$type_return_colspan1 = 6;
	$type_return_colspan2 = 7;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	
	$html .= '
	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	$html .= 		$header;
	
    $html .= ' 
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"><b>'.$type_return_subhuruf.'</b></td>
				<td class="sub-kategori"><b>'.$type_return_subkategori.'</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v2($type_return);
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
   /* $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

    <div id="header_1" class="header">';
	$html .= header_2013_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';*/
   // $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else 
						if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
						
						
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
	if($type_return == 0)
	{
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
	}
    //$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
					else if( ($item['kategori_kode'] == 'KelB') && ($mp_no==2)) 						
                    {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

    <div id="header_1" class="header">';
	$html .= header_2013_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        
					}
						
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\" rowspan='2'>{$mp_no}.</td>" . NL;
	$type_return_mapelname = $item['mapel_nama'];
	if($type_return == 0)
	{
		$type_return_mapelname = $item['mapel_nama'].'<br><b>'.$item['guru_nama'].'<b>';
	}
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" rowspan='2'>".$type_return_mapelname."</td>" . NL;
	if($type_return != 1)
	{				
					if($mode_range==100)
    				{	$cetak_kkm = $kkm;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
	}else
	{
					
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Pengetahuan</td>" . NL;
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
	if($type_return != 1)
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
	}else{ 
					
    $html .=        		"</tr><tr>";
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Keterampilan</td>" . NL;
    
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
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_v4($resultset,$row,$row_per_siswa,$deskripsi_array,$type_return,$background = 0 ,$input_kkm = 70)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '
		<table>
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2013_v1($resultset['data'],$row_per_siswa,$ktg_nama,$jml_row, $deskripsi_array);
//     $html .= '<br/><br/>';
     $html .= ' 
				</td>
			</tr>
			<tr>
				<td class="sub-kategori"><b>B.</b></td>
				<td class="sub-kategori"><b>Pengetahuan dan Keterampilan </b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v3();
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
					if ( ($item['kategori_nama'] != $ktg_nama) ||
						( ($item['kategori_kode'] == 'KelA') && ($mp_no==1)) ||
							( ($item['kategori_kode'] == 'KelA') && ($mp_no==5)) ||
							( ($item['kategori_kode'] == 'KelB') && ($mp_no==2)) ||
							( ($item['kategori_kode'] == 'KelC2') && ($mp_no==1)) ||
							( ($item['kategori_kode'] == 'MuatanN') && ($mp_no==1) && ($row_per_siswa['agama_id']!=1)) ||
							( ($item['kategori_kode'] == 'MuatanN') && ($mp_no==2) && ($row_per_siswa['agama_id']==1)) ||
							( ($item['kategori_kode'] == 'MuatanN') && ($mp_no==5)) ||
							( ($item['kategori_kode'] == 'MuatanK') && ($mp_no==1)) ||
							( ($item['kategori_kode'] == 'MuatanK') && ($mp_no==3))   
					)
                    {
                        $ktg_ascii++;
						if ($item['kategori_nama'] != $ktg_nama){
							$mp_no = 0;
						}
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }/*
                        else if ($item['kategori_kode'] == 'KelC1')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>C1</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }*/
                        else if ($item['kategori_kode'] == 'KelC3')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>C3</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
						else if (($item['kategori_kode'] == 'KelB')&& ($item['kategori_nama'] != $ktg_nama))
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
						else if (($item['kategori_kode'] == 'KelC2')&& ($item['kategori_nama'] != $ktg_nama))
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
						else if (($item['kategori_kode'] == 'MuatanK')&& ($item['kategori_nama'] != $ktg_nama))
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
						else if (($item['kategori_kode'] == 'C1. Dasar')&& ($item['kategori_nama'] != $ktg_nama))
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
						else if (($ktg_nama != NULL) || 
							( ($item['kategori_kode'] == 'KelA') && ($mp_no==1)) ||
							( ($item['kategori_kode'] == 'KelA') && ($mp_no==5)) ||
							( ($item['kategori_kode'] == 'KelB') && ($mp_no==2)) ||
							( ($item['kategori_kode'] == 'KelC2') && ($mp_no==1)) ||
							( ($item['kategori_kode'] == 'MuatanN') && ($mp_no==1) && ($row_per_siswa['agama_id']!=1)) ||
							( ($item['kategori_kode'] == 'MuatanN') && ($mp_no==2) && ($row_per_siswa['agama_id']==1)) ||
							( ($item['kategori_kode'] == 'MuatanN') && ($mp_no==5)) ||
							( ($item['kategori_kode'] == 'MuatanK') && ($mp_no==1)) ||
							( ($item['kategori_kode'] == 'MuatanK') && ($mp_no==3)) 
						)							
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

        <div id="header_1" class="header">';
	$html .= header_2013_v1($row,$row_per_siswa);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v3();
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" . NL;
					
					if($mode_range==100)
    				{	
						$cetak_kkm = $input_kkm;	
					}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
					
    $html .=		'</tr>' . NL;
                    $jml_row++;
                }
    $html .='
					</table>
				</td>
			</tr>
		</table>';
	  if($type_return == 1){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_sma8_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return,$background)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '';
	
	$type_return_subhuruf = "B.";
	$type_return_subkategori = "Pengetahuan dan Keterampilan";
	$type_return_colspan1 = 6;
	$type_return_colspan2 = 7;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	
	$html .= '
	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	$html .= 		$header;
	
    $html .= ' 
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"><b>'.$type_return_subhuruf.'</b></td>
				<td class="sub-kategori"><b>'.$type_return_subkategori.'</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v2($type_return);
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL)
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

    <div id="header_1" class="header">';
	$html .= header_2013_sma8_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
	if($type_return == 0)
	{
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
	}
    //$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\" rowspan='2'>{$mp_no}.</td>" . NL;
	$type_return_mapelname = $item['mapel_nama'];
	if($type_return == 0)
	{
		$type_return_mapelname = $item['mapel_nama'].'<br><b>'.$item['guru_nama'].'<b>';
	}
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" rowspan='2'>".$type_return_mapelname."</td>" . NL;
	if($type_return != 1)
	{				
					if($mode_range==100)
    				{	$cetak_kkm = $kkm;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
	}else
	{
					
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Pengetahuan</td>" . NL;
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
	if($type_return != 1)
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
	}else{ 
					
    $html .=        		"</tr><tr>";
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Keterampilan</td>" . NL;
    
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
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_sma9_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return,$background)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '';
	
	$type_return_subhuruf = "B.";
	$type_return_subkategori = "Pengetahuan dan Keterampilan";
	$type_return_colspan1 = 6;
	$type_return_colspan2 = 7;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	
	$html .= '
	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	$html .= 		$header;
	
    $html .= ' 
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"><b>'.$type_return_subhuruf.'</b></td>
				<td class="sub-kategori"><b>'.$type_return_subkategori.'</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v2($type_return);
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL)
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

    <div id="header_1" class="header">';
	$html .= header_2013_sma9_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
	if($type_return == 0)
	{
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
	}
    //$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\" rowspan='2'>{$mp_no}.</td>" . NL;
	$type_return_mapelname = $item['mapel_nama'];
	if($type_return == 0)
	{
		$type_return_mapelname = $item['mapel_nama'].'<br><b>'.$item['guru_nama'].'<b>';
	}
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" rowspan='2'>".$type_return_mapelname."</td>" . NL;
	if($type_return != 1)
	{				
					if($mode_range==100)
    				{	$cetak_kkm = $kkm;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
	}else
	{
					
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Pengetahuan</td>" . NL;
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
	if($type_return != 1)
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
	}else{ 
					
    $html .=        		"</tr><tr>";
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Keterampilan</td>" . NL;
    
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
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function tablepdf_2013_michael_v3($resultset,$row,$row_per_siswa,$deskripsi_array,$header,$type_return,$background,$kkm='70')
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '';
	
	$type_return_subhuruf = "B.";
	$type_return_subkategori = "Pengetahuan dan Keterampilan";
	$type_return_colspan1 = 6;
	$type_return_colspan2 = 7;
	
	if($type_return == 1){
		$type_return_subhuruf = "";
		$type_return_subkategori = "Deskripsi Pengetahuan dan Keterampilan";
		$type_return_colspan1 = 3;
		$type_return_colspan2 = 4;
		
	}
	
	$html .= '
	<div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">';
	$html .= 		$header;
	
    $html .= ' 
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"><b>'.$type_return_subhuruf.'</b></td>
				<td class="sub-kategori"><b>'.$type_return_subkategori.'</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v2($type_return);
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
					////////////////////// cek KKM /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					if($item['nas_teori']<$kkm)
					{	$item['nas_teori'] = $kkm;	}
					if(($item['pred_teori']=='D')||($item['pred_teori']=='d'))
					{	$item['pred_teori'] = 'C';	}
					
					if($item['nas_praktek']<$kkm)
					{	$item['nas_praktek'] = $kkm;	}
					if(($item['pred_praktek']=='D')||($item['pred_praktek']=='d'))
					{	$item['pred_praktek'] = 'C';	}
					
					
					
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan1."><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL)
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend page_bg'.$background.'">

    <div id="header_1" class="header">';
	$html .= header_2013_v2($row,$row_per_siswa);
	$html .= '
        </div>
		<table id="t-nilai" >
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v2($type_return);
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=".$type_return_colspan2."><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
	if($type_return == 0)
	{
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
	}
    //$html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\" rowspan='2'>{$mp_no}.</td>" . NL;
	$type_return_mapelname = $item['mapel_nama'];
	if($type_return == 0)
	{
		$type_return_mapelname = $item['mapel_nama'].'<br><b>'.$item['guru_nama'].'<b>';
	}
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" rowspan='2'>".$type_return_mapelname."</td>" . NL;
	if($type_return != 1)
	{				
					if($mode_range==100)
    				{	$cetak_kkm = $kkm;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
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
	}else
	{
					
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Pengetahuan</td>" . NL;
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
	if($type_return != 1)
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
	}else{ 
					
    $html .=        		"</tr><tr>";
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">Keterampilan</td>" . NL;
    
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
	  if($type_return == 2){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}

function table_interval_kkm_v2()
{
	$html ='
	<table cellspacing="0" width="100%" >
	<tr>
		<td width="20px"></td>
		<td >
		<br/><div style="font-size:12;">Tabel interval berdasarkan KKM.</div><br/>
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
			
	if( strtolower(APP_SCOPE)=='sman8smg')
	{
	$html .='		<tr>
				<td class="field-nilai t-border" align="center"> 70 </td>
				<td class="field-nilai t-border" align="center"> < 70 </td>
				<td class="field-nilai t-border" align="center"> 70 - 75</td>
				<td class="field-nilai t-border" align="center"> 76 - 90 </td>
				<td class="field-nilai t-border" align="center"> 91 - 100</td>
			';	
	}elseif( strtolower(APP_SCOPE)=='sman9smg')
	{
	$html .='		<tr>
				<td class="field-nilai t-border" align="center"> 70 </td>
				<td class="field-nilai t-border" align="center"> < 70 </td>
				<td class="field-nilai t-border" align="center"> 70 - 75</td>
				<td class="field-nilai t-border" align="center"> 76 - 84 </td>
				<td class="field-nilai t-border" align="center"> 85 - 100</td>
			';	
	}elseif( strtolower(APP_SCOPE)=='sman14smg')
	{
	
	$html .='		<tr>
				<td class="field-nilai t-border" align="center"> 70 </td>
				<td class="field-nilai t-border" align="center"> < 70 </td>
				<td class="field-nilai t-border" align="center"> 70 ≤ x ≤ 79</td>
				<td class="field-nilai t-border" align="center"> 80 ≤ x ≤ 89 </td>
				<td class="field-nilai t-border" align="center"> 90 ≤ x ≤ 100</td>
			';	
	}elseif( strtolower(APP_SCOPE)=='smk_nusaputera')
	{
	/*
	$html .='		<tr>
				<td class="field-nilai t-border" align="center"> 75 </td>
				<td class="field-nilai t-border" align="center"> < 60 </td>
				<td class="field-nilai t-border" align="center"> 61 - 74</td>
				<td class="field-nilai t-border" align="center"> 75 - 89 </td>
				<td class="field-nilai t-border" align="center"> 90 - 100</td>
			';	*/
	$html .='		<tr>
				<td class="field-nilai t-border" align="center"> 75 </td>
				<td class="field-nilai t-border" align="center"> < 75 </td>
				<td class="field-nilai t-border" align="center"> 75 - 80</td>
				<td class="field-nilai t-border" align="center"> 81 - 90 </td>
				<td class="field-nilai t-border" align="center"> 91 - 100</td>
			';	
	}elseif( strtolower(APP_SCOPE)=='sma_setiabudhi')
	{
	$html .='		<tr>
				<td class="field-nilai t-border" align="center"> 70 </td>
				<td class="field-nilai t-border" align="center"> < 64 </td>
				<td class="field-nilai t-border" align="center"> 65 - 69</td>
				<td class="field-nilai t-border" align="center"> 70 - 85 </td>
				<td class="field-nilai t-border" align="center"> 86 - 100</td>
			';	
	}elseif( strtolower(APP_SCOPE)=='sma_michael')
	{
	$html .='		<tr>
				<td class="field-nilai t-border" align="center"> 60 </td>
				<td class="field-nilai t-border" align="center"> < 60 </td>
				<td class="field-nilai t-border" align="center"> 60 - 69</td>
				<td class="field-nilai t-border" align="center"> 70 - 85 </td>
				<td class="field-nilai t-border" align="center"> 86 - 100</td>
			';	
	}else{
		$html .='		<tr>
				<td class="field-nilai t-border" align="center"> 70 </td>
				<td class="field-nilai t-border" align="center"> < 69 </td>
				<td class="field-nilai t-border" align="center"> 70 - 75</td>
				<td class="field-nilai t-border" align="center"> 76 - 90 </td>
				<td class="field-nilai t-border" align="center"> 91 - 100</td>
			';	
	}
	
	$html .='</tr>
		</table>
		
		</td>
		</tr>
	</table>';
	return $html;
}

function ttd_2013_v0($data,$type_ttd = 0)
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
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
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
		if ((strtolower($data["semester_nama"]) == "genap")&&($data["kelas_grade"] != 12))
			{
    $html .='       
		<tr>
            <td colspan="2"></td>
			<td colspan="3">
				<table>
					<tr>
						<td style="padding:20px;width: 100%;" >
								<b>Keputusan:</b> 
								<br>
								Berdasar hasil yang dicapai pada <br>
								semester 1 dan 2, peserta didik ditetapkan <br>
                                <br>dinyatakan <b>LULUS</b> <br>
                                naik ke kelas '.$data["kelas_grade"].'<br>
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
			}
	$html .='    
	</table>';
	return $html;
}

function ttd_2013_v1($data,$type_ttd = 0)
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
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		
		
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
			}else{
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
			}
			
	$html .='    
	</table>';
	return $html;
}

function ttd_2013_sma9_v1($data,$type_ttd = 0)
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
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		
		
		if ((strtolower($data["semester_nama"]) == "genap")&&($data["kelas_grade"] != 12))
			{
    $html .='       
		<tr>
            <td colspan="2"></td>
			<td colspan="3">
				<table>
					<tr>
						<td style="padding:0px 0px 0px 0px;width: 100%;" >
								<b>Keputusan:</b> 
								<br>
								Berdasar hasil yang dicapai pada <br>
								semester 1 dan 2, peserta didik ditetapkan <br>
                                <br>dinyatakan <br>
                                naik ke kelas '.($data["kelas_grade"]+1).' / 
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
			}else{
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
			}
			
	$html .='    
	</table>';
	return $html;
}

function ttd_2013_sma8_v1($data,$type_ttd = 0)
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
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		
		
		
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
			
	$html .='    
	</table>';
	return $html;
}

function ttd_2013_nusput_v1($data,$type_ttd = 0)
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
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		
		
		
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
			
			
	$html .='    
	</table>';
	return $html;
}

function ttd_2013_nusput_v2($data,$row_per_siswa,$type_ttd = 0)
{
	$nip=0;
	$type_ttd=1;
	if(strpos(APP_SCOPE, 'sman') !== false)
	{
		$nip=1;
	}
	$aray_naik_tingkat = array(10 => "X", 11 => "XI", 12 => "XII");
	
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
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		
		/*
		if ((strtolower($data["semester_nama"]) == "genap")&&($data["kelas_grade"] != 12))
			{
				$ket_kenaikan = '<b>'.$row_per_siswa['ket_kenaikan_kelas'].'</b> ke kelas '.$aray_naik_tingkat[$data["kelas_grade"]+1];
				if($row_per_siswa['ket_kenaikan_kelas']=="")
				{
					$ket_kenaikan = '<b>NAIK</b> ke kelas '.$aray_naik_tingkat[$data["kelas_grade"]+1];
				}
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
                                <br>dinyatakan '.$ket_kenaikan.' <br>
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

function ttd_2013_penerbad_v1($data,$row_per_siswa,$type_ttd = 0)
{
	$nip=0;
	if(strpos(APP_SCOPE, 'sman') !== false)
	{
		$nip=1;
	}
	$aray_naik_tingkat = array(10 => "X", 11 => "XI", 12 => "XII");
	
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
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		
		
		if ((strtolower($data["semester_nama"]) == "genap")&&($data["kelas_grade"] != 12))
			{
				$ket_kenaikan = '<b>'.$row_per_siswa['ket_kenaikan_kelas'].'</b> ke kelas '.$aray_naik_tingkat[$data["kelas_grade"]+1];
				if($row_per_siswa['ket_kenaikan_kelas']=="")
				{
					$ket_kenaikan = '<b>NAIK</b> ke kelas '.$aray_naik_tingkat[$data["kelas_grade"]+1];
					if($data["kelas_grade"]==11){
						$ket_semester = '3 dan 4';
					}else{
						$ket_semester = '1 dan 2';
					}
					
				}
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
								semester '.$ket_semester.', peserta didik ditetapkan <br>
                                <br>dinyatakan '.$ket_kenaikan.' <br>
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
			}else{
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
			}
			
	$html .='    
	</table>';
	return $html;
}

function ttd_2013_smkn6smg_v1($data,$row_per_siswa,$type_ttd = 0)
{
	$nip=0;
	if(strpos(APP_SCOPE, 'sman') !== false)
	{
		$nip=1;
	}
	elseif(strpos(APP_SCOPE, 'smkn') !== false)
	{
		$nip=1;
	}
	$aray_naik_tingkat = array(10 => "X", 11 => "XI", 12 => "XII");
	
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
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		
		
		if ((strtolower($data["semester_nama"]) == "genap")&&($data["kelas_grade"] != 12))
			{
				$ket_kenaikan = '<b>'.$row_per_siswa['ket_kenaikan_kelas'].'</b> ke kelas '.$aray_naik_tingkat[$data["kelas_grade"]+1];
				if($row_per_siswa['ket_kenaikan_kelas']=="")
				{
					$ket_kenaikan = '<b>NAIK</b> ke kelas '.$aray_naik_tingkat[$data["kelas_grade"]+1];
				}
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
                                <br>dinyatakan '.$ket_kenaikan.' <br>
								<br>
                                Mengetahui,<br/>
                                Kepala Sekolah
                                <br><br><br><br>
                                <u>'.$data["kepsek_nama"].'</u>';
								
								if($nip==1){
								$html .='<br>NIP : '.$data["kepsek_nip"];
								}
                                
		$html .='       											
						</td>
					</tr>
				</table>
			</td>
            <td></td>
		</tr>';
			}else{
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
			}
			
	$html .='    
	</table>';
	return $html;
}

function ttd_2013_v2($data,$row_per_siswa,$type_ttd = 0)
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
	$html .='			' . $data["wali_nama"] . '';
	
	if($nip==1){
		$html .='			<br/>
							NIP : ' . $data["wali_nip"];
	}
	
	$html .='		</p></b>
				<br>

			</td>
		</tr>';
		
		if ((strtolower($data["semester_nama"]) == "genap")&&($data["kelas_grade"] != 12))
			{
    $html .='       
		<tr>
            <td colspan="2"></td>
			<td colspan="3">
				<table>
					<tr>
						<td style="padding:20px;width: 100%;" >
								<b>Keputusan:</b> 
								<br>
								Berdasar hasil yang dicapai pada <br>
								semester 1 dan 2, peserta didik ditetapkan <br>
                                <br>dinyatakan <br>
                                '.$row_per_siswa["ket_kenaikan_kelas"].'
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
			}else{
				
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
						$html .='		' . $data["kepsek_nama"] . '';
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
				
			}
	$html .='    
	</table>';
	return $html;
}

function keterangan_kenaikan_sma_8()
{
	$html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="35px">
			<b>Keterangan Kenaikan Kelas:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Naik / Tidak Naik *) &nbsp;&nbsp;&nbsp;&nbsp;ke Kelas XI / XII *)
			</td>
        </tr>
	  </table>
	  *) coret yang tidak perlu <br/><br/><br/>';
	return $html; 
}


function pindahkelasv1($row){
	
}