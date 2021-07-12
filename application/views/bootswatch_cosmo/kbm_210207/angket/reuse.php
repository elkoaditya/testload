<?php

// function

function display_tipe($row)
{
	return ucfirst($row['tipe']) . (($row['nilai_posted']) ? " ({$row['nilai_kolom_kode']})" : '');

}

function display_soal_jml($n, $total)
{
	return ($n == 0 OR $total < $n) ? "<i>semua ({$total} pertanyaan)</i>" : "{$n} pertanyaan";

}

function display_ljs_max($n)
{
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
	'KBM'							 => 'kbm',
	'Angket'						 => 'kbm/angket',
	"#{$row['id']}"					 => "kbm/angket/id/{$row['id']}",
	'#reuse',
);

// pills link

$pills_kiri[] = array(
	'label'	 => 'Detail Angket',
	'uri'	 => "kbm/angket/id/{$row['id']}",
	'attr'	 => 'title="kembali ke detail angket"',
);

// pilss khusus tutor dan admin

$pills_kanan = array(
	'simulasi' => array(
		'label'	 => '<i class="icon-pencil"></i> Simulasi',
		'uri'	 => "kbm/angket_ljs/form?id={$row['id']}",
		'attr'	 => 'title="simulasi pengerjaan angket ini"',
		'class'	 => (($row['soal_total'] > 0) ? 'active' : 'disabled'),
	),
);

// pills wali belum terpikir krn blm ada implementasi login
//
//
// informasi angket

$detail['umum'] = array(
	'Pelajaran'	 => array(
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
	'Bentuk'	 => array('pilihan_jml', array('error', 'error', 'Pilihan Ganda - 2 opsi', 'Pilihan Ganda - 3 opsi', 'Pilihan Ganda - 4 opsi', 'Pilihan Ganda - 5 opsi')),
);

$detail['tambahan'] = array(
	'Batas Soal Tampil'	 => array('soal_jml', 'display_soal_jml', $row['soal_total']),
	'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
	'Acak Soal'			 => array('soal_acak', array('tidak', 'ya')),
);

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
	. pills($pills_kiri, 'class="nav nav-pills pull-left"')
	. pills($pills_kanan, 'class="nav nav-pills pull-right"')
	. '</td></tr></table></div>';

// pesan

$btn_back = a("kbm/angket/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke details angket', 'class="btn btn-info "');

$input['umum'] = array(
	'pelajaran_id' => array(
		'pelajaran_id',
		'type'		 => 'dropdown',
		'name'		 => 'pelajaran_id',
		'id'		 => 'pelajaran_id',
		'label'		 => 'Pelajaran',
		'extra'		 => 'class="input-large select" id="pelajaran_id"',
		'options'	 => 'opsi_pelajaran',
	),
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Reuse Angket #{$row['id']}")); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Gunakan Angket:<br/>
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
				echo '<legend>Master Angket</legend>';

				foreach ($detail['umum'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// tombol konfirm

				echo form_opening("{$uri}/{$row['id']}", 'class="form-horizontal well"');

				// input umum

				echo '<fieldset>';

				echo '<legend>Gunakan untuk</legend>';

				foreach ($input['umum'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset></div>';

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. $btn_back . ' &nbsp; &nbsp; '
				. '<button type="submit" class="btn btn-warning"><i class="icon-fighter-jet icon-white"></i> GUNAKAN !</button> '
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