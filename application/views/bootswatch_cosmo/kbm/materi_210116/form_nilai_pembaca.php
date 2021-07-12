<?php

// vars
$url_nilkel = "kbm/materi/id/" . $row['materi_id'];

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => '',
	'Kelas'							 => 'kbm/materi',
	'#' . $row['materi_id']	 => $url_nilkel,
	'#' . $row['id'],
);

// pills link


$pills[] = array(
	'label'	 => 'Materi',
	'uri'	 => $url_nilkel,
	'attr'	 => 'title="kembali ke detail Materi"',
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
	'nilai'		 => array(
		
		'nilai'	 => array(
			'nilai',
			'label'			 => 'Nilai Pembaca',
			'type'			 => 'input',
			'name'			 => 'nilai',
			'id'			 => 'nilai',
			'placeholder'	 => 'nilai materi',
			'title'			 => 'nilai materi',
			'class'			 => 'input input-medium',
			
		),
	),
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'KBM Pelajaran Siswa')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Nilai Materi</h1>
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
				echo "<label class=\"control-label\">Nama Siswa</label>";
				echo div('class="controls noinput"', $row['siswa_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Kelas</label>";
				echo div('class="controls noinput"', $row['kelas_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Materi</label>";
				echo div('class="controls noinput"', $row['materi_nama']);
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\">Pertanyaan</label>";
				echo div('class="controls noinput"', base64_decode($row['pertanyaan']));
				echo "</label></div>" . NL;
				
				echo div('class="control-group"');
				echo "<label class=\"control-label\">Jawaban</label>";
				echo div('class="controls noinput"', base64_decode($row['respon_jawaban']));
				echo "</label></div>" . NL;

				
				echo '</fieldset>';

				// KBM akhir semester

				echo '<fieldset class="well">';
				echo '<legend>Nilai Materi</legend>';

				foreach ($input['nilai'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset>';

				
				echo '</fieldset>';

				?>

				<fieldset>
					<div class="form-actions well">
						
						<button type="submit" class="btn btn-success input-xxlarge" name="redir" value="KBM_siswa">
							<i class="icon-save icon-white"></i> Simpan
						</button>
						&nbsp; &nbsp;
						<?= a($url_nilkel, ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke Materi', 'class="btn btn-info input-xlarge "'); ?>
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