<?php
// vars
//
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$row['id']}" => "kbm/evaluasi/id/{$row['id']}",
		'Rekap'
);

// pills link
// input data
$opsi_kelasid = array();
foreach ($row['kelas_result']['data'] as $rkelas):
	$opsi_kelasid[$rkelas['kelas_id']] = $rkelas['kelas_nama'];
endforeach;

$input['umum'] = array(
		'kolom' => array(
				'kolom',
				'type' => 'dropdown',
				'name' => 'kolom',
				'id' => 'kolom',
				'label' => 'Kolom Nilai',
				'extra' => 'class="input-large select"',
				'options' => 'kolom_list',
		),
		'kelas_id'	 => array(
			'pelajaran_id',
			'type'		 => 'dropdown',
			'name'		 => 'kelas_id',
			'id'		 => 'kelas_id',
			'label' 	 => 'Kelas',
			'options'	 =>  $opsi_kelasid,
			'extra'		 => 'class="input-large select"',
		),
);
// buttons

$btn_back = a("kbm/evaluasi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan evaluasi', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Rekap Nilai Evaluasi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Rekap Nilai Evaluasi</h1>
				</div>

				<style>
					#detail-tambahan{
						display: none;
					}
					.subinfo{
						font-size: 0.8em;
						opacity: 0.8;
						font-style: italic;
					}
				</style>

				<?php
				echo alert_get();
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
				echo '<fieldset>'; 
				echo '<legend>Pilih kolom rekap untuk menyimpan nilai.</legend>';

// input umum

				foreach ($input['umum'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '*data nilai sebelumnya pada kolom yang dipilih akan ditimpa, tidak bisa dikembalikan.';

// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Rekap</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
				. $btn_back
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