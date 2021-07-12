<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$eval['id']}" => "kbm/evaluasi/id/{$eval['id']}",
		'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$eval['id']}",
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/evaluasi_soal/id/{$row['id']}";
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
		'class' => 'input tinymce_mini',
		'style' => 'min-height: 200px;'
);

$input_poin = array(
		'type' => 'input',
		'name' => 'poin_max',
		'id' => 'poin_max',
		'class' => 'input input-small',
		'placeholder' => 'bobot',
		'title' => 'bobot / poin pertanyaan',
);

if ($eval['soal_bank']):
	$input_poin['disabled'] = 'true';
	$input_poin['value'] = 10;

else:
	$input_poin[] = 'poin_max';

endif;

$input_opsi = array(
		'type' => 'textarea',
		'class' => 'input tinymce_mini',
		'style' => 'height: 80px;'
);

IF ($row['id'] > 0)
	$btn_back = a("kbm/evaluasi_soal/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan pertanyaan', 'class="btn btn-info "');
else
	$btn_back = a("kbm/evaluasi_soal/browse?evaluasi_id={$eval['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke daftar pertanyaan', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Edit Materi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Soal Evaluasi</h1>
				</div>

				<style>
					img.thumb{
						max-width: 300px;
						max-height: 300px;
					}
				</style>

				<?php
				$gambar_tersimpan = NULL;
				$gambar_terupload = NULL;

				if ($row['gambar']):
					$gambar = json_decode($row['gambar'], TRUE);

					if (isset($gambar['full_path']) && file_exists($gambar['full_path']))
						$gambar_tersimpan = $gambar['full_path'];

				endif;

				if ($form['upload']):

					if (isset($form['upload']['full_path']) && file_exists($form['upload']['full_path']))
						$gambar_terupload = $form['upload']['full_path'];

				endif;

				alert_info("Soal tersimpan saat ini :: {$eval['soal_total']}");
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}&evaluasi_id={$eval['id']}", 'class="form-horizontal well"');

				// data umum

				echo '<fieldset>';
				echo '<legend>Soal</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"gambar\">Gambar</label>";
				echo div('class="controls"');
				echo form_upload('gambar') . '<br/>';
				echo '<label>' . form_checkbox('hapus_gambar', 'true') . ' &nbsp; <i>abaikan &amp; hapus  semua gambar</i></label>';

				if ($gambar_tersimpan OR $gambar_terupload):
					echo '<table border="0"><tr>';

					if ($gambar_tersimpan)
						echo '<td align="center"><i>tersimpan</i><br/>' . img(array('src' => $gambar_tersimpan, 'class' => 'thumb')) . '</td>';

					if ($gambar_terupload)
						echo '<td align="center"><i>diupload</i><br/>' . img(array('src' => $gambar_terupload, 'class' => 'thumb')) . '</td>';

					echo '</tr></table>';
				endif;

				echo "</div>" . NL;
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"pertanyaan\">Pertanyaan</label>";
				echo div('class="controls"', form_cell($input_pertanyaan, $row));
				echo "</label></div>" . NL;

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"pertanyaan\">Poin</label>";
				echo div('class="controls"', form_cell($input_poin, $row));
				echo "</label></div>" . NL;

				// pilihan
				/* / tes case
				  $eval['pilihan_jml'] = 5;
				  $row['pilihan'] = array(
				  'kunci' => 'benar',
				  'pengecoh' => array('a', 'd', 'd', 'd'),
				  );
				  // */

				if ($eval['pilihan_jml'] > 1):
					echo '<legend>Pilihan</legend>';

					if (!is_array($row['pilihan']) && $row['pilihan'])
						$row['pilihan'] = (array) json_decode($row['pilihan'], TRUE);
					else
						$row['pilihan'] = (array) $row['pilihan'];

					$input_opsi['id'] = 'kunci';
					$input_opsi['name'] = 'kunci';
					$input_opsi['value'] = array_node($row, array('pilihan', 'kunci'));

					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"pertanyaan\">Kunci</label>";
					echo div('class="controls"', form_cell($input_opsi));
					echo "</label></div>" . NL;

					for ($i = 1; $i < $eval['pilihan_jml']; $i++):

						$input_opsi['id'] = "pengecoh-{$i}";
						$input_opsi['name'] = "pengecoh-{$i}";

						if ($post_request)
							$input_opsi['value'] = html_entity_decode($this->input->post($input_opsi['name']));
						else
							$input_opsi['value'] = array_node($row, array('pilihan', 'pengecoh', ($i - 1)));

						echo div('class="control-group"');
						echo "<label class=\"control-label\" for=\"pertanyaan\">Pengecoh - {$i}</label>";
						echo div('class="controls"', form_cell($input_opsi));
						echo "</label></div>" . NL;

					endfor;

				endif;

				echo '</fieldset><br/>';

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> ';

				if ($row['id'] > 0)
					echo '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; ';
				else
					echo '<button type="submit" class="btn btn-success" name="tambah" value="true"><i class="icon-save icon-white"></i> Simpan, tambah lagi</button>  &nbsp; &nbsp; ';

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
		addon('tinymce');
		?>

	</body>
</html>