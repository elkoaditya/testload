<?php

$jenis_komentar=" Guru dengan Semua Siswa ";
if($pembaca_id>0){
	$jenis_komentar = " Privat Guru dengan Siswa Tertentu";
}
// function

function display_nama($row) {
	return a("data/profil/siswa/id/{$row['user_id']}?ringkas=ya", $row['siswa_nama'], 'title="lihat detail data siswa ini"');
}


// komponen

$this->load->helper('dataset');

// user akses

$author = ($user['id'] == $row['author_id']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Materi' => 'kbm/materi',
		"#{$row['id']}" => "kbm/materi/id/{$row['id']}",
		'Komentar'
);

// pills link

$pills[] = array(
		'label' => 'Tabel',
		'uri' => "kbm/materi",
		'attr' => 'title="kembali ke tabel materi"',
);
$pills[] = array(
		'label' => 'Kembali',
		'uri' => "kbm/materi/id/{$row['id']}",
		'attr' => 'title="kembali ke tampilan materi"',
);

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
		),
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->kelas('kelas'),
		),
);

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 5,
		'num_links' => 5,
		'next_link' => '→',
		'prev_link' => '←',
		'first_link' => '&compfn;',
		'last_link' => '&compfn;',
		'base_url' => "{$uri}/{$row['id']}",
		'full_tag_open' => '<div class="pagination"><ul>',
		'full_tag_close' => "<li class=\"disabled\"><a href=\"#\">{$stat}</a></li></ul></div>",
		'cur_tag_open' => '<li class="active"><a href="#">',
		'cur_tag_close' => '</a></li>',
		'num_tag_open' => '<li>',
		'num_tag_close' => '</li>',
		'first_tag_open' => '<li>',
		'first_tag_close' => '</li>',
		'last_tag_open' => '<li>',
		'last_tag_close' => '</li>',
		'next_tag_open' => '<li>',
		'next_tag_close' => '</li>',
		'prev_tag_open' => '<li>',
		'prev_tag_close' => '</li>',
);
$this->md->paging($resultset, $pagination);

// tabel data

$table = array(
		'table_properties' => array(
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data kosong</i></p>',
		'data' => array(
				
				'Komentar Terakhir' => array(
						'komentar_konten',
						'base64_decode',
						'suffix' => array(
								'
								<br/><span style="opacity: 0.8;"><b>',
								array('komentar_author_nama'),
								'</b>&nbsp;&nbsp;',
								array('komentar_registered', 'tglwaktu'),
								
								
								'</span>',
						),
				),
		),
);

// komen
$input_jawaban = array(
	'',
	//'html_entity_decode',
	'type'			 => 'textarea',
	'name'			 => 'komentar',
	'id'			 => 'komentar',
	'class'			 => 'input input-xxlarge tinymce_mini',
	'placeholder'	 => 'isi jawaban soal terkait dengan materi diatas',
	'style'			 => 'max-width: 100%;',
);

// bars

$bar_pills = pills($pills);
$bar_pencarian = '<div>'
			. form_opening("{$uri}/{$row['id']}", 'method="get" class="form-search well"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['kelas_id'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a("{$uri}/{$row['id']}", 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>

<html lang="en">
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
	
	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Materi #{$row['id']}")); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h2>Komentar <?=$jenis_komentar?> :</h2>
					<h1><?php echo strtoupper($row['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					#docs{
						width: 100%;
						min-height: 600px;
					}
				</style>

				<?php
				echo alert_get();

				$info = "Materi #{$row['id']}"
							. "<br/>Oleh "
							. a("data/profil/sdm/id/{$row['author_id']}", $row['author_nama'], 'title="lihat profil ' . strtolower(GURU_ALIAS) . ' ini"')
							. "<br/>Mapel "
							. a("data/akademik/pelajaran/id/{$row['pelajaran_id']}", $row['mapel_nama'], 'title="lihat detail pelajaran"')
							. " ({$row['pelajaran_kode']})";

				echo p('', $info);

				// pertanyaan

				echo p('', '<b>Pertanyaan siswa</b>')
				. $row['pertanyaan']
				. '<br/><br/><br/>';

				// Isi Komentar
				echo p('', '<b>Tulis Komentar</b>');
				
				echo form_opening("{$uri}/{$row['id']}/{$pembaca_id}");
				
				echo form_cell($input_jawaban, $row);
				
				?>
				<script type="text/javascript">
	  
						new FroalaEditor('textarea#komentar', {
							
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

							// Set max file size to 20MB.
							fileMaxSize: 20 * 1024 * 1024,

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

							// Set max image size to 5MB.
							imageMaxSize: 5 * 1024 * 1024,

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
							videoAllowedTypes: ['wmv', 'webm', 'mp4', 'ogg', 'avi'],

							events: {
								 
								 
							},
							
						  });
						
	
						</script>
				<?php
				// ketik pertanyaan
		
				echo '<button type="submit" class="btn btn-success" >
				<i class="icon-save icon-white"></i> Simpan Respon Jawaban</button> ';
				echo form_close();
				
				// tabel pembaca
				
				echo tag('h3', '', 'History Komentar Materi');
				//echo $bar_pills;
				echo $bar_pencarian;
				echo ds_table($table, $resultset);
				
				//print_r($resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>


	</body>
</html>