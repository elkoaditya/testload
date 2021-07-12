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
		'Video Call' => 'kbm/vidcall',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/vidcall/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

if ($row['id'] > 0):
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "kbm/vidcall/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan vidcall',
	);
else:
	$pills[] = array(
			'label' => 'Tabel',
			'uri' => "kbm/vidcall",
			'attr' => 'title="kembali ke tabel vidcall"',
	);
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "kbm/vidcall/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan vidcall',
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
				'placeholder' => 'nama / judul vidcall',
				'title' => 'isikan nama atau judul vidcall',
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
if($input['tanggal_tutup']['value']!=''){
	$input['tanggal_tutup']['value'] = datefix($input['tanggal_tutup']['value'] , 'Y-m-d H:i');
}
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
	$btn_back = a("kbm/vidcall/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan vidcall', 'class="btn btn-info "');
else
	$btn_back = a("kbm/vidcall/", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel vidcall', 'class="btn btn-info "');
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

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Video Call')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Video Call</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				// data umum

				echo '<fieldset>';
				echo '<legend>Video Call</legend>';

				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

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

		<script type="text/javascript">
			$(function() {
				$('.tglwaktu').datetimepicker({dateFormat: "yy-mm-dd"});
				$("#konten_tipe").change(function() {
					if ($(this).val() === "artikel") {
						$('#vidcall-artikel').slideDown(100);
						$('#vidcall-file').slideUp(100);
					} else {
						$('#vidcall-file').slideDown(100);
						$('#vidcall-artikel').slideUp(100);
					}
				});
				$('#cmd-artikel').click(function() {
					$('#vidcall-artikel').slideToggle(100);
				});
				$("#konten_tipe").change();
				konten = $('#konten').html();

				if (konten == '')
					$('#vidcall-artikel').slideUp(100);
			});
		</script>

	</body>
</html>