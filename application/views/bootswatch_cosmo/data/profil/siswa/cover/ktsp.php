<?php $this->load->view(THEME . "/data/profil/siswa/cover/info", $this->d); 
$info = info();
?>
<html>
	<head>
		<style>
			@page
			{
				/*size: 210mm 297mm;
				margin: 3mm 10mm 0mm 10mm;
				margin-header: 10mm;
				margin-footer: 15mm;*/
				size: 230mm 297mm;
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

	<!--<htmlpagefooter name="footer_ttd">
		<div id="footer_ttd" class="footer">

			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="400px" style="padding-left: 50px; text-align: center; vertical-align: middle;">

						<table border="1" cellspacing="0">
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
							Semarang, <?php //echo tanggal($row['masuk_tgl']); ?>
                            <?php echo $row['masuk_tgl']; ?>
						</p>
						<br/>
						<p>
							Kepala Sekolah,
						</p>

						<br/><br/><br/>

						<p>
							<b><u>Br. Agustinus Sudarmadi, M.Pd.</u></b>
							<br/>
							NIP. -
						</p>
					</td>
				</tr>
			</table>

		</div>
	</htmlpagefooter>-->

<!--	<div id="bg_cover">

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
			YAYASAN PANGUDI LUHUR <br>SEKOLAH MENENGAH ATAS DON BOSKO
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
-->
	<div style="padding-top: -40px";>
	<?php $this->load->view(THEME . "/data/profil/siswa/cover/front",$info); ?>
	</div>
	
	<div id="bg_profil" class="content">
		<style>
			#profil-siswa {
				/*margin-left: 70px;*/
			}
			.t-no{
				font-size: 13px;
				width: 30px;
				text-align: right;
				vertical-align: top;
				padding: 4px 5px 4px 5px;
			}
			.t-label{
				font-size: 13px;
				width: 200px;
				text-align: left;
				vertical-align: top;
				margin: 2px 2px 2px 5px;
				padding: 4px 5px 4px 5px;
			}
			.t-sp{
				font-size: 13px;
				width: 20px;
				text-align: left;
				vertical-align: top;
				padding: 4px 5px 4px 5px;
			}
			.t-data{
				font-size: 13px;
				text-align: left;
				vertical-align: top;
				padding: 4px 5px 4px 5px;
			}

			#foto-plament{
				display: block;
				width: 120px;
				height: 160px;
				text-align: center;
				vertical-align: middle;
				border: #7b7b7b thin;
			}

		</style>


		<?php $no = 0; ?>

		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="profil-siswa">
			<colgroup>
			</colgroup>
			<tr>
            	<td colspan="4" align="center">
                    <h3>
                        IDENTITAS PESERTA DIDIK
                    </h3>
                    <br><br>
		        </td>
                <td rowspan="11" width="150px" style="text-align: center; vertical-align: top;">

						<table border="1" cellspacing="0">
							<tr>
								<td id="foto-plament">
									Pas Foto
									<br/>
									3x4 cm
                                    <br/>
                                    waktu diterima di sekolah ini dan tiga sidik jari kiri
								</td>
							</tr>
						</table>

					</td>
            </tr>
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
					Nomor Induk
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["nis"] ; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Tempat dan Tgl. Lahir
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
					Alamat Peserta didik
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["alamat"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"></td>
				<td class="t-label">
					Telepon
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["telepon"]; ?>
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
					a. Di kelas
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["masuk_kelas_nama"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;</td>
				<td class="t-label">
					b. Pada Tanggal
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo tanggal($row['masuk_tgl']); ?>
					<!--
					PSB 2014: 14 Juli 2014
					-->
				</td>
			</tr>
            <tr>
				<td class="t-no" align="right">&nbsp;</td>
				<td class="t-label">
					c. Semester
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row['masuk_semester_nama']." ".$row['masuk_ta_nama']; ?>
					<!--
					PSB 2014: 14 Juli 2014
					-->
				</td>
			</tr>
            
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Sekolah Asal
				</td>
				<td class="t-sp"></td>
				<td class="t-data">
					
				</td>
			</tr>
            <tr>
				<td class="t-no" align="right"></td>
				<td class="t-label">
					a. Nama Sekolah
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["asal_sekolah_nama"]; ?>
				</td>
			</tr>
            <tr>
				<td class="t-no" align="right"></td>
				<td class="t-label">
					b. Alamat
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["asal_sekolah_alamat"]; ?>
				</td>
			</tr>
            
            <tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Ijazah SMP / Mts
				</td>
				<td class="t-sp"></td>
				<td class="t-data">
				</td>
			</tr>
            <tr>
				<td class="t-no" align="right"></td>
				<td class="t-label">
					a. Tahun
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["asal_ijazah_tahun"]; ?>
				</td>
			</tr>
            <tr>
				<td class="t-no" align="right"></td>
				<td class="t-label">
					b. Nomor
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["asal_ijazah_no"]; ?>
				</td>
			</tr>
            
            <tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label" colspan="3">
					Surat Keterangan Hasil Ujian Nasional (SKHUN) SMP/Mts, Paket B (diusulkan)
				</td>
                
			</tr>
            <tr>
				<td class="t-no" align="right"></td>
				<td class="t-label">
					a. Tahun
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["asal_ijazah_tahun"]; ?>
				</td>
			</tr>
            <tr>
				<td class="t-no" align="right"></td>
				<td class="t-label">
					b. Nomor
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["asal_skhu_no"]; ?>
				</td>
			</tr>
            
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Orangtua
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
					Alamat Orang Tua
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["ortu_alamat"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;</td>
				<td class="t-label">
					Telepon
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
                  <td rowspan="10" width="150px" style="text-align: center; vertical-align:bottom;">

						<table border="1" cellspacing="0">
							<tr>
								<td id="foto-plament">
									Pas Foto
									<br/>
									3x4 cm
                                    <br/>
                                    waktu diterima di sekolah ini dan tiga sidik jari kiri
								</td>
							</tr>
						</table>

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
					Telepon
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["wali_telepon"]; ?>
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Pekerjaan Wali
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					<?php echo $row["wali_pekerjaan"]; ?>
				</td>
			</tr>
            
            <tr>
				<td class="t-no" align="right"><?php echo ++$no; ?>.</td>
				<td class="t-label">
					Mutasi
				</td>
				<td class="t-sp">&nbsp;    </td>
				<td class="t-data">&nbsp;
					
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;  </td>
				<td class="t-label">
					a. Pindah ke
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					.................. kelas..................tahun............
				</td>
			</tr>
			<tr>
				<td class="t-no" align="right">&nbsp;  </td>
				<td class="t-label">
					b. Pindahan dari
				</td>
				<td class="t-sp"> : </td>
				<td class="t-data">
					.................. kelas..................tahun............
				</td>
			</tr>
		</table>

		<sethtmlpagefooter name="footer_ttd" value="on" show-this-page="1" />

	</div>


</body>
</html>