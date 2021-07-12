<?php
// vars

$pengecoh_jml = $angket['pilihan_jml'] ;

// pindahkan opsi/pilihan ke variabel semestera saat load pertama

if ($pengecoh_jml > 1):
	$row['pilihan'] = (array) $row['pilihan'];
/*
	if (isset($row['pilihan']['kunci']) && is_array($row['pilihan']['kunci']) && !$post_request):
		foreach ($row['pilihan']['kunci'] as $opsi):
			$pilihan['kunci'] = $opsi;
		endforeach;
	endif;
*/
	if (isset($row['pilihan']['pengecoh']) && is_array($row['pilihan']['pengecoh']) && !$post_request):
		$i = 0;
		foreach ($row['pilihan']['pengecoh'] as $opsi):
			$i++;
			$pengecoh_index = "pilihan-" . $i;
			$pilihan[$pengecoh_index] = $opsi;
			//echo $pilihan[$pengecoh_index];
		endforeach;
	endif;
	
endif;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$angket['id']}" => "kbm/angket/id/{$angket['id']}",
		'Soal' => "kbm/angket_soal/browse?angket_id={$angket['id']}",
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/angket_soal/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link
// input data

$input_pertanyaan = array(
		'pertanyaan',
		//'html_entity_decode',
		'type' => 'textarea',
		'name' => 'pertanyaan',
		'id' => 'pertanyaan',
		'class' => 'input tinymce_soal',
		'style' => 'height: 200px;',
);
/*
$input_poin = array(
		'poin_max',
		'type' => 'input',
		'name' => 'poin_max',
		'id' => 'poin_max',
		'class' => 'input input-medium',
		'placeholder' => '1 - 100',
		'title' => 'bobot / poin pertanyaan',
);
*/
$input_poin = array(
		'type' => 'input',
		'class' => 'input input-medium',
		'placeholder' => '1 - 100',
		'title' => 'bobot / poin pertanyaan',
);
$input_opsi = array(
		'type' => 'textarea',
		'class' => 'input tinymce_opsi',
		'style' => 'height: 80px;'
);

$btn_back = a("kbm/angket/id/{$angket['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail angket', 'class="btn btn-info "');

alert_info("Soal tersimpan saat ini :: {$angket['soal_total']}");
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Soal')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Form Soal Angket:
					<h1><?php echo a("kbm/angket/id/{$angket['id']}", strtoupper($angket['nama']), 'title="kembali ke detail angket"'); ?></h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo form_opening("{$uri}?id={$row['id']}&angket_id={$angket['id']}", 'class="form-horizontal well"');

				// data umum

				echo '<fieldset>';
				echo '<legend>Soal / Pertanyaan</legend>';

				echo div('class="control-group"');
				//echo "<label class=\"control-label\" for=\"poin_max\">Skor / Poin</label>";
				//echo div('class="controls"', form_cell($input_poin, $row));
				echo "</div>" . NL;

				echo form_cell($input_pertanyaan, $row);
				echo '<br/><br/><br/>';

				// pilihan

				if ($pengecoh_jml > 1):
					echo '<legend>Opsi / Pilihan</legend>';

					/*$input_opsi['id'] = 'kunci';
					$input_opsi['name'] = 'kunci';
					$input_opsi['value'] = html_entity_decode($pilihan['kunci']);

					echo "<b>Kunci</b>";
					echo form_cell($input_opsi);
					echo '<br/><br/>';
					*/
					for ($i = 1; $i <= $pengecoh_jml; $i++):
						$input_poin['name'] = "poin_". $i;
						$input_poin['id'] = "poin_". $i;
						$input_poin['value'] = $row[$input_poin['id']];
						$pengecoh_index = "pilihan-" . $i;
						$input_opsi['id'] = $pengecoh_index;
						$input_opsi['name'] = $pengecoh_index;
						$input_opsi['value'] = html_entity_decode($pilihan[$pengecoh_index]);

						echo "<b>Pilihan - {$i}</b>";
						
						// data umum
						
						echo '<fieldset>';
						
						echo div('class="control-group"');
						echo "<label class=\"control-label\" for=\"poin_max\">Skor / Poin</label>";
						//echo div('class="controls"', form_cell($input_poin, $row));
						echo div('class="controls"', form_cell($input_poin));
						echo "</div>" . NL;
						
						echo form_cell($input_opsi);
						echo '<br/><br/>';
						
					endfor;

				endif;

				echo '</fieldset><br/>';

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Akhiri Menulis Soal.</button> ';

				if ($row['id'] > 0)
					echo '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; ';
				else
					echo '<button type="submit" class="btn btn-success" name="tambah" value="true"><i class="icon-save icon-white"></i> Tulis Soal Berikutnya.</button>  &nbsp; &nbsp; ';

				echo $btn_back;
				echo '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		echo NL . '<script type="text/javascript" src="' . base_url('assets/tinymce_4.0.2/tinymce.min.js') . '"></script>' . NL;
		?>

		<script type="text/javascript">
			tinymce.init({
				selector: "textarea.tinymce_soal",
				theme: "modern",
				width: '100%',
				height: 240,
				plugins: [
					"eqneditor advlist autolink link image lists charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
					"save table contextmenu directionality emoticons template paste textcolor",
					"jbimages"
				],
				toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media | forecolor backcolor | eqneditor asciimath asciimathcharmap asciisvg | youtube jbimages",
				style_formats: [
					{title: 'Bold text', inline: 'b'},
					{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
					{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
					{title: 'Example 1', inline: 'span', classes: 'example1'},
					{title: 'Example 2', inline: 'span', classes: 'example2'},
					{title: 'Table styles'},
					{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
				],
				AScgiloc: '<?php base_url(); ?>/imathas/svgimg.php',
				ASdloc: '<?php base_url(); ?>/assets/tinymce_4.0.2/plugins/asciisvg/js/d.svg',
				relative_urls: false
			});
			tinymce.init({
				selector: "textarea.tinymce_opsi",
				theme: "modern",
				width: '100%',
				height: 120,
				plugins: [
					"eqneditor advlist autolink link image lists charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
					"save table contextmenu directionality emoticons template paste textcolor",
					"jbimages"
				],
				toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media | forecolor backcolor | eqneditor asciimath asciimathcharmap asciisvg | youtube jbimages",
				AScgiloc: '<?php base_url(); ?>/imathas/svgimg.php',
				ASdloc: '<?php base_url(); ?>/assets/tinymce_4.0.2/plugins/asciisvg/js/d.svg',
				relative_urls: false
			});
		</script>

	</body>
</html>