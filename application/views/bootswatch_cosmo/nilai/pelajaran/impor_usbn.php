<?php

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai' => 'nilai',
	'Pelajaran' => 'nilai/pelajaran',
	"#{$row['id']}" => "nilai/pelajaran/id/{$row['id']}",
	'#impor'
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

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Impor Nilai')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Impor Nilai <?php echo $row['pelajaran_nama']; ?></h1>
				</div>

				<?php

				echo alert_get();
				echo pills($pills);

				echo div('class="well"');

				echo '<fieldset>';
				echo '<legend>Arsip Nilai</legend>';

				// cek arsip nilai
				$arsip = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/{$row['id']}/nilai_usbn.xlsx";
				$uri_arsip = "content/".strtolower(APP_SCOPE)."/nilai-pelajaran/{$row['id']}/nilai_usbn.xlsx";

				if (file_ada($arsip))
				{
					echo p(
						'class="help-block"', a($uri_arsip, 'Download Arsip Nilai Terakhir', 'class="btn btn-info"')
					);
				}
				else
				{
					echo p(
						'class="help-block"', 'belum ada arsip nilai'
					);
				}

				echo p(
					'class="help-block"', 'Klik '
					. a("nilai/pelajaran/expor_usbn/{$row['id']}", 'disini')
					. ' untuk mendownload (format) data nilai yang ada.'
				);

				echo '</fieldset>';
				echo '</div>';
				
				
				$uri = $uri.'/'.$row['id'];
				echo form_openmp("{$uri}", 'class="form-horizontal well"');

				// upload

				echo '<fieldset>';
				echo '<legend>Pilih berkas yg ingin diimpor</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('upload', '', 'id="upload"');
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