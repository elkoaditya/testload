<?php
// vars
$base_url = base_url();
$file_path = array_node($row, array('lampiran', 'full_path'));
$file_local_path = APP_ROOT.$file_path;
$file_link = ($file_path && file_exists($file_local_path)) ? base_url(webpath($file_path)) : NULL;
$file_ofis = file_ofis($row, array('lampiran', 'file_ext'));
$file_imag = array_nodex($row, array('lampiran', 'is_image'), FALSE);
$file_name = array_nodex($row, array('lampiran', 'file_name'), (($file_ofis) ? 'dokumen' : (($file_imag) ? 'gambar' : 'download')));

$file_link2 = str_replace("http://" ,"" ,$file_link);
$file_link2 = str_replace("https://" ,"" ,$file_link);

$file_link2 = str_replace("".$_SERVER['HTTP_HOST']."/".APP_SUBDOMAIN."/" ,"".$_SERVER['HTTP_HOST']."/m4n3riq/" ,$file_link2);
$file_view = "https://docs.google.com/viewer?url=" . $file_link2;

// user akses

$author_ybs = ($user['id'] == $row['author_id']);

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Pengumuman'						 => 'kbm/pengumuman',
	"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
	'label'	 => 'Daftar pengumuman',
	'uri'	 => "kbm/pengumuman",
	'attr'	 => 'title="kembali ke daftar pengumuman"',
);

	
if ($author_ybs OR $admin):
	
	
	$pills_kanan['edit'] = array(
		'label'	 => '<i class="icon-edit"></i> Edit',
		'uri'	 => "kbm/pengumuman/form?id={$row['id']}",
		'attr'	 => 'title="ubah konten pengumuman ini"',
		'class'	 => 'active',
	);
	$pills_kanan['pembaca'] = array(
		'label'	 => '<i class="icon-group"></i> Pembaca',
		'uri'	 => "kbm/pengumuman/pembaca/{$row['id']}",
		'attr'	 => 'title="lihat aktifitas belajar siswa"',
		'class'	 => 'active',
	);
	$pills_kanan['delete'] = array(
		'label'	 => '<i class="icon-trash"></i> Hapus',
		'uri'	 => "kbm/pengumuman/hapus/{$row['id']}",
		'attr'	 => 'title="hapus konten pengumuman ini" onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK MENGHAPUS PENGUMUMAN INI ?\')"',
		'class'	 => 'active',
	);

endif;

// bars

$bar_pill = '<div>'
	. pills($pills_kanan, 'class="nav nav-pills pull-right"')
	. pills($pills_kiri)
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
	
<?php $this->load->view(THEME . "/-html-/head", array('title' => "Pengumuman #{$row['id']}")); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">
		
		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Pengumuman:<br/>
					<h1><?php echo strtoupper($row['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					#info{
						font-size: .9em;
						opacity: .7;
					}
					#lampiran{
						width: 100%;
						min-height: 600px;
					}
				</style>

				<?php

				echo alert_get();

				$info = "Oleh {$row['author_nama']}<br/>"
					. "Waktu Publish ".tglwaktu($row['tanggal_publish'])."<br/>"
					. "Waktu Tutup ".tglwaktu($row['tanggal_tutup'])."";

				echo p('id="info"', $info);
				echo $bar_pill;

				//klo ada gambar tampilkan saja

				if ($file_imag && $file_link):
					echo div('align="center"', img($file_link)) . '<br/>';
				endif;

				// tampilkan lampiran
				
				if ($file_link):
					echo '<p><i>lampiran: ' . a($file_link, $file_name, 'title="download lampiran" target="_blank"') . '</i></p><br/><br/>';
				endif;

				// klo ada ketikan artikel, tampilkan. lampiran jadi link

				if ($file_ofis):
					echo "<iframe id=\"lampiran\" src=\"{$file_view}&embedded=true\"></iframe>";
				endif;	
				if (!empty($row['konten'])):
					$row['konten'] = str_replace('<img src="/', '<img src="'.$base_url, $row['konten']);
					$row['konten'] = str_replace('<img src="../../', '<img src="'.$base_url, $row['konten']);
				
					$row['konten'] = str_replace('style="','style="max-width: 100%; ', $row['konten']);
					$row['konten'] = str_replace('iframe','iframe style="max-width: 100%;" ', $row['konten']);
					
					echo tag('article', 'id="artikel"', clean_charset($row['konten']));


				endif;

				echo '<br/><br/><br/>';

				

				?>

			</div>

		<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

<?php

echo cosmo_js();
//addon('tinymce');

?>
		
		
	</body>
</html>
