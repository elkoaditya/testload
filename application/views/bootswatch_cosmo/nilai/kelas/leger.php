<?php ?>

<style>
  @page {
		sheet-size: 13in 8.5in;
		margin: 30px 20px 20px 30px;
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
	.right{
		text-align: right;
	}
	.center{
		text-align: center;
	}
	.middle{
		vertical-align: middle;
	}
	.left{
		text-align: left;
	}
	.top{
		vertical-align: top;
	}
</style>

<div class="page" id="page-1">

	<table border="0" cellspacing="0" cellpadding="2" style="border-collapse: collapse;">
		<thead>
			<tr>
				<th colspan="8" align="left">
					LEGER SEMESTER <?php echo strtoupper($row['semester_nama']); ?><br/>
					TAHUN <?php echo strtoupper($row['ta_nama']); ?>
				</th>
				<th colspan="<?php echo $kolom_nilai_count; ?>" align="left">
					<span style="font-size: 150%">
						KELAS <?php echo strtoupper($row['kelas_nama']); ?>
					</span>
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					Wali Kelas : <?php echo ($row['kelas_wali_nama']); ?>

				</th>
			</tr>
			<tr>
				<th class="t-border t-vert" rowspan="2" width="2em">No</th>
				<th class="t-border t-vert nama" rowspan="2">Nama Siswa</th>
				<th class="t-border t-vert" rowspan="2">NIS</th>
				<th class="t-border t-vert" colspan="3">Absen</th>
				<th class="t-border t-vert" rowspan="2">Jml</th>
				<th class="t-border t-vert" rowspan="2">Rnk</th>

				<?php
				foreach ($pelajaran_array as $pelajaran):
					$colspan_mapel = ($pelajaran['teori'] == 1 && $pelajaran['praktek'] == 1) ? 3 : 2;

					echo "<th class=\"t-border t-vert\" colspan=\"{$colspan_mapel}\">" . strtoupper($pelajaran['mapel_kode']) . "</th>" . NL;

				endforeach;
				?>

			</tr>

			<tr>
				<th class="t-border t-vert">S</th>
				<th class="t-border t-vert">I</th>
				<th class="t-border t-vert">A</th>

				<?php
				foreach ($pelajaran_array as $pelajaran):

					if ($pelajaran['teori'] == 1)
						echo "<th class=\"t-border t-vert\">Ko</th>" . NL;

					if ($pelajaran['praktek'] == 1)
						echo "<th class=\"t-border t-vert\">Ps</th>" . NL;

					echo "<th class=\"t-border t-vert\">Af</th>" . NL;

				endforeach;
				?>

			</tr>
			<tr>
				<th class="t-border t-vert" colspan="8">KKM</th>

				<?php
				foreach ($pelajaran_array as $pelajaran):
					$colspan_mapel = ($pelajaran['teori'] == 1 && $pelajaran['praktek'] == 1) ? 3 : 2;

					echo "<th class=\"t-border t-vert\" colspan=\"{$colspan_mapel}\">" . round($pelajaran['kkm']) . "</th>" . NL;

				endforeach;
				?>

			</tr>

		</thead>

		<tbody>

			<?php
			$no_absen = 0;

			foreach ($leger as $nisis):
				$no_absen++;
				echo "<tr>" . NL;
				echo "<td class=\"t-border top center\">{$no_absen}</td>" . NL;
				echo "<td class=\"t-border top nama\">{$nisis['siswa_nama']}</td>" . NL;
				echo "<td class=\"t-border top\">{$nisis['siswa_nis']}</td>" . NL;
				echo "<td class=\"t-border top center\">{$nisis['absen_s']}</td>" . NL;
				echo "<td class=\"t-border top center\">{$nisis['absen_i']}</td>" . NL;
				echo "<td class=\"t-border top center\">{$nisis['absen_a']}</td>" . NL;
				echo "<td class=\"t-border top right\">" . round($nisis['nas_skor']) . "</td>" . NL;
				echo "<td class=\"t-border top right\">{$nisis['rank_kelas']}</td>" . NL;
				//
				//* /
				foreach ($pelajaran_array as $pelajaran_id => $pelajaran):

					$ikut_belajar = array_key_exists($pelajaran_id, $nisis['nisispel_array']);

					if ($pelajaran['teori'] == 1):
						$nas_teori = ($ikut_belajar) ? round($nisis['nisispel_array'][$pelajaran_id]['nas_teori']) : '-';
						echo "<td class=\"t-border top right\">{$nas_teori}</td>" . NL;
					endif;

					if ($pelajaran['praktek'] == 1):
						$nas_praktek = ($ikut_belajar) ? round($nisis['nisispel_array'][$pelajaran_id]['nas_praktek']) : '-';
						echo "<td class=\"t-border top right\">{$nas_praktek}</td>" . NL;
					endif;

					$nas_sikap = ($ikut_belajar) ? $nisis['nisispel_array'][$pelajaran_id]['nas_sikap'] : '-';
					echo "<td class=\"t-border top center\">{$nas_sikap}</td>" . NL;

				endforeach;
				// */

				echo "</tr>" . NL;

			endforeach;
			?>
		</tbody>
	</table>
</div>
