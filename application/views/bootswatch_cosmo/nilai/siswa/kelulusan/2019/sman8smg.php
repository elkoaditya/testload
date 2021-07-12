
<style type="text/css">
<!--
.style3 {font-size: 11px}
-->
/*
#halaman {
height:1500px;
}*/
@page {
	 	/* POLIO*/
        sheet-size: 210mm 297mm ;
        margin: 30px 60 5px 60px;
    }

.style7 {font-size: 11px; font-weight: bold; }
.style8 {font-size: 11px}
.style11 {font-size: 12px}
.style12 {font-size: 12px}
.style14 {font-size: 14px}
.style15 {font-size: 14px}
.style13 {
	font-size: 24px;
	font-weight: bold;
}
.style17 {font-size: 22px}
.style18 {font-size: 24px}
.style19 {font-size: 16px}
.style20 {font-size: 20px}

#content1 p{
		line-height: 190%;
    text-align: justify;
    text-justify: inter-word;
	}
</style>
<?php 

$tahun = 2019;
$tahun_lalu = $tahun - 1;
//$ta_thun = $resultset['data'][0]['ta'] . '/' . ($resultset['data'][0]['ta'] + 1);
//$surat_keputusan = "421.3/235/2016";
//$surat_keputusan = "421.3/248/2017";
$surat_keputusan = "421.3/283/".$tahun;
$sekolah_nama = "SMA Negeri 8 Semarang";
$sekolah_yayasan = "";
$ta_thun = $row["ta_nama"];
//$tanggal_pengumuman = "2 Mei 2017";
//$hari_pengumuman	= "Selasa";

$tanggal_keputusan = "10 Mei ".$tahun;
$hari_keputusan	= "Jumat";
$jam_keputusan	= "13:30";

$tanggal_pengumuman = "13 Mei ".$tahun;
$hari_pengumuman	= "Senin";

//echo "<pre>";
//print_r($row);
//echo "</pre>";
//nomer_ujian
$explode_kelas = explode(' ',$row['kelas_nama']);
if(strtoupper($explode_kelas[1]) == 'MIPA'){
	$jurusan = "Matematika dan Ilmu Pengetahuan Alam";
}else{
	$jurusan = "Ilmu Pengetahuan Sosial";
	
}
;
?>
<div > 
		
<table border="0" style="width: 100%;">
  <tr>
    <td  valign="top"><img src="<?php echo base_url();?>/images/logo/logo-jawa-tengah3.png" width="85" /> </td>
    <td  align="center" valign="top">
	<span class="style19">
	PEMERINTAH PROVINSI JAWA TENGAH<br />
      DINAS PENDIDIKAN DAN KEBUDAYAAN</span><br />
	  
      <span class="style18"><b><?=strtoupper($sekolah_nama)?></b></span><br />
	  <span class="style12">
      Jl. Raya Tugu Semarang Telp.024 8664553 Fax. 024 8661798<br />
				website: http://www.sman8-smg.sch.id- Email : sman8smg@yahoo.com</span>
				</span>
				</td>
    <td  valign="top"><img src="<?php echo base_url();?>/images/logo/<?=APP_SCOPE?>/sma8.jpg" width="85" /></td>
  </tr>
  <tr>

    <td colspan="3" valign="top" style="border-top:solid; border-top-width:4; padding-top:-8"><strong><hr></strong></td>
  </tr>
    <tr>
	<td colspan="3" valign="top">
		<table border="0" style="width: 100%;" >
			<tr>
				<td valign="top" class="style15">No</td>
				<!--<td valign="top" class="style15">: 421.3/235/20/2016</td>-->
                <td valign="top" class="style15">: <?=$surat_keputusan?></td>
				<td valign="top" class="style15" align="right"><?=$tanggal_pengumuman ?></td>
			</tr>
			<tr>
				<td valign="top" class="style15">Lamp</td>
				<td valign="top" class="style15" colspan="2">: -</td>
			</tr>
			<tr>
				<td valign="top" class="style15">Hal</td>
				<td valign="top" class="style15" colspan="2">: Pengumuman Hasil Kelulusan dari Satuan Pendidikan</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>

    <td colspan="3" valign="top"></td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top">
		<div align="center" class="style20" style="text-transform:uppercase;">
		<br>
			<b>PENGUMUMAN</b> <br />
			HASIL KELULUSAN <br />
			<?=$sekolah_nama?> <br />
			TAHUN PELAJARAN <?=$ta_thun; ?>
		</div> 
      </td>
  </tr>

</table>
<br>
<div id="content1">
                Berdasarkan hasil rapat Dewan Guru SMA Negeri 8 Semarang yang telah dilaksanakan pada hari <?=$hari_keputusan ?> tanggal <?=$tanggal_keputusan ?> pukul <?=$jam_keputusan?> WIB maka diputuskan :
			<br><br>
               <table border="0" cellspacing="0" width="100%" align="right">
				<tr>
					<td rowspan="6" width=10%></td>
					<td width=30%>Nama Lengkap</td>
					<td width=60%>: <?=$row['siswa_nama']; ?></td>
				</tr>
				<tr>
					<td>Kelas</td>
					<td>: <?=$row['kelas_nama']; ?></td>
				</tr>
				<tr>
					<td>Peminatan</td>
					<td>: <?=$jurusan; ?></td>
				</tr>
				<tr>
					<td>Nomor Induk	</td>
					<td>: <?=$row['siswa_nis']; ?></td>
				</tr>
				<tr>
					<td>NISN</td>
					<td>: <?=$row['siswa_nisn']; ?></td>
				</tr>
				<tr>
					<td>Nomor Peserta UN</td>
					<td>: <?=$row['siswa_no_un']; ?></td>
				</tr>
			</table><br><br>
			<table border="0" cellspacing="0" width="100%">
				<tr>
					<td align="right" class="style17"><b>Dinyatakan</b></td>
					<td align="center" class="style17"><b>:  LULUS DARI SATUAN PENDIDIKAN</b></td>
				</tr>
			</table>
			<br>
			setelah memenuhi seluruh kriteria kelulusan sesuai dengan peraturan perundang-undangan.
	</div>
	<table border="0" style="width: 100%;">
  <tr>
    <td width="62%"></td>

    <td width="38%"  valign="top">
	<!-----Semarang, 21 Desember 2013
  ---->
	</td>
  </tr>
  <tr>
    <td></td>

    <td valign="top">
			<p class="style6">
				Kepala Sekolah<br/>
				<br/>
				<br/><br/><br/>
				Sugiyo, S.Pd, M.Kom.
				</p>    </td>
  </tr>
  <tr>
    <td></td>

    <td valign="top">
	NIP : 19640131 199003 1 003

	</td>
  </tr>
</table><br>
Catatan :<br>
Hal-hal yang berkaitan dengan ijazah dan <!--SKHUN-->Sertifikat Hasil Ujian Nasional akan diinformasikan kemudian melalui pengumuman di sekolah.


</div>

<!-- ===================================================================================== -->

<!-- ====================================================================================== -->