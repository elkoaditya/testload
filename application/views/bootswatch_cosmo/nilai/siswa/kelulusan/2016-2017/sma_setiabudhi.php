
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
	font-size: 36px;
	font-weight: bold;
}
.style12 {
	font-size: 28px;
}
.style17 {font-size: 24px}
.style18 {font-size: 36px}
.style19 {font-size: 28px}

#content1 p{
		text-indent: 70px;
		line-height: 190%;
    text-align: justify;
    text-justify: inter-word;
	margin:50px;}
	
	.backgrounds{

        background-image: url("<?php echo base_url('images/logo/logo_setiabudhi3.png'); ?>");
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: left;
		/*
		opacity: 0.4;
		position: absolute;
		z-index: -1;
		*/
    }
</style>
<?php 
$ta_thun = $row["ta_nama"];
//$surat_keputusan = "223/A/VI/IV/2016";
//$surat_keputusan_panutan = "163/A/VI/II/2016";
$surat_keputusan = "274/A/VI/IV/2017";
$surat_keputusan_panutan = "216/A/VI/II/2017"; 
$tanggal_surat_keputusan_panutan ="20 Februari 2017";
$sekolah_nama = "SMA Setiabudhi";
$sekolah_yayasan = "";
$ket_lulus = "LULUS";
$tanggal_pengumuman = "2 Mei 2017";

//if($row['siswa_id'] == 3901){
	//$ket_lulus = 'Tidak Lulus';
//}
3901
?>
<div id="halaman"> 
<table border="0" style="width: 100%;">
  <tr>
    <td width="95" valign="top"><img src="<?php echo base_url();?>/images/logo/<?=APP_SCOPE?>/logo_setiabudhi.png" width="140" /> </td>
    <td width="942" align="center" valign="top">
		<span class="style12">
			YAYASAN PENDIDIKAN SETIABUDHI
		</span>
		<br />
		<span class="style13">
			S M A   SETIABUDHI SEMARANG
		</span>
		<br />
		<span class="style12">
			TERAKREDITASI  A
			<br />
			<i>Jl. WR Supratman No. 37 <img src="<?php echo base_url();?>/images/logo/telp.gif"/> 7605783 <img src="<?php echo base_url();?>/images/logo/mail.gif"/> 50149 </i>
		</span>
	</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" style="border-top:solid; border-top-width:8; padding-top:-8"><strong><hr></strong></td>
  </tr>
</table>
<br>
<table border="0" style="width: 100%;">
  <tr>
    <td width="10%" valign="top">Nomor</td>
    <td width="1%" valign="top">:</td>
    <td  valign="top"><?=$surat_keputusan?></td>
  </tr>
  <tr>
    <td width="10%" valign="top">Lamp.</td>
    <td width="1%" valign="top">:</td>
    <td  valign="top">-</td>
  </tr>
  <tr>
    <td width="10%" valign="top">Hal</td>
    <td width="1%" valign="top">:</td>
    <td  valign="top">Pengumuman Hasil Ujian Nasional & <br>
	  Ujian Sekolah Tahun 2017
	</td>
  </tr>
</table>
<br><br>
<table border="0" style="width: 100%;">
  <tr>
    <td colspan="2" valign="top">Kepada</td>
  </tr>
  <tr>
    <td width="10%" valign="top">Yth.</td>
    <td  valign="top">
		Bp/Ibu Orang Tua Siswa <br>
		Kelas XII IPA/IPS  <br>
		SMA Setiabudhi Semarang
	</td>
  </tr>
</table>
<br>
Assalamu’alaikum Wr. Wb.
<br>
Dengan hormat kami beritahukan kepada Orang Tua Siswa bahwa berdasarkan :
<br>
<table border="0" style="width: 100%;">
  <tr>
    <td width="10%"  valign="top" align="center">1.</td>
    <td  valign="top">
		Surat Keputusan Kepala SMA Setiabudhi Semarang Nomor : <?=$surat_keputusan_panutan?> 
		tanggal <?=$tanggal_surat_keputusan_panutan?> Tentang Penetapan Kelulusan  
		SMA Setiabudhi Semarang Tahun Pelajaran <?=$row["ta_nama"]; ?>.
	</td>
  </tr>
  <tr>
    <td width="10%"  valign="top" align="center">2.</td>
    <td  valign="top">
		Kriteria Kelulusan Dan Hasil Ujian Nasional maupun Ujian Sekolah serta
		Ujian Sekolah Bertaraf Nasional SMA Setiabudhi tahun pelajaran <?=$row["ta_nama"]; ?>.
	</td>
  </tr>
  <tr>
    <td width="10%"  valign="top" align="center">3.</td>
    <td  valign="top">
		Rapat pleno Dewan Guru SMA Setiabudhi Semarang tanggal  <?=$tanggal_pengumuman?>.
	</td>
  </tr>
</table>
<br>
Maka peserta UN/US/USBN SMA Setiabudhi Semarang Tahun Pelajaran <?=$row["ta_nama"]; ?> dengan :
<br>
<table border="0" style="width: 100%;">
  <tr>
    <td width="15%" rowspan="3"></td>
    <td  valign="top" width="15%">
		No. peserta
	</td>
    <td  valign="top">
		 : <?=$row['siswa_no_un']; ?>
	</td>
  </tr>
  <tr>
    <td  valign="top" width="15%">
		Nama
	</td>
    <td  valign="top">
		 : <?=$row['siswa_nama']; ?>
	</td>
  </tr>
  <tr>
    <td  valign="top" width="15%">
		Kelas
	</td>
    <td  valign="top">
		 : <?=$row['kelas_nama']; ?>
	</td>
  </tr>
</table>
<br>
<b>Dinyatakan :</b>
<table border="0" style="width: 100%;">
  <tr>
    <td align="center"  class="style12"> <?=$ket_lulus?></td>
  </tr>
</table>
<br><br>
Syukur Alhamdulillah <br>
Kami keluarga besar SMA Setiabudhi Semarang mengucapkan selamat, kepada yang telah berhasil, dan 
kepada yang belum berhasil jangan berkecil hati, karena tidak lulus adalah keberhasilan yang tertunda.
<br>
Wa’alaikumsalam  Wr. Wb.
<br>
<table border="0" style="width: 100%;">
  <tr>
    <td width='65%'></td>
    <td>
	Semarang, <?=$tanggal_pengumuman?> <br>
	Kepala Sekolah
	<br><br><br><br>
	Drs. Gimin	 
	</td>
  </tr>
</table>

</div>

<!-- ===================================================================================== -->

<!-- ====================================================================================== -->