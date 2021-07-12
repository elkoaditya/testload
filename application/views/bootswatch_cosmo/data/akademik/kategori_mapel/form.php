<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Kategori mapel' => 'data/akademik/kategori_mapel',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/akademik/kategori_mapel/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => 'Daftar Kategori Mapel',
		'uri' => "data/akademik/kategori_mapel",
		'attr' => 'title="kembali ke tabel kategori mapel"',
);

// input data

$input = array(
		'kode' => array(
				'kode',
				'type' => 'input',
				'name' => 'kode',
				'id' => 'kode',
				'class' => 'input input-xlarge',
				'label' => 'Kode',
		),
		'nama' => array(
				'nama',
				'label' => 'Nama',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'input input-xlarge',
		),
		'nourut' => array(
				'nourut',
				'label' => 'Urutan',
				'type' => 'input',
				'name' => 'nourut',
				'id' => 'nourut',
				'class' => 'input input-medium',
		),
);

// buttons

$btn_back = a("data/akademik/kategori_mapel", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel kategori mapel', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Kategori Mapel')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Kategori Mapel</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				echo '<fieldset>';

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"kode\">Kode kategori</label>"
				. "<div class=\"controls\">"
				. form_cell($input['kode'], $row)
				. "</div></div>" . NL;

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"nama\">Nama kategori</label>"
				. "<div class=\"controls\">"
				. form_cell($input['nama'], $row)
				. "</div></div>" . NL;

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"nourut\">Urutan</label>"
				. "<div class=\"controls\">"
				. form_cell($input['nourut'], $row)
				. "</div></div>" . NL;
				
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