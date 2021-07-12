<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		"Nilai" => "kbm/evaluasi_nilai/browse?evaluasi_id={$evaluasi['id']}",
		"LJS" => "kbm/evaluasi_ljs/browse?evaluasi_id={$evaluasi['id']}",
		"#{$row['id']}" => "kbm/evaluasi_ljs/id/{$row['id']}",
		'#koreksi',
);

// pills link

$pills_kiri[] = array(
		'label' => 'Detail Evaluasi',
		'uri' => "kbm/evaluasi/id/{$evaluasi['id']}",
		'attr' => 'title="kembali ke halaman detail evaluasi"',
);

$pills_kiri[] = array(
		'label' => 'Daftar Nilai',
		'uri' => "kbm/evaluasi_nilai/browse?evaluasi_id={$evaluasi['id']}",
		'attr' => 'title="kembali ke daftar nilai evaluasi"',
);

// tabel data

$dset['Nama'] = array('siswa_nama');
$dset['Kelas'] = 'kelas_nama';
$dset['Nilai'] = array('nilai');

// bars

$bar_pill = '<div>'
			. pills($pills_kiri)
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Koreksi Jawaban')); ?>

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
					<h1><?php echo strtoupper($evaluasi['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
				</style>

				<?php
				echo alert_get();
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal"');

				// data utama

				echo pills($pills);
				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/><br/>';

				foreach ($jawaban_result['data'] as $idx => $butir):
					echo '<div class="well">';
					echo '<fieldset>';
					echo "<legend>Pertanyaan ::&nbsp; " . ($idx + 1) . "</legend>";

					// detek gambar

					$gambar = array_node($butir, array('soal_gambar', 'full_path'));
					$gambar = ($gambar && file_exists($gambar)) ? webpath($gambar) : NULL;
					$kunci = array_node($butir, array('soal_pilihan', 'kunci'));

					if ($gambar)
						echo img(array('src' => $gambar, 'class' => 'soal-img'));

					// tampilkan pertanyaan

					echo div('class="soal-pertanyaan"', $butir['soal_pertanyaan']) . '<br/>';

					// tampilkan jawaban siswa

					echo '<table class="table table-bordered table-striped table-hover">' . NL;
					echo "<tr><td><b>Jawaban:</b><br/>{$butir['jawaban']}</td></tr>";

					if (!empty($kunci))
						echo "<tr><td><b>Kunci:</b><br/>{$kunci}</td></tr>";

					$name = "poin-{$butir['soal_id']}";
					$input_poin = array(
							'poin',
							'type' => 'input',
							'name' => $name,
							'id' => $name,
							'class' => 'input input-small',
							'value' => (int) (($post_request) ? $this->input->post($name) : $butir['poin']),
					);

					echo "<tr><td>";

					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$name}\">Poin</label>";
					echo div('class="controls"', form_cell($input_poin, $butir) . "&nbsp; <i>( range : {$butir['soal_poin_min']} - {$butir['soal_poin_max']} )</i>");
					echo "</div>" . NL;

					echo "</td></tr>";
					echo '</table>';
					echo ' </fieldset></div><br/><br/>';

				endforeach;

				// form button

				echo '<fieldset>';
				echo '<div class = "form-actions well">'
				. ' <button type = "submit" class = "btn btn-success btn-large"><i class = "icon-save icon-white"></i> Simpan Jawaban</button> '
				. ' </div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>