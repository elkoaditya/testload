<?php
// komponen

$this->load->helper('dataset');

// tabel data
$ds_row = array(
		'data' => array(
				'Nama &nbsp; ' => array('siswa_nama'),
				'Kelas &nbsp; ' => 'kelas_nama',
				'Waktu &nbsp; ' => array('waktu', 'tglwaktu'),
				'Nilai &nbsp; ' => array('nilai'),
		),
);

if ($user['role'] != 'siswa' OR $evaluasi['closed'])
	$ds_row['data']['Skor Poin &nbsp; '] = array(
			'poin',
			'suffix' => array(
					' / ',
					'poin_max',
			),
	);
?>
<div class="container">

	<!-- Typography	================================================== -->
	<div id="tabel">
		<div class="page-header alert-block">
			Lembar Jawab Soal :<br/>
			<h1><?php echo strtoupper($evaluasi['nama']) ?></h1>
		</div>

		<style>
			.controls{
				font-size: 1.2em;
				margin: 0.2em 0;
				color: black;
			}
		</style>

		<?php
		// data utama

		echo ds_row($ds_row, $row) . '<br/>';

		// butir jawaban

		echo '<table border="0">';

		foreach ($butir_result['data'] as $idx => $butir):
			soal_prepjwb($butir);

			echo '<tr>';
			echo '<td valign="top" align="right">' . ($idx + 1) . '. &nbsp; </td>';
			echo '<td valign="top">';

			// tampilkan pertanyaan

			echo $butir['pertanyaan'] . '<br/>';

			// poin

			if ($user['role'] != 'siswa' OR $evaluasi['closed'])
				echo "<b>Poin: </b>{$butir['jwb_poin']} / {$butir['poin_max']}<br/>";

			// jawaban

			echo "<b>Jawaban:</b>";
			//echo ul(array($butir['jwb_jawaban']));
			echo "<br/>";

			// pilihan, bila ada

			if ($butir['pilihan'] && $this->input->get('pilihan') && ($user['role'] != 'siswa' OR $evaluasi['closed'] )):

				echo "<b>Kunci:</b>";
				echo ul(array($butir['pilihan']['kunci']['label']));
				echo "<br/>";

				echo "<b>Pengecoh:</b>";
				echo ul($butir['pilihan']['pengecoh']);
				echo "<br/>";

			endif;

			echo '<br/></td>';
			echo '</tr>';

		endforeach;

		echo '</table>';
		?>

	</div>

</div><!-- /container -->
