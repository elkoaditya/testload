<?php

// vars

if ($row['id'] == 0 && !$post_request)
	$row['pelajaran_id'] = $this->input->get_post('pelajaran_id');

if ($row['id'] > 0 && !$row['soal_jml'])
	$row['soal_jml'] = NULL;

if ($row['id'] > 0 && !$row['ljs_max'])
	$row['ljs_max'] = NULL;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/evaluasi/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link
// input data

$input['uraian'] = array(
		'detail_uraian' => array(
				'detail_uraian',
				'label' => 'Uraian',
				'type' => 'textarea',
				'name' => 'detail_uraian',
				'id' => 'detail_uraian',
				'class' => 'input tinymce_soal',
				'style' => 'height: 200px;',
		),
		
);

// buttons

if ($row['id'] > 0)
	$btn_back = a("kbm/evaluasi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan evaluasi', 'class="btn btn-info "');
else
	$btn_back = a("kbm/evaluasi", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail evaluasi', 'class="btn btn-info "');

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Uraian Evaluasi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Uraian Evaluasi</h1>
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
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
				echo '<fieldset>';



// input umum

				foreach ($input['uraian'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				
				

// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
				. $btn_back
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		addon('tinymce');
		?>

		

	<!--</body>
</html>-->