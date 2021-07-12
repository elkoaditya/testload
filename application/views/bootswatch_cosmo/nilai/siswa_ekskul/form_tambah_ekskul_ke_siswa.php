<?php

// vars
$url_nilsis = "nilai/siswa/id/" . $siswa_nilai_id;
$row = array();
$query_siswa = array(
	'select' => array(
		'siswa_nama'	 => 'siswa.nama',
		'semester_nama'	 => 'semester.nama',
		'ta_nama'		 => 'ta.nama',
		'kelas_nama'	 => 'kelas.nama',
	),
	'from'	 => 'nilai_siswa nilsis',
	'join'	 => array(
		array('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'inner'),
		array('prd_semester semester', 'nilsis.semester_id = semester.id', 'left'),
		array('prd_ta ta', 'semester.ta_id = ta.id', 'left'),
		array('dakd_kelas kelas', 'nilsis.kelas_id = kelas.id', 'left'),
	),
	'where'	 => array(
		'nilsis.id' => $siswa_nilai_id,
	),
);
$siswa = $this->md->query($query_siswa)->row();

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai'							 => '',
	'Siswa'							 => 'nilai/siswa',
	'#' . $siswa_nilai_id			 => $url_nilsis,
	'#baru',
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
	'ekskul_nilai_id'	 => array(
		//'ekskul_nilai_id',
		'label'		 => 'Mapel',
		'type'		 => 'dropdown',
		'name'		 => 'ekskul_nilai_id',
		'id'		 => 'ekskul_nilai_id',
		'extra'		 => 'id="ekskul_nilai_id" class="input input-large select"',
		'options'	 => $this->m_option->_get(array(
			'value'	 => 'id',
			'label'	 => 'ekskul_nama',
			'query'	 => array(
				'select'	 => array(
					'nilkul.id',
					'ekskul_nama' => 'ekskul.nama',
				),
				'from'		 => 'nilai_ekskul nilkul',
				'join'		 => array(
					array('dnakd_ekskul ekskul', 'nilkul.ekskul_id = ekskul.id', 'inner'),
				),
				'order_by'	 => 'ekskul.nama',
				'where'		 => array(
					'nilkul.semester_id' => $semaktif['id'],
				),
			),
		)),
	),
	'ekskul'			 => array(
		'ekskul_id'	 => array(
			//'ekskul_nilai_id',
			'label'		 => 'Ekstrakurikuler',
			'type'		 => 'dropdown',
			'name'		 => 'ekskul_id',
			'id'		 => 'ekskul_id',
			'extra'		 => 'id="ekskul_id" class="input input-large select"',
			'options'	 => $this->m_option->_get(array(
				'value'	 => 'id',
				'label'	 => 'nama',
				'query'	 => array(
					'select'	 => array(
						'id', 'nama',
					),
					'from'		 => 'dnakd_ekskul ekskul',
					'order_by'	 => 'nama',
				),
			)),
		),
		'nilai'		 => array(
			//'nilai',
			'label'			 => 'Predikat',
			'type'			 => 'input',
			'name'			 => 'nilai',
			'id'			 => 'nilai',
			'placeholder'	 => 'predikat',
			'title'			 => 'predikat',
			'class'			 => 'input input-medium',
		),
		'keterangan' => array(
			//'keterangan',
			'label'			 => 'Keterangan',
			'type'			 => 'input',
			'name'			 => 'keterangan',
			'id'			 => 'keterangan',
			'placeholder'	 => 'predikat',
			'title'			 => 'predikat',
			'class'			 => 'input input-xxlarge',
		),
	),
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Nilai Ekstrakurikuler Siswa')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Tambah Ekstrakurikuler Siswa</h1>
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
				echo form_opening($uri, 'class="form-horizontal"');
				echo form_hidden('siswa_nilai_id', $siswa_nilai_id);

				// info rapor

				echo '<fieldset class="well">';
				echo '<legend>Informasi Umum</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Semester</label>";
				echo div('class="controls noinput"', $siswa['semester_nama'] . ' ' . $siswa['ta_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Nama Siswa</label>";
				echo div('class="controls noinput"', $siswa['siswa_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Kelas</label>";
				echo div('class="controls noinput"', $siswa['kelas_nama']);
				echo "</label></div>" . NL;

				echo '</fieldset>';

				// nilai akhir semester

				echo '<fieldset class="well">';
				echo '<legend>Tambahan Ekstrakurikuler</legend>';

				foreach ($input['ekskul'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset>';

				?>

				<fieldset>
					<div class="form-actions well">
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