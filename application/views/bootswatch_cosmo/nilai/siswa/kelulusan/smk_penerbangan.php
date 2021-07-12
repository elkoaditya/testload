
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
.style13 {
	font-size: 24px;
	font-weight: bold;
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
	
	tr.border_bottom td {
		border-bottom:1pt solid black !important;
	}
	
	.backgrounds{

        background-image: url("<?php echo base_url('images/logo/'.APP_SCOPE.'/ttdpenerbad.gif'); ?>");
		background-repeat: no-repeat;
		background-position: left;
		background-size: 10px 5px;
		padding-bottom: 35px;
		/*
		opacity: 0.4;
		position: absolute;
		z-index: -1;
		*/
    }
</style>
<?php 
$ta_thun = $row["ta_nama"];
//$surat_keputusan = "Sket/264/SMK.PKAB/V/2016";
//$surat_keputusan = "R/166/SMK.PKAB/V/2017";
//$surat_keputusan = "R/132/SMK.PKAB/V/2018";
//$surat_keputusan = "R/237/SMKPKAB/V/2019";
$surat_keputusan = "R/237/SMKPKAB/V/2020";

//$tanggal_keputusan = "4 Mei 2016";
//$tanggal_keputusan = "28 April 2017";
//$hari_keputusan = "Rabu";
//$tanggal_keputusan = "2 Mei 2018";
//$hari_keputusan = "Jumat";
//$tanggal_keputusan = "10 Mei 2019";
$hari_keputusan = "Kamis";
$tanggal_keputusan = "30 April 2020";

//$tanggal_pengumuman = "7 Mei 2016";
//$tanggal_pengumuman = "2 Mei 2017";
//$tanggal_pengumuman = "3 Mei 2018";
//$tanggal_pengumuman = "13 Mei 2019";
$tanggal_pengumuman = "2 Mei 2020";

$sekolah_nama = "SMK Penerbangan Kartika Aqasa Bhakti";
$sekolah_yayasan = "";
?>
<div id="halaman"> 
	<!-- <img src="<?php //echo base_url('images/logo/'.APP_SCOPE.'/penerbad.gif'); ?>" style="width:100%;">-->
	<img src="<?php echo base_url('images/logo/'.APP_SCOPE.'/penerbad.jpg'); ?>" style="width:100%;">
		
		<div id="content1">
			
			<table width="100%">
				<tr>

					<td colspan="3" valign="top" style="border-bottom:1pt solid black; border-top-width:4; " ></td>
				  </tr>
				<tr>

					<td colspan="3" valign="top" style="border-top:solid; border-top-width:4; "></td>
				  </tr>
			</table>
			
			<table border="0" cellspacing="0" width="35%">
				
				<tr>
					<td width="40%">Nomor </td>
					<td width="5%">:</td> 
					<td><?=$surat_keputusan?></td>
				</tr>
				<tr>
					<td>Klasifikasi </td>
					<td>:</td> 
					<td> RAHASIA</td>
				</tr>
				<tr>
					<td>Lampiran </td>
					<td>:</td>
					<td> -</td>
				</tr>
				<tr>
					<td>Perihal </td>
					<td>:</td> 
					<td>Pengumuman Kelulusan</td>
				</tr>
			</table>
			
			<table border="0" cellspacing="0" width="100%">
				<tr>
					<td colspan="2"></td>
					<td width="35%">Kepada</td>
				</tr>
				<tr>
					<td colspan="2" align="right">Yth. </td>
					<td>Orang Tua / Wali Siswa</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td><?php echo $row['siswa_nama']; ?></td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td>di</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td>Semarang</td>
				</tr>
				<?php for ($x = 0; $x <= 4; $x++) {?>
				<tr>
					<td colspan="3"> <br> </td>
				</tr>
				<?php }?>
				<tr>
					<td width="15%"></td>
					<td colspan="2">
					Dengan Hormat,<br>
					Berdasarkan  keputusan rapat pleno kelulusan siswa kelas XII tahun pelajaran <?=$ta_thun?>
					pada hari <?=$hari_keputusan?> tanggal <?=$tanggal_keputusan?> yang diikuti oleh seluruh staf sekolah dan guru pengampu, 
					dengan mempertimbangkan secara cermat dan teliti ketentuan kelulusan dan ketuntasan belajar 
					yang tercantum dalam Standar Operasional Prosedur Ujian Akhir Nasional 
					tahun pelajaran <?=$ta_thun?>, maka siswa tersebut dibawah ini :<br>
					<table border="0" cellspacing="0" width="100%">
							<!--
							<tr>
								<td width='30%'>Nomor Ujian Akhir Nasional</td>
								<td width='1%'>:</td>
								<td width='59%'><?=$row['siswa_no_un']; ?></td>
							</tr>-->
							<tr>
								<td>Nama Siswa</td>
								<td>:</td>
								<td><?=$row['siswa_nama']; ?></td>
							</tr>
							<tr>
								<td>Kelas / kompetensi keahlian</td>
								<td>:</td>
								<td><?=$row['kelas_nama']; ?></td>
							</tr>
							<tr>
								<td>dinyatakan  </td>
								<td>:</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td><h2>LULUS</h2></td>
							</tr>
						</table>
						<br>
						Demikian untuk menjadikan periksa. Atas kerja sama yang baik, kami ucapkan terima kasih.
					</td>
				</tr>
				
				<tr>
					<td colspan='3'></td>
				</tr>
				<tr>
					<td colspan='2'></td>
					<td class="backgrounds">
						Semarang, <?=$tanggal_pengumuman?><br>
						Kepala Sekolah <br><br><br><br><br>
						Mukar, S. Pd.
					</td>
				</tr>
			</table>
        </div>
</div>

<!-- ===================================================================================== -->

<!-- ====================================================================================== -->