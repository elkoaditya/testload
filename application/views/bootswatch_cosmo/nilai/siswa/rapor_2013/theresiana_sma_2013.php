<?php

function ket_ekskul($str) {
	if (empty($str))
		return '-';

	if (strlen($str) == 1)
		return strtoupper($str);

	$str = substr($str, 0, 1);

	return strtoupper($str);
}
?>

<style>
  @page {
		sheet-size: 210mm 330mm ;
		margin: 20px;
	}

	.page *, td{
		font-size: 11px;
	}

	.page-notend{
		page-break-after: always;
	}

	.t-border{
		border-width: 1px;
		border-style: solid;
		border-color: black;
    border-collapse: collapse;

	}
	#t-nilai
	{
		width: 100%;
	}
	.thead-1{
		vertical-align: middle;
		text-align: center;
	}
	.thead-2{
		vertical-align: middle;
		text-align: center;
		padding: 7px;
	}
	.field-nilai
	{
		padding: 7px 12px 7px 7px;
	}
	.f-kompetensi{
		padding: 3px 7px;
	}


	#header-rapor{
		text-align: center;
		font-family: Arial;
		font-size: 120%;
		font-weight: bold;
	}
	.t-siswa tr td{
		padding: 6px 10px 6px 6px;
	}

	.t-ekskul{
		margin: 0px;
		width: 245px;
	}
	.thead-ekskul{
		text-align: center;
		margin: 4px;
		font-weight: bold;
	}

	#head-1{
		text-align: center;
		font-size: 24px;
		font-weight: bold;
	}
	#head-2{
		text-align: center;
		font-size: 20px;
		font-weight: bold;
	}
</style>

