<?php ?>

<style>
  @page {
		sheet-size: 8.5in 13in;
		margin: 60px 50px 50px 60px;
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

	<table border="0" cellspacing="0" cellpadding="2" width="100%" style="border-collapse: collapse;">
		<thead>
			<tr>
				<th colspan="2" align="left">
					PERINGKAT SEMESTER <?php echo strtoupper($row['semester_nama']); ?><br/>
					TAHUN <?php echo strtoupper($row['ta_nama']); ?>

				</th>
				<th colspan="2" align="left">
					<span style="font-size: 150%">KELAS <?php echo strtoupper($row['kelas_nama']); ?></span><br/>
					Wali Kelas : <?php echo ($row['kelas_wali_nama']); ?>

				</th>
			</tr>
			<tr>
				<th class="t-border t-vert" width="2em">Rangking</th>
				<th class="t-border t-vert nama">Nama Siswa</th>
				<th class="t-border t-vert">NIS</th>
				<th class="t-border t-vert">Jumlah</th>

			</tr>

		</thead>

		<tbody>

			<?php
			foreach ($nisis_result['data'] as $nisis):
				echo "<tr>" . NL;
				echo "<td class=\"t-border top center\">{$nisis['rank_kelas']}</td>" . NL;
				echo "<td class=\"t-border top nama\">{$nisis['siswa_nama']}</td>" . NL;
				echo "<td class=\"t-border top center\">{$nisis['siswa_nis']}</td>" . NL;
				echo "<td class=\"t-border top center\">" . round($nisis['nas_skor']) . "</td>" . NL;

				echo "</tr>" . NL;

			endforeach;
			?>
		</tbody>
	</table>
</div>
