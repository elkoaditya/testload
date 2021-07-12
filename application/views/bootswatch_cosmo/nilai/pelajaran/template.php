<?php

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai' => 'nilai',
	'Pelajaran' => 'nilai/pelajaran',
	"#{$row['id']}" => "nilai/pelajaran/id/{$row['id']}",
	'#template'
);

// pills link

$pills[] = array(
	'label' => '<i class="icon-table"></i>Nilai Pelajaran',
	'uri' => 'nilai/pelajaran',
	'attr' => 'title="kembali ke daftar nilai pelajaran"',
);
$pills[] = array(
	'label' => "<i class=\"icon-table\"></i>Nilai {$row['pelajaran_nama']}",
	'uri' => "nilai/pelajaran/id/{$row['id']}",
	'attr' => 'title="kembali ke detail nilai pelajaran"',
);

// buttons

$btn_back = a("nilai/pelajaran/id/{$row['id']}", "<i class=\"icon-circle-arrow-left icon-white\"></i> Kembali ke detail nilai {$row['pelajaran_nama']}", 'class="btn btn-info "');

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
					<h1>Template Nilai <?php echo $row['pelajaran_nama']; ?></h1>
				</div>

				<?php

				echo alert_get();
				echo pills($pills);
				echo form_openmp("{$uri}/{$row['id']}", 'class="form-horizontal well"');

				// upload

				echo '<fieldset>';
				echo '<legend>Pilih berkas yg ingin diupload</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('upload', '', 'id="upload"');

				// link template tersimpan
				$template_tersimpan = "content/nilai-pelajaran/{$row['id']}/template.xlsx";

				if (file_ada($template_tersimpan))
				{
					echo p('class="help-block"', 'Klik ' . a($template_tersimpan, 'disini', 'target="_blank"') . ' untuk mendownload template excel yg tersimpan.');
				}

				// link template sekolah
				$template_sekolah = "content/nilai-pelajaran/template.xlsx";

				if (file_ada($template_sekolah))
				{
					echo p('class="help-block"', 'Klik ' . a($template_sekolah, 'disini', 'target="_blank"') . ' untuk mendownload template nilai sekolah.');
				}

				// link template default
				$template_default = 'content/template/nipel-flexible-2013.xlsx';

				if (file_ada($template_default))
				{
					echo p('class="help-block"', 'Klik ' . a($template_default, 'disini', 'target="_blank"') . ' untuk mendownload template nilai default.');
				}

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