<?php
// vars
//
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$row['id']}" => "kbm/angket/id/{$row['id']}",
		'Rekap'
);

// pills link
// input data

$input['umum'] = array(
		'kolom' => array(
				'kolom',
				'type' => 'dropdown',
				'name' => 'kolom',
				'id' => 'kolom',
				'label' => 'Kolom Nilai',
				'extra' => 'class="input-large select" id="pelajaran_id"',
				'options' => array(
					's2' => 'Penilaian Diri',
					's3' => 'Penilaian Sejawat'
					),
		),
);
$input['umum']['kolom']['extra'] .= ' disabled="true"';
// buttons

$btn_back = a("kbm/angket/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan angket', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Rekap Nilai Angket')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Rekap Nilai Angket</h1>
				</div>

				<style>
					#detail-tambahan{
						display: none;
					}
					.subinfo{
						font-size: 0.8em;
						opacity: 0.8;
						font-style: italic;
					}
				</style>

				<?php
				echo alert_get();
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
				echo '<fieldset>';

				echo '<legend>Pilih kolom rekap untuk menyimpan nilai.</legend>';

// input umum

				foreach ($input['umum'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '*data nilai sebelumnya pada kolom yang dipilih akan ditimpa, tidak bisa dikembalikan.';

// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Rekap</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
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