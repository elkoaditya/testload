<?php

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Nilai' => 'nilai',
		'Siswa' => 'nilai/siswa',
		'#Catatan Download Siswa'
);

// pills link

$pills[] = array(
		'label' => '<i class="icon-table"></i>Nilai Siswa',
		'uri' => 'nilai/siswa',
		'attr' => 'title="kembali ke daftar nilai siswa"',
);

// buttons

$btn_back = a("nilai/siswa", "<i class=\"icon-circle-arrow-left icon-white\"></i> Kembali ke daftar nilai siswa ", 'class="btn btn-info "');

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Catatan Download Siswa')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Catatan Download Siswa</h1>
				</div>

				<?php

				echo alert_get();
				echo pills($pills);

				
				// download

				echo form_openmp("{$uri}/format", 'class="form-horizontal well"');

				echo '<fieldset>';
				echo '<legend>Download format import</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">Pilih kelas</label>";
				echo div('class="controls"');

				foreach ($opsi_kelas as $kelas_id => $kelas_nama):
					echo "<label class=\"checkbox\">"
					. form_checkbox(array(
							'name' => 'kelas[]',
							'id' => 'kelas-' . $kelas_id,
							'value' => $kelas_id,
							'checked' => TRUE,
					))
					. $kelas_nama
					. "</label>";
				endforeach;

				echo "</div>" . NL;
				echo "</label></div>" . NL;
				echo '</fieldset>';

				// form button

				echo '<div class="form-actions">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-download icon-white"></i> Download</button> ';
				echo '</div>';
				echo '</fieldset>';

				echo form_close() . '<br/><br/><br/>';

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>