<?php
// vars

$file_path = array_node($row, array('lampiran', 'full_path'));
$file_link = ($file_path && file_exists($file_path)) ? webpath($file_path) : NULL;
$file_name = array_nodex($row, array('lampiran', 'file_name'), 'berkas-tersimpan');
$file_anchor = ($file_link) ? a($file_link, $file_name, '') : NULL;

$upload_path = array_node($form, array('upload', 'full_path'));
$upload_link = ($upload_path && file_exists($upload_path)) ? webpath($upload_path) : NULL;
$upload_name = array_nodex($form, array('upload', 'file_name'), 'berkas-diupload');
$upload_anhor = ($upload_link) ? a($upload_link, $upload_name, '') : NULL;

$pengecoh_jml = $evaluasi['pilihan_jml'] - 1;

// pindahkan opsi/pilihan ke variabel semestera saat load pertama

if ($pengecoh_jml > 1):

	$row['pilihan'] = (array) $row['pilihan'];

	if (isset($row['pilihan']['kunci']) && is_array($row['pilihan']['kunci']) && !$post_request):
		foreach ($row['pilihan']['kunci'] as $opsi):
			$pilihan['kunci'] = $opsi;
		endforeach;
	endif;

	if (isset($row['pilihan']['pengecoh']) && is_array($row['pilihan']['pengecoh']) && !$post_request):
		$i = 0;
		foreach ($row['pilihan']['pengecoh'] as $opsi):
			$i++;
			$pengecoh_index = "pengecoh-" . $i;
			$pilihan[$pengecoh_index] = $opsi;
		endforeach;
	endif;

endif;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$evaluasi['id']}",
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/evaluasi_soal/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link
// input data

$input_jawaban = array(
		'',
		//'html_entity_decode',
		'type' => 'textarea',
		'name' => 'jawaban',
		'id' => 'jawaban',
		'class' => 'input input-large',
		'style' => 'height: 200px;',
);

$input_jml_soal = array(
		'0',
		'type' => 'input',
		'name' => 'jumlah_soal',
		'id' => 'jumlah_soal',
		'class' => 'input input-medium',
		'placeholder' => '1 - 200',
		'title' => 'jumlah pertanyaan',
);

$input_opsi = array(
		'type' => 'textarea',
		'class' => 'input tinymce_opsi',
		'style' => 'height: 80px;'
);

$btn_back = a("kbm/evaluasi/id/{$evaluasi['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail evaluasi', 'class="btn btn-info "');

alert_info("Soal tersimpan saat ini :: {$evaluasi['soal_total']}");
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
					Form Soal Evaluasi:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke detail evaluasi"'); ?></h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}&evaluasi_id={$evaluasi['id']}", 'class="form-horizontal well"');

				///// Soal dan jawaban //////////////////
				
				echo '<fieldset>';
				echo '<div id="materi-file">';
				echo '<legend>Upload Soal</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('upload_soal') . '<br/>';
				echo p('', '<i>file Microsoft Office, PDF atau gambar.</i>');

				if ($file_anchor)
					echo "tersimpan : {$file_anchor} <br/>";

				if ($upload_anhor)
					echo "diupload : {$upload_anhor} <br/>";

				echo '</div>';
				echo "</div>" . NL;
				echo '</div>'; 
				
				echo '<legend>Soal / Pertanyaan</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"poin_max\">Tambah Jumlah Soal</label>";
				echo '+ '.div('class="controls"', form_cell($input_jml_soal, $row));
				echo "</div>" . NL;

				echo '<legend>Jawaban</legend>';
				
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"poin_max\">Kunci Jawaban</label>";
				echo div('class="controls"', form_cell($input_jawaban, $row));
				echo "</div>" . NL;

			///	echo form_cell($input_jawaban, $row);
				echo '<br/><br/><br/>';

				echo '</fieldset><br/>';
				// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan.</button> ';

				if ($row['id'] > 0)
					echo '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; ';
				//else
					//echo '<button type="submit" class="btn btn-success" name="tambah" value="true"><i class="icon-save icon-white"></i> Tulis Soal Berikutnya.</button>  &nbsp; &nbsp; ';

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