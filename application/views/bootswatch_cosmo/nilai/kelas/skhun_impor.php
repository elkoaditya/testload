<?php

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai' => 'nilai',
	'Kelas' => 'nilai/kelas',
	"#{$row['id']}" => "nilai/kelas/id/{$row['id']}",
	'#impor'
);

// pills link

$pills[] = array(
	'label' => '<i class="icon-table"></i>Nilai kelas',
	'uri' => 'nilai/kelas',
	'attr' => 'title="kembali ke daftar nilai kelas"',
);
$pills[] = array(
	'label' => "<i class=\"icon-table\"></i>Nilai {$row['kelas_nama']}",
	'uri' => "nilai/kelas/id/{$row['id']}",
	'attr' => 'title="kembali ke detail nilai kelas"',
);

// buttons

$btn_back = a("nilai/kelas/id/{$row['id']}", "<i class=\"icon-circle-arrow-left icon-white\"></i> Kembali ke detail nilai {$row['kelas_nama']}", 'class="btn btn-info "');

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
					<h1>Impor Nilai SKHUN <?php echo $row['kelas_nama']; ?></h1>
				</div>

				<?php

				echo alert_get();
				echo pills($pills);

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