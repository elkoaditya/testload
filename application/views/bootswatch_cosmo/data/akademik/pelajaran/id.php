<?php

// function

function display_guru($row) {
	if ($row['guru_id'])
		return a("data/profil/sdm/id/{$row['guru_id']}", $row['guru_nama'], "title=\"lihat profil " . strtolower(GURU_ALIAS) . "\"");

	return '';
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Pelajaran' => 'data/akademik/pelajaran',
		"#{$row['id']}",
);

// pills link
$pills_kanan = array();
$pills_kiri[] = array(
		'label' => 'Daftar Pelajaran',
		'uri' => "data/akademik/pelajaran",
		'attr' => 'title="kembali ke tabel pelajaran"',
);

if ($admin):
	$pills_kanan[] = array(
			'label' => '<i class="icon-edit"></i>Edit',
			'uri' => "data/akademik/pelajaran/form?id={$row['id']}",
			'attr' => 'title="ubah data pelajaran ini"',
			'class' => (($semaktif['id'] == 0) ? 'active' : 'disabled'),
	);
endif;

// data tabel

$dset['Kode'] = 'kode';
$dset['Nama'] = 'nama';
$dset['Mata Pelajaran'] = 'mapel_nama';
$dset['Pengajar'] = array(FALSE, 'display_guru');
$dset['Kategori'] = 'kategori_nama';
$dset['Kurikulum'] = 'kurikulum_nama';
$dset['Bentuk pelajaran'] = array(
		'teori', array('', 'Teori'),
		'suffix' => array(
				' ',
				array('praktek', array('', 'Praktek'),),
		),
);

if ($view)
	$dset['Aktif'] = array('aktif', array('Tidak', 'Ya'));

$kelas_list = array('data' => 'nama');

// pills bar

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
			. pills($pills_kiri, 'class="nav nav-pills pull-left"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. '</td></tr></table></div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Pelajaran')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Detail Pelajaran</h1>
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

				echo '<div class="form-horizontal"><fieldset><legend>Informasi Umum</legend>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset><br/><br/>';

				// daftar peserta

				echo '<fieldset><legend>Perserta Pelajaran</legend>';

				echo "<div class=\"control-group\"><label class=\"control-label\">Agama</label><div class=\"controls\">";
				echo $row['agama_nama'];
				echo "</div></div>";

				echo "<div class=\"control-group\"><label class=\"control-label\">Kelas</label><div class=\"controls\">";
				echo ds_list($kelas_list, $row['kelas_result']);
				echo "</div></div>";

				echo '</fieldset></div>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>