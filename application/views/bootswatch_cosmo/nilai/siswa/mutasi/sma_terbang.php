<?php

$asal_sekolah 	= "SMA Kristen Terang Bangsa";
$tanggal_mutasi	= $row['tanggal_mutasi'];

if (strpos($row['kelas_nama'], 'IPA') !== false){
	$jurusan = "Ilmu Pengetahuan Alam";
	$sjurusan = "MIPA";
}else{
	$jurusan = "Ilmu Pengetahuan Sosial";
	$sjurusan = "IPS";
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
        sheet-size: 210mm 275mm ;
        margin: 70px 50px 5px 70px;
    }

    .page-notend{
        page-break-after: always;
    }
	.style6 {
		font-size: 13px;	
		padding: 1px 3px 15px 3px;
	}
    .style7 {
		font-size: 13px;	
		padding: 2px 5px 2px 5px;
		vertical-align: middle;
		 text-align: center;
	}
	.style7l {
		font-size: 13px;	
		padding: 2px 5px 2px 5px;
		vertical-align: middle;
		 text-align: left;
	}
	.style7lt {
		font-size: 13px;	
		padding: 2px 5px 2px 5px;
		vertical-align: text-top;
		 text-align: left;
	}
	.style7ct {
		font-size: 13px;	
		padding: 2px 5px 2px 5px;
		vertical-align: text-top;
		 text-align: center;
	}
	.style12 {
		font-size: 13px;
        font-weight: bold;
		padding: 0px 0px 15px 0px;
    }
    
    .backgrounds{

			background-image: url('<?=base_url("")?>/images/logo/<?=APP_SCOPE?>/sma-terang-bangsa-wm.png);
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: 30px 150px;
			background-size: 1700px 1700px;
		}
</style>

<?php
$font_header = "font-size:14";
$width_nama = "38%";
if(strlen($row['kelas_nama'])>20)
{
	//$font_header = "font-size:13;";
	$width_nama = "35%";
}
	
foreach($id_nilai_siswa['data'] as $cetak)
{
	$jumlah_rapor--;
	$row_per_siswa=$cetak;

	//// nama
	$nama = strtolower($row_per_siswa['siswa_nama']); 
	$nama = explode(" ",$nama);
	$cetak_nsiswa = '';
	foreach($nama as $cetak_nama)
	{
		$cetak_nsiswa = $cetak_nsiswa.ucfirst($cetak_nama)." ";
	}
	////kelas
	$nama_kelas = explode(" ",$row['kelas_nama']);
	$jml_nama_kelas = 0;
	$cetak_kelas='';
	foreach($nama_kelas as $cetak_nama_kelas)
	{	
		$cetak_kelas = $cetak_kelas.$cetak_nama_kelas." "; 
		$jml_nama_kelas++;
	}
	//// semester
	if(strtolower($row['semester_nama'])=='gasal') 
	{	$semester = '1';	}
	else 
	{	$semester = '2';	} 
	
	$header ='
	<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;<?=$font_header?> padding: 10px 0 10px 0;">
		
		<tr>
			<td width="126px" valign="top" class="style6 ">Nama Peserta Didik</td>
			<td width="6px" valign="top" class="style6 ">:</td>
			<td width="'.$width_nama.'" valign="top" class="style6 ">'.$cetak_nsiswa.'
			
			
			</td>
			
			<td width="104px" valign="top" class="style6 " >Kelas/Semester</td>
			<td width="6px" valign="top" class="style6 " >:</td>
			<td valign="top" class="style6 " >'.$cetak_kelas.' / '.$semester.'</td>
					
		</tr>
		
		<tr>
			<td valign="top" class="style6 " >Nomor Induk</td>
			<td valign="top" class="style6 ">:</td>
			<td valign="top" class="style6 ">'.$row_per_siswa['siswa_nis'].'</td>
			
			<td valign="top" class="style6 " >Tahun Pelajaran </td>
			<td valign="top" class="style6 " >:</td>
			<td valign="top" class="style6 " >'.$row['ta_nama'].'</td>
		</tr>
		
		<tr>
			<td valign="top" class="style6 ">Nama Sekolah </td>
			<td valign="top" class="style6 ">:</td>
			<td valign="top" class="style6 ">'.$asal_sekolah.'</td>
			
			<td valign="top" class="style6 ">Program </td>
			<td valign="top" class="style6 ">:</td>
			<td valign="top" class="style6 ">'.$sjurusan.'</td>
		</tr>

	</table>';


	
	?>	
	<div id="bg_deskripsi" class="content page-notend backgrounds">
		<table border="0" style="width: 100%;">
			<tr>
				<td align="center" valign="top" style="padding: 0 0 10px 0">
					<span class="style12">
						Keterangan Pindah Sekolah
						<br />
						(Diisi oleh sekolah yang ditinggalkan)
					</span>
				</td>
			</tr>
		</table>

		<?=$header?>

		<table border="1" cellpadding="0" cellspacing="0" style="width: 100%;<?=$font_header?> padding: 10px 0 10px 0;">
			<tr>
				<td colspan="4" class="style7 "><b>K E L U A R</b></td>
			</tr>
			<tr>
				<td class="style7 " width="15%">Tanggal</td>
				<td class="style7 " width="25%">Kelas dan Semester yang ditinggalkan</td>
				<td class="style7 " width="35%">Sebab-sebab keluar dan atas permintaan (tertulis) dari :</td>
				<td class="style7 " >
					Tanda Tangan Kepala Sekolah,
					Stempel Sekolah Dan Tanda Tangan
					Orang Tua / Wali
				</td>
			</tr>
			<tr>
				<td class="style7ct "><?=$tanggal_mutasi?></td>
				<td class="style7ct "><?=$cetak_kelas?> / <?=$semester?></td>
				<td class="style7 "></td>
				<td class="style7 ">
				Semarang, <?=$tanggal_mutasi?> <br/>
				Kepala Sekolah,
				<br/><br/><br/><br/>
				( Drs. S. PRIHADI )
				<br/><br/><br/>
				Orang Tua/Wali
				<br/><br/><br/><br/>
				(………………………………)
				</td>
			</tr>
			<?php 
				$x=1;
				while($x<=2){
					?>
				<tr>
					<td class="style7 "></td>
					<td class="style7 "></td>
					<td class="style7 "></td>
					<td class="style7 ">
					……………………………… <br/>
					Kepala Sekolah,
					<br/><br/><br/><br/>
					(………………………………)
					<br/><br/><br/>
					Orang Tua/Wali
					<br/><br/><br/><br/>
					(………………………………)
					</td>
				</tr>
			<?php 
				$x++;
			}?>
		</table>
			
	</div>
	
	
	
	<div id="bg_deskripsi" class="content page-notend backgrounds">
		<table border="0" style="width: 100%;">
			<tr>
				<td align="center" valign="top" style="padding: 0 0 10px 0">
					<span class="style12">
						Keterangan Pindah Sekolah
						<br />
						(Diisi oleh sekolah yang baru)
					</span>
				</td>
			</tr>
		</table>

		<?=$header?>

		<table border="1" cellpadding="0" cellspacing="0" style="width: 100%;<?=$font_header?> padding: 10px 0 10px 0;">
			<tr>
				<td colspan="4" class="style7 "><b>M A S U K</b></td>
			</tr>
			
			<?php 
				$x=1;
				while($x<=3){
					?>
				<tr>
					<td class="style7 ">No.</td>
					<td class="style7 " colspan="2">Identitas Peserta Didik</td>
				</tr>
				<tr>
					<td class="style7 ">
						<br/>1.<br>2.<br>3.<br>4.<br><br/><br/><br/>5.<br/>
						<br/><br/><br/>
					</td>
					<td class="style7l ">
						<br/>
						Nama Peserta Didik<br/>
						Nomor Induk<br/>
						Nama Sekolah<br/>
						Masuk :<br/>
						a.Tanggal<br/>
						b.Di Kelas<br/>
						c.Semester<br/>
						Tahun Pelajaran<br/> 
						<br/><br/><br/>
					</td>
					<td class="style7 ">
						<br/>
						…………………………………………………………………<br/>
						…………………………………………………………………<br/>
						…………………………………………………………………<br/>
						<br/>
						…………………………………………………………………<br/>
						…………………………………………………………………<br/>
						…………………………………………………………………<br/>
						…………………………………………………………………<br/>
						<br/><br/><br/>
					</td>
					<td class="style7 " rowspan="2">
						……………………………… <br/>
						Kepala Sekolah,
						<br/><br/><br/><br/><br/>
						(………………………………)
						<br/><br/><br/>
					</td>
				</tr>
			<?php 
				$x++;
			}?>
		</table>
			
	</div>
	<?php
	if($jumlah_rapor>0)
	 	echo '<div id="bg_deskripsi" class="content page-notend backgrounds">';
	 else
	 	echo '<div class="page backgrounds" id="page-1" >';	
	?>
		<table border="0" style="width: 100%;">
			<tr>
				<td align="center" valign="top" style="padding: 0 0 10px 0">
					<span class="style12">
						Catatan Prestasi Yang Telah Dicapai
						<br /><br /><br />
					</span>
				</td>
			</tr>
		</table>

		<?=$header?>
		<table border="1" cellpadding="0" cellspacing="0" style="width: 100%;<?=$font_header?> padding: 10px 0 10px 0;">
			<tr>
				<td width="6%" class="style7 "><b>No.</b></td>
				<td width="48%" class="style7 "><b>Prestasi yang Pernah Dicapai</b></td>
				<td class="style7 "><b>Bukti Sertifikat/Piagam/Trophy yang diperoleh (Sebutkan)</b></td>
			</tr>
			<?php
			$sertifikat = array(
				"Kurikuler",
				"Ekstrakurikuler",
				"Lain-lain",
				"Catatan Khusus lainnya",
			);
			$no=0;
			foreach($sertifikat as $ser){
				$no++;
				?>
				<tr>
					<td class="style7ct "><?=$no?>.</td>
					<td class="style7lt ">
						<?=$ser?>
						<br><br><br><br>
						<br><br><br><br>
						<br><br>
					</td>
					<td></td>
				</tr>
				<?php
			}?>
		</table>
			
			
	</div>
<?php 
}?>