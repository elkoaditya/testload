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
					<td width="400px" style="padding-left: 100px; text-align: center; vertical-align: middle;">

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
							Semarang, 14 Juli 2014
						</p>
						<br/>
						<p>
							Kepala Sekolah,
						</p>

						<br/><br/><br/>

						<p>
							<b><u>Hj. Kastri Wahyuni, S.Pd, MM.</u></b>
							<br/>
							NIP. 19560615 197903 2 005
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
				padding: 18px 18px 20px 18px;
				font-size: 22px;
			}

			#cover-title{
				font-size: 28px;
				font-weight: bold;
				font-family: "Times New Roman";
				line-height: 50px;
			}

			#w-nama{
				margin: 12px 50px 28px 50px;
			}

			#w-nisn{
				margin: 12px 140px 28px 140px;
			}

		</style>

		<br/><br/>

		<p style="text-align: center;">
			<?php

			$logotutwuri = array(
				"src" => "content/images/logotutwurihandayanicolor21.png",
				"width" => "20%",
				"height" => "20%",
			);

			echo img($logotutwuri);

			?>
		</p>

		<div id="cover-title" class="center">
			LAPORAN<BR/>
			CAPAIAN KOMPETENSI PESERTA DIDIK<BR/>
			SEKOLAH MENENGAH ATAS<BR/>
			(SMA)
		</div>

		<br/><br/>

		<div class="center" style="font-size: 20px;">
			Nama Peserta Didik
		</div>

		<div id="w-nama" class="center cover-label bold">
			<?php echo strtoupper($row["nama"]); ?>
		</div>

		<div id="w-nisn" class="center cover-label">
			NISN : <?php echo ($row["nisn"]); ?>
		</div>

		<br/><br/><br/><br/><br/><br/>

		<div style="text-align: center; font-size: 18px;">
			KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN<BR/><br/>
			REPUBLIK INDONESIA
		</div>

	</div>

	<pagebreak />

	<div id="bg_profil" class="content">
		<style>

			.t-no{
				width: 30px;
				text-align: right;
				vertical-align: top;
			}
			.t-label{
				width: 230px;
				text-align: left;
				vertical-align: top;
				margin: 2px 2px 2px 5px;
			}
			.t-sp{
				width: 20px;
				text-align: left;
				vertical-align: top;
			}
			.t-data{
				text-align: left;
				vertical-align: top;
			}

			#foto-plament{
				display: block;
				width: 90px;
				height: 120px;
				text-align: center;
				vertical-align: middle;
				border: #7b7b7b dashed 1px;
			}

		</style>

		<h3 align="center">
			KETERANGAN TENTANG DIRI PESERTA DIDIK
		</h3>

		<br/><br/>

		<?php $no = 0; ?>

		<table border="0" cellpadding="0" cellspacing="0" id="profil-siswa">
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Nama Peserta Didik (Lengkap)
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
					Tempat dan Tanggal Lahir
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
					Alamat Peserta Didik
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["alamat"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Nomor Telepon
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
				<td class="t-sp"> &nbsp; </td>
				<td class="t-data">
					&nbsp;
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
					14 Juli 2014
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Nama Orangtua
				</td>
				<td class="t-sp">  &nbsp;  </td>
				<td class="t-data">
					&nbsp;
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
					Nomor Telepon
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
				<td class="t-sp">  &nbsp;  </td>
				<td class="t-data">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"> &nbsp; </td>
				<td class="t-label">
					a. Ayah
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["ayah_pekerjaan"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"> &nbsp; </td>
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
					Nama Wali Peserta Didik
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["wali_nama"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Alamat Wali Peserta Didik
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["wali_alamat"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"> &nbsp; </td>
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
					Pekerjaan Wali Peserta Didik
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