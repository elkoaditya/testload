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
?>
<style type="text/css">
<!--
.style3 {font-size: 11px}
-->
#halaman {
height:1500px;
}

.style7 {font-size: 11px; font-weight: bold; }
.style8 {font-size: 11px}
.style11 {font-size: 12px}
.style12 {
	font-size: 16px;
	font-weight: bold;
}
.style13 {
	font-size: 18px;
	font-weight: bold;
}
.style17 {font-size: 24px}
.style18 {font-size: 36px}
.style19 {font-size: 28px}

.style110 {
	padding-bottom:10px;
	font-size: 14px;
	}

#content1{
		line-height: 190%;
    text-align: justify;
    text-justify: inter-word;
	margin-left:50px;}
#content1 h3{
line-height: 260%;
}
#content1 table{
	margin-left:70px;}
</style>
<?php 

//echo "<pre>";
//print_r($row);
//echo "</pre>";
//$ta_thun = ($resultset['data'][0]['ta']-1) . '/' . ($resultset['data'][0]['ta'] );
$ta_thun = $row['ta_nama'];
$sekolah_nama = "SMA NEGERI 1 SEMARANG";
$sekolah_yayasan = "";
?>
<div id="halaman"> 
		
<table border="0" style="width: 100%;">
<tr>
    <td width="10%" class="style110" valign="top"><img src="<?php echo base_url();?>/content/sma1_smg/Logo Dinas Pend.jpg" width="70" height="90"/> </td>
    <td width="80%" align="center" valign="top"><span class="style13">PEMERINTAH KOTA SEMARANG<br />
      DINAS PENDIDIKAN</span><br />
      <span class="style13"><?=strtoupper($sekolah_nama)?></span><br />
      <span class="style11">
	  Jalan Taman Menteri Supeno No.1 Semarang 50243<br/>
                    Telp.(024)8310447 - 8318539 Fax.(024)8414851 E-mail : <u>sma1semarang@yahoo.co.id</u>
	  </span>
	  </td>
    <td width="10%" class="style110" valign="top"><img src="<?php echo base_url();?>/content/sma1_smg/Logo SMA1.jpg" width="70" height="90" /> </td>
  </tr>
  <tr>

    <td colspan="3" valign="top" style="border-top:solid; border-top-width:8; padding-top:-8"><strong><hr></strong></td>
  </tr>

</table>
<?php 
$explode_kelas = explode(' ',$row['kelas_nama']);
if(strtoupper($explode_kelas[1]) == 'IPA'){
	$jurusan = "Ilmu Pengetahuan Alam";
}else{
	$jurusan = "Ilmu Pengetahuan Sosial";
}

	$jurusan = "Ilmu Pengetahuan Sosial";
?>
<table border="0" style="width: 100%;">
<tr>
    <td width="80%" align="center" valign="top">
		<span class="style12">
		SURAT KETERANGAN HASIL UJIAN (SKHU) SEMENTARA<br />
		SEKOLAH MENENGAH ATAS<br>
		<?=strtoupper($jurusan)?><br>
		TAHUN PELAJARAN <?= strtoupper($row['ta_nama']); ?>
	</td>
  </tr>
</table>
<br>
<table border="0" cellpadding='0' cellspacing='0' style="width: 100%;">
<tr>
    <td valign="top" colspan='3' class="style110">
		<span>
		Yang bertanda tangan dibawah ini, Kepala Sekolah Menengah Atas (SMA) Negeri 1 Semarang menerangkan bahwa:
		</span>
	</td>
</tr>
<tr>
		<td class="style110" width="30%">Nama</td>
		<td class="style110" width="1%">:</td>
		<td class="style110" width="69%"><?= strtoupper($row['siswa_nama']); ?> </td>
</tr>
<tr>
		<td class="style110">Tempat dan tanggal lahir</td>
		<td class="style110">:</td>
		<td class="style110" width="69%">  </td>
</tr>
<tr>
		<td class="style110">Nama orangtua/wali</td>
		<td class="style110">:</td>
		<td class="style110" width="69%">  </td>
</tr>
<tr>
		<td class="style110">Nomor induk siswa</td>
		<td class="style110">:</td>
		<td class="style110" width="69%"><?= strtoupper($row['siswa_nis']); ?> </td>
</tr>
<tr>
		<td class="style110">Nomor induk siswa nasional</td>
		<td class="style110">:</td>
		<td class="style110" width="69%"><?= strtoupper($row['siswa_nisn']); ?> </td>
</tr>
<tr>
		<td class="style110">Nomor peserta ujian nasional</td>
		<td class="style110">:</td>
		<td class="style110" width="69%"><?= strtoupper($row['siswa_nama']); ?> </td>
</tr>
<tr>
    <td colspan='3' align="center" class="style12" >
		LULUS
	</td>
</tr>
<tr>
    <td colspan='3' class="style110">
	<br>
		Dari SMA Negeri 1 Semarang setelah memenuhi kriteria sesuai dengan peraturan perundang-undangan. 
	</td>
</tr>
</table>
<br>
 <table border="0" style="width: 100%;">
  <tr>
    <td width="62%"></td>

    <td width="38%" valign="top">
	Semarang, 7 Mei 2016
	</td>
  </tr>
  <tr>
    <td></td>

    <td  valign="top">
			<p class="style6">
				Kepala Sekolah<br/>
				<br/>
				<br/><br/><br/>
				Hj. Kastri Wahyuni, S.Pd, MM.
				</p>    </td>
  </tr>
  <tr>
    <td></td>

    <td valign="top">
	NIP. 19560615 197903 2 005
	</td>
  </tr>
</table>

</div>
<?php
//echo "<pre>";
//print_r($row);
//print_r($resultset);
///echo "</pre>";
?>
<!-- ===================================================================================== -->

<!-- ====================================================================================== -->