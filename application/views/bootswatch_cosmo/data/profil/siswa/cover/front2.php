<?php
$data_sekolah = array(
	"nama"		=> "SEKOLAH MENENGAH KEJURUAN PENERBANGAN KARTIKA AQASA BHAKTI",
	"npsn"		=> "20328943",
	"nis"		=> "400180/562036314001",
	"alamat"	=> "Jalan Jembawan Raya No.20 A",
	"kode_pos"	=> "50145",
	"telepon"	=> "(024) 7617708",
	"kelurahan"	=> "Kalibanteng Kulon",
	"kecamatan"	=> "Semarang Barat",
	"kota"		=> "Semarang",
	"provinsi"	=> "Jawa Tengah",
	"website"	=> "http://smkpenerbangansmg.sch.id/",
	"email"		=> "smk_penerbangan_smg@yahoo.co.id",
);
?>

<div id="bg_profil" class="content page_bg0" style="height:100%">
		<style>
			#profil-siswa {
				margin-left: 70px;
				margin-right: 70px;
			}
			.t-no{
				width: 36px;
				text-align: right;
				vertical-align: top;
				padding: 4px 5px 4px 5px;
			}
			.t-label2{
				width: 160px;
				text-align: left;
				vertical-align: top;
				margin: 2px 2px 2px 5px;
				padding: 10px 5px 10px 5px;
			}
			.t-sp1{
				width: 20px;
				text-align: left;
				vertical-align: top;
				padding: 10px 0px 0px 0px;
			}
			.t-data2{
				text-align: left;
				vertical-align: top;
				padding: 10px 5px 10px 5px;
			}

			#foto-plament{
				display: block;
				width: 90px;
				height: 120px;
				text-align: center;
				vertical-align: middle;
				border: #7b7b7b thin;
			}

		</style>
		<br/>

		<h3 align="center">
			RAPOR SISWA<br/>
			SEKOLAH MENENGAH KEJURUAN<br/>
			(SMK)
		</h3>

		

		<table border="0" cellpadding="0" cellspacing="0" id="profil-siswa" >
			<colgroup>
			</colgroup>
			<tr>
				
				<td class="t-label2">
					Nama Sekolah
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["nama"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					NPSN
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["npsn"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					NIS/NSS
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["nis"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					Alamat Sekolah
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["alamat"]; ?>
				</td>
			</tr>
			<!--<tr>
				<td class="t-label2"></td>
				<td class="t-sp1"> </td>
				<td class="t-data2"></td>
			</tr>-->
			<tr>
				
				<td class="t-label2">
				</td>
				<td class="t-sp1">  </td>
				<td class="t-data2">
					Kode Pos <?php echo $data_sekolah["kode_pos"]; ?> &nbsp;&nbsp;&nbsp;
					Telp <?php echo $data_sekolah["telepon"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					Kelurahan
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["kelurahan"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					Kecamatan
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["kecamatan"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					Kota/Kabupaten
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["kota"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					Provinsi
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["provinsi"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					Website
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["website"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					Email
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["email"]; ?>
				</td>
			</tr>
			
		
		</table>


	</div>
	<?= '<pagebreak />'; ?>
