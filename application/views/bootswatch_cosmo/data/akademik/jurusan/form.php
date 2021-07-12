<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Jurusan' => 'data/akademik/jurusan',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/akademik/jurusan/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => 'Tabel Jurusan',
		'uri' => "data/akademik/jurusan",
		'attr' => 'title="kembali ke tabel jurusan"',
);

if ($row['id'] > 0)
	$pills[] = array(
			'label' => 'Detail Jurusan',
			'uri' => "data/akademik/jurusan/id/{$row['id']}",
			'attr' => 'title="kembali ke detail jurusan"',
	);

// input data

$input = array(
		'kode' => array(
				'kode',
				'type' => 'input',
				'name' => 'kode',
				'id' => 'kode',
				'class' => 'input input-xxlarge',
				'label' => 'Kode',
		),
		'nama' => array(
				'nama',
				'label' => 'Nama',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'input input-xxlarge',
		),
		'deskripsi' => array(
				'deskripsi',
				'label' => 'Deskripsi',
				'type' => 'textarea',
				'name' => 'deskripsi',
				'id' => 'deskripsi',
				'class' => 'input input-xxlarge',
				'rows' => 3,
		),
		'aktif' => array(
				'name' => 'aktif',
				'id' => 'aktif',
				'value' => 1,
				'checked' => (bool) $row['aktif'],
		),
);

// buttons

$btn_back = a("data/akademik/jurusan", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel jurusan', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Jurusan')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Jurusan</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				// detail jurusan

				echo '<fieldset>';

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"kode\">Kode jurusan</label>"
				. "<div class=\"controls\">"
				. form_cell($input['kode'], $row)
				. "</div></div>" . NL;

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"nama\">Nama jurusan</label>"
				. "<div class=\"controls\">"
				. form_cell($input['nama'], $row)
				. "</div></div>" . NL;

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"deskripsi\">Deskripsi jurusan</label>"
				. "<div class=\"controls\">"
				. form_cell($input['deskripsi'], $row)
				. "</div></div>" . NL;

				// akun email pengguna baru

				if ($row['id'] > 0):
					echo "<div class=\"control-group\">"
					. "<label class=\"control-label\" for=\"aktif\">Aktif</label>"
					. "<div class=\"controls\">"
					. "<label class=\"checkbox\">"
					. form_checkbox($input['aktif'])
					. "masih aktif dalam kurikulum sekolah"
					. "</label></div></div>" . NL;

				endif;

				// form button

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

		<?php echo cosmo_js(); ?>

	</body>
</html>