<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		"Nilai" => "kbm/evaluasi_nilai/browse?evaluasi_id={$evaluasi['id']}",
		"LJS" => "kbm/evaluasi_ljs/browse?evaluasi_id={$evaluasi['id']}",
		"#{$row['id']}",
);

// pills link

$pills_kiri['evaluasi_browse'] = array(
		'label' => 'Daftar Evaluasi',
		'uri' => "kbm/evaluasi",
		'attr' => 'title="kembali ke daftar evaluasi"',
);
$pills_kiri['evaluasi_id'] = array(
		'label' => 'Detail Evaluasi',
		'uri' => "kbm/evaluasi/id/{$evaluasi['id']}",
		'attr' => 'title="kembali ke detail evaluasi"',
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
					Koreksi Lembar Jawab Soal :<br/>
					<h1><?php echo strtoupper($evaluasi['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					.pengecoh{
						display: none;
					}
				</style>

				<?php
				echo alert_get();
				echo $bar_pill;
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal"');

				// data utama

				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label>"
					. "<div class=\"controls\">" . data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/><br/>';

				foreach ($butir_result['data'] as $idx => $butir):
					soal_prepjwb($butir);

					echo '<div class="form-horizontal well">';
					echo '<fieldset>';
					echo "<legend>Pertanyaan ::&nbsp; " . ($idx + 1) . "</legend>";

					// tampilkan pertanyaan

					echo div('class="soal-pertanyaan"', $butir['pertanyaan']) . '<br/>';

					// poin

					$name = "poin-{$butir['id']}";
					$input_poin = array(
							'jwb_poin',
							'type' => 'dropdown',
							'name' => $name,
							'id' => $name,
							'value' => (int) (($post_request) ? $this->input->post($name) : $butir['jwb_poin']),
							'extra' => "class=\"input-large select\" id=\"{$name}\"",
					);

					for ($i = $butir['poin_min']; $i <= $butir['poin_max']; $i++)
						$input_poin['options'][$i] = $i;

					echo div('class="control-group"');
					echo "<b>Poin: </b>";
					echo form_cell($input_poin, $butir) . " &nbsp; <i>( range : {$butir['poin_min']} - {$butir['poin_max']} )</i>";
					echo "</div>" . NL;

					// jawaban

					echo "<div><b>Jawaban:</b>";
					echo ul(array($butir['jwb_jawaban']));
					echo "</div>";

					// pilihan, bila ada

					if ($butir['pilihan']):

						echo "<div><b>Kunci:</b>";
						echo ul(array($butir['pilihan']['kunci']['label']));
						echo "</div>";

						echo "<div>";
						echo "<div class=\"btn btn-info btn-small\" onClick=\"$('#pengecoh-{$butir['id']}').slideToggle(200);\">Pengecoh</div>";
						echo ul($butir['pilihan']['pengecoh'], "id=\"pengecoh-{$butir['id']}\" class=\"pengecoh\"");
						echo "</div>";

					endif;

					echo '<fieldset>';
					echo "</div>";

				endforeach;

				// form button

				echo '<fieldset>';
				echo '<div class = "form-actions well">'
				. ' <button type = "submit" class = "btn btn-success btn-large"><i class = "icon-save icon-white"></i> Simpan Skor Jawaban</button> '
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