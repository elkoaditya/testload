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

// input data

$input = array(
		'nama' => array(
				'nama',
				'label' => 'Judul',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'input input-xxlarge',
				'placeholder' => 'nama / judul materi',
				'title' => 'isikan nama atau judul materi',
		),
		'pelajaran_id' => array(
				'pelajaran_id',
				'label' => 'Pelajaran',
				'type' => 'dropdown',
				'name' => 'pelajaran_id',
				'id' => 'pelajaran_id',
				'extra' => 'class="input-large select" id="pelajaran_id"',
		),
		'tanggal_publish' => array(
				'tanggal_publish',
				'label' => 'Tanggal Publish',
				'type' 	=> 'input',
				'name' 	=> 'tanggal_publish',
				'id' 	=> 'tanggal_publish',
				'class' => 'input input-medium tglwaktu',
				'placeholder' => 'yyyy-mm-dd hh:ii',
				'title' => 'isikan tanggal publish ',
		),
		'tanggal_tutup' => array(
				'tanggal_tutup',
				'label' => 'Tanggal Tutup',
				'type' 	=> 'input',
				'name' 	=> 'tanggal_tutup',
				'id' 	=> 'tanggal_tutup',
				'class' => 'input input-medium tglwaktu',
				'placeholder' => 'yyyy-mm-dd hh:ii',
				'title' => 'isikan tanggal tutup ',
		),
			/*
			  'konten_tipe' => array(
			  'konten_tipe',
			  'type' => 'dropdown',
			  'name' => 'konten_tipe',
			  'id' => 'konten_tipe',
			  'extra' => 'id="konten_tipe"',
			  'label' => 'Bentuk Materi',
			  'options' => array(
			  'file' => 'File office upload',
			  'artikel' => 'Artikel',
			  ),
			  ),
			 *
			 */
);

if ($row['id'] == 0 OR $author_ybs)
	$input['pelajaran_id']['options'] = $this->m_option->ajaran_user();
else
	$input['pelajaran_id']['options'][$row['pelajaran_id']] = $row['pelajaran_nama'];

$date_now = date("Y-m-d");
$input['tanggal_publish']['value'] = $date_now;
$input['tanggal_tutup']['value'] = "";

if(isset($row['tanggal_publish'])){
	$input['tanggal_publish']['value'] = $row['tanggal_publish']." 08:00";
}

$input['tanggal_publish']['value'] = datefix($input['tanggal_publish']['value'] , 'Y-m-d H:i');
$input['tanggal_tutup']['value'] = datefix($input['tanggal_tutup']['value'] , 'Y-m-d H:i');

$input_konten = array(
		'konten',
		//'html_entity_decode',
		'type' => 'textarea',
		'name' => 'konten',
		'id' => 'konten',
		'class' => 'input input-xxlarge tinymce',
		'rows' => 100,
);

$input_pertanyaan = array(
		'pertanyaan',
		//'html_entity_decode',
		'type' => 'textarea',
		'name' => 'pertanyaan',
		'id' => 'pertanyaan',
		'class' => 'input input-xxlarge tinymce_mini',
);

// buttons

