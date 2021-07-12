
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
        margin: 145px 90px 5px 90px;
    }

.style7 {font-size: 11px; font-weight: bold; }
.style8 {font-size: 11px}
.style12 {
	font-size: 14px;
	font-weight: bold;
}
.style13 {
	font-size: 36px;
	font-weight: bold;
}
.style16 {
	font-size: 16px;
	font-weight: bold;
}
.style17 {font-size: 24px}
.style18 {font-size: 36px}
.style19 {font-size: 28px;font-weight: bold;}

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
$surat_keputusan = "362/SMAKTB/E.05/2017";
$surat_keputusan_panutan = "274/A/VI/II /2018";
$tanggal_surat_keputusan_panutan ="27 Februari 2018";
$sekolah_nama = "SMA Kristen Terang Bangsa";
$sekolah_yayasan = "";
$ket_lulus = "L U L U S";
$tanggal_pengumuman = "3 Mei 2018";

//if($row['siswa_id'] == 3901){
	//$ket_lulus = 'Tidak Lulus';
//}
3901
?>
<div id="halaman"> 
<table border="0" style="width: 100%;">
	<tr>
		<td align="center">
			<div class="style16"><u>PENGUMUMAN</u><div>
			<div class="style12">Nomor : <?=$surat_keputusan?><div>
		</td>
	</tr>
</table>	
<br>
Berdasarkan hasil rapat Dewan Guru <?=$sekolah_nama?> Semarang pada hari Kamis <?=$tanggal_pengumuman?> pukul 07.30, 
bahwa siswa tersebut di bawah ini:
<br><br><br>
<table border="0" style="width: 100%;">
	<tr>
		<td style="width: 10%;"></td>
		<td>
			<table border="0" style="width: 100%;">
			  <tr>
				<td  valign="top" width="18%">
					Nama
				</td>
				<td  valign="top">
					 : <?=$row['siswa_nama']; ?>
				</td>
			  </tr>
			  <tr>
				
				<td  valign="top">
					No. peserta
				</td>
				<td  valign="top">
					 : <?=$row['siswa_no_un']; ?>
				</td>
			  </tr>
			  <tr>
				
				<td  valign="top">
					NIS
				</td>
				<td  valign="top">
					 : <?=$row['siswa_nis']; ?>
				</td>
			  </tr>
			  <tr>
				<td  valign="top">
					Kelas
				</td>
				<td  valign="top">
					 : <?=$row['kelas_nama']; ?>
				</td>
			  </tr>
			  <tr>
				<td><br/>Dinyatakan </td>
				<td valign="top">
					 <br/>: 
				</td>
			  </tr>
			</table>
		</td>
	</tr>
</table>	
<br>

<table border="0" style="width: 100%;">
  <tr>
    <td align="center"  class="style19"> <?=$ket_lulus?></td>
  </tr>
</table>
<br><br>
Demikian surat ini kami berikan sebagai pemberitahuan, terima kasih.<br>
Tuhan Yesus memberkati.
<table border="0" style="width: 100%;" cellspacing="10">
  <tr>
    <td width='55%' align="right" >
		<!--<table border="1" cellpadding="0" cellspacing="0" height= '100%' style="width: 30%;">
			<tr height= '100%'>
				<td align="center" valign="mid" >
				<br><br>Pas Foto<br>3 X 4 
				<br><br><br><br><br>
				</td>
			</tr>
		</table>-->
	</td>
    <td>
	Semarang, <?=$tanggal_pengumuman?> <br>
	Kepala <?=$sekolah_nama?>
	<br><br><br><br><br>
	Drs. Sungkowo Prihadi	 
	</td>
  </tr>
</table>

</div>

<!-- ===================================================================================== -->

<!-- ====================================================================================== -->