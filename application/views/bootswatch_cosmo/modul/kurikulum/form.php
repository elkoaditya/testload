<?php
//vars

$file_path = array_node($row, array('lampiran', 'full_path'));
$file_link = ($file_path && file_exists($file_path)) ? webpath($file_path) : NULL;
$file_name = array_nodex($row, array('lampiran', 'file_name'), 'berkas-tersimpan');
$file_anchor = ($file_link) ? a($file_link, $file_name, '') : NULL;

$upload_path = array_node($form, array('upload', 'full_path'));
$upload_link = ($upload_path && file_exists($upload_path)) ? webpath($upload_path) : NULL;
$upload_name = array_nodex($form, array('upload', 'file_name'), 'berkas-diupload');
$upload_anhor = ($upload_link) ? a($upload_link, $upload_name, '') : NULL;

if (!$post_request && $row['id'] == 0)
	$row['pelajaran_id'] = (int) $this->input->get_post('pelajaran_id');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Kurikulum' => 'modul/kurikulum',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "modul/kurikulum/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

if ($row['id'] > 0):
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "modul/kurikulum/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan kurikulum',
	);
else:
	$pills[] = array(
			'label' => 'Tabel',
			'uri' => "modul/kurikulum",
			'attr' => 'title="kembali ke tabel kurikulum"',
	);
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "modul/kurikulum/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan kurikulum',
	);

endif;

// input data

$input = array(
		'nama' => array(
				'nama',
				'label' => 'Judul',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'input input-xxlarge',
				'placeholder' => 'nama / judul kurikulum',
				'title' => 'isikan nama atau judul kurikulum',
		),
		'kurikulum_id' => array(
				'kurikulum_id',
				'label' => 'Jenis',
				'type' => 'dropdown',
				'name' => 'kurikulum_id',
				'id' => 'kurikulum_id',
				'extra' => 'class="input-large select" id="kurikulum_id"',
		),
			/*
			  'konten_tipe' => array(
			  'konten_tipe',
			  'type' => 'dropdown',
			  'name' => 'konten_tipe',
			  'id' => 'konten_tipe',
			  'extra' => 'id="konten_tipe"',
			  'label' => 'Bentuk kurikulum',
			  'options' => array(
			  'file' => 'File office upload',
			  'artikel' => 'Artikel',
			  ),
			  ),
			 *
			 */
);

if (($row['id'] == 0)||($user['role']=='sdm'))
{
	$input['kurikulum_id']['options'] = $this->m_option->modul_kurikulum(FALSE,$this->input->get('kurikulum_id'));
}else{
	$input['kurikulum_id']['options'] = $this->m_option->modul_kurikulum();
}



$input_keterangan = array(
		'keterangan',
		'type' => 'textarea',
		'name' => 'keterangan',
		'id' => 'keterangan',
		'class' => 'input input-xxlarge tinymce_mini',
);

// buttons

if ($row['id'] > 0)
	$btn_back = a("modul/kurikulum/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan kurikulum', 'class="btn btn-info "');
else
	$btn_back = a("modul/kurikulum/", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel kurikulum', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form kurikulum')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Kurikulum</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				// data umum

				echo '<fieldset>';
				echo '<legend>Kurikulum</legend>';

				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset><br/>';

				// data upload

				echo '<fieldset>';
				echo '<div id="kurikulum-file">';
				echo '<legend>Upload File / Lampiran</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('upload') . '<br/>';
				echo p('', '<i>file Microsoft Office, PDF atau gambar.</i>');

				if ($file_anchor)
					echo "tersimpan : {$file_anchor} <br/>";

				if ($upload_anhor)
					echo "diupload : {$upload_anhor} <br/>";

				echo '</div>';
				echo "</div>" . NL;
				echo '</div>';
				echo '</fieldset><br/>';

				

				// ketik pertanyaan

				echo '<fieldset>';
				echo '<legend>Keterangan</legend>';
				echo form_cell($input_keterangan, $row);
				echo '</fieldset><br/>';

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
				. $btn_back
				. '</div>';
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

		<script type="text/javascript">
			$(function() {
				$("#konten_tipe").change(function() {
					if ($(this).val() === "artikel") {
						$('#kurikulum-artikel').slideDown(100);
						$('#kurikulum-file').slideUp(100);
					} else {
						$('#kurikulum-file').slideDown(100);
						$('#kurikulum-artikel').slideUp(100);
					}
				});
				$('#cmd-artikel').click(function() {
					$('#kurikulum-artikel').slideToggle(100);
				});
				$("#konten_tipe").change();
				konten = $('#konten').html();

				if (konten == '')
					$('#kurikulum-artikel').slideUp(100);
			});
		</script>

	</body>
</html>