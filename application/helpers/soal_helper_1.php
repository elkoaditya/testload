<?php

function opsi_del(&$opsi, $x) {
	//$i = strpos($opsi, $x);
	$i = array_search($x, $opsi);

	if ($i !== FALSE)
		unset($opsi[$i]);
}

function opsi_del__(&$opsi, $x) {
	$i = strpos($opsi, $x);

	if ($i !== FALSE)
		unset($opsi[$i]);
}

function opsi_rand($time) {

	if (!is_numeric($time)):
		$dto = new DateTime($time);
		$time = (int) $dto->getTimestamp();

	else:
		$time = (int) $time;

	endif;

	$opsi = array('a', 'b', 'c', 'd', 'e');
	$feed = ($time % 5);

	return $opsi[$feed];
}

function soal_prepare(&$row) {

	$row['opsi'] = NULL;
	$row['pertanyaan'] = base64_decode($row['pertanyaan']);

	if (!$row['pilihan']):
		$row['pilihan'] = NULL;
		return;
	endif;

	$row['pilihan'] = json_decode($row['pilihan'], TRUE);

	if (!is_array($row['pilihan']) OR empty($row['pilihan'])):
		$row['pilihan'] = NULL;
		return;
	endif;

	$row['pilihan'] = (array) $row['pilihan'];
	$row['pilihan']['kunci'] = (array) $row['pilihan']['kunci'];

	if (!isset($row['pilihan']['kunci']['index']))
		$row['pilihan']['kunci']['index'] = opsi_rand($row['registered']);

	if (isset($row['pilihan']['kunci']['label']))
		$row['pilihan']['kunci']['label'] = base64_decode($row['pilihan']['kunci']['label']);
	else
		$row['pilihan']['kunci']['label'] = NULL;

	// siapkan pengecoh

	if (!isset($row['pilihan']['pengecoh']) OR !is_array($row['pilihan']['pengecoh'])):
		$row['pilihan']['pengecoh'] = array();

	else:
		foreach (array_keys($row['pilihan']['pengecoh']) as $index):
			$row['pilihan']['pengecoh'][$index] = base64_decode($row['pilihan']['pengecoh'][$index]);
		endforeach;
	endif;
}

function soal_prepjwb(&$butir) {
	soal_prepare($butir);

	// pengecekan jawaban pilihan ganda

	$kunci_index = array_node($butir, 'pilihan', 'kunci', 'index');

	if ($butir['jwb_pilihan'] && $butir['jwb_pilihan'] == $kunci_index):
		$butir['jwb_jawaban'] = array_node($butir, 'pilihan', 'kunci', 'label');

	elseif ($butir['jwb_pilihan'] && $kunci_index):
		$jawaban = array_node($butir, 'pilihan', 'pengecoh', $butir['jwb_pilihan']);

		if ($jawaban):
			$butir['jwb_jawaban'] = $jawaban;
		endif;

	elseif (!$butir['pilihan']):
		$butir['jwb_jawaban'] = base64_decode($butir['jwb_jawaban']);

	endif;
}

function soal_prepljs_(&$row) {
	soal_prepare($row);

	if (!is_array($row['pilihan']))
		return;

	$key = $row['pilihan']['kunci']['index'];
	$row['opsi'] = $row['pilihan']['pengecoh'];
	$row['opsi'][$key] = $row['pilihan']['kunci']['label'];
	$pilihan = array_keys($row['opsi']);

	shuffle($pilihan);

	foreach ($pilihan as $i)
		$opsi[$i] = $row['opsi'][$i];

	$row['opsi'] = $opsi;
}

function soal_prepljs(&$row) {
	soal_prepare($row);

	if (!is_array($row['pilihan']))
		return;

	$opsi = array('a', 'b', 'c', 'd', 'e');
	$key = $row['pilihan']['kunci']['index'];
	$row['opsi'][$key] = $row['pilihan']['kunci']['label'];

	opsi_del($opsi, $key);
	shuffle($opsi);

	foreach ($row['pilihan']['pengecoh'] as $pengecoh):
		$idx = array_shift($opsi);
		$row['opsi'][$idx] = $pengecoh;

	endforeach;

	//$row['opsi'] = $row['pilihan']['pengecoh'];
	$pilihan = array_keys($row['opsi']);

	shuffle($pilihan);

	foreach ($pilihan as $i)
		$opsi_baru[$i] = $row['opsi'][$i];

	$row['opsi'] = $opsi_baru;
}
