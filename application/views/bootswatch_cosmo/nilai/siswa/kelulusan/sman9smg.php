
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
.style13 {
	font-size: 24px;
	font-weight: bold;
}
.style17 {font-size: 22px}
.style18 {font-size: 34px}
.style19 {font-size: 28px}

.style110 { padding:3px 3px 3px 3px; }
.style110 { padding-bottom:10px;}

#content1{
		line-height: 190%;
    text-align: justify;
    text-justify: inter-word;
	margin-left:50px;
	margin-right:100px}
#content1 h3{
line-height: 260%;
}
#content1 table{
	margin-left:70px;}
</style>
<?php 
$ta_thun = $row["ta_nama"];
$sekolah_nama = "SMA Negeri 9 Semarang";
$sekolah_yayasan = "";
$ket_lulus = "LULUS UJIAN";
/*if($row['siswa_id'] == 3905){
	$ket_lulus = 'harap menghubungi kepala sekolah';
}*/
?>
<div > 
		
<table border="0" style="width: 100%;">
<tr>
    <td align="center" valign="top"><img src="<?=APP_ROOT?>/images/logo/logo-jawa-tengah3.png" width="140" /> </td>
	<td width="850" align="center" valign="top"><span class="style13"><span class="style19">PEMERINTAH PROVINSI JAWA TENGAH<br />
      DINAS PENDIDIKAN DAN KEBUDAYAAN</span><br />
      <span class="style18"><?=strtoupper($sekolah_nama)?></span><br />
      <span class="style17">Jl. Cemara Raya Padangsari Banyumanik Semarang Telp.(024) 7472812 </span></td>
  </tr>
  <tr>

    <td colspan="3" valign="top" style="border-top:solid; border-top-width:8; padding-top:-8"><strong><hr></strong></td>
  </tr>

</table>
<br>
<div id="content1">
                Berdasarkan Nilai Ujian Sekolah dan Ujian Nasional Tahun Pelajaran <?= $ta_thun; ?> <br>
				Kepala <?=$sekolah_nama?>
			<br><br>				
               <table border="0" cellspacing="3" cellpadding="0" width="100%" align="right">
				<tr>
					
					<td colspan="3" align="center"><br><h3> M E M U T U S K A N </h3><br><br></td>
				</tr>
				<tr>
					<td class="style110" width="27%">Nama</td>
					<td class="style110" width="2px">:</td>
					<td class="style110"><?php echo $row["siswa_nama"]; ?></td>
				</tr>
				<tr>
					<td class="style110">Nomor Ujian</td>
					<td class="style110">:</td>
					<td class="style110"><?php echo $row['siswa_no_un']; ?></td>
				</tr>
				<tr>
					<td class="style110">Kelas/Program</td>
					<td class="style110">:</td>
					<td class="style110"><?php echo $row['kelas_nama']; ?></td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<br/><br/><h2><b><?=$ket_lulus?></b></h2><!-- pada tahun pelajaran <?= $ta_thun; ?>-->
					</td>
				</tr>
			</table>
	</div>
 <!--   
    <br/>
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
				Drs. Wiharto, M.Si
				</p>    </td>
  </tr>
  <tr>
    <td></td>

    <td valign="top">
	NIP : 19631003 198803 1 009
	</td>
  </tr>
</table>-->

</div>
<?php
//echo "<pre>";
//print_r($row);
//print_r($resultset);
///echo "</pre>";
?>
<!-- ===================================================================================== -->

<!-- ====================================================================================== -->