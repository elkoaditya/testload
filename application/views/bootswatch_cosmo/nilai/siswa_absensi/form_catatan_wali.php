<?php

// vars
$url_nilsis = "nilai/siswa/id/" . $row['id'];

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai'							 => '',
	'Siswa'							 => 'nilai/siswa',
	'#' . $row['id']	 => $url_nilsis,
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
	'catatan'		 => array(
		'note_walikelas' => array(
			'note_walikelas',
			'label'			 => 'Catatan WaliKelas',
			'type'			 => 'textarea',
			'rows' 			 => 4,
			'name'			 => 'note_walikelas',
			'id'			 => 'note_walikelas',
			'placeholder'	 => 'keterangan',
			'title'			 => 'keterangan',
			'class'			 => 'input input-xxlarge',
		),
	),
	
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Catatan WaliKelas Siswa')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Catatan WaliKelas Siswa</h1>
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
				echo "<label class=\"control-label\">Nama Wali</label>";
				echo div('class="controls noinput"', $row['wali_nama']);
				echo "</label></div>" . NL;


				echo '</fieldset>';

				// nilai akhir semester

				echo '<fieldset class="well">';
				echo '<legend>Catatan WaliKelas</legend>';

				foreach ($input['catatan'] as $inp):
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