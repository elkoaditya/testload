<?php
$data_sekolah = array(
	"nama"		=> "SMA NEGERI 8 SEMARANG",
	"npsn"		=> "20328866",
	"nss"		=> "301036316008",
	"alamat"	=> "JL RAYA TUGU",
	"kode_pos"	=> "50185",
	"telepon"	=> "(024) 8664553",
	"fax"		=> "Fax. 	&nbsp;+62247610472",
	"kelurahan"	=> "TAMBAK AJI",
	"kecamatan"	=> "NGALIYAN",
	"kota"		=> "SEMARANG",
	"provinsi"	=> "JAWA TENGAH",
	"website"	=> "http://www.sman8-smg.sch.id",
	"email"		=> "sman8smg@yahoo.com",
);
?>
<br/><br/>
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

		<h4 align="center">
			LAPORAN<br/>
			CAPAIAN KOMPETENSI PESERTA DIDIK<br/><br/>
			SEKOLAH MENENGAH ATAS<br/><br/>
			(SMA)
		</h4>
		<br/>
		

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
					NPSN/NSS
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["npsn"]; ?> / <?php echo $data_sekolah["nss"]; ?>
				</td>
			</tr>
			<tr>
				
				<td class="t-label2">
					Alamat Sekolah
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["alamat"]; ?><br/><br/>
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
					Telp. <?php echo $data_sekolah["telepon"]; ?>
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
					E-mail
				</td>
				<td class="t-sp1"> : </td>
				<td class="t-data2">
					<?php echo $data_sekolah["email"]; ?>
				</td>
			</tr>
			
		
		</table>


	</div>
	<?= '<pagebreak />'; ?>
