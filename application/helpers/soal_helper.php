<?php

//sma1
function opsi_del(&$opsi, $x)
{
	//$i = strpos($opsi, $x);
	$i = array_search($x, $opsi);

	if ($i !== FALSE)
		unset($opsi[$i]);

}

function opsi_rand($time)
{

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

function soal_prepare(&$row)
{

	$row['opsi'] = NULL;
	$row['pertanyaan'] 	= base64_decode($row['pertanyaan']);
	$kunsian = 1;
	while($kunsian<=9){
		$row['kunci_isian'.$kunsian] = base64_decode($row['kunci_isian'.$kunsian]);
		$kunsian++;
	}

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
	if(isset($row['pilihan']['kunci'])){
		$row['pilihan']['kunci'] = (array) $row['pilihan']['kunci'];
	}else{
		$row['pilihan']['kunci'] = '';
	}
	
	if (!isset($row['pilihan']['kunci']['index']))
		$row['pilihan']['kunci']['index'] = opsi_rand($row['registered']);

	if (isset($row['pilihan']['kunci']['label']))
		$row['pilihan']['kunci']['label'] = base64_decode($row['pilihan']['kunci']['label']);
	else
		$row['pilihan']['kunci']['label'] = NULL;

	// siapkan pengecoh

	if (!isset($row['pilihan']['pengecoh']) OR ! is_array($row['pilihan']['pengecoh'])):
		$row['pilihan']['pengecoh'] = array();

	else:
		foreach (array_keys($row['pilihan']['pengecoh']) as $index):
			$row['pilihan']['pengecoh'][$index] = base64_decode($row['pilihan']['pengecoh'][$index]);
		endforeach;
	endif;

}

function soal_angket_prepare(&$row)
{

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
	/*
	  $row['pilihan']['kunci'] = (array) $row['pilihan']['kunci'];

	  if (!isset($row['pilihan']['kunci']['index']))
	  $row['pilihan']['kunci']['index'] = opsi_rand($row['registered']);

	  if (isset($row['pilihan']['kunci']['label']))
	  $row['pilihan']['kunci']['label'] = base64_decode($row['pilihan']['kunci']['label']);
	  else
	  $row['pilihan']['kunci']['label'] = NULL;
	 */
	// siapkan pengecoh

	if (!isset($row['pilihan']['pengecoh']) OR ! is_array($row['pilihan']['pengecoh'])):
		$row['pilihan']['pengecoh'] = array();

	else:
		foreach (array_keys($row['pilihan']['pengecoh']) as $index):
			$row['pilihan']['pengecoh'][$index] = base64_decode($row['pilihan']['pengecoh'][$index]);
		endforeach;
	endif;

}

function soal_prepjwb(&$butir)
{
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

function soal_angket_prepjwb(&$butir)
{
	soal_angket_prepare($butir);

	// pengecekan jawaban pilihan ganda

	/* $kunci_index = array_node($butir, 'pilihan', 'kunci', 'index');

	  if ($butir['jwb_pilihan'] && $butir['jwb_pilihan'] == $kunci_index):
	  $butir['jwb_jawaban'] = array_node($butir, 'pilihan', 'kunci', 'label');

	  elseif ($butir['jwb_pilihan'] && $kunci_index):
	 */ $jawaban = array_node($butir, 'pilihan', 'pengecoh', $butir['jwb_pilihan']);

	if ($jawaban):
		$butir['jwb_jawaban'] = $jawaban;
	endif;

	if (!$butir['pilihan']):
		$butir['jwb_jawaban'] = base64_decode($butir['jwb_jawaban']);

	endif;

}

function soal_prepljs(&$row,$opsi_acak)
{
	soal_prepare($row);

	$opsi = $opsi_acak[$row['id']]; 
	$opsi_shuffle = explode(",",$opsi);
	array_pop($opsi_shuffle);
	
	$key = $row['pilihan']['kunci']['index'];
	$row['opsi'][$key] = $row['pilihan']['kunci']['label'];
	
	foreach ($opsi_shuffle as $idx)
	{
		if (isset($row['pilihan']['pengecoh'][$idx]))
		{
			$row['opsi'][$idx] = $row['pilihan']['pengecoh'][$idx];
		}
	}
	
	foreach ($opsi_shuffle as $i)
	{
		if(isset($row['opsi'][$i]))
		{
			$opsi_baru[$i] = $row['opsi'][$i];
		}
	}
	if(isset($opsi_baru))
	{
		$row['opsi'] = $opsi_baru;
	}
}

function soal_prepljs_print(&$row)
{
	soal_prepare($row);

	if (!is_array($row['pilihan']))
		return;

	$opsi = array('a', 'b', 'c', 'd', 'e');
	$key = $row['pilihan']['kunci']['index'];
	$row['opsi'][$key] = $row['pilihan']['kunci']['label'];

	opsi_del($opsi, $key);
	shuffle($opsi);

	foreach ($opsi as $idx)
	{
		if (isset($row['pilihan']['pengecoh'][$idx]))
		{
			$row['opsi'][$idx] = $row['pilihan']['pengecoh'][$idx];
		}
	}

	/* / kode pengacak sebelumnya terdapat error
	  foreach ($row['pilihan']['pengecoh'] as $pengecoh):
	  $idx = array_shift($opsi);
	  $row['opsi'][$idx] = $pengecoh;

	  endforeach;
	  // */

	//$row['opsi'] = $row['pilihan']['pengecoh'];
	$pilihan = array_keys($row['opsi']);

	shuffle($pilihan);

	foreach ($pilihan as $i)
		$opsi_baru[$i] = $row['opsi'][$i];

	if(isset($opsi_baru))
	{
		$row['opsi'] = $opsi_baru;
	}

}

function soal_angket_prepljs(&$row)
{
	soal_angket_prepare($row);

	if (!is_array($row['pilihan']))
		return;

	$opsi = array('a', 'b', 'c', 'd', 'e');
	/* $key = $row['pilihan']['kunci']['index'];
	  $row['opsi'][$key] = $row['pilihan']['kunci']['label'];

	  opsi_del($opsi, $key);
	  shuffle($opsi);
	 */

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

function soal_ana_tk($n)
{
	// =IF(B15>=0.71,"Soal Mudah",IF(AND(B15<0.71,B15>=0.31),"Soal Sedang","Soal Sulit"))
	$n = (float) $n;

	if ($n >= 0.71)
		return 'Soal Mudah';

	if ($n >= 0.31)
		return 'Soal Sedang';

	return 'Soal Sulit';

}

function soal_ana_db($n)
{
	//=IF(L16>=0.4,"Daya Beda Baik",IF(AND(L16<0.4,L16>=0.2),"Daya Beda Sedang","Tidak Dapat Membedakan"))

	$n = (float) $n;

	if ($n >= 0.4)
		return 'Daya Beda Baik';

	if ($n >= 0.2)
		return 'Daya Beda Sedang';

	return 'Tidak Dapat Membedakan';

}

function soal_analisa($db)
{
	//=IF(AND(L16>=0.4,L16<=1),"Soal Baik",
	//	IF(AND(L16<0.4,L16>=0.3),"Soal Diterima & Perbaiki",
	//	IF(AND(L16<0.3,L16>=0.2),"Soal Diperbaiki",
	//	"Soal Ditolak")))

	$db = (float) $db;

	if ($db >= 0.4 && $db <= 1)
		return 'Soal Baik';

	if ($db < 0.4 && $db >= 0.3)
		return 'Soal Diterima &amp; Perbaiki';

	if ($db < 0.3 && $db >= 0.2)
		return 'Soal Diperbaiki';

	return 'Soal Ditolak';

}

function essay_jawaban_prepare(&$row)
{
	$row['jawaban'] = base64_decode($row['jawaban']);

}