<?php

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Config',
	'Kunci Password'
);

// input data
$jml_key = 0;
foreach ($config_value['data'] as $key => $value) {
	$input_mid[$key] = array(
		'config_value',
		'label'	 => $value['nama_kelas'],
		'type'	 => 'input',
		'name'	 => 'config_value_mid['.$value['nilai_kelas_id'].']',
		'id'	 => 'config_value_mid['.$value['nilai_kelas_id'].']',
		'value'	 => $value['tanggal_mid_new'],
	);
	$input_uas[$key] = array(
		'config_value',
		'label'	 => $value['nama_kelas'],
		'type'	 => 'input',
		'name'	 => 'config_value_uas['.$value['nilai_kelas_id'].']',
		'id'	 => 'config_value_uas['.$value['nilai_kelas_id'].']',
		'value'	 => $value['tanggal_uas_new'],
	);
	if($value['grade_kelas']==12){
		$input_mutasi[$key] = array(
			'config_value',
			'label'	 => $value['nama_kelas'],
			'type'	 => 'input',
			'name'	 => 'config_value_mutasi['.$value['nilai_kelas_id'].']',
			'id'	 => 'config_value_mutasi['.$value['nilai_kelas_id'].']',
			'value'	 => $value['tanggal_mutasi'],
		);
	}
	$jml_key++;
}
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
					<h1>Konfigurasi Tanggal Rapor</h1>
				</div>

				<p>
					Konfigurasi tanggal rapor hanya bisa diperbaruhi pada semester yang aktif saja.
				</p>

				<?php
			///	echo '<pre>';
			////print_r($config_value);
			///	echo '</pre>';
				echo alert_get();
				echo form_opening("", 'class="form-horizontal well"');

				echo '<fieldset> MID';
	
				foreach ($input_mid as $key => $value) {
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$value['id']}\">{$value['label']}</label>";
					echo div('class="controls"', form_cell($value));
					echo "</label></div>" . NL;
				}
				
				echo '</fieldset><br/><br/>';

				echo '<fieldset> UAS';
	
				foreach ($input_uas as $key => $value) {
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$value['id']}\">{$value['label']}</label>";
					echo div('class="controls"', form_cell($value));
					echo "</label></div>" . NL;
				}
				
				echo '</fieldset><br/><br/>';
					
				echo '<fieldset> MUTASI';
	
				foreach ($input_mutasi as $key => $value) {
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$value['id']}\">{$value['label']}</label>";
					echo div('class="controls"', form_cell($value));
					echo "</label></div>" . NL;
				}
				
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