<div class="page page-notend" id="page-1">

	<div id="header-rapor">

		<table border="0" cellspacing="0">
			<tr>
				<td width="27%">
					<?php
					$logo = array(
							'src' => 'content/theresiana_sma1/logo_120.jpg',
							'width' => 80,
					);
					//echo img($logo);
					?>&nbsp;
				</td>
				<td align="center">
					<div id="head-2">
						LAPORAN HASIL BELAJAR PESERTA DIDIK<br/>
						SMA THERESIANA 1 SEMARANG

					</div>
				</td>
			</tr>
		</table>

	</div>
	<br/>

	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td valign="top" width="60%">
				<table border="0" cellspacing="0" style="width: 100%;">
					<tr>
						<td valign="top">Nama Peserta Didik &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['siswa_nama']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top">Nomor Induk &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['siswa_nis']; ?>
						</td>
					</tr>
				</table>

			</td>
			<td valign="top" width="40%">
				<table border="0" cellspacing="0" style="width: 100%;">
					<tr>
						<td valign="top">Kelas/Semester &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['kelas_nama'] . ' / ' . (($row['semester_nama'] == 'genap') ? 2 : 1); ?>
						</td>
					</tr>
					<tr>
						<td valign="top">Tahun Pelajaran &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['ta_nama']; ?>
						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br/>

	<table cellspacing="0" id="t-nilai" class="t-border" >
		 <tr>
            <td class="thead-1 t-border" rowspan="2" colspan="2" width="25%">Mata Pelajaran</td>
            <td class="thead-1 t-border" colspan="2">Pengetahuan</td>
            <td class="thead-1 t-border" colspan="2">Praktek</td>
            <td class="thead-1 t-border" colspan="2">Sikap Spiritual dan Sosial</td>
          </tr>
		
		<tr>
			<td class="thead-1 t-border">&nbsp;Angka&nbsp;</td>
			<td class="thead-1 t-border">&nbsp;Predikat&nbsp;</td>
			<td class="thead-1 t-border">&nbsp;Angka&nbsp;</td>
			<td class="thead-1 t-border">&nbsp;Predikat&nbsp;</td>
			<td class="thead-1 t-border" width="15%">&nbsp;Dalam Mapel&nbsp;</td>
            <td class="thead-1 t-border" width="15%">&nbsp;Antar Mapel&nbsp;</td>
		</tr>
		<?php
		$mp_no = 0;
		$ktg_ascii = 64;
		$ktg_nama = NULL;
		$jml_row=0;
		
		foreach ($resultset['data'] as $idx => $item):
			if ($item['kategori_nama'] != $ktg_nama):
				$ktg_nama = $item['kategori_nama'];
				$jml_row++;
			endif;
			$jml_row++;
		endforeach;
		
		$ktg_nama = NULL;
		$antr_mapel=0;
		foreach ($resultset['data'] as $idx => $item):

			if ($item['kategori_nama'] != $ktg_nama):
				
				$ktg_ascii++;
				$mp_no = 0;
				
				echo '<tr>' . NL;
				//echo "<td class=\"field-nilai t-border\" valign=\"top\"><b>" . chr($ktg_ascii) . "</b></td>" . NL;
				//echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"7\"><b>{$ktg_nama}</b></td>" . NL;
				if($ktg_nama!=NULL):
					echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"7\"><b>".$item['kategori_nama']."</b></td>" . NL;
				else:
					echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ><b>(1-4)</b></td>" . NL;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" ></td>" . NL;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ><b>(1-4)</b></td>" . NL;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" ></td>" . NL;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ><b>SB/B/K</b></td>" . NL;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" ></td>" . NL;
				endif;
				echo '</tr>' . NL;
				
				$ktg_nama = $item['kategori_nama'];
			endif;

			$mp_no++;

			echo '<tr>' . NL;
			echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"right\">{$mp_no}</td>" . NL;
			echo "<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}</td>" . NL;
			

			// ppk
			$cetak_nilai=0;
			if ($item['nipel_teori']):
				foreach ($konversi_nilai['data'] as $konversi):
					if( (round($item['nas_teori'])>=$konversi['rentang_nilai_min'])&&(round($item['nas_teori'])<=$konversi['rentang_nilai_max'])):
						$cetak_nilai=1;
						echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['bobot'] . "</td>" . NL;
						echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['predikat'] . "</td>" . NL;
					endif;
				endforeach;	
				if($cetak_nilai==0):
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
				endif;
			else:
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
			
			endif;

			// prk
			$cetak_nilai=0;
			if ($item['nipel_praktek']):
				foreach ($konversi_nilai['data'] as $konversi):
					if( (round($item['nas_praktek'])>=$konversi['rentang_nilai_min'])&&(round($item['nas_praktek'])<=$konversi['rentang_nilai_max'])):
						$cetak_nilai=1;
						echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['bobot'] . "</td>" . NL;
						echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['predikat'] . "</td>" . NL;
					endif;
				endforeach;
				if($cetak_nilai==0):
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
				endif;	
			else:
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;

			endif;

			// sikap
			$avg = (round($item['nas_praktek'])+round($item['nas_teori']) )/2;
			$cetak_nilai=0;
			foreach ($konversi_nilai['data'] as $konversi):
				if( (round($avg)>=$konversi['rentang_nilai_min'])&&(round($avg)<=$konversi['rentang_nilai_max'])):
					$cetak_nilai=1;
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['kualifikasi'] . "</td>" . NL;
				endif;
			endforeach;
			if($cetak_nilai==0):
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
			endif;
			//echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . ($item['nas_sikap']) . "</td>" . NL;

			if($antr_mapel==0):
				$text="Peserta didik sangat baik dalam menjalankan ajaran agama yang dianutnya dan menunjukan kesungguhannya dalam menerapkan sikap jujur, kerjasama, dan percaya diri";
				echo "<td class=\"field-nilai t-border\" valign=\"top\" rowspan=\"".$jml_row."\"><b>".$text."</b></td>" . NL;
				$antr_mapel++;
			endif;
			
			echo '</tr>' . NL;
			$jml_row++;
		endforeach;
		?>

	</table>
	<br/>

	<table cellspacing="0" class="t-border" width="100%" >
		<tr>
			<td class="t-border" align="center" valign="middle" width="40">No</td>
			<td class="t-border" align="center" valign="middle" >Kegiatan Ekstrakurikuler</td>
			<td class="t-border" align="center" valign="middle" width="8%">Nilai</td>
            <td class="t-border" align="center" valign="middle">Keterangan</td>
		</tr>

		<?php
		foreach ($ekskul_result['data'] as $_idx => $_row):
			echo '<tr>' . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"40\">" . ($_idx + 1) . ".</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"200\">{$_row['ekskul_nama']}</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\" align=\"center\">{$_row['nilai']}</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\">{$_row['keterangan']}</td>" . NL;
			echo '</tr>' . NL;

		endforeach;
		/*
		foreach ($org_result['data'] as $_idx => $_row):
			echo '<tr>' . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"40\">" . ($_idx + 1) . ".</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"200\">{$_row['org_nilai']}</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"200\">{$_row['org_nama']}</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\">{$_row['keterangan']}</td>" . NL;
			echo '</tr>' . NL;

		endforeach;
		*/
		?>
        <tr>
			<td class="t-border" align="center"></td>
			<td class="t-border" align="center">-</td>
			<td class="t-border" align="center">-</td>
            <td class="t-border" align="center">-</td>
		</tr>
	</table>
	<br/>
	<table cellspacing="0" class="t-border" width="50%" >
		<tr>
			<td class="t-border" colspan="2" align="center">Ketidakhadiran</td>
		</tr>
		<tr>
			<td class="t-border" width="50%">Sakit</td>
			<td class="t-border"><?php echo ($row['absen_s'] > 0) ? "{$row['absen_s']} hari" : "-"; ?></td>
		</tr>
		<tr>
			<td class="t-border">Ijin</td>
			<td class="t-border"><?php echo ($row['absen_i'] > 0) ? "{$row['absen_i']} hari" : "-"; ?></td>
		</tr>
		<tr>
			<td class="t-border">Tanpa Keterangan</td>
			<td class="t-border"><?php echo ($row['absen_a'] > 0) ? "{$row['absen_a']} hari" : "-"; ?></td>
		</tr>
	</table>
    <br/>	
	<table border="0" style="width: 100%;">
		<tr>
			<td valign="bottom" align="center" style="width: 30%;">
				<p>
					Orang Tua/Wali
				</p>
			</td>

			<td valign="bottom" align="center" style="width: 35%;">
				<p>
					Mengetahui,<br/>
					Kepala Sekolah
				</p>
			</td>

			<td valign="bottom" align="center" style="width: 35%;">
				<p>
					Semarang, 21 Desember 2013<br/><br/><br/>
					Wali Kelas
				</p>
			</td>
		</tr>
		<tr>
			<td valign="bottom" align="center">
				<p>
					<br/><br/><br/><br/>
					...................................
				</p>
			</td>

			<td valign="bottom" align="center">
				<p>
					<br/><br/><br/><br/>
					Drs. Antonius Kristiadi
				</p>
			</td>

			<td valign="bottom" align="center">
				<p>
					<br/><br/><br/><br/>
					<?php echo $row['wali_nama']; ?>
				</p>
			</td>
		</tr>
	</table>

