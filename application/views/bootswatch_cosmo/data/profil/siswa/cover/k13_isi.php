<htmlpagefooter name="footer_ttd">
		<div id="footer_ttd" class="footer">

			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="400px" style="padding-left: 50px; text-align: center; vertical-align: middle;">

						<table border="0" cellspacing="0">
							<tr>
								<td id="foto-plament">
									<!-- Pas Foto
									<br/>
									3x4-->
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
							<b><u><?=$info['kepala_sekolah'];?></u></b>
							<br/>
							NIP. <?=$info['nip'];?>
						</p>
					</td>
				</tr>
			</table>
			<br/><br/><br/>

		</div>
	</htmlpagefooter>
	
<div id="bg_profil" class=" page_bg0" style="height:100%">
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
			.t-label{
				width: 230px;
				text-align: left;
				vertical-align: top;
				margin: 2px 2px 2px 5px;
				padding: 4px 5px 4px 5px;
			}
			.t-label2{
				width: 160px;
				text-align: left;
				vertical-align: top;
				margin: 2px 2px 2px 5px;
				padding: 10px 5px 10px 5px;
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

		<!--<sethtmlpagefooter name="footer_ttd" value="on" show-this-page="1" />-->
		
		<div id="footer_ttd" class="footer">
			<br/><br/><br/><br/>
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="400px" style="padding-left: 50px; text-align: center; vertical-align: middle;">

						<table border="0" cellspacing="0">
							<tr>
								<td id="foto-plament">
									<!-- Pas Foto
									<br/>
									3x4-->
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
							<b><u><?=$info['kepala_sekolah'];?></u></b>
							<br/>
							NIP. <?=$info['nip'];?>
						</p>
					</td>
				</tr>
			</table>
			

		</div>

	</div>