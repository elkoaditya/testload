<?php

// function
/*
 *
  function display_pelajaran($row) {
  return a("data/akademik/pelajaran/id/{$row['pelajaran_id']}", $row['mapel_nama'], 'title="lihat detail pelajaran"')
  . "&nbsp; ({$row['pelajaran_kode']})";
  }

  function display_guru($row) {
  return a("data/profil/sdm/id/{$row['author_id']}", $row['author_nama'], 'title="lihat detail pengajar"');
  }

  function display_pengerjaan($row) {
  if ($row['evaluasi_last'])
  return tglwaktu($row['evaluasi_last']);

  return a("kbm/evaluasi_ljs/form?id={$row['id']}", 'kerjakan sekarang', 'title="klik untuk mengerjakan soal evaluasi ini sekarang"');
  }

 */

function display_ljs_max($n) {
	return ($n == 0) ? '<i>tak terbatas</i>' : "{$n} kali";
}

function display_jadwal($row) {
	$cfg = array(
			'table_properties' => array(
					'id' => 'tabel-jadwal',
					'class' => 'table table-bordered table-striped table-hover',
			),
			'empty_message' => '<i>kosong</i>',
			'data' => array(
					'Kelas' => 'kelas_nama',
					'Mulai' => 'evaluasi_mulai',
					'Ditutup' => 'evaluasi_ditutup',
			),
	);
	return ds_table($cfg, $row['kelas_result']);
}

function display_tipe($row) {
	return ucfirst($row['tipe']) . (($row['nilai_posted']) ? "({$row['nilai_kolom_kode']})" : '');
}

function display_soal_jml($n) {
	return ($n == 0) ? '<i>semua</i>' : "{$n} pertanyaan";
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$author = ($user['id'] == $row['author_id']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$row['id']}" => "kbm/evaluasi/id/{$row['id']}",
		'#publish',
);

// pills link
// informasi evaluasi

$detail['umum'] = array(
		'Pelajaran' => array(
				'mapel_nama',
				'ucwords',
				'suffix' => array(
						'<div class="subinfo">',
						'pelajaran_nama',
						' oleh ',
						'author_nama',
						'.&nbsp; ',
						'semester_nama',
						' ',
						'ta_nama',
						'</div>',
				),
		),
		'Tipe' => array(FALSE, 'display_tipe'),
		'Bentuk' => array('pilihan_jml', array('Uraian', 'error', 'error', 'Pilihan Ganda - 3 opsi', 'Pilihan Ganda - 4 opsi', 'Pilihan Ganda - 5 opsi')),
		'KKM' => 'kkm',
);
$detail['tambahan'] = array(
		'Batas Soal Tampil' => array('soal_jml', 'display_soal_jml'),
		'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
		'Acak Soal' => array('soal_acak', array('tidak', 'ya')),
);

// table

$table = array(
		'table_properties' => array(
				'id' => 'tabel-jadwal',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<i>jadwal kosong</i>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'Mulai' => array('evaluasi_mulai', 'tglwaktu'),
				'Ditutup' => array('evaluasi_ditutup', 'tglwaktu'),
		),
);

$btn_back = a("kbm/evaluasi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan evaluasi', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Evaluasi #{$row['id']}")); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Publikasikan Evaluasi:<br/>
					<h1><?php echo strtoupper($row['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
				</style>

				<?php
				if (!$error)
					alert_info(div('align="center"', '<h3>Apakah Anda yakin akan mempublikasikan ini ke semua siswa???</h3>'));

				echo alert_get();
				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Informasi</legend>';

				foreach ($inf_eval as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div>';

// jadwal pelaksanaan

				echo '<br/><br/><div class="form-horizontal"><fieldset>';
				echo '<legend>Jadwal pelaksanaan</legend>';
				echo ds_table($table, $row['kelas_result']);
				echo '</fieldset></div>';

				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-warning"><i class="icon-fighter-jet icon-white"></i> PUBLIKASIKAN !</button> '
				. $btn_back
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>