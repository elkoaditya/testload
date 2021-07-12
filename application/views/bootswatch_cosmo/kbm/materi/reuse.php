<?php

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$author_ybs = ($user['id'] == $row['author_id']);

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Materi'						 => 'kbm/materi',
	"#{$row['id']}"					 => "kbm/materi/id/{$row['id']}",
	'#reuse',
);

// pills link

$pills_kiri[] = array(
	'label'	 => 'Detail Materi',
	'uri'	 => "kbm/materi/id/{$row['id']}",
	'attr'	 => 'title="kembali ke detail materi"',
);

// informasi materi

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
);

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
	. pills($pills_kiri, 'class="nav nav-pills pull-left"')
	. '</td></tr></table></div>';

// pesan

$btn_back = a("kbm/materi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail materi', 'class="btn btn-info "');

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

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Reuse Materi #{$row['id']}")); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Gunakan Materi:<br/>
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
				echo '<legend>Master Materi</legend>';

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