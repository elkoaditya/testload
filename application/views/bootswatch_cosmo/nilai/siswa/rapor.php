<style>
  @page { sheet-size: 216mm 270mm ; }
	#t-nilai
	{
		border: 1px solid black;
    border-collapse: collapse;
		width: 100%;
	}
	#t-nilai tr td, #t-nilai tr th
	{
		border: 1px solid black;
		font-size: 12px;
		padding: 2px 4px;
	}
</style>
<table border="0" style="width: 100%;">
  <tr>
    <td valign="top" width="400px">
			<table border="0" style="width: 100%;">
				<tr>
					<td valign="top">
						<b>Nama Peserta Didik</b>
					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b><?php echo $row['siswa_nama']; ?></b>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<b>Nomor Induk</b>
					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b><?php echo $row['siswa_nis']; ?></b>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<b>Nama Sekolah</b>
					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b>SMA Negeri Semarang</b>
					</td>
				</tr>
			</table>
    </td>
    <td valign="top">
			<table border="0">
				<tr>
					<td valign="top">
						<b>Kelas</b>
					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b><?php echo ucwords($row['kelas_nama']); ?></b>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<b>Semester</b>
					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b><?php echo ucwords($row['prd_semester']); ?></b>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<b>Tahun Pelajaran</b>
					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b><?php echo $row['prd_ta'] . '/' . ($row['prd_ta'] + 1); ?></b>
					</td>
				</tr>
			</table>
    </td>
  </tr>
</table>
<br/>

<table cellspacing="0" id="t-nilai">
  <tr>
    <th rowspan="3">No</th>
    <th rowspan="3">Komponen</th>
    <th rowspan="3">Kriteria<br/>Ketuntasan<br/>Minimal<br/>(KKM)</th>
    <th colspan="5">Nilai Hasil Belajar</th>
  </tr>
  <tr>
    <th colspan="2">Pengetahuan</th>
    <th colspan="2">Praktek</th>
    <th>Sikap</th>
  </tr>
  <tr>
    <th>Angka</th>
    <th>Huruf</th>
    <th>Angka</th>
    <th>Huruf</th>
    <th>Predikat</th>
  </tr>
	<?php
	$kategori = '';
	$kat_no = 0;
	$mp_no = 0;

	foreach ($resultset['data'] as $idx => $item):

		if ($kategori != $item['kat_mapel_nama']):
			$kategori = $item['kat_mapel_nama'];
			$kat_no++;
			$mp_no = 0;

			echo '<tr>' . NL;
			echo "<td valign=\"top\"><b>" . chr($kat_no + 64) . "</b></td>" . NL;
			echo "<td valign=\"top\" colspan=\"7\"><b>{$kategori}</b></td>" . NL;
			echo '</tr>' . NL;

		endif;

		$mp_no++;
		echo '<tr>' . NL;
		echo "<td valign=\"top\">{$mp_no}</td>" . NL;
		echo "<td valign=\"top\">{$item['mapel_nama']}</td>" . NL;
		echo "<td valign=\"top\" align=\"center\">" . round($item['pelajaran_kkm']) . " &nbsp;</td>" . NL;

		// ppk, prk

		foreach (array('nas_ppk', 'nas_prk') as $col):
			if (is_numeric($item[$col])):
				echo "<td valign=\"top\" align=\"center\">" . formnil_angka($item[$col]) . " &nbsp; </td>" . NL;
				echo "<td valign=\"top\" align=\"center\">" . formnil_huruf($item[$col]) . "</td>" . NL;

			else:
				echo "<td valign=\"top\" align=\"center\" style=\"background-color: grey;\">-</td>" . NL;
				echo "<td valign=\"top\" align=\"center\" style=\"background-color: grey;\">-</td>" . NL;

			endif;
		endforeach;

		// sikap

		if (is_numeric($item['nas_skp']))
			echo "<td valign=\"top\" align=\"center\">" . formnil_predikat($item['nas_skp']) . "</td>" . NL;
		else
			echo "<td valign=\"top\" align=\"center\" style=\"background-color: grey;\">-</td>" . NL;

		echo '</tr>' . NL;
	endforeach;
	?>
</table>
<br/>

<p align="right">
  Semarang, <?php echo date('d M Y'); ?>
</p>
<br/>

<table border="0" style="width: 100%;">
  <tr>
    <td valign="top" align="center">
			<p>
				Orang Tua/Wali<br/>
				Peserta Didik<br/>
				<br/><br/><br/>
				.....................
			</p>
    </td>
    <td valign="top" align="center">
			<p>
				Wali Kelas<br/>
				<br/>
				<br/><br/><br/>
				.....................
			</p>
    </td>
    <td valign="top" align="center">
			<p>
				Kepala Sekolah<br/>
				<br/>
				<br/><br/><br/>
				.....................
			</p>
    </td>
  </tr>
</table>
