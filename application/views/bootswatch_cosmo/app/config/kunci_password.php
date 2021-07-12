<?php

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Config',
	'Kunci Password'
);

// input data

$input = array(
	'config_value',
	'label'	 => 'Kunci Password',
	'type'	 => 'input',
	'name'	 => 'config_value',
	'id'	 => 'config_value',
	'value'	 => $config_value,
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
					<h1>Konfigurasi Kunci Password</h1>
				</div>

				<p>
					Kunci password berfungsi sebagai umpan generator password.
					Jika isiannya berubah maka hasil password saat mereset password juga berubah.
				</p>

				<?php

				echo alert_get();
				echo form_opening("", 'class="form-horizontal well"');

				echo '<fieldset>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"{$input['id']}\">{$input['label']}</label>";
				echo div('class="controls"', form_cell($input));
				echo "</label></div>" . NL;

				echo '</fieldset><br/><br/>';

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
				. '</div>';
				echo '</fieldset>';

				echo form_close();

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>