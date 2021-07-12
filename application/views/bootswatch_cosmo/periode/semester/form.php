<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Periode' => 'periode',
		'Semester' => 'periode/semester',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "periode/semester/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => 'Semester Aktif',
		'uri' => "periode/semester",
		'attr' => 'title="kembali info semester aktif"',
);

// input data

$input = array(
		'term' => array(
				'term',
				'type' => 'dropdown',
				'name' => 'term',
				'id' => 'term',
				'label' => 'Periode Semester',
				'extra' => 'class="input input-medium" id="term"',
				'options' => array(
						'semester' => 'Semester',
						'trimester' => 'Trimester',
				//'quarter'=>'Quarter',
				//'minimester'=>'Minimester',
				),
		),
		'nama' => array(
				'nama',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'label' => 'Nama Semester',
				'class' => 'input input-medium',
				'suffix' => array(
						' ',
						array(
								'ta_nama',
								'type' => 'input',
								'name' => 'ta_nama',
								'id' => 'ta_nama',
								'class' => 'input input-medium',
								'disabled' => 'true',
						)
				),
		),
		'akhir' => array(
				'akhir',
				'date2tgl',
				'label' => 'Akhir Semester',
				'type' => 'input',
				'name' => 'akhir',
				'id' => 'akhir',
				'class' => 'input input-medium tanggal',
		),
		'kepsek_id' => array(
				'kepsek_id',
				'type' => 'dropdown',
				'name' => 'kepsek_id',
				'id' => 'kepsek_id',
				'label' => 'Kepala Sekolah',
				'extra' => 'class="input input-xlarge" id="kepsek_id"',
				'options' => $this->m_option->sdm(),
		),
);

$btn_back = a("periode/semester", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke semester aktif', 'class = "btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array(' title' => 'Startup Semester')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Semester</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_opening($uri, 'class="form-horizontal well"');

				// detail jurusan

				echo '<fieldset>';

				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				// form button

				echo '<div class = "form-actions well">'
				. '<button type = "submit" class = "btn btn-success"><i class = "icon-save icon-white"></i> Simpan</button> '
				. '<button type = "reset" class = "btn"><i class = "icon-undo icon-white"></i> Batal</button> &nbsp;&nbsp;'
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

		<script type="text/javascript">

			$(function() {
				$('.tanggal').datepicker({
					dateFormat: 'dd-mm-yy',
					dayNamesMin: ['Mgg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
					gotoCurrent: true,
					changeMonth: true,
					changeYear: true
				});
			});

		</script>

	</body>
</html>