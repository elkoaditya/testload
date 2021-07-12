<?php
// vars
//function
// komponen
// hak akses & user scope

$author_ybs = ($user['id'] == $row['author_id']);
$guru_ybs = ($user['id'] == $row['guru_id']);

$file_tersimpan = array_node($row, array('lampiran', 'full_path'));
$file_terunggah = array_node($form, array('upload', 'full_path'));
$file_tersimpan = webpath($file_tersimpan);
$file_terunggah = webpath($file_terunggah);
$nama_tersimpan = array_node($row, array('lampiran', 'file_name'));
$nama_terunggah = array_node($form, array('upload', 'file_name'));
$link_tersimpan = file_exists($file_tersimpan) ? a($file_tersimpan, $nama_tersimpan, '') : NULL;
$link_terunggah = file_exists($file_terunggah) ? a($file_terunggah, $nama_terunggah, '') : NULL;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Artikel' => 'kbm/artikel',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/artikel/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
		'label' => 'Kembali ke Daftar Artikel',
		'uri' => "kbm/artikel",
		'attr' => 'title="kembali ke daftar artikel"',
);

if ($row['id'] > 0):
	$pills_kiri[] = array(
			'label' => 'Kembali ke Tampilan Artikel',
			'uri' => "kbm/artikel/id/{$row['id']}",
			'attr' => 'title="batal mengubah dan kembali ke tampilan artikel"',
	);
	$pills_kanan[] = array(
			'label' => '<i class="icon-undo"></i>Batal',
			'uri' => "kbm/artikel/id/{$row['id']}",
			'attr' => 'title="batal mengubah dan kembali ke tampilan artikel"',
			'class' => 'active',
	);

else:
	$pills_kanan[] = array(
			'label' => '<i class="icon-undo"></i>Batal',
			'uri' => "kbm/artikel",
			'attr' => 'title="batal menulis dan kembali ke daftar artikel"',
			'class' => 'active',
	);

endif;

// data tabel

$detail1 = array(
		'Mata Pelajaran' => array('mapel_nama'),
		GURU_ALIAS . ' Pengajar' => array(
				'guru_nama',
				'suffix' => array(
						'<div class="info">',
						'pelajaran_nama',
						' &nbsp; ',
						'semester_nama',
						' ',
						'ta_nama',
						'</div>',
				),
		),
);

// inputs

$input = array(
		'umum' => array(
				'nama' => array(
						'nama',
						'label' => 'Nama / Judul',
						'type' => 'input',
						'name' => 'nama',
						'id' => 'nama',
						'class' => 'input input-xxlarge',
						'placeholder' => 'isikan nama judul artikel',
						'title' => 'isikan nama judul artikel',
				),
				'pelajaran_id' => array(
						'pelajaran_id',
						'label' => 'Pelajaran',
						'type' => 'dropdown',
						'name' => 'pelajaran_id',
						'id' => 'pelajaran_id',
						'extra' => 'class="input-large select" id="pelajaran_id"',
						'options' => $this->m_option->pelajaran_user(FALSE, 'artikel'),
				),
		),
		'konten' => array(
				'konten',
				//'html_entity_decode',
				'type' => 'textarea',
				'name' => 'konten',
				'id' => 'konten',
				'class' => 'input input-xxlarge tinymce',
		),
		'guru_catatan' => array(
				'guru_catatan',
				//'html_entity_decode',
				'type' => 'textarea',
				'name' => 'guru_catatan',
				'id' => 'guru_catatan',
				'class' => 'input input-xxlarge tinymce',
		),
);

// bars

$bar_pill = '<div>'
		. pills($pills_kanan, 'class="nav nav-pills pull-right"')
		. pills($pills_kiri)
		. '</div>';

// buttons

if ($row['id'] > 0)
	$btn_back = a("kbm/artikel/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan artikel', 'class="btn btn-info "');
else
	$btn_back = a("kbm/artikel/", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke daftar artikel', 'class="btn btn-info "');
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
					<h1>Form <?php echo (APP_DOMAIN == 'anugrahbangsa.fresto.co') ? 'Spotcapturing' : 'Artikel Siswa'; ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
				</style>

				<?php
				echo alert_get();
				echo $bar_pill;
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Informasi Umum</legend>';

				foreach ($input['umum'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset></div><br/><br/>';

				// data upload

				echo '<div class="form-horizontal"><fieldset>';
				echo '<div id="materi-file">';
				echo '<legend>Upload File / Lampiran</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('upload') . '<br/>';
				echo p('', '<i>file Microsoft Office, PDF atau gambar.</i>');
				echo '</div>';

				if ($link_tersimpan)
					echo "tersimpan : {$link_tersimpan} <br/>";

				if ($link_terunggah)
					echo "diupload : {$link_terunggah} <br/>";

				echo "</div>" . NL;
				echo '</div>';
				echo '</fieldset><br/>';

				// ketik artikel

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Isi Artikel</legend>';
				echo form_cell($input['konten'], $row);
				echo '</fieldset><br/>';

				// bagian menampilkan catatan guru

				if ($user['role'] == 'siswa'):
					echo '<div class="form-horizontal"><fieldset>';
					echo '<legend>Catatan ' . ucwords(GURU_ALIAS) . ' Pengajar</legend>';
					echo (!empty($row['guru_catatan'])) ? $row['guru_catatan'] : '<i>belum ada catatan untuk artikel ini</i>';
					echo '</fieldset><br/><br/></div>';

				else:
					echo '<div class="form-horizontal"><fieldset>';
					echo '<legend>Catatan ' . ucwords(GURU_ALIAS) . ' Pengajar</legend>';
					echo form_cell($input['guru_catatan'], $row);
					echo '</fieldset><br/>';

				endif;

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

	</body>
</html>