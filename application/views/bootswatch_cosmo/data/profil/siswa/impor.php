<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		(GURU_ALIAS) . ' &amp; SDM' => 'data/profil/sdm',
		'#impor ' . strtolower(GURU_ALIAS)
);

// pills link

$pills[] = array(
		'label' => 'Tabel ' . (GURU_ALIAS) . ' &amp; SDM',
		'uri' => "data/profil/sdm",
		'attr' => 'title="kembali ke tabel ' . strtolower(GURU_ALIAS) . ' dan sdm"',
);
$pills[] = array(
		'label' => 'Form ' . (GURU_ALIAS) . ' &amp; SDM',
		'uri' => "data/profil/sdm/form",
		'attr' => 'title="tambah profil ' . strtolower(GURU_ALIAS) . '/sdm baru"',
);

// buttons

$btn_back = a("data/profil/sdm", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel ' . strtolower(GURU_ALIAS) . ' / sdm', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Impor ' . (GURU_ALIAS))); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Impor <?php echo GURU_ALIAS; ?></h1>
				</div>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_openmp("", 'class="form-horizontal well"');

				// profil pribadi

				echo '<fieldset>';
				echo '<legend>Pilih berkas yg ingin diimpor</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('upload', '', 'id="upload"');
				echo p('class="help-block"', 'download formatnya ' . a("content/template/data-profil-sdm-guru.xls", 'disini'));
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