</div>



<!--
<div class="page page-notend" id="page-2">

	<div id="head-2">
		KETERCAPAIAN KOMPETENSI PESERTA DIDIK
	</div>
	<br/>

	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td valign="top" width="60%">
				<table border="0" cellspacing="0" style="width: 100%;">
					<tr>
						<td valign="top">Nama Peserta Didik &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['siswa_nama']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top">Nomor Induk &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['siswa_nis']; ?>
						</td>
					</tr>
				</table>

			</td>
			<td valign="top" width="40%">
				<table border="0" cellspacing="0" style="width: 100%;">
					<tr>
						<td valign="top">Kelas/Semester &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['kelas_nama'] . ' / ' . (($row['semester_nama'] == 'genap') ? 2 : 1); ?>
						</td>
					</tr>
					<tr>
						<td valign="top">Tahun Pelajaran &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['ta_nama']; ?>
						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br/>

	<table cellspacing="0" class="t-border" width="100%" >
		<tr>
			<td class="thead-1 t-border" width="40">No</td>
			<td class="thead-1 t-border" width="400">Komponen</td>
			<td class="thead-1 t-border">Ketercapaian Kompetensi</td>
		</tr>
		<?php
		$mp_no = 0;
		$ktg_ascii = 64;
		$ktg_nama = NULL;

		foreach ($resultset['data'] as $idx => $item):

			if ($item['kategori_nama'] != $ktg_nama):
				$ktg_nama = $item['kategori_nama'];
				$ktg_ascii++;
				$mp_no = 0;

				echo '<tr>' . NL;
				echo "<td class=\"field-nilai t-border\" valign=\"top\"><b>" . chr($ktg_ascii) . "</b></td>" . NL;
				echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>{$ktg_nama}</b></td>" . NL;
				echo '</tr>' . NL;

			endif;

			$mp_no++;

			echo '<tr>' . NL;
			echo "<td class=\"field-nilai t-border\" valign=\"top\">{$mp_no}</td>" . NL;
			echo "<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}</td>" . NL;
			echo "<td class=\"field-nilai t-border\" valign=\"top\">{$item['kompetensi']}</td>" . NL;
			echo '</tr>' . NL;
		endforeach;
		?>

	</table>
	<br/><br/>

