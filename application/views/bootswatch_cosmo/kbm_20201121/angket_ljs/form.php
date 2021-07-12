<?php
// vars
$array_angka['a'] = 1;
$array_angka['b'] = 2;
$array_angka['c'] = 3;
$array_angka['d'] = 4;
$array_angka['e'] = 5;

$author_ybs = ($angket['author_id'] == $user['id']);
$editable = (($author_ybs OR $admin) && !$angket['closed'] && $angket['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$angket['published']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$angket['id']}" => "kbm/angket/id/{$angket['id']}",
		"LJS" => "kbm/angket_ljs/browse?angket_id={$angket['id']}",
		'#pengerjaan',
);

// input data

$input_essay = array(
		'type' => 'textarea',
		'class' => 'input tinymce_mini',
);
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Pengerjaan Angket')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header alert-block">
					Lembar Jawab Soal :<br/>
					<h1><?php echo strtoupper($angket['nama']) ?></h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();

				if ($user['role'] == 'siswa'):
					echo form_opening("{$uri}/{$user['menilai_id']}?id={$angket['id']}", 'class="form-horizontal"');
				endif;

				foreach ($soal_result['data'] as $idx => $soal):
					soal_angket_prepljs($soal);

					echo '<div class="well">';
					echo '<fieldset>';
					echo "<legend>Pertanyaan ::&nbsp; " . ($idx + 1) . "</legend>";

					// tampilkan pertanyaan

					echo div('class="soal-pertanyaan"', $soal['pertanyaan']) . '<br/>';

					// tampilkan isian siswa

					if ($angket['pilihan_jml'] > 1 && is_array($soal['opsi'])):
						echo '<table class="table table-bordered table-striped table-hover">' . NL;
						$no_poin = 1;
						foreach ($soal['opsi'] as $key => $opsi):
							$name = "butir-{$soal['id']}";
							$radio = array(
									'name' => $name,
									'id' => $name . '-' . $key,
									'value' => $key ,
									'checked' => ($this->input->post($name) == $key),
							);
							echo '<tr><td>';

							echo "<label class=\"radio\">"
							. div('class="soal-opsi"', form_radio($radio) . $opsi. '(point ' . $soal['poin_'.$array_angka[$key]].')')
							. "</label>" . NL;

							echo '</td></tr>';
							$no_poin++;
						endforeach;

						echo '</table>';

					else:
						$input_essay['id'] = "butir-{$soal['id']}";
						$input_essay['name'] = "butir-{$soal['id']}";
						$input_essay['value'] = (!$post_request) ? '' : html_entity_decode($this->input->post($input_essay['name']));

						echo form_cell($input_essay);

						if ($angket['pilihan_jml'] > 1 && !is_array($soal['opsi'])):
							echo '<div class="label label-warning">Terjadi kesalahan pada opsi pilihan.<br/>';

							if ($editable)
								echo 'Klik ' . a("kbm/angket_soal/form?id={$soal['id']}", 'disini', '') . ' untuk merubah daftar opsi/pilihan. ';

							if ($deletable)
								echo 'Klik ' . a("kbm/angket_soal/delete?id={$soal['id']}", 'disini', '') . ' untuk menghapus butir soal. ';

							echo '</div>';

						endif;

					endif;

					echo ' </fieldset></div><br/><br/>';

				endforeach;

				// form button

				if ($user['role'] == 'siswa'):

					echo '<fieldset>';
					echo '<div class = "form-actions well">'
					. ' <button type = "submit" class = "btn btn-success btn-large"><i class = "icon-save icon-white"></i> Simpan Jawaban</button> '
					. ' </div>';
					echo '</fieldset>';

					echo form_close();

				endif;
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		addon('tinymce');
		?>

	</body>
</html>