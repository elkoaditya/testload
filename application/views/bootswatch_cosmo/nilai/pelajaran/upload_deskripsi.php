<?php

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai' => 'nilai',
	'Pelajaran' => 'nilai/pelajaran',
	'#template'
);

// buttons

$btn_back = a("nilai/pelajaran", "<i class=\"icon-circle-arrow-left icon-white\"></i> Kembali ke daftar nilai pelajaran", 'class="btn btn-info "');

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Template Nilai')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Upload Deskripsi Pelajaran</h1>
				</div>

				<?php

				echo alert_get();
				echo form_openmp($uri, 'class="form-horizontal well"');

				// upload

				echo '<fieldset>';
				echo '<legend>Pilih berkas yg ingin diupload</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('upload', '', 'id="upload"');

				// link template default
				$template_deskripsi = 'nilai/pelajaran/upload_deskripsi/expor';

				
				echo p('class="help-block"', 'Klik ' . a($template_deskripsi, 'disini', 'target="_blank"') . ' untuk mendownload template deskripsi pelajaran.');
				

				echo "</div>" . NL;
				echo "</label></div>" . NL;
				echo '</fieldset>';

				// form button

				echo '<div class="form-actions">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> ';
				echo '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button>&nbsp; &nbsp; ';
				echo $btn_back;
				echo '</div>';
				echo '</fieldset>';

				echo form_close();

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>