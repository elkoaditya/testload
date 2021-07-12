<?php

// function

function display_jadwal($row) {
	$cfg = array(
			'show_header' => FALSE,
			'pagination_link' => FALSE,
			'show_stat' => FALSE,
			'show_number' => FALSE,
			'row_action' => FALSE,
			'row_link' => FALSE,
			'jquery' => FALSE,
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

function display_soal_jml($n, $total) {
	return ($n == 0 OR $total < $n) ? "<i>semua ({$total} pertanyaan)</i>" : "{$n} pertanyaan";
}

function display_ljs_max($n) {
	return ($n == 0) ? '<i>tidak dibatasi</i>' : "{$n} kali";
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$author_ybs = ($user['id'] == $row['author_id']);
$editable = (($author_ybs OR $admin) && $row['semester_id'] == $semaktif['id'] && !$row['closed']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$row['id']}" => "kbm/evaluasi/id/{$row['id']}",
		'#publish',
);

// pills link

$pills_kiri[] = array(
		'label' => 'Detail Evaluasi',
		'uri' => "kbm/evaluasi/id/{$row['id']}",
		'attr' => 'title="kembali ke detail evaluasi"',
);

// pilss khusus tutor dan admin

$pills_kanan = array(
		'edit' => array(
				'label' => '<i class="icon-edit"></i> Edit',
				'uri' => "kbm/evaluasi/form?id={$row['id']}",
				'attr' => 'title="ubah data siswa ini"',
				'class' => (($editable) ? 'active' : 'disabled'),
		),
		'simulasi' => array(
				'label' => '<i class="icon-pencil"></i> Simulasi',
				'uri' => "kbm/evaluasi_ljs/form?id={$row['id']}",
				'attr' => 'title="simulasi pengerjaan evaluasi ini"',
				'class' => (($row['soal_total'] > 0) ? 'active' : 'disabled'),
		),
);

// pills wali belum terpikir krn blm ada implementasi login
//
//
// informasi evaluasi

$detail['umum'] = array(
		'Pelajaran' => array(
				'mapel_nama', 'ucwords',
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
		'Batas Soal Tampil' => array('soal_jml', 'display_soal_jml', $row['soal_total']),
		'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
		'Acak Soal' => array('soal_acak', array('tidak', 'ya')),
);

// table

$table = array(
		'table_properties' => array(
				'id' => 'tabel-jadwal',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<i>kosong</i>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'Mulai' => array('evaluasi_mulai', 'tglwaktu'),
				'Selesai' => array('evaluasi_ditutup', 'tglwaktu'),
		),
);

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
			. pills($pills_kiri, 'class="nav nav-pills pull-left"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. '</td></tr></table></div>';

// pesan

if (!$error)
	alert_info(div('align="center"', '<h3>Apakah Anda yakin akan mempublikasikan ini ke semua siswa???</h3>'));

$btn_back = a("kbm/evaluasi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke details evaluasi', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Publish Evaluasi #{$row['id']}")); ?>

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
						margin: 0.2em;
						color: black;
					}
					.subinfo{
						font-size: .8em;
						opacity: .7;
						line-height: .9em;
					}
					#detail-tambahan{
						display: none;
					}
				</style>

				<?php
				echo alert_get();
				echo $bar_pills;

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Informasi Umum</legend>';

				foreach ($detail['umum'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// opsi tambahan

				echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
				echo '<div id="detail-tambahan" class="form-horizontal"><fieldset>';
				//echo '<legend>Keterangan Tambahan</legend>';

				foreach ($detail['tambahan'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// jadwal pelaksanaan

				echo '<br/><br/><div class="form-horizontal"><fieldset>';
				echo '<legend>Jadwal Pelaksanaan</legend>';
				echo ds_table($table, $row['kelas_result']);
				echo '</fieldset></div><br/>';

				// tombol konfirm

				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. $btn_back . ' &nbsp; &nbsp; '
				. '<button type="submit" class="btn btn-warning"><i class="icon-fighter-jet icon-white"></i> PUBLIKASIKAN !</button> '
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

		<script type="text/javascript">
			$(function() {
				$('#cmd-detail-tambahan').click(function() {
					$('#detail-tambahan').slideToggle(200);
				});
			});
		</script>

	</body>
</html>