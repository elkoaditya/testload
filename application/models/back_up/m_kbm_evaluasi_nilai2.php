<?php

class M_kbm_evaluasi_nilai extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	// queries

	function filter_1($query) {
		$r = & $this->ci->d['request'];
		$default = array(
				'term' => '',
				'evaluasi_id' => 0,
				'kelas_id' => 0,
				'order_by' => 'kelas, nama',
		);
		array_default($r, $default);

		$query['where']['evanil.evaluasi_id'] = $r['evaluasi_id'];
		$query['like'] = array($r['term'], array('siswa.nama', 'siswa.nis', 'kelas.nama'));

		if ($r['kelas_id'] > 0)
			$query['where']['evanil.kelas_id'] = $r['kelas_id'];

		if ($r['order_by'] == 'nilai'):
			$query['order_by'] = 'evanil.evaluasi_nilai desc';
		else:
			$query['order_by'] = 'kelas.nama, siswa.nama';
		endif;

		return $query;
	}

	function query_1() {
		return array(
				'select' => array(
						'evanil.*',
						'kelas_nama' => 'kelas.nama',
						'siswa_id' => 'siswa.id',
						'siswa_nis' => 'siswa.nis',
						'siswa_nisn' => 'siswa.nisn',
						'siswa_nama' => 'siswa.nama',
						'siswa_gender' => 'siswa.gender',
				),
				'from' => 'kbm_evaluasi_nilai evanil',
				'join' => array(
						array('dprofil_siswa siswa', 'evanil.user_id = siswa.id', 'inner'),
						array('dakd_kelas kelas', 'evanil.kelas_id = kelas.id', 'inner'),
				),
		);
	}

	// operasi data

	function browse($index = 0, $limit = 20) {
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);
	}

	function nama_file(){
		$r = & $this->ci->d['request'];
		$query = array(
				'select' => array(
						'eva.*',
						'pengajar' => 'sdm.nama',
				),
				'from' => 'kbm_evaluasi eva',
				'join' => array(
						array('dakd_pelajaran pelajaran', 'eva.pelajaran_id = pelajaran.id', 'inner'),
						array('dprofil_sdm sdm', 'pelajaran.guru_id = sdm.id', 'inner'),
				),
		);
		
		$query['where']['eva.id'] = $r['evaluasi_id'];
		
		return $this->md->query($query)->resultset(0, 1);
	}
	
	function download() {
		$d = & $this->ci->d;
		$d['resultset'] = $this->browse(0, 10240);
		$nama_file = $this->nama_file();
		$fallback = 'kbm/evaluasi_nilai' . array2qs();
		$no = 0;
		$rowexcel = 1;
		//$file_path = 'content/template/kbm-evaluasi-nilai.xls';
		$file_path = APP_ROOT."content/".strtolower(APP_SCOPE)."/template/kbm-evaluasi-nilai.xls";
		$map = array(
				'B' => 'kelas_nama',
				'C' => 'siswa_nama',
				'D' => 'siswa_gender',
				'E' => 'evaluasi_nilai',
		);

		if ($d['resultset']['selected_rows'] == 0)
			return alert_error('Data nilai kosong, periksa filter pencarian Anda.', $fallback);

		$this->load->library('PHPExcel');

		$objPHPExcel = PHPExcel_IOFactory::load($file_path);
		$style_border = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
						)
				)
		);
		$style_nilai = array(
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				),
		);

		if (!$objPHPExcel)
			return alert_error('Excel error.', $fallback);

		$sheet = $objPHPExcel->setActiveSheetIndex(0);

		// mulai isi nilai

		foreach ($d['resultset']['data'] as $row):

			$no++;
			$rowexcel++;

			foreach ($map as $colex => $coldb):
				$sheet->setCellValue($colex . $rowexcel, $row[$coldb]);

			endforeach;

			$sheet->setCellValue("A" . $rowexcel, $no);
			
			// KONVERSI
			$konversi = $row['evaluasi_nilai']/25;
			$sheet->setCellValue("G" . $rowexcel, $konversi);
			
			if (!$row['ljs_id'])
				$sheet->setCellValue("F" . $rowexcel, 'belum mengerjakan');

			else if (!$row['evaluasi_terkoreksi'])
				$sheet->setCellValue("F" . $rowexcel, 'belum dikoreksi');

		endforeach;

		// format garis & align

		$sheet->getStyle("A1:G{$rowexcel}")->applyFromArray($style_border);
		$sheet->getStyle("E1:E{$rowexcel}")->applyFromArray($style_nilai);

		// output file

		header("Content-Type: application/vnd.ms-excel");
		//header("Content-Disposition: attachment; filename=\"nilai_evaluasi_{$d['request']['evaluasi_id']}.xls\"");
		header("Content-Disposition: attachment; filename=\"nilai_evaluasi_{$nama_file['data'][0]['nama']}_{$nama_file['data'][0]['pengajar']}_({$d['request']['evaluasi_id']}).xls\"");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		exit();
	}

	function rowset($id) {
		$query = $this->query_1();
		$query['where']['evanil.id'] = $id;

		return $this->md->row();
	}

	function statistik() {
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$d['pie'] = array();
		$d['bar'] = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$query = array(
				'select' => array(
						'evanil.*',
				),
				'from' => 'kbm_evaluasi_nilai evanil',
				'where' => array(
						'evanil.evaluasi_id' => $r['evaluasi_id'],
						'trial' => 0,
				),
		);

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$query['where']['evanil.kelas_id'] = $r['kelas_id'];

		$result = $this->md->query($query)->result();

		//exit_dump($result);

		if ($result['selected_rows'] == 0)
			return !alert_info('Data nilai evaluasi kosong / tidak ditemukan.');

		$kkm = (float) $d['evaluasi']['kkm'];
		$jml_total = $result['selected_rows'];
		$jml_lulus = 0;
		$jml_gagal = 0;
		$jml_kosong = 0;
		$jml_uncek = 0;

		foreach ($result['data'] as $row):

			if (!$row['ljs_id']):
				$jml_kosong++;
				$d['bar'][0]++;
				continue;
			endif;

			if (!$row['evaluasi_terkoreksi']):
				$jml_uncek++;
				$d['bar'][0]++;
				continue;
			endif;

			$nilai = (float) $row['evaluasi_nilai'];
			$cat = ceil($nilai / 10);

			$d['bar'][$cat]++;

			if ($nilai >= $kkm)
				$jml_lulus++;
			else
				$jml_gagal++;

		endforeach;

		$pcn_lulus = number_format((100 * $jml_lulus / $jml_total), 1, ',', '.');
		$pcn_gagal = number_format((100 * $jml_gagal / $jml_total), 1, ',', '.');
		$pcn_uncek = number_format((100 * $jml_uncek / $jml_total), 1, ',', '.');
		$pcn_kosong = number_format((100 * $jml_kosong / $jml_total), 1, ',', '.');
		$d['pie'][] = array("Tuntas : {$jml_lulus} ({$pcn_lulus}%)", $jml_lulus);
		$d['pie'][] = array("Gagal : {$jml_gagal} ({$pcn_gagal}%)", $jml_gagal);
		$d['pie'][] = array("Blm dikoreksi : {$jml_uncek} ({$pcn_uncek}%)", $jml_uncek);
		$d['pie'][] = array("Kosong : {$jml_kosong} ({$pcn_kosong}%)", $jml_kosong);
	}

}

