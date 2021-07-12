<?php

$asal_sekolah = "SMA Kristen Terang Bangsa";
$tanggal_rapor='03 Mei 2018 ';

if (strpos($row['kelas_nama'], 'IPA') !== false){
	$jurusan = "Ilmu Pengetahuan Alam";
	//$sjurusan = "MIPA";
}else{
	$jurusan = "Ilmu Pengetahuan Sosial";
	//$sjurusan = "IPS";
}

function int2huruf($n) {
    if (is_null($n) OR !is_numeric($n))
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

function tgl_indo($tgl) {
    $tanggal = substr($tgl, 0, 2);
    $bulan = getBulan(substr($tgl, 3, 2));
    $tahun = substr($tgl, 6, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function getBulan($bln) {
    switch ($bln) {
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
?>
<style type="text/css">
   
	@page {
	 	/* POLIO*/
        sheet-size: 210mm 330mm ;
        margin: 150px 50px 5px 70px;
    }

    .page-notend{
        page-break-after: always;
    }
	.style6 {font-size: 14px;	}
    .style7 {font-size: 11px; font-weight: bold; }
	.style8 {	
		font-size: 12px; 
		padding: 1px 3px 0px 3px;
		border: 1px solid black;
	}
	.style8a {	
		font-size: 12px; 
		padding: 1px 3px 0px 3px;
	}
    .style10 {
		font-size: 12px; 
		font-weight: bold; 
		padding: 1px 3px 0px 3px;
		border: 1px solid black;
	}
    .style9 {font-size: 15px}
    .style11 {font-size: 18px}
	.style12 {
        font-weight: bold;
    }
    .style13 {
        font-size: 30px;
        font-weight: bold;
    }
    .style14 {
        font-size: 34px;
        font-weight: bold;
    }
    .style16 {font-size: 14px}
    .style17 {font-size: 13px}
    .style18 {font-size: 36px}
    .style19 {font-size: 28px}
    
</style>

<?php
foreach($id_nilai_siswa['data'] as $cetak)
{
	$jumlah_rapor--;
	$row_per_siswa=$cetak;
	
	$resultset 			= $resultset_array[$cetak['id']];

	if($jumlah_rapor>0)
	 	echo '<div id="bg_deskripsi" class="content page-notend">';
	 else
	 	echo '<div class="page" id="page-1" >';	
?>	
<table border="0" style="width: 100%;">
    <tr>

    <td valign="top" style="border-top:solid; border-top-width:4; padding-top:-8"><strong><hr></strong></td>
	</tr>
	<tr>
		<td align="center" valign="top" style="padding: 0 0 10px 0">
            <span class="style12">
                SERTIFIKAT KELULUSAN DAN HASIL UJIAN<br>
				SEKOLAH MENENGAH ATAS
          
				<br />
                Tahun Pelajaran <?=$row['ta_nama']?><br />
               Program Studi : <?=$jurusan?>
            </span>
            
        </td>
    </tr>
	
</table>

<?php
	$font_header = "font-size:14;";
?>
<div class="style6 " style="text-align: justify; text-justify: inter-word;" >
Yang bertandatangan dibawah ini, Kepala Sekolah Menengah Atas Kristen Terang Bangsa, Semarang menerangkan bahwa :
</div>		
<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;<?=$font_header?> padding: 10px 0 10px 0;">
	
    <tr>
        <td width="27%" valign="top" class="style6 ">Nama</td>
        <td width="10px" valign="top" class="style6 ">:</td>
        <td valign="top" class="style6 "><?php 
		
		$nama = strtolower($row_per_siswa['siswa_nama']); 
        $nama = explode(" ",$nama);
		foreach($nama as $cetak_nama)
		{
			echo ucfirst($cetak_nama)." ";
		}
		
		?> </td>
    </tr>
	
	<tr>
        <td valign="top" class="style6 ">Tempat dan Tanggal Lahir </td>
        <td valign="top" class="style6 ">:</td>
        <td valign="top" class="style6 "><?php echo $row_per_siswa['lahir_tempat']; ?> , <?php echo tanggal($row_per_siswa['lahir_tgl']); ?> </td>
    </tr>
	
	<tr>
        <td valign="top" class="style6 ">Nama Orang Tua </td>
        <td valign="top" class="style6 ">:</td>
        <td valign="top" class="style6 "><?php 
		if($row_per_siswa['ayah_nama']!=''){
			echo $row_per_siswa['ayah_nama']; 
		}else{ 
			echo $row_per_siswa['ibu_nama']; 
		}?> </td>
    </tr>
	
    <tr>
        <td valign="top" class="style6 " >Nomor Induk / NISN </td>
        <td valign="top" class="style6 ">:</td>
        <td valign="top" class="style6 "><?php echo $row_per_siswa['siswa_nis']; ?> / <?php echo $row_per_siswa['siswa_nisn']; ?> </td>
    </tr>
	
	<tr>
        <td valign="top" class="style6 ">No Peserta </td>
        <td valign="top" class="style6 ">:</td>
        <td valign="top" class="style6 "><?php echo $row_per_siswa['siswa_no_un']; ?>  </td>
    </tr>
	
	<tr>
        <td valign="top" class="style6 ">Sekolah Asal </td>
        <td valign="top" class="style6 ">:</td>
        <td valign="top" class="style6 "><?php echo $asal_sekolah; ?> </td>
    </tr>

</table>
<div class="style6 " style="padding: 0 0 10px 0">Telah dinyatakan <b>LULUS</b> dari <?php echo $asal_sekolah; ?> dengan hasil sebagai berikut :</div>

<table width="100%" >
	<tr>
		<td width="2%"></td>
		<td>
	
			<?php
				$width_col_1a="23px";
				$width_col1="30px";
				$width_col2="240px";
				$width_col3="120px";
				$width_col4="120px";
				$width_col5="150px";
			?>
			<table border="1" cellpadding="0" cellspacing="0" >
				<tr>
					<th width="<?=$width_col1?>"  class="style10" align="center">No</th>
					<th width="<?=$width_col2?>" class="style10">Mata Pelajaran</th>
					<th width="<?=$width_col3?>" class="style10">Nilai Rata-rata Raport (NR)</th>
					<th width="<?=$width_col4?>" class="style10">Nilai Ujian Sekolah (NUS)</th>
					<th width="<?=$width_col5?>" class="style10">Nilai Sekolah <br>(70% NR + 30% NUS)</th>
				</tr>
				<tr>
					<th class="style10" >I</th>
					<th class="style10" align="left">Ujian Sekolah</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
					<?php
					$mp_no = 0;
					$jml_nrata	= 0;
					$jml_us	= 0;
					$jml_ns	= 0;
					foreach ($resultset['data'] as $idx => $item): 
						$mp_no++;
						$item['skhun_nrata'] 	= round($item['skhun_nrata']);
						$item['skhun_us']		= round($item['skhun_us']);
						$item['skhun_ns']		= round($item['skhun_ns']);
						$jml_nrata	= $jml_nrata + $item['skhun_nrata'];
						$jml_us		= $jml_us + $item['skhun_us'];
						$jml_ns		= $jml_ns + $item['skhun_ns'];
					?>
					<tr>
						<td valign="middle" class="style8" align="right"></td>
						<td valign="top"  class="style8" align="left">
							<table border="0" cellpadding="0" cellspacing="0" >
								<tr>
									<td valign="top" class="style8a" width="<?=$width_col_1a?>"><?php echo $mp_no; ?>.</td> 
									<td class="style8a"><?=$item['mapel_nama']; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" class="style8" align="center"><?=number_format($item['skhun_nrata'],2); ?></td>
						<td valign="top" class="style8" align="center"><?=number_format($item['skhun_us'],2); ?></td>
						<td valign="top" class="style8" align="center"><?=number_format($item['skhun_ns'],2); ?></td>
					</tr>
				<?php endforeach; 
				
				$rata_nrata = round($jml_nrata / $mp_no);
				$rata_us 	= round($jml_us / $mp_no);
				$rata_ns 	= round($jml_ns / $mp_no);
				?>
				<tr>
					<td valign="middle" class="style10" align="center" colspan="2">Rata - Rata</td>
					<td valign="middle" class="style10" align="center" >
						<?=number_format($rata_nrata,2)?></td>
					<td valign="middle" class="style10" align="center" >
						<?=number_format($rata_us,2)?></td>
					<td valign="middle" class="style10" align="center" >
						<?=number_format($rata_ns,2)?></td>
				</tr>
			</table>
				
			<br/>
			<?php
			$mapel_un=array(
				"indonesia",
				"matematika",
				"inggris",
				"fisika",
				"biologi",
				"kimia",
				"geografi",
				"ekonomi",
				"sosiologi"
			);
			?>
			<table  border="1" cellpadding="0" cellspacing="0" >
				<tr>
					<th width="<?=$width_col1?>" class="style10" align="center">No</th>
					<th width="<?=$width_col2?>" class="style10">Mata Pelajaran</th>
					<th width="<?=$width_col3?>" class="style10">Nilai Sekolah</th>
					<th width="<?=$width_col4?>" class="style10">Nilai Ujian Nasional</th>
				</tr>
				<tr>
					<th class="style10" >II</th>
					<th class="style10" align="left">Ujian Nasional</th>
					<th></th>
					<th></th>
				</tr>
					<?php
					$mp_no = 0;
					$jml_un=0;
					foreach ($resultset['data'] as $idx => $item): 
						$show_mapel=0;
						foreach($mapel_un as $m_un){
							if (stripos($item['mapel_nama'], $m_un) !== false) {
								$show_mapel=1;
							}
						}
						if(($show_mapel==1)&&($item['skhun_un']>0)){
							$mp_no++;
							$item['skhun_ns']		= round($item['skhun_ns']);
							$jml_un = $jml_un + $item['skhun_un'];
							?>
							<tr>
								<td valign="middle" class="style8" align="right"></td>
								<td valign="top"  class="style8" align="left">
									<table border="0" cellpadding="0" cellspacing="0" >
										<tr>
											<td valign="top" class="style8a" width="<?=$width_col_1a?>"><?php echo $mp_no; ?>.</td> 
											<td class="style8a"><?=$item['mapel_nama']; ?></td>
										</tr>
									</table>
								</td>
								<td valign="top" class="style8" align="center"><?=number_format($item['skhun_ns'],2); ?></td>
								<td valign="top" class="style8" align="center"><?=$item['skhun_un']; ?></td>
							</tr>
							<?php
						}
					endforeach; ?>
				<tr>
					<td valign="middle" class="style10" align="center" colspan="3">Jumlah</td>
					<td valign="middle" class="style10" align="center"><?=number_format($jml_un,2)?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div class="style6 " style="text-align: justify; text-justify: inter-word; padding: 10px 0 10px 0" >
SHU ini dapat digunakan untuk keperluan Penerimaan Mahasiswa Baru (PMB) 
atau keperluan lain sesuai dengan kebutuhan, dan hanya berlaku sampai dengan diterbitkannya 
Ijazah dan Sertifikat Hasil Ujian Nasional (SKHUN) Tahun Pelajaran <?=$row['ta_nama']?>
</div>


<table border="0" style="width: 100%;">
    <tr>
        <td width="42%" align="center" valign="top">
        </td>
        <td width="18%" align="center" valign="top" style="padding: 10" >
			<table border="1" cellpadding="0" cellspacing="0" width="100%" height="100%">
				<tr>
					<td valign="middle" align="center">
					<br><br><br>
					<b>FOTO 3 x 4</b>
					<br><br><br><br><br/>
					</td>
				</tr>
			</table>
        </td>
        <td valign="top">
			Semarang, <?php echo $tanggal_rapor; ?><br/>
			Kepala <?php echo $asal_sekolah; ?> <br/>
			<br/>
			<br/><br/><br/><br/>
			 Drs. Sungkowo Prihadi	  </p>    
		</td>
    </tr>
</table>
</div>
<?php }?>