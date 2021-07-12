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
						'kelas_nama'	=> 'kelas.nama',
						'siswa_id' 		=> 'siswa.id',
						'siswa_nis' 	=> 'siswa.nis',
						'siswa_nisn' 	=> 'siswa.nisn',
						'siswa_nama' 	=> 'siswa.nama',
						'siswa_gender' 	=> 'siswa.gender',
						'ljs_id'		=>	'ljs.id',
						'ljs_waktu'		=>	'ljs.waktu',
						'ljs_dikoreksi'	=>	'ljs.dikoreksi',
				),
				'from' => 'kbm_evaluasi_nilai evanil',
				'join' => array(
						array('dprofil_siswa siswa', 'evanil.user_id = siswa.id', 'inner'),
						array('dakd_kelas kelas', 'evanil.kelas_id = kelas.id', 'inner'),
						array('kbm_evaluasi_ljs ljs', 'evanil.ljs_id = ljs.id', 'left'),
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
						'pengajar'		=> 'sdm.nama',
						'semester_nama'	=> 'semester.nama',
						'ta_nama'		=> 'ta.nama',
						
				),
				'from' => 'kbm_evaluasi eva',
				'join' => array(
						array('dakd_pelajaran pelajaran', 'eva.pelajaran_id = pelajaran.id', 'inner'),
						array('dprofil_sdm sdm', 'pelajaran.guru_id = sdm.id', 'inner'),
						array('prd_semester semester', 'eva.semester_id = semester.id', 'inner'),
						array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				),
		);
		
		$query['where']['eva.id'] = $r['evaluasi_id'];
		
		return $this->md->query($query)->resultset(0, 1);
	}
	
	function jawaban_nilai_ljs()
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		// data nilai pelajaran tiap siswa

		$nisisljs_query = array(
			'select' => array(
						'evanil.*',
						'siswa_id' 			=> 'siswa.id',
						'soal_id'			=> 'soal.id',
						'ljs_id'			=> 'ljs.id',
						'jawaban_poin'		=> 'jawaban.poin',
						'jawaban_pilihan'	=> 'jawaban.pilihan',
				),
			'from' => 'kbm_evaluasi_nilai evanil',
			'join' => array(
					array('dprofil_siswa siswa', 'evanil.user_id = siswa.id', 'inner'),
					array('dakd_kelas kelas', 'evanil.kelas_id = kelas.id', 'inner'),
					array('kbm_evaluasi_ljs ljs', 'evanil.ljs_id = ljs.id', 'inner'),
					array('kbm_evaluasi_jawaban jawaban', 'ljs.id = jawaban.ljs_id', 'inner'),
					array('kbm_evaluasi_soal soal', 'jawaban.soal_id = soal.id', 'inner'),
			),
			'where' => array(
				'evanil.evaluasi_id' => $r['evaluasi_id'],
				),
			'order_by' => 'soal.id',
		);
		
		$nisisljs_result = $this->md->query($nisisljs_query)->result();

		if ($nisisljs_result['selected_rows'] == 0)
			return alert_error("Daftar nilai pelajaran tiap siswa tidak ditemukan.");

		// kumpulkan nisispel ke leger

		foreach ($nisisljs_result['data'] as $nisisljs):
			$siswa_id 			= (int) $nisisljs['siswa_id'];
			$soal_id  			= (int) $nisisljs['soal_id'];
			$ljs_id 			= (int) $nisisljs['ljs_id'];
			$jawaban_poin 		= (int) $nisisljs['jawaban_poin'];
			$jawaban_pilihan 	=  $nisisljs['jawaban_pilihan'];
			
			$d['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['poin']   = $jawaban_poin;
			$d['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['pilihan'] = $jawaban_pilihan;

		endforeach;
		
		unset($nisisljs_result);

		$soaleval_query = array(
			'from'		 => 'kbm_evaluasi_soal',
			'where'		 => array(
				'evaluasi_id' => $r['evaluasi_id'],
			),
			'order_by'	 => 'id',
			'select' => array('*'),
		);

		$soaleval_result = $this->md->query($soaleval_query)->result();

		if ($soaleval_result['selected_rows'] == 0)
			return alert_error("Daftar pelajaran siswa tidak ditemukan.");

		$d['kolom_soal_count'] = 0;

		$no=0;
		foreach ($soaleval_result['data'] as $soaleval):
			$d['soal_array'][$no] = $soaleval;

			$d['kolom_soal_count'] += 3;
			$no++;			
		endforeach;

		unset($soaleval_result);

		return TRUE;
	}
	
	function download() {
		$d = & $this->ci->d;
		$d['resultset'] = $this->browse(0, 10240);
		$nama_file = $this->nama_file();
		$this->load->helper('excel');
		$this->jawaban_nilai_ljs();
		
		$fallback = 'kbm/evaluasi_nilai' . array2qs();
		$no = 0;
		$rowexcel = 6;
		$array_opsi = array(
			'-' => '0',
			'a' => '1',
			'b' => '2',
			'c' => '3',
			'd' => '4',
			'e' => '5',
		);
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
		$styleGreen = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => '66FF33'),
			)
		);
		
		$styleRed = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'DD9898'),
			)
		);
		if (!$objPHPExcel)
			return alert_error('Excel error.', $fallback);

		$sheet = $objPHPExcel->setActiveSheetIndex(0);

		$sheet->getColumnDimension('G')->setVisible(FALSE);
		$sheet->getColumnDimension('H')->setVisible(FALSE);
		$sheet->getColumnDimension('I')->setVisible(FALSE);
		$sheet->getColumnDimension('J')->setVisible(FALSE);
		$sheet->getColumnDimension('K')->setVisible(FALSE);
		
		$excel_col_offset = ord('K') - 65;
		$col_no = $excel_col_offset;
	
	
		$cfg = array(
				'row.nikls'		 => array(
					// top header
					'A1' => array(
						'nama',
						'strtoupper',
						'prefix' => 'NAMA EVALUASI : ',
					),
					'A2' => array(
						'pengajar',
						'strtoupper',
						'prefix' => 'GURU : ',
					),
					'A3' => array(
						'semester_nama',
						'strtoupper',
						'prefix' => 'SEMESTER  ',
						'suffix' => array(
							' TAHUN ',
							'ta_nama',
						),
					),
				),
			);
		
		excel_row_write($sheet, $nama_file['data'][0], $cfg['row.nikls']);
		
					
		$jml_soal=0;
		foreach ($d['soal_array'] as &$s0al):
			$jml_soal++;
			$s0al['excol']['poin'] = excel_colnumber(++$col_no);
			$s0al['excol']['pilihan'] = excel_colnumber(++$col_no);
			$s0al['excol']['opsi'] = excel_colnumber(++$col_no);
			
			$cell_soal_label = $s0al['excol']['poin'].'5';
			$cell_soal_poin = $s0al['excol']['poin'] . '6';
			$cell_soal_pilihan = $s0al['excol']['pilihan'] . '6';
			$cell_soal_opsi = $s0al['excol']['opsi'] . '6';
			
			$sheet->setCellValue($cell_soal_label, "SOAL ".$jml_soal);
			$sheet->setCellValue($cell_soal_poin, "Benar");
			$sheet->setCellValue($cell_soal_pilihan, "Jawab");
			$sheet->setCellValue($cell_soal_opsi, "Opsi");
			
			$sheet->getColumnDimension($s0al['excol']['poin'])->setWidth(6);
			$sheet->getColumnDimension($s0al['excol']['pilihan'])->setWidth(7);
			$sheet->getColumnDimension($s0al['excol']['opsi'])->setWidth(6);
			
			$cell_merge = $cell_soal_label . ':' . $s0al['excol']['opsi'] . '5';
			$sheet->mergeCells($cell_merge);
			
			//MODE PHP
			$mode[$jml_soal][0]=0;
			$mode[$jml_soal][1]=0;
			$mode[$jml_soal][2]=0;
			$mode[$jml_soal][3]=0;
			$mode[$jml_soal][4]=0;
			$mode[$jml_soal][5]=0;
		endforeach;
		
		// mulai isi nilai
		$judul_kelas_nama='';
		foreach ($d['resultset']['data'] as $row):

			$no++;
			$rowexcel++;
			$judul_kelas_nama = $row['kelas_nama'];
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

			$jml_soal=0;
			foreach ($d['soal_array'] as $soal_no => $soal):
				$jml_soal++;
				$cell_soal_poin 	= $soal['excol']['poin'] . $rowexcel;
				$cell_soal_pilihan	= $soal['excol']['pilihan'] . $rowexcel;
				$cell_soal_opsi 	= $soal['excol']['opsi'] . $rowexcel;
				
				if(isset($d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['pilihan'])){
					if($d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['poin']>0){ 
						$benar = 1;
						$sheet->getStyle($cell_soal_poin)->applyFromArray($styleGreen);
					}else{ 
						$benar = 0;
						$sheet->getStyle($cell_soal_poin)->applyFromArray($styleRed);
					}
					if($d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['pilihan']=='')
					{	$jawaban='-';	}
					else
					{	$jawaban = $d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['pilihan'];	}
					$sheet->setCellValue($cell_soal_poin, $benar);
					$sheet->setCellValue($cell_soal_pilihan, $jawaban);
					//echo " x".$jawaban.$d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['poin']."x";
					$sheet->setCellValue($cell_soal_opsi, (int)$array_opsi[$jawaban]);
				}else{
					$jawaban='-';
					$sheet->getStyle($cell_soal_poin)->applyFromArray($styleRed);
					$sheet->setCellValue($cell_soal_poin, 0);
					$sheet->setCellValue($cell_soal_pilihan, "-");
					$sheet->setCellValue($cell_soal_opsi, 0);
				}
				
				if($array_opsi[$jawaban]=='0')
					$mode[$jml_soal][0]++;
				elseif($array_opsi[$jawaban]=='1')
					$mode[$jml_soal][1]++;
				elseif($array_opsi[$jawaban]=='2')
					$mode[$jml_soal][2]++;
				elseif($array_opsi[$jawaban]=='3')
					$mode[$jml_soal][3]++;
				elseif($array_opsi[$jawaban]=='4')
					$mode[$jml_soal][4]++;
				elseif($array_opsi[$jawaban]=='5')
					$mode[$jml_soal][5]++;
					
			endforeach;
		endforeach;
		
		// rata2 dan median
		$last_row = $rowexcel;
		$rowexcel++;
		$sheet->setCellValue('A'.$rowexcel, 'Persentase Jumlah Soal Benar & Opsi yang banyak di pilih');
		$cell_merge = 'A'.$rowexcel . ':' . 'F'.$rowexcel;
		$sheet->mergeCells($cell_merge);
		
		$jml_soal=0;
		foreach ($d['soal_array'] as $soal_no => $soal):
			$jml_soal++;
			$cell_soal_poin 	= $soal['excol']['poin'] . $rowexcel;
			$cell_soal_pilihan	= $soal['excol']['pilihan'] . $rowexcel;
			$cell_soal_opsi 	= $soal['excol']['opsi'] . $rowexcel;
			
			$rata_jml_benar = '=AVERAGE('.$soal['excol']['poin'].'7:'.$soal['excol']['poin'].$last_row.')';
			$sheet->setCellValue($cell_soal_poin, $rata_jml_benar);
			
			$max=0;
			for($x=0;$x<=5;$x++)
			{
				if($mode[$jml_soal][$x]>$max)
				{	
					$mode_opsi	= $x;
					$max		= $mode[$jml_soal][$x];
				}
			}
			
			//$sheet->setCellValue($cell_soal_opsi, '=MODE( $'.$soal['excol']['opsi'].'$7:$'.$soal['excol']['opsi'].'$'.$last_row.' )');
			$sheet->setCellValue($cell_soal_opsi,$mode_opsi);
			$sheet->setCellValue($cell_soal_pilihan,
			'=IF('.$cell_soal_opsi.'=1,"a",IF('.$cell_soal_opsi.'=2,"b", IF('.$cell_soal_opsi.'=3,"c", IF('.$cell_soal_opsi.'=4,"d", IF('.$cell_soal_opsi.'=5,"e", "-")))))');
			
			
			$sheet->getColumnDimension($soal['excol']['opsi'])->setVisible(FALSE);
			$sheet->getStyle($soal['excol']['opsi']."1:".$soal['excol']['opsi'].$rowexcel)->applyFromArray($style_nilai);
		endforeach;

		// format garis & align
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		$sheet->getStyle("A5:".$soal['excol']['opsi']."6")->getFont()->setBold(true);
		$sheet->getStyle("A5:{$cell_soal_opsi}")->applyFromArray($style_border);
		$sheet->getStyle("E5:E{$rowexcel}")->applyFromArray($style_nilai);
		

		// output file 
		header("Content-Type: application/vnd.ms-excel");
		//header("Content-Disposition: attachment; filename=\"nilai_evaluasi_{$d['request']['evaluasi_id']}.xls\"");
		
		if($d['request']['kelas_id']){
			$sheet->setCellValue('E2','Kelas : '.$judul_kelas_nama);
			header("Content-Disposition: attachment; filename=\"nilai_evaluasi_{$nama_file['data'][0]['nama']}_{$nama_file['data'][0]['pengajar']}_({$judul_kelas_nama})_({$d['request']['evaluasi_id']}).xls\"");
		}else{
			header("Content-Disposition: attachment; filename=\"nilai_evaluasi_{$nama_file['data'][0]['nama']}_{$nama_file['data'][0]['pengajar']}_({$d['request']['evaluasi_id']}).xls\"");
		}
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

