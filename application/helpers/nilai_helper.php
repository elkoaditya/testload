<?php

function nilai_siswa_pelajaran_fetch(&$row, $nipel, $bobot_teori = 1) {
	$na_harian = array();
	$na_praktek = array();
	$na_sikap = array();

	for ($no = 1; $no <= 10; $no++):
		$u = $row['u' . $no];
		$r = $row['r' . $no];
		$kkm = (float) (empty($nipel['kkm' . $no])) ? $nipel['kkm'] : $nipel['kkm' . $no];

		// proses nilai harian

		if (empty($u) OR !is_numeric($u)):
			$row['u' . $no] = NULL;
			$row['r' . $no] = NULL;
			$row['h' . $no] = NULL;

		elseif ($u >= $kkm OR empty($r) OR !is_numeric($r) OR $u > $r):
			$row['u' . $no] = (float) $u;
			$row['r' . $no] = (is_numeric($r)) ? (float) $r : NULL;
			$row['h' . $no] = (float) $u;

		elseif ($r > $kkm):
			$row['u' . $no] = (float) $u;
			$row['r' . $no] = (float) $r;
			$row['h' . $no] = (float) $kkm;

		else:
			$row['u' . $no] = (float) $u;
			$row['r' . $no] = (float) $r;
			$row['h' . $no] = (float) $r;

		endif;

		if ($row['h' . $no])
			$na_harian[] = $row['h' . $no];

		// proses nilai tugas

		if (empty($row['t' . $no])):
			$row['t' . $no] = NULL;

		else:
			$row['t' . $no] = (float) $row['t' . $no];
			$na_harian[] = $row['t' . $no];

		endif;

		// proses nilai praktek

		if (empty($row['p' . $no])):
			$row['p' . $no] = NULL;

		else:
			$row['p' . $no] = (float) $row['p' . $no];
			$na_praktek[] = $row['p' . $no];

		endif;

		// proses nilai sikap

		if (empty($row['s' . $no])):
			$row['s' . $no] = NULL;

		else:
			$row['s' . $no] = (float) $row['s' . $no];
			$na_sikap[] = $row['s' . $no];

		endif;

	endfor;

	// ulangan umum

	$row['uts'] = (!empty($row['uts'])) ? (float) $row['uts'] : NULL;
	$row['uas'] = (!empty($row['uas'])) ? (float) $row['uas'] : NULL;

	// jumlah nilai masuk

	$na_harian_jml = count($na_harian);
	$na_praktek_jml = count($na_praktek);
	$na_sikap_jml = count($na_sikap);

	// proses nilai akhir teori

	if (!$row['uas'] && $na_harian_jml < 1):
		$row['nas_teori'] = NULL;

	elseif ($row['uas'] && $na_harian_jml < 1):
		$row['nas_teori'] = $row['uas'];

	elseif (!$row['uas'] && $na_harian_jml > 0):
		$row['nas_teori'] = array_sum($na_harian) / $na_harian_jml;

	else:
		$row['nas_teori'] = ( (2 * array_sum($na_harian) / $na_harian_jml) + $row['uas']) / 3;

	endif;

	// nilai akhir praktek & sikap

	$row['nas_praktek'] = ($na_praktek_jml > 0) ? (array_sum($na_praktek) / $na_praktek_jml) : NULL;
	$row['nas_sikap'] = ($na_sikap > 0) ? (array_sum($na_sikap) / $na_sikap_jml) : NULL;

	// nilai akhir total

	if (!$row['nas_teori'] && !$row['nas_praktek']):
		$row['nas_total'] = 0;

	elseif (($row['nas_teori'] && !$row['nas_praktek'] ) OR $bobot_teori > 99):
		$row['nas_total'] = (float) $row['nas_teori'];

	elseif (!$row['nas_teori'] && $row['nas_praktek']):
		$row['nas_total'] = (float) $row['nas_praktek'];

	else:
		$bobot_praktek = 100 - $bobot_teori;
		$row['nas_total'] = (($bobot_teori * $row['nas_teori']) + ($bobot_praktek * $row['nas_praktek'])) / 100;

	endif;

	// kompetensi
	// sementara hanya proses kompetensi akhir semester

	$kompetensi = array(
			$nipel['kd_h1'],
			$nipel['kd_h2'],
			$nipel['kd_h3'],
			$nipel['kd_h4'],
			$nipel['kd_h5'],
			$nipel['kd_h6'],
			$nipel['kd_h7'],
			$nipel['kd_h8'],
			$nipel['kd_h9'],
			$nipel['kd_h10'],
	);
	$kompetensi = implode(', ', $kompetensi);
	$kompetensi = trim($kompetensi, ', \t\n\r\0\x0B');
	$row['kompetensi'] = ($row['nas_total'] < $nipel['kkm']) ? "Tingkatkan penguasaan {$kompetensi}." : ucfirst($kompetensi) . " telah mencapai KKM.";
}
