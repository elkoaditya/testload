<?php

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM' => 'kbm',
	'Evaluasi' => 'kbm/evaluasi',
	"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
);

// input data

$input = array(
		'nama' => array(
				'nama',
				'label' => 'Nama / Judul',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'input input-xxlarge',
				'placeholder' => 'isikan nama/judul kompetensi evaluasi',
				'title' => 'nama/kompetensi',
		),
		'soal_jml' => array(
				'soal_jml',
				'label' => 'Jumlah Muncul<br>(*isi 0 untuk tampil semua )',
				'type' => 'input',
				'name' => 'soal_jml',
				'id' => 'soal_jml',
				'class' => 'input input-large',
				'placeholder' => 'isikan jumlah soal evaluasi',
				'title' => 'jumlah soal',
		),
);

if($evaluasi['status']=='published'){	
	$input['soal_jml']['disabled'] = 'true';
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
					Edit Soal Bagian <?=$_GET['posisi_kd']?>:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke detail evaluasi"'); ?></h1>
				</div>

				<?php
				//echo"AAA";
				//	print_r($row);
				//echo"BBB";
				echo alert_get();
				echo form_openmp("{$uri}?evaluasi_id=".$this->input->get('evaluasi_id')."&posisi_kd=".$this->input->get('posisi_kd'), 'class="form-horizontal well"');
				echo '<fieldset>';
				
				// input 
				echo '<input type="hidden" name="evaluasi_id" value="'.$this->input->get('evaluasi_id').'">';
				echo '<input type="hidden" name="posisi_kd" value="'.$this->input->get('posisi_kd').'">';
				if($row==''){
					$row['nama']='';
					$row['soal_jml']='';
				}
				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;
				

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

	<!--</body>
</html>-->