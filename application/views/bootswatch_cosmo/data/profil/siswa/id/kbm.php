<?php

//function

function dispel_nama($row) {
	return a("data/akademik/pelajaran/id/{$row['id']}", $row['mapel_nama'], "title=\"lihat detail pelajaran ini ({$row['nama']})\"");
}

function dispel_guru($row) {
	return a("data/profil/sdm/id/{$row['guru_id']}", $row['guru_nama'], 'title="lihat detail pengajar"');
}

function dispel_kbm($row) {
	$params = "pelajaran_id={$row['id']}";
	return a("kbm/materi/browse?{$params}", 'materi', 'title="lihat materi pelajaran ini"') . ' &nbsp; '
				. a("kbm/evaluasi/browse?{$params}", 'evaluasi', 'title="lihat evaluasi pelajaran ini"');
}

function disxkul_nama($row) {
	return a("data/non_akademik/ekstrakurikuler/id/{$row['id']}", $row['nama'], "title=\"lihat detail ekstrakurikuler\"");
}

function disorg_nama($row) {
	return a("data/non_akademik/organisasi/id/{$row['id']}", $row['nama'], "title=\"lihat detail organisasi\"");
}

// bentuk tabel data pelajaran

$tabel_pelajaran = array(
		'table_properties' => array(
				'id' => 'tabel-pelajaran',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data tidak ditemukan</i></p>',
		'data' => array(
				'Kode' => 'kode',
				'Kurikulum' => 'kurikulum_nama',
				'Kategori' => 'kategori_kode',
				'Mata Pelajaran' => array(FALSE, 'dispel_nama'),
				(GURU_ALIAS) . ' Pengajar' => array(FALSE, 'dispel_guru'),
		),
);

if ($siswa_ybs && $semaktif['id'] > 0)
	$tabel_pelajaran['data']['Proses KBM'] = array(FALSE, 'dispel_kbm');

// bentuk tabel data ekskul

$tabel_ekskul = array(
		'table_properties' => array(
				'id' => 'tabel-ekskul',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data tidak ditemukan</i></p>',
		'data' => array(
				'Nama' => array(FALSE, 'disxkul_nama'),
		),
);

// bentuk tabel data org

$tabel_organisasi = array(
		'table_properties' => array(
				'id' => 'tabel-org',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data tidak ditemukan</i></p>',
		'data' => array(
				'Nama' => array(FALSE, 'disorg_nama'),
		),
);

////////// mulai generate tampilan ////////////////////

$label_judul = ($semaktif['id'] == 0) ? 'Sementara' : 'yang Diikuti';

echo '<div class="form-horizontal"><fieldset>';
echo "<legend>Daftar Pelajaran {$label_judul}</legend>";
echo ds_table($tabel_pelajaran, $pelajaran_result);
echo '</fieldset><br/><br/></div>';

if ($semaktif['id'] > 0):

	echo '<div class="row">';

	echo '<div class="span6"><fieldset>';
	echo "<legend>Daftar Ekstrakurikuler {$label_judul}</legend>";
	echo ds_table($tabel_ekskul, $ekskul_result);
	echo '</fieldset><br/><br/></div>';

	echo '<div class="span6"><fieldset>';
	echo "<legend>Daftar Kelas {$label_judul}</legend>";
	echo ds_table($tabel_organisasi, $organisasi_result);
	echo '</fieldset><br/><br/></div>';

	echo '</div>';

endif;