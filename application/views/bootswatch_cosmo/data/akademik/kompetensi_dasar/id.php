<?php
// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Kompetensi Dasar' => 'data/akademik/kompetensi_dasar',
		"#{$row['id']}",
);

// pills link

$pills_kanan = array();
$pills_kiri[] = array(
		'label' => 'Daftar Kompetensi Dasar',
		'uri' => "data/akademik/kompetensi_dasar",
		'attr' => 'title="kembali ke daftar Kompetensi Dasar"',
);

if ($admin):
	$pills_kanan[] = array(
			'label' => '<i class="icon-edit"></i> Edit',
			'uri' => "data/akademik/kompetensi_dasar/form?id={$row['id']}",
			'attr' => 'title="ubah data kategori ini"',
			'class' => 'active',
	);
endif;

// data tabel

$dset['Kode'] = 'kode';
$dset['Nama'] = 'nama';

// pills bar

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
			. pills($pills_kiri, 'class="nav nav-pills pull-left"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. '</td></tr></table></div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Kompetensi Dasar')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Detail Kompetensi Dasar</h1>
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