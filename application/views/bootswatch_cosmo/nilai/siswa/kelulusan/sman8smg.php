
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
.style12 {font-size: 13px}
.style14 {font-size: 14px}
.style15 {font-size: 14px}
.style13 {
	font-size: 24px;
	font-weight: bold;
}
.style17 {font-size: 22px}
.style18 {font-size: 22px}
.style19 {font-size: 16px; font-weight: bold; }
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
//$surat_keputusan = "421.3/283/".$tahun;
$surat_keputusan = "800/252/2020";

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
		
<table border="0" style="width: 100%;
			  text-align: justify;
			  text-justify: inter-word;">
  <tr>
    <td  valign="top"><img src="<?php echo base_url();?>/images/logo/logo-jawa-tengah3.png" width="85" /> </td>
    <td  align="center" valign="top">
	<span class="style19">
	PEMERINTAH PROVINSI JAWA TENGAH<br />
      DINAS PENDIDIKAN DAN KEBUDAYAAN</span><br />
	  
      <span class="style18"><b><?=strtoupper($sekolah_nama)?></b></span><br />
	  <span class="style12">
      Jl. Raya Tugu Semarang 50185 Telp. 024-8664553 Fax. 024- 8661798<br />
				website : http://www.sman8-smg.sch.id E-mail : sman8smg@yahoo.com</span>
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
				<td valign="top" class="style15" width="14%">Nomor</td>
				<!--<td valign="top" class="style15">: 421.3/235/20/2016</td>-->
                <td valign="top" class="style15">: <?=$surat_keputusan?></td>
				<td valign="top" class="style15" align="right"></td>
			</tr>
			<tr>
				<td valign="top" class="style15">Klasifikasi</td>
				<td valign="top" class="style15" colspan="2">: <b>RAHASIA</b></td>
			</tr>
			<tr>
				<td valign="top" class="style15">Perihal </td>
				<td valign="top" class="style15" colspan="2">: <b>Pengumuman Kelulusan</b></td>
			</tr>
			
			<tr>
				<td valign="top" class="style15"><br>Kepada  </td>
				<td valign="top" class="style15" colspan="2"></td>
			</tr>
			<tr>
				<td valign="top" class="style15">Yth </td>
				<td valign="top" class="style15" colspan="2">
				: Bpk/Ibu Orang Tua / Wali Peserta Didik Kls XII<br>
				&nbsp;&nbsp;SMA Negeri 8 Semarang <br>
				&nbsp;&nbsp;&nbsp;di –<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<u>Semarang</u>
				</td>
			</tr>
			
			<tr>
				<td valign="top" class="style15"><br>  </td>
				<td valign="top" class="style15" colspan="2">
					
					Yang bertanda tangan di bawah ini, Kepala SMA Negeri 8 Semarang Kota  Semarang., Provinsi Jawa Tengah menerangkan bahwa :
					<br><br>
					   <table border="0" cellspacing="0" width="100%" align="right">
						<tr>
							
							<td class="style15" width='34%'>Nama</td>
							<td class="style15" >: <?=$row['siswa_nama']; ?></td>
						</tr>
						<tr>
							<td class="style15">Kelas / Peminatan</td>
							<td class="style15">: <?=$row['kelas_nama']; ?> / <?=$jurusan; ?></td>
						</tr>
						<tr>
							<td class="style15">Tempat Dan Tanggal Lahir</td>
							<td class="style15">: <?php echo $row['lahir_tempat']; ?> , <?php echo tanggal($row['lahir_tgl']); ?></td>
						</tr>
						<tr>
							<td class="style15">Nama Orang Tua/Wali </td>
							<td class="style15">: <?php 
									if($row['ayah_nama']!=''){
										echo $row['ayah_nama']; 
									}else{ 
										echo $row['ibu_nama']; 
									}?></td>
						</tr>
						<tr>
							<td class="style15">Nomor Induk Siswa </td>
							<td class="style15">: <?=$row['siswa_nis']; ?></td>
						</tr>
						<tr>
							<td class="style15">Nomor Induk Siswa Nasional</td>
							<td class="style15">: <?=$row['siswa_nisn']; ?></td>
						</tr>
						
					</table>
					
					<br>
					Setelah dilaksanakan rapat  dewan guru SMA Negeri 8 Semarang pada hari Kamis, 30 April 2020 dinyatakan
					<table border="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" class="style17"><b>LULUS</b></td>
						</tr>
					</table>
					<br>
					dari satuan pendidikan berdasarkan kriteria kelulusan SMA Negeri 8 Semarang Kota Semarang Tahun Pelajaran <?=$row['ta_nama']?>.
					<br><br>
					Demikian Pengumuman ini  disampaikan, Atas perhatian dan kerja sama Saudara, kami ucapkan terima kasih.
			
						
				</td>
			</tr>
		</table>
	</td>
  </tr>

</table>
<br><br><br>

<table border="0" style="width: 100%;">
  <tr>
    <td width="62%"></td>

    <td width="38%"  valign="top">
	Semarang, 2 Mei 2020
 
	</td>
  </tr>
  <tr>
    <td></td>

    <td valign="top">
			<p class="style6">
				<b>Kepala Sekolah</b><br/>
				<br/>
				<br/><br/><br/>
				<b>Sugiyo, S.Pd, M.Kom.</b>
				</p>    </td>
  </tr>
  <tr>
    <td></td>

    <td valign="top">
	<b>NIP : 19640131 199003 1 003</b>

	</td>
  </tr>
</table><br>



</div>

<!-- ===================================================================================== -->

<!-- ====================================================================================== -->