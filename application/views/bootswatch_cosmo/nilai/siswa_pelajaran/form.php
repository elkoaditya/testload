<?php

// vars
$url_nilsis = "nilai/siswa/id/" . $row['siswa_nilai_id'];
$url_nilpel = "nilai/pelajaran/id/" . $row['pelajaran_nilai_id'];

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai'							 => '',
	'Siswa'							 => 'nilai/siswa',
	'#' . $row['siswa_nilai_id']	 => $url_nilsis,
	'#' . $row['id'],
);

// pills link

$pills[] = array(
	'label'	 => 'Tabel Nilai',
	'uri'	 => "nilai/siswa",
	'attr'	 => 'title="kembali ke tabel nilai siswa"',
);

$pills[] = array(
	'label'	 => 'Nilai Siswa',
	'uri'	 => $url_nilsis,
	'attr'	 => 'title="kembali ke detail nilai siswa (rapor)"',
);

// input data

$input = array(
	'___'		 => array(
		'___' => array(
			'____',
			'label'			 => '___',
			'type'			 => 'input',
			'name'			 => '___',
			'id'			 => '___',
			'title'			 => '___',
			'placeholder'	 => '___',
			'class'			 => 'input input-medium',
		),
	),
	'nas'		 => array(
		'nas_teori'		 => array(
			'nas_teori',
			'label'			 => 'Pengetahuan',
			'type'			 => 'input',
			'name'			 => 'nas_teori',
			'id'			 => 'nas_teori',
			'placeholder'	 => 'nilai angka',
			'title'			 => 'nilai angka',
			'class'			 => 'input input-medium',
			'suffix'		 => array(
				'pred_teori' => array(
					'pred_teori',
					'type'			 => 'input',
					'name'			 => 'pred_teori',
					'id'			 => 'pred_teori',
					'placeholder'	 => 'predikat',
					'title'			 => 'predikat',
					'class'			 => 'input input-medium',
				),
			),
		),
		'nas_praktek'	 => array(
			'nas_praktek',
			'label'			 => 'Keterampilan',
			'type'			 => 'input',
			'name'			 => 'nas_praktek',
			'id'			 => 'nas_praktek',
			'placeholder'	 => 'nilai angka',
			'title'			 => 'nilai angka',
			'class'			 => 'input input-medium',
			'suffix'		 => array(
				'pred_praktek' => array(
					'pred_praktek',
					'type'			 => 'input',
					'name'			 => 'pred_praktek',
					'id'			 => 'pred_praktek',
					'placeholder'	 => 'predikat',
					'title'			 => 'predikat',
					'class'			 => 'input input-medium',
				),
			),
		),
		'nas_sikap'		 => array(
			'nas_sikap',
			'label'			 => 'Sikap',
			'type'			 => 'input',
			'name'			 => 'nas_sikap',
			'id'			 => 'nas_sikap',
			'placeholder'	 => 'nilai angka',
			'title'			 => 'nilai angka',
			'class'			 => 'input input-medium',
			'suffix'		 => array(
				'pred_sikap' => array(
					'pred_sikap',
					'type'			 => 'input',
					'name'			 => 'pred_sikap',
					'id'			 => 'pred_sikap',
					'placeholder'	 => 'predikat',
					'title'			 => 'predikat',
					'class'			 => 'input input-medium',
				),
			),
		),
	),
	'mid'		 => array(
		'mid_teori'		 => array(
			'mid_teori',
			'label'			 => 'Pengetahuan',
			'type'			 => 'input',
			'name'			 => 'mid_teori',
			'id'			 => 'mid_teori',
			'placeholder'	 => 'nilai angka',
			'title'			 => 'nilai angka',
			'class'			 => 'input input-medium',
			'suffix'		 => array(
				'mid_pred_teori' => array(
					'mid_pred_teori',
					'type'			 => 'input',
					'name'			 => 'mid_pred_teori',
					'id'			 => 'mid_pred_teori',
					'placeholder'	 => 'predikat',
					'title'			 => 'predikat',
					'class'			 => 'input input-medium',
				),
			),
		),
		'mid_praktek'	 => array(
			'mid_praktek',
			'label'			 => 'Keterampilan',
			'type'			 => 'input',
			'name'			 => 'mid_praktek',
			'id'			 => 'mid_praktek',
			'placeholder'	 => 'nilai angka',
			'title'			 => 'nilai angka',
			'class'			 => 'input input-medium',
			'suffix'		 => array(
				'mid_pred_praktek' => array(
					'mid_pred_praktek',
					'type'			 => 'input',
					'name'			 => 'mid_pred_praktek',
					'id'			 => 'mid_pred_praktek',
					'placeholder'	 => 'predikat',
					'title'			 => 'predikat',
					'class'			 => 'input input-medium',
				),
			),
		),
		'mid_sikap'		 => array(
			'mid_sikap',
			'label'			 => 'Sikap',
			'type'			 => 'input',
			'name'			 => 'mid_sikap',
			'id'			 => 'mid_sikap',
			'placeholder'	 => 'nilai angka',
			'title'			 => 'nilai angka',
			'class'			 => 'input input-medium',
			'suffix'		 => array(
				'mid_pred_sikap' => array(
					'mid_pred_sikap',
					'type'			 => 'input',
					'name'			 => 'mid_pred_sikap',
					'id'			 => 'mid_pred_sikap',
					'placeholder'	 => 'predikat',
					'title'			 => 'predikat',
					'class'			 => 'input input-medium',
				),
			),
		),
	),
	'ulangan'	 => array(
		'uas'	 => array(
			'uas',
			'label'			 => 'UAS',
			'type'			 => 'input',
			'name'			 => 'uas',
			'id'			 => 'uas',
			'placeholder'	 => 'ulangan akhir semester',
			'title'			 => 'ulangan akhir semester',
			'class'			 => 'input input-medium',
		),
		'uts'	 => array(
			'uts',
			'label'			 => 'UTS',
			'type'			 => 'input',
			'name'			 => 'uts',
			'id'			 => 'uts',
			'placeholder'	 => 'ulangan tengah semester',
			'title'			 => 'ulangan tengah semester',
			'class'			 => 'input input-medium',
		),
	),
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Nilai Pelajaran Siswa')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Nilai Pelajaran Siswa</h1>
				</div>

				<style>
					.noinput
					{
						padding: 5px;
					}

				</style>
				<?php

				echo alert_get();
				echo pills($pills);
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal"');

				// info rapor

				echo '<fieldset class="well">';
				echo '<legend>Informasi Umum</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Semester</label>";
				echo div('class="controls noinput"', $row['semester_nama'] . ' ' . $row['ta_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Nama Siswa</label>";
				echo div('class="controls noinput"', $row['siswa_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Kelas</label>";
				echo div('class="controls noinput"', $row['kelas_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Mata Pelajaran</label>";
				echo div('class="controls noinput"', $row['mapel_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Nama Pengampu</label>";
				echo div('class="controls noinput"', $row['guru_nama']);
				echo "</label></div>" . NL;

				echo '</fieldset>';

				// nilai akhir semester

				echo '<fieldset class="well">';
				echo '<legend>Nilai Akhir Semester</legend>';

				foreach ($input['nas'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset>';

				// nilai mid semester

				echo '<fieldset class="well">';
				echo '<legend>Nilai Mid Semester</legend>';

				foreach ($input['mid'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset>';

				// nilai ulangan umum

				echo '<fieldset class="well">';
				echo '<legend>Nilai Ulangan Umum</legend>';

				foreach ($input['ulangan'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset>';

				?>

				<fieldset>
					<div class="form-actions well">
						<button type="submit" class="btn btn-success input-xxlarge" name="redir" value="nilai_pelajaran">
							<i class="icon-save icon-white"></i> Simpan &AMP; kembali ke Nilai-Pelajaran
						</button>
						&nbsp; &nbsp;
						<?= a($url_nilpel, ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke nilai pelajaran', 'class="btn btn-info input-xlarge "'); ?>
						<br/><br/>
						<button type="submit" class="btn btn-success input-xxlarge" name="redir" value="nilai_siswa">
							<i class="icon-save icon-white"></i> Simpan &AMP; kembali ke Nilai-Siswa
						</button>
						&nbsp; &nbsp;
						<?= a($url_nilsis, ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke nilai siswa', 'class="btn btn-info input-xlarge "'); ?>
						<br/><br/>
					</div>
				</fieldset>

				<?= form_close(); ?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>