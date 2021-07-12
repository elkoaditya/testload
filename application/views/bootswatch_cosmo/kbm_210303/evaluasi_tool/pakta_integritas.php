<?php

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Pakta Integeritas',	
);

// input data

$input = array(
	'pakta_integritas',
	//'html_entity_decode',
	'label'		 => 'Silahkan Tulis Ulang Pakta Integritas',
	'type'			 => 'textarea',
	'name'			 => 'pakta_integritas',
	'id'			 => 'pakta_integritas',
	'class'			 => 'input input-xxlarge ',
	'placeholder'	 => 'isi Pakta Integritas',
	'value'		 => '',
	
);
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Pakta Integritas')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Isi Pakta Integritas</h1>
				</div>

				<?php

				echo alert_get();
				echo form_opening("", 'class="form-horizontal well"');

				echo "<input type='hidden' name='id' value='".$this->input->get('id')."'>";
				echo '<fieldset>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" >Pakta Intergitas</label>";
				echo div('class="controls"', "<b>".$keterangan_pakta_integritas."</b>");
				echo "</label></div>" . NL;
				
				
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

		<?php
		echo cosmo_js();
		//echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		//echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		
		//addon('tinymce');
		?>

		

	</body>
</html>