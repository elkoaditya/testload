<?php

// vars

$file_path = array_node($row, array('lampiran', 'full_path'));
$file_local_path = APP_ROOT.$file_path;
$file_link = ($file_path && file_exists($file_local_path)) ? base_url(webpath($file_path)) : NULL;
$file_ofis = file_ofis($row, array('lampiran', 'file_ext'));
$file_imag = array_nodex($row, array('lampiran', 'is_image'), FALSE);
$file_name = array_nodex($row, array('lampiran', 'file_name'), (($file_ofis) ? 'dokumen' : (($file_imag) ? 'gambar' : 'download')));
$file_view = "http://docs.google.com/viewer?url=" . $file_link;

// user akses

$author_ybs = ($user['id'] == $row['author_id']);

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Materi'						 => 'kbm/materi',
	"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
	'label'	 => 'Daftar Materi',
	'uri'	 => "kbm/materi",
	'attr'	 => 'title="kembali ke daftar materi"',
);

if ($author_ybs OR $admin):
	
	$pills_kanan['edit'] = array(
		'label'	 => '<i class="icon-edit"></i> Edit',
		'uri'	 => "kbm/materi/form?id={$row['id']}",
		'attr'	 => 'title="ubah konten materi ini"',
		'class'	 => 'disabled',
	);
	$pills_kanan['pembaca'] = array(
		'label'	 => '<i class="icon-group"></i> Pembaca',
		'uri'	 => "kbm/materi/pembaca/{$row['id']}",
		'attr'	 => 'title="lihat aktifitas belajar siswa"',
		'class'	 => 'active',
	);
	$pills_kanan['delete'] = array(
		'label'	 => '<i class="icon-trash"></i> Hapus',
		'uri'	 => "kbm/materi/hapus/{$row['id']}",
		'attr'	 => 'title="hapus konten materi ini" onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK MENGHAPUS MATERI INI ?\')"',
		'class'	 => 'active',
	);
	if ($row['semester_id'] == $semaktif['id'])
		$pills_kanan['edit']['class'] = 'active';

endif;

if ($author_ybs OR $admin OR $user['role'] == 'sdm')
{
	$pills_kanan['reuse'] = array(
		'label'	 => 'Reuse',
		'uri'	 => "kbm/materi/reuse/{$row['id']}",
		'attr'	 => 'title="gunakan kembali materi ini"',
		'class'	 => 'active',
	);
}
// respon

$input_jawaban = array(
	'respon_jawaban',
	//'html_entity_decode',
	'type'			 => 'textarea',
	'name'			 => 'respon_jawaban',
	'id'			 => 'respon_jawaban',
	'class'			 => 'input input-xxlarge tinymce_mini',
	'placeholder'	 => 'isi jawaban soal terkait dengan materi diatas',
);

// bars

$bar_pill = '<div>'
	. pills($pills_kanan, 'class="nav nav-pills pull-right"')
	. pills($pills_kiri)
	. '</div>';

?>
<!DOCTYPE html>
<html lang="en">

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
					Materi:<br/>
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
					. "Mapel {$row['mapel_nama']} ({$row['pelajaran_nama']})";

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

				if (!empty($row['konten'])):
					echo tag('article', 'id="artikel"', clean_charset($row['konten']));

				elseif ($file_ofis):
					echo "<iframe id=\"lampiran\" src=\"{$file_view}&embedded=true\"></iframe>";

				endif;

				echo '<br/><br/><br/>';

				// pertanyaan

				echo p('', '<b>Pertanyaan Siswa</b>') . $row['pertanyaan'];

				if ($user['role'] == 'siswa'):
					echo p('', '<b>Respon Jawaban</b>');

					if ($row['respon_jawaban']):
						echo ($row['respon_jawaban']);

					else:
						echo form_opening("{$uri}/{$row['id']}");
						echo form_cell($input_jawaban, $row);
						echo '<button type="submit" class="btn btn-success" onclick="return confirm(\'APAKAH ANDA YAKIN TELAH SELESAI MENGERJAKAN ?\')">
						<i class="icon-save icon-white"></i> Simpan Respon Jawaban</button> ';
						echo form_close();

					endif;

				endif;

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