if ($row['id'] > 0)
	$btn_back = a("kbm/materi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan materi', 'class="btn btn-info "');
else
	$btn_back = a("kbm/materi/", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel materi', 'class="btn btn-info "');
?>
<!DOCTYPE html>

<!-- EDITOR FROALA -->
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/third_party/font_awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/froala_editor.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/froala_style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/code_view.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/colors.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/emoticons.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/image_manager.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/image.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/line_breaker.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/table.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/char_counter.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/video.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/fullscreen.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/quick_insert.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/file.css">

	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/themes/gray.css">

	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/froala_editor.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/align.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/code_beautifier.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/code_view.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/colors.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/draggable.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/emoticons.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/font_size.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/font_family.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/image.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/file.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/image_manager.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/line_breaker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/link.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/lists.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/paragraph_format.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/paragraph_style.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/video.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/table.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/url.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/entities.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/char_counter.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/inline_style.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/quick_insert.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/save.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/fullscreen.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/quote.min.js"></script>
	
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
					<h1>Form Materi</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				// data umum

				echo '<fieldset>';
				echo '<legend>Materi</legend>';

				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset><br/>';

				// data upload

				echo '<fieldset>';
				echo '<div id="materi-file">';
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

				// ketik artikel

				echo '<fieldset>';
				echo '<legend>Artikel Materi</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_button('', 'ketikan isi artikel', 'id="cmd-artikel" class="btn btn-success"');
				echo '</div>';
				echo '</div>';

				echo '<div id="materi-artikel">';
				echo '<h4>( Rekomendasi Upload Video: .ogg .mp4 .webm )<br>
				( Rekomendasi Unggah Gambar: .jpg .png ) </h4>';
				echo form_cell($input_konten, $row);
				echo '</div>';
				echo '</fieldset><br/><br/>';
				?>
				<script type="text/javascript">
						
						
  
						new FroalaEditor('textarea#konten', {
							
							toolbarButtons: [['insertImage', 'insertVideo', 'insertFile'], ['bold', 'italic', 'underline']],
							
							heightMin: 150,
							
							attribution: false,
							
							/// FILE /////
							// Set the file upload parameter.
							fileUploadParam: 'file',

							// Set the file upload URL.
							fileUploadURL: '<?=base_url()?>froala_document',

							// Additional upload params.
							fileUploadParams: {id: 'my_editor'},

							// Set request type.
							fileUploadMethod: 'POST',

							// Set max file size to 100MB.
							fileMaxSize: 100 * 1024 * 1024,

							// Allow to upload any file.
							fileAllowedTypes: ['*'],
							
							
							
							/// IMAGE ////
							// Set the image upload parameter.
							imageUploadParam: 'file',

							// Set the image upload URL.
							imageUploadURL: '<?=base_url()?>froala_image',

							// Additional upload params.
							imageUploadParams: {id: 'my_editor'},

							// Set request type.
							imageUploadMethod: 'POST',

							// Set max image size to 100MB.
							imageMaxSize: 100 * 1024 * 1024,

							// Allow to upload PNG and JPG.
							imageAllowedTypes: ['jpeg', 'jpg', 'png'],
							
							
							
							/// VIDEO ////
							// Set the video upload parameter.
							videoUploadParam: 'file',

							// Set the video upload URL.
							videoUploadURL: '<?=base_url()?>froala_video',

							// Additional upload params.
							videoUploadParams: {id: 'my_editor'},

							// Set request type.
							videoUploadMethod: 'POST',

							// Set max video size to 200MB.
							videoMaxSize: 200 * 1024 * 1024,

							// Allow to upload MP4, WEBM and OGG
							videoAllowedTypes: ['wmv', 'webm', 'mp4', 'ogg', 'avi', 'flv', '3gp', 'mkv', 'mpg', 'swf', 'dat', 'mov', 'vob', 'nut', 'hevc', 'quicktime'],

							//videoAllowedTypes: ['*'],
							
							videoResponsive: true,
							
							events: {
								
								
								'video.error': function (error, response) {
									// Bad link.
									if (error.code == 1) { 
										console.log('Bad link');
									}

									// No link in upload response.
									else if (error.code == 2) { 
										console.log('No link');
									}

									// Error during image upload.
									else if (error.code == 3) { 
										console.log('error');
									}

									// Parsing response failed.
									else if (error.code == 4) { 
										console.log('parsing');
									}

									// Image too text-large.
									else if (error.code == 5) { 
										console.log('large');
									}

									// Invalid image type.
									else if (error.code == 6) { 
										console.log('type');
									}

									// Image can be uploaded only to same domain in IE 8 and IE 9.
									else if (error.code == 7) { 
										console.log('ie 8 9');
									}

									// Response contains the original server response to the request if available.
								  },
	  
								'image.error': function (error, response) {
									// Bad link.
									if (error.code == 1) { 
										console.log('Bad link');
									}

									// No link in upload response.
									else if (error.code == 2) { 
										console.log('No link');
									}

									// Error during image upload.
									else if (error.code == 3) { 
										console.log('error');
									}

									// Parsing response failed.
									else if (error.code == 4) { 
										console.log('parsing');
									}

									// Image too text-large.
									else if (error.code == 5) { 
										console.log('large');
									}

									// Invalid image type.
									else if (error.code == 6) { 
										console.log('type');
									}

									// Image can be uploaded only to same domain in IE 8 and IE 9.
									else if (error.code == 7) { 
										console.log('ie 8 9');
									}

									// Response contains the original server response to the request if available.
								  },
								 
							},
							
							
							
						  });
						  
						</script>
				<?php
				// ketik pertanyaan

				echo '<fieldset>';
				echo '<h4>Pertanyaan siswa<br>
				( Rekomendasi Upload Video: .ogg .mp4 .webm )<br>
				( Rekomendasi Unggah Gambar: .jpg .png ) </h4>';
				echo form_cell($input_pertanyaan, $row);
				echo '</fieldset><br/>';
				?>
				<script type="text/javascript">
	  
						new FroalaEditor('textarea#pertanyaan', {
							
							toolbarButtons: [['insertImage', 'insertVideo', 'insertFile'], ['bold', 'italic', 'underline']],
							
							heightMin: 150,
							
							attribution: false,
							
							/// FILE /////
							// Set the file upload parameter.
							fileUploadParam: 'file',

							// Set the file upload URL.
							fileUploadURL: '<?=base_url()?>froala_document',

							// Additional upload params.
							fileUploadParams: {id: 'my_editor'},

							// Set request type.
							fileUploadMethod: 'POST',

							// Set max file size to 100MB.
							fileMaxSize: 100 * 1024 * 1024,

							// Allow to upload any file.
							fileAllowedTypes: ['*'],
							
							
							
							/// IMAGE ////
							// Set the image upload parameter.
							imageUploadParam: 'file',

							// Set the image upload URL.
							imageUploadURL: '<?=base_url()?>froala_image',

							// Additional upload params.
							imageUploadParams: {id: 'my_editor'},

							// Set request type.
							imageUploadMethod: 'POST',

							// Set max image size to 100MB.
							imageMaxSize: 100 * 1024 * 1024,

							// Allow to upload PNG and JPG.
							imageAllowedTypes: ['jpeg', 'jpg', 'png'],
							
							
							
							/// VIDEO ////
							// Set the video upload parameter.
							videoUploadParam: 'file',

							// Set the video upload URL.
							videoUploadURL: '<?=base_url()?>froala_video',

							// Additional upload params.
							videoUploadParams: {id: 'my_editor'},

							// Set request type.
							videoUploadMethod: 'POST',

							// Set max video size to 200MB.
							videoMaxSize: 200 * 1024 * 1024,

							// Allow to upload MP4, WEBM and OGG
							videoAllowedTypes: ['wmv', 'webm', 'mp4', 'ogg', 'avi', 'flv', '3gp', 'mkv', 'mpg', 'swf', 'dat', 'mov', 'vob', 'nut', 'hevc', 'quicktime'],

							events: {
								 
								 
							},
							
						  });
						
	
						</script>
				<?php
				
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

		<script type="text/javascript">
			$(function() {
				$('.tglwaktu').datetimepicker({dateFormat: "yy-mm-dd"});
				$("#konten_tipe").change(function() {
					if ($(this).val() === "artikel") {
						$('#materi-artikel').slideDown(100);
						$('#materi-file').slideUp(100);
					} else {
						$('#materi-file').slideDown(100);
						$('#materi-artikel').slideUp(100);
					}
				});
				$('#cmd-artikel').click(function() {
					$('#materi-artikel').slideToggle(100);
				});
				$("#konten_tipe").change();
				konten = $('#konten').html();

				if (konten == '')
					$('#materi-artikel').slideUp(100);
			});
		</script>

	</body>
</html>