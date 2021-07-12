<?php

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Tool',
	'Reset Password SDM'
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Konfigurasi')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Reset Password Guru &amp; SDM</h1>
				</div>

				<p class="alert">
					Apa Anda yakin akan mereset semua password guru dan SDM??
				</p>

				<?php

				echo alert_get();
				/*echo form_opening("", 'class="form-horizontal well"');
				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success" onclick="return confirm(\'Apakah yakin Reset Password GURU ?\')">
				<i class="icon-save icon-white" ></i> GO Reset Password GURU</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; <br><br>'
				
				echo '</fieldset>';

				echo form_close();
				*/
				echo
				a("/app/tool/reset_password_sdm_new", '<i class="icon-download"></i> GO Reset Password Guru', 'class="btn btn-success" title="reset password guru" target="_blank"') . " &nbsp; "
				.'<br><br>'
				. a("/app/tool/print_password_sdm", '<i class="icon-download"></i> Download Hasil Reset Password GURU <br/>(*jika kosong maka belum di reset login)', 'class="btn btn-primary" title="cetak password guru" target="_blank"') . " &nbsp; "
				. '</div>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>