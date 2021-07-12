<?php
// hak akses & user scope

$adminsdm = user_role('admin', 'sdm');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Jurusan' => 'data/akademik/jurusan',
		"#{$row['id']}",
);

// pills link

$pills_kiri[] = array(
		'label' => 'Tabel Jurusan',
		'uri' => "data/akademik/jurusan",
		'attr' => 'title="kembali ke tabel jurusan"',
);
$pills_kanan = array();

if ($admin):
	$pills_kanan[] = array(
			'label' => '<i class="icon-edit"></i> Edit',
			'uri' => "data/akademik/jurusan/form?id={$row['id']}",
			'attr' => 'title="ubah data jurusan ini"',
			'class' => 'active',
	);
endif;

// data tabel

if ($adminsdm)
	$dset['Kode'] = 'kode';

$dset['Nama'] = 'nama';
$dset['Deskripsi'] = 'deskripsi';
$dset['Aktif'] = array('aktif', array('tidak', 'ya'));

// pills bar

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
			. pills($pills_kiri, 'class="nav nav-pills pull-left"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. '</td></tr></table></div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Jurusan')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Detail Jurusan</h1>
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
				echo $bar_pills;
				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>