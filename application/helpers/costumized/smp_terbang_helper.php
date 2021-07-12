<?php

function nisispel_rerata(&$row, $kkm, $teori = TRUE, $praktek = TRUE) {
	$kkm = (float) $kkm;
	$nilai_harian_list = array();
	$nilai_praktek_list = array();
	$rkd_harian = array();
	$rkd_tugas = array();
	$rkd_praktek = array();
	$kd_teori = array();
	$kd_praktek = array();

	// ulangan umum

	$row['uts'] = (is_numeric($row['uts'])) ? (float) $row['uts'] : NULL;
	$row['uas'] = (is_numeric($row['uas'])) ? (float) $row['uas'] : NULL;

	// proses no 1-40

	for ($no = 1; $no <= 40; $no++):

		$_kd_no = ceil($no / 4);

		if ($teori):
			$u = $row['u' . $no];
			$r = $row['r' . $no];

			// proses nilai harian

			if (!is_numeric($u)):
				$row['u' . $no] = NULL;
				$row['r' . $no] = NULL;
				// $row['h' . $no] = NULL;

			elseif ($u >= $kkm OR !is_numeric($r) OR $u > $r):
				$row['u' . $no] = (float) $u;
				$row['r' . $no] = (is_numeric($r)) ? (float) $r : NULL;
				// $row['h' . $no] = (float) $u;

			elseif ($r > $kkm):
				$row['u' . $no] = (float) $u;
				$row['r' . $no] = (float) $r;
				// $row['h' . $no] = (float) $kkm;

			else:
				$row['u' . $no] = (float) $u;
				$row['r' . $no] = (float) $r;
				// $row['h' . $no] = (float) $r;

			endif;

			// proses nilai kd

			// if (is_numeric($row['h' . $no]))
				// $rkd_harian[$_kd_no]['list'][] = $row['h' . $no];

			// if (is_numeric($row['t' . $no]))
				// $rkd_tugas[$_kd_no]['list'][] = $row['t' . $no];

		endif;

		if ($praktek):
			if (is_numeric($row['p' . $no]))
				$rkd_praktek[$_kd_no]['list'][] = $row['p' . $no];

		endif;

	endfor;

	// proses per KD

	for ($no = 1; $no <= 10; $no++):

		if ($teori):

			if (isset($rkd_harian[$no])):
				$rkd_harian[$no]['rata2'] = avg($rkd_harian[$no]['list']);
			endif;

			if (isset($rkd_tugas[$no])):
				$rkd_tugas[$no]['rata2'] = avg($rkd_tugas[$no]['list']);
			endif;

			if (isset($rkd_harian[$no]) && isset($rkd_tugas[$no])):
				$kd_teori[$no] = ( ( ( 2 * $rkd_harian[$no]['rata2'] ) + $rkd_tugas[$no]['rata2'] ) / 3 );

			elseif (isset($rkd_harian[$no])):
				$kd_teori[$no] = $rkd_harian[$no]['rata2'];

			elseif (isset($rkd_tugas[$no])):
				$kd_teori[$no] = $rkd_tugas[$no]['rata2'];

			endif;

		endif;

		if ($praktek):
			if (isset($rkd_praktek[$no])):
				$kd_praktek[$no] = avg($rkd_praktek[$no]['list']);
			endif;

		endif;

	endfor;

	// rata2 nilai harian & praktek

	$nh = (empty($kd_teori)) ? NULL : avg($kd_teori);
	$np = (empty($kd_praktek)) ? NULL : avg($kd_praktek);

	// nilai akhir praktek

	if (!$praktek):
		$row['nas_praktek'] = NULL;

	elseif ($teori):
		$row['nas_praktek'] = $np;

	elseif (!is_nan($row['uas']) && !is_nan($np)):
		$row['nas_praktek'] = ( $row['uas'] + ( 3 * $np ) ) / 4;

	elseif (!is_nan($row['uas'])):
		$row['nas_praktek'] = $row['uas'];

	elseif (!is_nan($np)):
		$row['nas_praktek'] = $np;

	else:
		$row['nas_praktek'] = NULL;

	endif;

	// olah nilai teori

	if (!$teori):
		$row['nas_teori'] = NULL;

	elseif (!is_nan($row['uas']) && !is_nan($nh)):
		$row['nas_teori'] = ($row['uas'] + (4 * $nh)) / 5;

	elseif (!is_nan($row['uas'])):
		$row['nas_teori'] = $row['uas'];

	elseif (!is_nan($nh)):
		$row['nas_teori'] = $nh;

	else:
		$row['nas_teori'] = NULL;

	endif;

	// nilai akhir total

	$row['nas_total'] = (float) $row['nas_teori'];

	/* /
	  if ($row['id'] == 6113):
	  alert_dump($rkd_harian, 'r kd harian');
	  alert_dump($rkd_tugas, 'r kd tugas');
	  alert_dump($kd_teori, 'kd teori');
	  alert_dump($rkd_praktek, 'kd praktek');
	  alert_dump($kd_praktek, 'kd praktek');
	  alert_dump($nh, 'nh');
	  alert_dump($row, 'row');
	  endif;

	  // */
}
