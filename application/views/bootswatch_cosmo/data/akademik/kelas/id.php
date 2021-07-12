<?php

// function

function display_wali($row) {
	return a("data/profil/sdm/id/{$row['wali_id']}", $row['wali_nama'], 'title="lihat profil wali kelas"');
}

function display_gurubk($row) {
	return ($row['gurubk_id']) ? a("data/profil/sdm/id/{$row['gurubk_id']}", $row['gurubk_nama'], 'title="lihat profil guru bk"') : '';
}

function display_pelajaran($row) {
	return a("data/akademik/pelajaran/id/{$row['id']}", $row['mapel_nama'], "title=\"lihat detail pelajaran {$row['nama']}\"")
				. (($row['agama_id']) ? "&nbsp;({$row['agama_nama']})" : '');
}

function display_guru($row) {
	return ($row['guru_id']) ? a("data/profil/sdm/id/{$row['guru_id']}", $row['guru_nama'], 'title="lihat detail pengajar"') : '';
}

function display_siswa($row) {
	return a("data/profil/siswa/id/{$row['id']}", $row['nama'], 'title="lihat detail siswa"');
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$view_nilai_kelas = cfguc_view('akses', 'nilai', 'kelas');
$walikelas_ybs = walikelas($row['id']);
$adminsdm = user_role('admin', 'sdm');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Kelas' => 'data/akademik/kelas',
		"#{$row['id']}",
);

// pills link

$pills_kiri[] = array(
		'label' => 'Daftar Kelas',
		'uri' => "data/akademik/kelas",
		'attr' => 'title="kembali ke daftar kelas"',
);
$pills_kanan = array();

if ($view_nilai_kelas OR $walikelas_ybs)
	$pills_kanan[] = array(
			'label' => '<i class="icon-search"></i> Riwayat Nilai',
			'uri' => "nilai/kelas/browse?kelas_id={$row['id']}",
			'attr' => 'title="telusuri riwayat nilai kelas ini"',
	);

if ($admin)
	$pills_kanan[] = array(
			'label' => '<i class="icon-edit"></i>Edit',
			'uri' => "data/akademik/kelas/form?id={$row['id']}",
			'attr' => 'title="ubah data kelas ini"',
			'class' => (($semaktif['id'] == 0) ? 'active' : 'disabled'),
	);

// data tabel

$detail['umum'] = array(
		'Nama' => array('nama'),
		'Wali' => array(FALSE, 'display_wali'),
);

if ($adminsdm)
	$detail['umum']['Aktif'] = array('aktif', array('tidak', 'ya'));

if ($semaktif['id'] > 0)
	$detail['umum']['Jumlah Siswa'] = 'siswa_jml';

$detail['tambahan'] = array(
		'Jurusan' => 'jurusan_nama',
		'Grade' => 'grade',
		'Kurikulum' => 'kurikulum_nama',
		'Bimbingan Konseling' => array(FALSE, 'display_gurubk'),
);

// subtabel data pelajaran

$table = array(
		'table_properties' => array(
				'id' => 'tabel-pelajaran',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data pelajaran masih kosong</i></p>',
		'data' => array(
				'Kategori' => 'kategori_kode',
				'Kode' => 'kode',
				'Pelajaran' => array(FALSE, 'display_pelajaran'),
				GURU_ALIAS . ' pengajar' => array(FALSE, 'display_guru'),
		),
);

// subtabel data siswa

$table_siswa = array(
		'table_properties' => array(
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data siswa kosong</i></p>',
		'data' => array(
				'NIS' => 'nis',
				'NISN' => 'nisn',
				'Nama' => array(FALSE, 'display_siswa'),
				'Gender' => array('gender', 'strtoupper'),
				'Agama' => 'agama_nama',
		),
);

//pills

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
			. pills($pills_kiri, 'class="nav nav-pills pull-left"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. '</td></tr></table></div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Kelas')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Detail Kelas</h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					#detail-tambahan{
						display: none;
					}
				</style>

				<?php
				echo alert_get();
				echo $bar_pills;

				// data utama

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Informasi Umum</legend>';

				foreach ($detail['umum'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// opsi tambahan

				echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
				echo '<div id="detail-tambahan" class="form-horizontal"><fieldset>';

				foreach ($detail['tambahan'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset><br/><br/></div>';

				$label = ($semaktif['id'] == 0) ? 'Sementara' : '';

				// daftar pelajaran

				echo '<div class="form-horizontal"><fieldset>';
				echo "<legend>Daftar Pelajaran {$label}</legend>";
				echo ds_table($table, $pelajaran_result);
				echo '</fieldset><br/><br/></div>';

				// daftar siswa

				echo '<div class="form-horizontal"><fieldset>';
				echo "<legend>Daftar Siswa {$label}</legend>";
				echo ds_table($table_siswa, $siswa_result);
				echo '</fieldset><br/><br/></div>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

		<script type="text/javascript">
			$(function() {
				$('#cmd-detail-tambahan').click(function() {
					$('#detail-tambahan').slideToggle(200);
				});
			});
		</script>

	</body>
</html>