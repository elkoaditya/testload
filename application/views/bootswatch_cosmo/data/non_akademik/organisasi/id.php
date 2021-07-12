<?php
// hak akses & user scope

$admin = cfguc_admin('akses', 'data', 'non_akademik', 'organisasi');
$view = cfguc_view('akses', 'data', 'non_akademik', 'organisasi');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Non-Akademik' => 'data/non_akademik',
		'Organisasi' => 'data/non_akademik/organisasi',
		"#{$row['id']}",
);

// pills link

$pills[] = array(
		'label' => '<i class="icon-table"></i>Tabel Organisasi',
		'uri' => "data/non_akademik/organisasi",
		'attr' => 'title="kembali ke tabel organisasi"',
);

if ($admin):
	$pills[] = array(
			'label' => '<i class="icon-edit"></i>Edit Organisasi Ini',
			'uri' => "data/non_akademik/organisasi/form?id={$row['id']}",
			'attr' => 'title="ubah data organisasi ini"',
	);
endif;

// data tabel

$dset['Nama'] = 'nama';
$dset['Pembina'] = 'pembina_nama';

if ($view)
	$dset['Aktif'] = array('aktif', array('tidak', 'ya'));
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Organisasi')); ?>

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
				echo pills($pills);
				echo '<div class="form-horizontal well"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div>';
				echo pills($pills);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>