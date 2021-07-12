<?php

function input_akses($row, $node, $namid, $label) {
	$ci = & get_instance();
	$prenode = array('xdat', 'config', 'akses');
	$node = array_merge($prenode, $node);
	$def = (string) array_node($row, $node);
	$val = (string) ($ci->d['post_request']) ? $ci->input->post($namid) : $def;
	$cfg = array(
			'type' => 'dropdown',
			'name' => $namid,
			'value' => $val,
			'extra' => "class=\"input-medium select\" id=\"{$namid}\"",
			'options' => array(
					'none' => 'none',
					'view' => 'view',
					'admin' => 'admin',
			),
	);
	$label_attr = array(
			'class' => 'list-label',
			'for' => $namid,
	);
	$input = tag('label', $label_attr, $label) . ' &nbsp; ' . form_cell($cfg);
	return li('style="vertical-align: middle"', $input);
}

$row['xdat'] = (array) json_decode($row['xdat'], TRUE);
?>
<style>
</style>
<fieldset>

	<legend>Hak Akses Data</legend>

	<ul style="padding-left: 20px;">

		<?php
		if ($row['role'] == 'admin')
			echo input_akses($row, array('app'), 'a-app', 'App');

		echo input_akses($row, array('log'), 'a-log', 'Log');
		echo input_akses($row, array('periode'), 'a-periode', 'Periode');
		?>
		<li>Data
			<ul style="padding-left: 20px;">

				<?php echo input_akses($row, array('data', 'user'), 'a-d-user', 'User'); ?>

				<li>Master
					<ul style="padding-left: 20px;">
						<?php
						echo input_akses($row, array('data', 'master', 'jabatan'), 'a-d-m-jabatan', 'Jabatan');
						//echo input_akses($row, array('data', 'master', 'kota'), 'a-d-m-kota', 'Kota');
						//echo input_akses($row, array('data', 'master', 'aspek_pribadi'), 'a-d-m-aspri', 'Aspek pribadi');
						?>
					</ul>
				</li>

				<li>Profil
					<ul style="padding-left: 20px;">
						<?php
						echo input_akses($row, array('data', 'profil', 'admin'), 'a-d-p-admin', 'Admin');
						echo input_akses($row, array('data', 'profil', 'sdm'), 'a-d-p-sdm', 'SDM &amp; ' . strtolower(GURU_ALIAS));
						echo input_akses($row, array('data', 'profil', 'siswa'), 'a-d-p-siswa', 'Siswa');
						//echo input_akses($row, array('data', 'profil', 'wali'), 'a-d-p-wali', 'Wali');
						//echo input_akses($row, array('data', 'profil', 'sekolah'), 'a-d-p-sekolah', 'Sekolah');
						?>
					</ul>
				</li>

				<li>Akademik
					<ul style="padding-left: 20px;">
						<?php
						echo input_akses($row, array('data', 'akademik', 'jurusan'), 'a-d-a-jurusan', 'Jurusan');
						echo input_akses($row, array('data', 'akademik', 'kelas'), 'a-d-a-kelas', 'Kelas');
						echo input_akses($row, array('data', 'akademik', 'kategori_mapel'), 'a-d-a-kategori_mapel', 'Kategori mapel');
						echo input_akses($row, array('data', 'akademik', 'mapel'), 'a-d-a-mapel', 'Mapel');
						echo input_akses($row, array('data', 'akademik', 'pelajaran'), 'a-d-a-pelajaran', 'Pelajaran');
						?>
					</ul>
				</li>

				<li>Non-Akademik
					<ul style="padding-left: 20px;">
						<?php
						echo input_akses($row, array('data', 'master', 'ekskul'), 'a-d-n-ekskul', 'Ekstrakurikuler');
						echo input_akses($row, array('data', 'master', 'organisasi'), 'a-d-n-organisasi', 'Organiasasi');
						?>
					</ul>
				</li>

			</ul>
		</li>

		<li>KBM
			<ul style="padding-left: 20px;">
				<?php
				echo input_akses($row, array('kbm', 'materi'), 'a-k-materi', 'Materi');
				echo input_akses($row, array('kbm', 'evaluasi'), 'a-k-evaluasi', 'Evaluasi');
				echo input_akses($row, array('kbm', 'jurnal_kelas'), 'a-k-jurnal_kelas', 'Jurnal kelas');
				echo input_akses($row, array('kbm', 'absensi'), 'a-k-absensi', 'Absensi');
				?>
			</ul>
		</li>

		<li>Nilai
			<ul style="padding-left: 20px;">
				<?php
				echo input_akses($row, array('nilai', 'organisasi'), 'a-n-organisasi', 'Organisasi');
				echo input_akses($row, array('nilai', 'ekskul'), 'a-n-ekskul', 'Ekstrakurikuler');
				echo input_akses($row, array('nilai', 'kelas'), 'a-n-kelas', 'Kelas');
				echo input_akses($row, array('nilai', 'pelajaran'), 'a-n-pelajaran', 'Pelajaran');
				echo input_akses($row, array('nilai', 'siswa'), 'a-n-siswa', 'Siswa');
				echo input_akses($row, array('nilai', 'siswa_pelajaran'), 'a-n-siswa_pelajaran', 'Siswa-pelajaran');
				?>
			</ul>
		</li>

	</ul>

	<!--
		<div class="control-group">

			<label class="control-label" for=""></label>

			<div class="controls">

			</div>

		</div>
	-->

</fieldset><br/><br/>
