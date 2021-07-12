<?php

function nisispel_rerata(&$row, $kkm, $teori = TRUE, $praktek = TRUE) {
	$dumpingan = ($row['id'] == 2217 && TRUE);
	$kkm = (float) $kkm;
	$rkd_harian = array();
	$rkd_tugas = array();
	$rkd_praktek = array();
	$kd_teori = array();
	$kd_praktek = array();
	$jml_teori		= 0;
	$jml_praktek	= 0;
	$jml_sikap		= 0;
	$jml_nilai_teori	= 0;
	$jml_nilai_praktek	= 0;
	$jml_nilai_sikap	= 0;
	// ulangan umum

	$row['uts'] = (is_numeric($row['uts'])) ? (float) $row['uts'] : NULL;
	$row['uas'] = (is_numeric($row['uas'])) ? (float) $row['uas'] : NULL;

	// proses no 1-40

	for ($no = 1; $no <= 10; $no++):

		$_kd_no = ceil($no / 10);

		if ($teori):
			//$u = $row['u' . $no];
			$r = $row['r' . $no];
			$h = $row['h' . $no];
			// proses nilai harian

			if (empty($h) OR !is_numeric($h)):
				//$row['u' . $no] = NULL;
				$row['r' . $no] = NULL;
				$row['h' . $no] = NULL;
/*
			elseif ($u >= $kkm OR empty($r) OR !is_numeric($r) OR $u > $r):
				//$row['u' . $no] = (float) $u;
				$row['r' . $no] = (is_numeric($r)) ? (float) $r : NULL;
				$row['h' . $no] = (float) $u;

			elseif ($r > $kkm):
				//$row['u' . $no] = (float) $u;
				$row['r' . $no] = (float) $r;
				$row['h' . $no] = (float) $kkm;
*/
			elseif($h > $r):
				$row['h' . $no] = (float) $h;

			else:
				//$row['u' . $no] = (float) $u;
				//$row['r' . $no] = (float) $r;
				$row['h' . $no] = (float) $r;

			endif;

			// proses nilai kd

			if (is_numeric($row['h' . $no]))
				$rkd_teori[$_kd_no]['list'][] = $row['h' . $no];
				//echo $_kd_no."ff  ";
			//if (is_numeric($row['t' . $no]))
				//$rkd_tugas[$_kd_no]['list'][] = $row['t' . $no];

		endif;
	endfor;
	
	for ($no = 1; $no <= 9; $no++):
		if ($praktek):
		
			$_kd_no = ceil($no / 9);
			
			$rp = $row['rp' . $no];
			$p = $row['p' . $no];
			// proses nilai harian

			if (empty($p) OR !is_numeric($p)):
				//$row['u' . $no] = NULL;
				$row['rp' . $no] = NULL;
				$row['p' . $no] = NULL;
				
			elseif($p > $rp):
				$row['p' . $no] = (float) $p;

			else:
				//$row['u' . $no] = (float) $u;
				//$row['r' . $no] = (float) $r;
				$row['p' . $no] = (float) $rp;

			endif;
			
			if (is_numeric($row['p' . $no]))
				$rkd_praktek[$_kd_no]['list'][] = $row['p' . $no];
			
		endif;
		
	endfor;
	
	//nilai sikap
	for ($no = 1; $no <= 4; $no++):
		$_kd_no = ceil($no / 4);
		
		if (($teori)&&($praktek)):
			if (is_numeric($row['s' . $no]))
				$rkd_sikap[$_kd_no]['list'][] = $row['s' . $no];
		endif;
	endfor;

	// proses per KD

	for ($no = 1; $no <= 10; $no++):
/*
		if ($teori):

			if (isset($rkd_harian[$no])):
				$rkd_harian[$no]['rata2'] = avg($rkd_harian[$no]['list']);
			endif;

			if (isset($rkd_tugas[$no])):
				//$rkd_tugas[$no]['rata2'] = avg($rkd_tugas[$no]['list']);
			endif;

			if (isset($rkd_harian[$no]) && isset($rkd_tugas[$no])):
				//$kd_teori[$no] = ( ( ( 2 * $rkd_harian[$no]['rata2'] ) + $rkd_tugas[$no]['rata2'] ) / 3 );
				$kd_teori[$no] = $rkd_harian[$no]['rata2'];
				
			elseif (isset($rkd_harian[$no])):
				$kd_teori[$no] = $rkd_harian[$no]['rata2'];

			elseif (isset($rkd_tugas[$no])):
				//$kd_teori[$no] = $rkd_tugas[$no]['rata2'];

			endif;

		endif;
*/
		if ($teori):
			if (isset($rkd_teori[$no])):
				$jml_teori++;
				$jml_nilai_teori = $jml_nilai_teori + avg($rkd_teori[$no]['list']);
			endif;

		endif;
		
		if ($praktek):
			if (isset($rkd_praktek[$no])):
				$jml_praktek++;
				$jml_nilai_praktek = $jml_nilai_praktek + avg($rkd_praktek[$no]['list']);
				//echo " ".$no."a".$kd_praktek[$no]." ";
				//$kd_praktek[$no] = $rkd_praktek[$no]['list'];
			endif;

		endif;
		
		if (($teori)&&($praktek)):
			if (isset($rkd_sikap[$no])):
				$jml_sikap++;
				$jml_nilai_sikap = $jml_nilai_sikap + avg($rkd_sikap[$no]['list']);
			endif;

		endif;
		
	endfor;

	// rata2 nilai harian & praktek
	$bobot_teori=1;
	if($row['uts']!=NULL)
		$bobot_teori++;
	if($row['uas']!=NULL)
		$bobot_teori++;
	
	$nt = (empty($jml_nilai_teori)) ? NULL : ($row['uts']+$row['uas']+round(($jml_nilai_teori/$jml_teori),0) )/$bobot_teori;
	$np = (empty($jml_nilai_praktek)) ? NULL : ($jml_nilai_praktek/$jml_praktek);
	$ns = (empty($jml_nilai_sikap)) ? NULL : ($jml_nilai_sikap/$jml_sikap);
	
	$row['nas_teori']	= $nt;
	$row['nas_praktek']	= $np;
	$row['nas_sikap']	= $ns;
/*
	// nilai akhir praktek

	if ($praktek && $teori):
		$row['nas_praktek'] = $np;

	elseif (!$praktek):
		$row['nas_praktek'] = NULL;

	else:
	
		$bobot_uas = 1;
		$bobot_uts = 1;
		$bobot_np = 3;
		$bobot_total = 0;
		$score_total = 0;

		if (is_numeric($row['uas'])):
			$bobot_total += $bobot_uas;
			$score_total += ($row['uas'] * $bobot_uas);

		endif;

		if (is_numeric($row['uts'])):
			$bobot_total += $bobot_uts;
			$score_total +=( $row['uts'] * $bobot_uts);

		endif;

		if (is_numeric($np)):
			$bobot_total += $bobot_np;
			$score_total += ($np * $bobot_np);

		endif;

		$row['nas_praktek'] = ($bobot_total > 0) ? ($score_total / $bobot_total) : NULL;

	endif;


	//* /
	if ($dumpingan):
		alert_dump('dumping');
		alert_dump($teori, 'teori');
		alert_dump($row['uas'], 'nilai uas');
		alert_dump($rkd_praktek, 'r kd praktek');
		alert_dump($kd_praktek, 'kd praktek');
		alert_dump($np, 'np');
		alert_dump($score_total, 'score_total praktek');
		alert_dump($bobot_total, 'bobot_total praktek');
	endif;

	
	// olah nilai teori

	$bobot_uas = 1;
	$bobot_uts = 1;
	$bobot_nh = 3;
	$bobot_total = 0;
	$score_total = 0;

	if ($teori && is_numeric($row['uas'])):
		$bobot_total += $bobot_uas;
		$score_total += ($row['uas'] * $bobot_uas);

	endif;

	if ($teori && is_numeric($row['uts'])):
		$bobot_total += $bobot_uts;
		$score_total +=( $row['uts'] * $bobot_uts);

	endif;

	if ($teori && is_numeric($nh)):
		$bobot_total += $bobot_nh;
		$score_total += ($nh * $bobot_nh);

	endif;

	$row['nas_teori'] = ($bobot_total > 0) ? ($score_total / $bobot_total) : NULL;


	
	if ($dumpingan):
		alert_dump($rkd_harian, 'r kd harian');
		alert_dump($rkd_tugas, 'r kd tugas');
		alert_dump($kd_teori, 'kd teori');
		alert_dump($nh, 'nh');
		alert_dump($score_total, 'score_total teori');
		alert_dump($bobot_total, 'bobot_total teori');
		alert_dump($row, 'row');
	endif;
*/
	// nilai akhir total

	$row['nas_total'] = ((float) $row['nas_teori']+(float) $row['nas_praktek']+(float) $row['nas_sikap'])/3;
}