</div>




<div class="page" id="page-3">

	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td valign="top" width="60%">
				<table border="0" cellspacing="0" style="width: 100%;">
					<tr>
						<td valign="top">Nama Peserta Didik &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['siswa_nama']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top">Nomor Induk &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['siswa_nis']; ?>
						</td>
					</tr>
				</table>

			</td>
			<td valign="top" width="40%">
				<table border="0" cellspacing="0" style="width: 100%;">
					<tr>
						<td valign="top">Kelas/Semester &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['kelas_nama'] . ' / ' . (($row['semester_nama'] == 'genap') ? 2 : 1); ?>
						</td>
					</tr>
					<tr>
						<td valign="top">Tahun Pelajaran &nbsp;</td>
						<td valign="top"> : &nbsp;</td>
						<td valign="top">
							<?php echo $row['ta_nama']; ?>
						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br/>


	<?php
	// membentuk data ekskul & organisasi
	// maksimal 3 baris, bila kurang dikosongi

	$ekskul_jml = $ekskul_result['selected_rows'];

	if ($ekskul_jml > 3):
		$ekskul_result['data'] = array_slice($ekskul_result, 0, 3);

	elseif ($ekskul_jml < 3):

		for ($i = $ekskul_jml; $i < 3; $i++):
			$ekskul_result['data'][] = array(
					'ekskul_nama' => '',
					'keterangan' => '',
			);
		endfor;

	endif;

	$org_jml = $org_result['selected_rows'];

	if ($org_jml > 3):
		$org_result['data'] = array_slice($org_result, 0, 3);

	elseif ($org_jml < 3):

		for ($i = $org_jml; $i < 3; $i++):
			$org_result['data'][] = array(
					'org_nama' => '',
					'keterangan' => '',
			);
		endfor;

	endif;
	?>

	<b>Pengembangan Diri</b><br/>

	<table cellspacing="0" class="t-border" width="100%" >
		<tr>
			<td class="t-border" align="center" valign="middle" width="40">No</td>
			<td class="t-border" align="center" valign="middle" colspan="2">Jenis Kegiatan</td>
			<td class="t-border" align="center" valign="middle">Keterangan</td>
		</tr>
		<tr>
			<td class="t-border" valign="top">A.</td>
			<td class="t-border" valign="top" colspan="3">Kegiatan Ekstrakurikuler</td>
		</tr>

		<?php
		foreach ($ekskul_result['data'] as $_idx => $_row):
			echo '<tr>' . NL;
			echo "<td class=\"t-border\" valign=\"top\">&nbsp;</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"40\">" . ($_idx + 1) . ".</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"200\">{$_row['ekskul_nama']}</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\">{$_row['keterangan']}</td>" . NL;
			echo '</tr>' . NL;

		endforeach;
		?>
		<tr>
			<td class="t-border" valign="top">B.</td>
			<td class="t-border" valign="top" colspan="3">Keikutsertaan dalam Organisasi/Kegiatan Sekolah</td>
		</tr>

		<?php
		foreach ($org_result['data'] as $_idx => $_row):
			echo '<tr>' . NL;
			echo "<td class=\"t-border\" valign=\"top\">&nbsp;</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"40\">" . ($_idx + 1) . ".</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\" width=\"200\">{$_row['org_nama']}</td>" . NL;
			echo "<td class=\"t-border\" valign=\"top\">{$_row['keterangan']}</td>" . NL;
			echo '</tr>' . NL;

		endforeach;
		?>
	</table>
	<br/>

	<b>Akhlak Mulia dan Kepribadian</b><br/>

	<?php
	// kepribadian

	echo '<table cellspacing="0" class="t-border" width="100%" >' . NL;
	echo '<tr>' . NL;
	echo '<td align="center" align="center" width="40px"><b>No</b></td>' . NL;
	echo '<td align="center" width="300px"><b>Aspek yang Dinilai</b></td>' . NL;
	echo '<td align="center"><b>Keterangan</b></td>' . NL;
	echo '</tr>' . NL;

	$kepribadian = (array) json_decode($row['kepribadian'], TRUE);
	$no = 1;

	foreach ($this->m_nilai_siswa->dm['kepribadian.ktsp'] as $idx => $label):
		echo '<tr>' . NL;
		echo '<td class="t-border">' . ($no++) . '</td>' . NL;
		echo '<td class="t-border">' . $label . '</td>' . NL;
		echo '<td class="t-border">' . array_node($kepribadian, $idx) . '</td>' . NL;
		echo '</tr>' . NL;

	endforeach;

	echo '</table>' . NL;
	echo '<br/>';
	?>

	<b>Ketidakhadiran</b><br/>
	<table cellspacing="0" class="t-border" width="100%" >
		<tr>
			<td class="t-border" align="center" width="40px">No</td>
			<td class="t-border" width="300px">Alasan Ketidakhadiran</td>
			<td class="t-border">Keterangan</td>
		</tr>
		<tr>
			<td class="t-border" align="center">1</td>
			<td class="t-border">Sakit</td>
			<td class="t-border"><?php echo ($row['absen_s'] > 0) ? "{$row['absen_s']} hari" : "-"; ?></td>
		</tr>
		<tr>
			<td class="t-border" align="center">2</td>
			<td class="t-border">Ijin</td>
			<td class="t-border"><?php echo ($row['absen_i'] > 0) ? "{$row['absen_i']} hari" : "-"; ?></td>
		</tr>
		<tr>
			<td class="t-border" align="center">3</td>
			<td class="t-border">Tanpa Keterangan</td>
			<td class="t-border"><?php echo ($row['absen_a'] > 0) ? "{$row['absen_a']} hari" : "-"; ?></td>
		</tr>
	</table>
	<br/><br/>

	<table border="0" style="width: 100%;">
		<tr>
			<td valign="bottom" align="center" style="width: 30%;">
				<p>
					Orang Tua/Wali
				</p>
			</td>

			<td valign="bottom" align="center" style="width: 35%;">
				<p>
					Mengetahui,<br/>
					Kepala Sekolah
				</p>
			</td>

			<td valign="bottom" align="center" style="width: 35%;">
				<p>
					Semarang, 21 Desember 2013<br/><br/><br/>
					Wali Kelas
				</p>
			</td>
		</tr>
		<tr>
			<td valign="bottom" align="center">
				<p>
					<br/><br/><br/><br/>
					...................................
				</p>
			</td>

			<td valign="bottom" align="center">
				<p>
					<br/><br/><br/><br/>
					Drs. Antonius Kristiadi
				</p>
			</td>

			<td valign="bottom" align="center">
				<p>
					<br/><br/><br/><br/>
					<?php echo $row['wali_nama']; ?>
				</p>
			</td>
		</tr>
	</table>


</div>-->