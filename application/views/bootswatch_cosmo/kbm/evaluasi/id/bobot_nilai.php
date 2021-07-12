<?php

echo '<div class="form-horizontal"><fieldset>';
echo '<legend>Bobot Nilai</legend>';

echo '<div class="pull-right soal-pills">';
echo a("kbm/evaluasi/form_bobot_nilai?id={$row['id']}", 'Edit Bobot Nilai', 'class="btn btn-small btn-success"');

echo '</div>';

$detail['nilai'] = array(
		'Bobot Nilai Pilihan Ganda' => 'bobot_pilgan',
);

if($row['plus_isian']==1){
	$detail['nilai']['Bobot Nilai Isian Singkat'] = 'bobot_isian';
}

if($row['plus_uraian']==1){
	$detail['nilai']['Bobot Nilai Uraian'] = 'bobot_uraian';
}

$total = 0;
foreach ($detail['nilai'] as $label => $cdat):
	$total = $total+$row[$cdat];
	echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
	. data_cell($cdat, $row) . " % </div></div>";
endforeach;

echo "<div class=\"control-group\">
		<label class=\"control-label\">Total</label>
		<div class=\"controls\">".$total." % </div>
		</div>";

echo '</fieldset></div>';