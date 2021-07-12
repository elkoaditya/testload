<?php
// vars
//function
// komponen
// hak akses & user scope

$author_ybs = ($user['id'] == $row['author_id']);
$guru_ybs = ($user['id'] == $row['guru_id']);

$file_path = array_node($row, array('lampiran', 'full_path'));
$file_link = ($file_path && file_exists($file_path)) ? webpath($file_path) : NULL;
$file_name = array_nodex($row, array('lampiran', 'file_name'), 'lampiran');
$file_imag = array_nodex($row, array('lampiran', 'is_image'), FALSE);
$file_ofis = file_ofis($row, array('lampiran', 'file_ext'));
$file_view = "http://docs.google.com/viewer?url=" . $file_link;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Artikel' => 'kbm/artikel',
		"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
		'label' => 'Daftar Artikel',
		'uri' => "kbm/artikel",
		'attr' => 'title="kembali ke daftar artikel"',
);

if ($admin OR $author_ybs)
	$pills_kanan[] = array(
			'label' => '<i class="icon-edit"></i> Edit',
			'uri' => "kbm/artikel/form?id={$row['id']}",
			'attr' => 'title="ubah artikel ini"',
			'class' => 'active',
	);

if ($guru_ybs)
	$pills_kanan[] = array(
			'label' => '<i class="icon-edit"></i> Beri Catatan',
			'uri' => "kbm/artikel/form?id={$row['id']}",
			'attr' => 'title="beri catatan pada ini"',
			'class' => 'active',
	);

// data tabel

$detail1 = array(
		'Mata Pelajaran' => array('mapel_nama'),
		GURU_ALIAS . ' Pengajar' => array(
				'guru_nama',
				'suffix' => array(
						'<div class="subinfo">',
						'pelajaran_nama',
						' &nbsp; ',
						'semester_nama',
						' ',
						'ta_nama',
						'</div>',
				),
		),
);

// bars

$bar_pill = '<div>'
		. pills($pills_kanan, 'class="nav nav-pills pull-right"')
		. pills($pills_kiri)
		. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Artikel Spotcapturing')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<?php echo (APP_DOMAIN == 'anugrahbangsa.fresto.co') ? 'Spotcapturing' : 'Artikel Siswa'; ?>:<br/>
					<h1><?php echo strtoupper($row['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					.subinfo{
						font-size: .8em;
						opacity: .8;
					}
					#lampiran{
						width: 100%;
						min-height: 600px;
					}
				</style>

				<?php
				echo alert_get();
				echo $bar_pill;

				echo '<div class="form-horizontal"><fieldset>';

				foreach ($detail1 as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

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
					echo tag('article', 'id="artikel"', $row['konten']);

				elseif ($file_ofis):
					echo "<iframe id=\"lampiran\" src=\"{$file_view}&embedded=true\"/>";

				endif;

				echo '<br/><br/><br/>';

				// bagian menampilkan catatan guru

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Catatan ' . ucwords(GURU_ALIAS) . ' Pengajar</legend>';
				echo (!empty($row['guru_catatan'])) ? $row['guru_catatan'] : '<i>belum ada catatan untuk artikel ini</i>';
				echo '</fieldset><br/><br/></div>';
				?>
			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>