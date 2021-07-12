<?php

$tgl_masuk;
	$kepala_sekolah='-';
	$nip='';
	if (APP_DOMAIN == 'localhost'):
		$title ='SEKOLAH MENENGAH ATAS ';

	elseif (APP_SUBDOMAIN == 'sma-setiabudhi.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS SETIABUDHI';
		$kepala_sekolah	= 'Drs. Gimin';
		$nip			= '-';
	elseif (APP_SUBDOMAIN == 'sman8-smg.fresto.co'):
		$title 			= 'SEKOLAH MENENGAH ATAS NEGERI 8';
		$kepala_sekolah	= 'Poniman Slamet S.Pd, M.Kom';
		$nip			= '19740604 199903 1007';
	elseif (APP_SUBDOMAIN == 'sman9-smg.fresto.co'):
		$title 			= 'SEKOLAH MENENGAH ATAS NEGERI 9';
		$kepala_sekolah	= 'Dr. Siswanto M. Pd. ';
		$nip			= '19660608 199512 1 001';
	elseif (APP_SUBDOMAIN == 'sman14-smg.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS NEGERI 14';
		
	elseif (APP_SUBDOMAIN == 'smaterbang.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS TERANG BANGSA';
		$kepala_sekolah	= 'Drs. Sungkowo Prihadi';
		$nip			= '-';
	elseif (APP_SUBDOMAIN == 'smamichael.smg.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS SANTO MICHAEL';
		$kepala_sekolah	= 'L. Ruddy Sulistiawan, S. Pd';
		$nip			= '-';
	elseif (APP_SUBDOMAIN == 'smk-penerbangan.smg.fresto.co'):
		$title ='SEKOLAH MENENGAH KEJURUAN KARTIKA AQASA BHAKTI';
		$kepala_sekolah	= 'Mukar S.Pd ';
		$nip			= '-';
	elseif (APP_SUBDOMAIN == 'smknusaputera1.fresto.co'):
		$title ='SEKOLAH MENENGAH KEJURUAN NUSA PUTERA 1';	
		$kepala_sekolah	= 'Drs. Ariawan Sudagijono, M.Kom';
		$nip			= '-';
	elseif (APP_SUBDOMAIN == 'demo.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS ANDALUS';
		
	endif;

?>
<html>
	<head>
		<style>
			@page
			{
				size: 210mm 297mm;
				margin: 3mm 10mm 0mm 10mm;
				margin-header: 10mm;
				margin-footer: 15mm;
			}

			.bold{
				font-weight: bold;
			}

			.center{
				text-align: center;
			}

			.foot-text
			{
				font-size: 10px;
				font-style: italic;
			}

		</style>
	</head>

	<body>

	<htmlpagefooter name="footer_ttd">
		<div id="footer_ttd" class="footer">

			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="400px" style="padding-left: 50px; text-align: center; vertical-align: middle;">

						<table border="0" cellspacing="0">
							<tr>
								<td id="foto-plament">
									Pas Foto
									<br/>
									3x4
								</td>
							</tr>
						</table>

					</td>
					<td>

						<p>
							Semarang, <?= tanggal($row['masuk_tgl']); ?>
						</p>
						<br/>
						<p>
							Kepala Sekolah,
						</p>

						<br/><br/><br/>

						<p>
							<b><u><?=$kepala_sekolah;?></u></b>
							<br/>
							NIP. <?=$nip;?>
						</p>
					</td>
				</tr>
			</table>

		</div>
	</htmlpagefooter>

	<div id="bg_cover">

		<style>

			.cover-label{
				border: #000 thin solid;
				padding: 10px 18px 10px 18px;
				font-size: 22px;
			}

			#cover-title{
				font-size: 24px;
				font-weight: bold;
				font-family: "Times New Roman";
				line-height: 40px;
			}

			#w-nama{
				margin: 12px 50px 28px 50px;
			}

			#w-nisn{
				margin: 12px 140px 28px 140px;
			}

		</style>

		<br/>
		<br/>
		<br/>

		<div id="cover-title" class="center">
			RAPOR SISWA
			<BR/>
			<?=$title;?>
			<br/>
			SEMARANG
		</div>

		<br/>
		<br/>
		<br/>
		<br/>
		<br/>

		<p style="text-align: center;">
			<?php

			$logotutwuri = array(
				"src"	 => "content/images/logotutwurihandayanicolor21.png",
				"width"	 => "20%",
				"height" => "20%",
			);

			echo img($logotutwuri);

			?>
		</p>

		<br/>
		<br/>
		<br/>
		<br/>

		<div class="center" style="font-size: 14px;">
			Nama Siswa:
		</div>

		<div id="w-nama" class="center cover-label bold">
			<?php echo strtoupper($row["nama"]); ?>
		</div>

		<br/>
		<br/>
		<div class="center" style="font-size: 14px;">
			NISN:
		</div>

		<div id="w-nama" class="center cover-label">
			<?php echo ($row["nisn"]); ?>
		</div>

		<br/><br/><br/><br/><br/><br/>

		<div style="text-align: center; font-size: 14px; font-weight: bold;">
			KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN
			<BR/><br/>
			REPUBLIK INDONESIA
		</div>

	</div>

	<?= '<pagebreak />'; ?>

	<div id="bg_profil" class="content">
		<style>
			#profil-siswa {
				margin-left: 70px;
			}
			.t-no{
				width: 36px;
				text-align: right;
				vertical-align: top;
				padding: 4px 5px 4px 5px;
			}
			.t-label{
				width: 230px;
				text-align: left;
				vertical-align: top;
				margin: 2px 2px 2px 5px;
				padding: 4px 5px 4px 5px;
			}
			.t-sp{
				width: 20px;
				text-align: left;
				vertical-align: top;
				padding: 4px 5px 4px 5px;
			}
			.t-data{
				text-align: left;
				vertical-align: top;
				padding: 4px 5px 4px 5px;
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
			KETERANGAN TENTANG DIRI SISWA
		</h3>

		<br/><br/>

		<?php $no = 0; ?>

		<table border="0" cellpadding="0" cellspacing="0" id="profil-siswa">
			<colgroup>
			</colgroup>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Nama Siswa (Lengkap)
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<b>	<?php echo strtoupper($row["nama"]); ?></b>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					NIS / NISN
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["nis"] . " / " . $row["nisn"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Tempat Tanggal Lahir
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo ucwords($row["lahir_tempat"]) . ", " . tanggal($row["lahir_tgl"]); ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Jenis Kelamin
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php

					if ($row["gender"] == "l")
					{
						echo "Laki-laki";
					}
					else if ($row["gender"] == "p")
					{
						echo "Perempuan";
					}
					else
					{
						echo "&nbsp;";
					}

					?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Agama
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo ucwords($row["agama_nama"]); ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Status dalam keluarga
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo ucwords($row["status_keluarga"]); ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Anak ke
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["anak_ke"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Alamat Siswa
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["alamat"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Nomor Telepon Rumah
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["telepon"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Sekolah Asal
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["asal_sekolah_nama"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Diterima di Sekolah ini
				</td>
				<td class="t-sp">&nbsp;  </td>
				<td class="t-data">&nbsp;
					
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;</td>
				<td class="t-label">
					Di kelas
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["masuk_kelas_nama"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;</td>
				<td class="t-label">
					Pada Tanggal
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?= tanggal($row['masuk_tgl']); ?>
					<!--
					PSB 2014: 14 Juli 2014
					-->
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Nama Orangtua
				</td>
				<td class="t-sp">&nbsp;    </td>
				<td class="t-data">&nbsp;
					
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;</td>
				<td class="t-label">
					a. Ayah
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["ayah_nama"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;</td>
				<td class="t-label">
					b. Ibu
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["ibu_nama"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Alamat Orangtua
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["ortu_alamat"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;</td>
				<td class="t-label">
					Nomor Telepon Rumah
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["ortu_telepon"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Pekerjaan Orang Tua
				</td>
				<td class="t-sp">&nbsp;    </td>
				<td class="t-data">&nbsp;
					
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;  </td>
				<td class="t-label">
					a. Ayah
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["ayah_pekerjaan"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;  </td>
				<td class="t-label">
					b. Ibu
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["ibu_pekerjaan"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Nama Wali Siswa
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["wali_nama"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Alamat Wali Siswa
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["wali_alamat"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;  </td>
				<td class="t-label">
					Nomor Telepon Rumah
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["wali_telepon"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Pekerjaan Wali Siswa
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["wali_pekerjaan"]; ?>
				</td>
			</tr>
		</table>

		<sethtmlpagefooter name="footer_ttd" value="on" show-this-page="1" />

	</div>


</body>
</html>