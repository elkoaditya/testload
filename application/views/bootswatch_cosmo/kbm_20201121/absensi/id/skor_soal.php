<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$evaluasi['id']}#baru",
);


// pills link

$pills[] = array(
		'label' => 'Evaluasi : '. $evaluasi['nama'],
		'uri' => "kbm/evaluasi/id/{$evaluasi['id']}",
		'attr' => 'title="kembali ke evaluasi"',
);

// input data

$input = array(
		'jml_soal' => array(
				'50',
				'type' => 'input',
				'name' => 'poin_max',
				'id' => 'poin_max',
				'label' => 'Bobot Max Soal : ',
				'class' => 'input input-small',
		),
);

$btn_back = a("kbm/evaluasi/id/{$evaluasi['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail evaluasi', 'class = "btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array(' title' => 'Startup Semester')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Ubah Skor Soal</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo pills($pills);
				// echo form_opening("{$uri}?id={$evaluasi['id']}", 'class="form-horizontal well"');
				echo form_openmp("{$uri}?evaluasi_id={$evaluasi['id']}", 'class="form-horizontal well"'); 

				// detail jurusan

				echo '<fieldset>';

				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, ''));
					echo "</label></div>" . NL;
				endforeach;

				// form button

				echo '<div class = "form-actions well">'
				. '<button type = "submit" class = "btn btn-success"><i class = "icon-save icon-white"></i> Simpan</button> '
				. '<button type = "reset" class = "btn"><i class = "icon-undo icon-white"></i> Batal</button> &nbsp;&nbsp;'
				. $btn_back
				. '</div>';
				echo '</fieldset>    ';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		?>

		<script type="text/javascript">

			$(function() {
				$('.tanggal').datepicker({
					dateFormat: 'dd-mm-yy',
					dayNamesMin: ['Mgg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
					gotoCurrent: true,
					changeMonth: true,
					changeYear: true
				});
			});

		</script>

	</body>
</html>