<?php

// fungsi

function display_pengerjaan($row) {
	if ($row['ljs_last'])
		return tglwaktu($row['ljs_last']);

	return a("kbm/evaluasi_ljs/form?evaluasi_id={$row['id']}", 'kerjakan sekarang', 'title="klik untuk mengerjakan soal evaluasi ini sekarang"');
}

function display_ljs($row) {
	if (!$row['ljs_id'])
		return;

	return a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", 'lihat LJS', 'title="klik untuk melihat lembar jawab soal"');
}

function display_ljs_count($row) {
	return "{$row['ljs_count']} kali. &nbsp; "
				. ( ($row['ljs_max'] == 0) ? '<i class="subinfo">(maks tak dibatasi)</i>' : "<i>(maks {$row['ljs_max']} kali)</i>");
}

// item data

$detail['nilai'] = array(
		'Nilai' => array(
				'evaluasi_nilai',
				'suffix' => array(
						' &nbsp; &nbsp;',
						array(FALSE, 'display_ljs'),
				),
		),
		'Mengerjakan' => array(FALSE, 'display_ljs_count'),
		'Terakhir' => array(FALSE, 'display_pengerjaan'),
);

echo '<div class="form-horizontal"><fieldset>';
echo '<legend>Hasil Pengerjaan</legend>';

foreach ($detail['nilai'] as $label => $cdat):
	echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
	. data_cell($cdat, $row) . "</div></div>";
endforeach;

echo '</fieldset></div>';
