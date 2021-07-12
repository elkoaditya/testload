<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Periode' => 'periode',
		'Semester' => 'periode/semester',
		'#tutup'
);

$btn_back = a("periode/semester", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke semester aktif', 'class = "btn btn-info "');

alert_info('<div align="center">Apakah benar Anda akan menutup semester ini ?</div>');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array(' title' => 'Tutup Semester')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Tutup Semester</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo form_opening($uri, 'class="form-horizontal well"');

				// form button

				echo '<div class = "form-actions well">'
				. '<button type = "submit" class = "btn btn-success"><i class = "icon-save icon-white"></i> Tutup</button> '
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

	</body>
</html>