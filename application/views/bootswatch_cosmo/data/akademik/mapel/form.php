<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Mapel' => 'data/akademik/mapel',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/akademik/mapel/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => 'Daftar Mapel',
		'uri' => "data/akademik/mapel",
		'attr' => 'title="kembali ke tabel mapel"',
);

if ($row['id'] > 0)
	$pills[] = array(
			'label' => 'Detail Mapel',
			'uri' => "data/akademik/mapel/id/{$row['id']}",
			'attr' => 'title="kembali ke detail mapel"',
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
				'label' => 'Urutan K13',
				'type' => 'input',
				'name' => 'nourut',
				'id' => 'nourut',
				'class' => 'input input-medium',
		),
		'no_urut_ktsp' => array(
				'no_urut_ktsp',
				'label' => 'Urutan KTSP',
				'type' => 'input',
				'name' => 'no_urut_ktsp',
				'id' => 'no_urut_ktsp',
				'class' => 'input input-medium',
		),
);

// buttons

$btn_back = a("data/akademik/mapel", ' <i class="icon-table icon-white"></i> Kembali ke tabel mapel', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Mapel')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Mapel</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				echo '<fieldset>';

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"kode\">Kode mapel</label>"
				. "<div class=\"controls\">"
				. form_cell($input['kode'], $row)
				. "</div></div>" . NL;

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"nama\">Nama mapel</label>"
				. "<div class=\"controls\">"
				. form_cell($input['nama'], $row)
				. "</div></div>" . NL;
				
				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"nourut\">Urutan K13</label>"
				. "<div class=\"controls\">"
				. form_cell($input['nourut'], $row)
				. "</div></div>" . NL;
				
				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"no_urut_ktsp\">Urutan KTSP</label>"
				. "<div class=\"controls\">"
				. form_cell($input['no_urut_ktsp'], $row)
				. "</div></div>" . NL;

				echo '</fieldset>';

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions">'
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