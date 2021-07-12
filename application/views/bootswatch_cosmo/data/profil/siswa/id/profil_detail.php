<?php

$detail = array(
		'keluarga' => array(
				'Status' => 'status_keluarga',
				'Anak ke' => 'anak_ke',
				'Nama Ayah' => 'ayah_nama',
				'Pekerjaan Ayah' => 'ayah_pekerjaan',
				'Nama Ibu' => 'ibu_nama',
				'Pekerjaan Ibu' => 'ibu_pekerjaan',
				'Alamat Orangtua' => 'ortu_alamat',
				'Telepon Orangtua' => 'ortu_telepon',
				'Nama Wali' => 'wali_nama',
				'Alamat Wali' => 'wali_alamat',
				'Telepon Wali' => 'wali_telepon',
				'Pekerjaan Wali' => 'wali_pekerjaan',
		),
		'asal' => array(
				'Nama' => 'asal_sekolah_nama',
				'Alamat' => 'asal_sekolah_alamat',
				'Jenjang' => 'asal_sekolah_jenjang',
				'Nomor ijazah' => 'asal_ijazah_no',
				'Nomor SKHU' => 'asal_skhu_no',
				'Tahun' => 'asal_ijazah_tahun',
		),
		'baru' => array(
				'Nama Sekolah Terbaru' => 'baru_sekolah_nama',
				'Tanggal Masuk Sekolah Terbaru' => 'baru_sekolah_tgl',
				'Alamat Sekolah Terbaru' => 'baru_sekolah_alamat',
				'Nama Pekerjaan Terbaru' => 'baru_kerja_nama',
				'Tanggal Pekerjaan Terbaru' => 'baru_kerja_tgl',
				'Alamat Pekerjaan Terbaru' => 'baru_kerja_alamat',
				'Catatan Terbaru' => 'baru_ket',
		),
		'masuk' => array(
				'Semester' => array(
						'masuk_semester_nama',
						'suffix' => array(
								' ',
								'masuk_ta_nama',
						),
				),
				'Jalur' => 'masuk_jalur',
				'Tanggal' => array('masuk_tgl', 'tgl'),
				'Kelas' => 'masuk_kelas_nama',
		),
		'keluar' => array(
				'Semester' => array(
						'keluar_semester_nama',
						'suffix' => array(
								' ',
								'keluar_ta_nama',
						),
				),
				'Sebab' => 'keluar_sebab',
				'Tanggal' => array('keluar_tgl', 'tgl'),
				'Kelas' => 'keluar_kelas_nama',
		),
);

echo '<div class="form-horizontal data-lengkap"><fieldset>';
echo '<legend>Status Terbaru</legend>';

foreach ($detail['baru'] as $label => $cdat):
	echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
	. data_cell($cdat, $row) . "</div></div>";
endforeach;
echo '</fieldset><br/><br/></div>';
echo '<legend>Masuk Pendaftaran</legend>';

foreach ($detail['masuk'] as $label => $cdat):
	echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
	. data_cell($cdat, $row) . "</div></div>";
endforeach;
echo '</fieldset><br/><br/></div>';

echo '<div class="form-horizontal data-lengkap"><fieldset>';
echo '<legend>Asal Sekolah</legend>';

foreach ($detail['asal'] as $label => $cdat):
	echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
	. data_cell($cdat, $row) . "</div></div>";
endforeach;

echo '</fieldset><br/><br/></div>';

echo '<div class="form-horizontal data-lengkap"><fieldset>';
echo '<legend>Keluarga</legend>';

foreach ($detail['keluarga'] as $label => $cdat):
	echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
	. data_cell($cdat, $row) . "</div></div>";
endforeach;

echo '</fieldset><br/><br/></div>';

echo '<div class="form-horizontal data-lengkap"><fieldset>';
echo '<legend>Keluar/Kelulusan</legend>';

foreach ($detail['keluar'] as $label => $cdat):
	echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
	. data_cell($cdat, $row) . "</div></div>";
endforeach;

echo '</fieldset><br/><br/></div>';

