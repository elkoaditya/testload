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
		'KBM' => 'kbm',
		'Materi' => 'kbm/materi',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/materi/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

if ($row['id'] > 0):
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "kbm/materi/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan materi',
	);
else:
	$pills[] = array(
			'label' => 'Tabel',
			'uri' => "kbm/materi",
			'attr' => 'title="kembali ke tabel materi"',
	);
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "kbm/materi/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan materi',
	);

endif;





// buttons

if ($row['id'] > 0)
	$btn_back = a("kbm/materi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan materi', 'class="btn btn-info "');
else
	$btn_back = a("kbm/materi/", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel materi', 'class="btn btn-info "');
?>
<!DOCTYPE html>
	
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Materi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Upload Dokumen Soal</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				// data umum

				echo '<fieldset>';
				echo '<legend>Evaluasi : '.$row['nama'].'</legend>';


				echo '</fieldset><br/>';

				// data upload

				echo '<fieldset>';
				echo '<div id="materi-file">';
				echo '<legend>Upload Dokumen Soal</legend>';
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
		//addon('tinymce');
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		addon('timepicker');
		?>

		

	</body>
</html>