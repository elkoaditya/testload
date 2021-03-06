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
	function filter_2($query,$ljs_id) {
		$query['where']['jawaban.ljs_id'] = $ljs_id;
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

	function query_2() {
		return array(
				'select' => array(
						'jawaban.*',
				),
				'from' => 'kbm_evaluasi_jawaban jawaban',
				'join' => array( 
						array('kbm_evaluasi_soal soal', 'jawaban.soal_id = soal.id', 'inner'),
				),
		);
	}
	// operasi data

	function browse_ljs($ljs_id) {
		$query = $this->query_2();
		$query = $this->filter_2($query,$ljs_id);

		// return $query;
		return $this->md->query($query)->result();
	}
	
	function browse($index = 0, $limit = 20) {
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);
	}

	function browse_allaa($index = 0, $limit = 20) {
		
		$d = $this->browse($index, $limit);
		$ss = array();
		foreach ($d['data'] as $key => $nisisljs){
			$ss[$key] = $this->browse_ljs($nisisljs['ljs_id']);
			// $d['data'][$key]['jawaban']
		}
		
		return $ss;
	}
	
	
	function browse_all()
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		// data nilai pelajaran tiap siswa

		$data = array();
		$nisisljs_query = array(
			'select' => array(
						'evanil.*',
						'siswa_id' 			=> 'siswa.id',
						'soal_id'			=> 'soal.id',
						'poin_max'			=> 'soal.poin_max',
						'ljs_id'			=> 'ljs.id',
						'jawaban_poin'		=> 'jawaban.poin',
						'jawaban_pilihan'	=> 'jawaban.pilihan',
						'jawaban_jawab'		=> 'jawaban.jawaban',
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
			$poin_max  			= (int) $nisisljs['poin_max'];
			$ljs_id 			= (int) $nisisljs['ljs_id'];
			$jawaban_poin 		= (int) $nisisljs['jawaban_poin'];
			$jawaban_pilihan 	=  $nisisljs['jawaban_pilihan'];
			$jawaban_jawab 		=  $nisisljs['jawaban_jawab'];
			
			$poin_kkm = ($jawaban_poin / $poin_max) * 100;
			
			$data['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['poin']   = $jawaban_poin;
			$data['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['poin_max']   = $poin_max;
			$data['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['poin_kkm']   = $poin_kkm;
			$data['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['pilihan'] = $jawaban_pilihan;
			$data['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['jawaban'] = $jawaban_jawab;

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

		$data['kolom_soal_count'] = 0;

		$no=0;
		foreach ($soaleval_result['data'] as $soaleval):
			$data['soal_array'][$no] = $soaleval;

			$data['kolom_soal_count'] += 3;
			$no++;			
		endforeach;

		unset($soaleval_result);

		return $data;
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
						'poin_max'			=> 'soal.poin_max',
						'ljs_id'			=> 'ljs.id',
						'jawaban_poin'		=> 'jawaban.poin',
						'jawaban_pilihan'	=> 'jawaban.pilihan',
						'jawaban_jawab'		=> 'jawaban.jawaban',
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
			$poin_max  			= (int) $nisisljs['poin_max'];
			$ljs_id 			= (int) $nisisljs['ljs_id'];
			$jawaban_poin 		= (int) $nisisljs['jawaban_poin'];
			$jawaban_pilihan 	=  $nisisljs['jawaban_pilihan'];
			$jawaban_jawab 		=  $nisisljs['jawaban_jawab'];
			
			$d['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['poin']   = $jawaban_poin;
			$d['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['poin_max']   = $poin_max;
			$d['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['pilihan'] = $jawaban_pilihan;
			$d['jawaban'][$siswa_id]['nisisljs_array'][$soal_id]['jawaban'] = $jawaban_jawab;

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
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
		);
		$styleGreen = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => '66FF99'),
			)
		);
		
		$styleYellow = array(
			'fill' => array(
				'type'	 => PHPExcel_Style_Fill::FILL_SOLID,
				'color'	 => array('rgb' => 'FFFF66'),
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

		$sheet->getColumnDimension('D')->setVisible(FALSE);
		$sheet->getColumnDimension('F')->setVisible(FALSE);
		
		$sheet->getColumnDimension('G')->setVisible(FALSE);
		$sheet->getColumnDimension('H')->setVisible(FALSE);
		$sheet->getColumnDimension('I')->setVisible(FALSE);
		//$sheet->getColumnDimension('J')->setVisible(FALSE);
		//$sheet->getColumnDimension('K')->setVisible(FALSE);
		
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
						'kkm',
						'prefix' => 'KKM : ',
					),
					'A4' => array(
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
			
			$s0al['excol']['pilihan'] = excel_colnumber(++$col_no);
			
			$cell_soal_pilihan = $s0al['excol']['pilihan'].'5';
			
			$sheet->setCellValue($cell_soal_pilihan, $jml_soal);
			
			$sheet->getColumnDimension($s0al['excol']['pilihan'])->setWidth(4);
			
			
			//MODE PHP
			$mode[$jml_soal][0]=0;
			$mode[$jml_soal][1]=0;
			$mode[$jml_soal][2]=0;
			$mode[$jml_soal][3]=0;
			$mode[$jml_soal][4]=0;
			$mode[$jml_soal][5]=0;
		endforeach;
		/// SIMPULAN JUMLAH BETUL SISWA
		$column_jml_sis_betul = excel_colnumber(++$col_no);
		$cell_jml_sis_betul = $column_jml_sis_betul.'5';
		$sheet->setCellValue($cell_jml_sis_betul, "Jml Betul");
		$sheet->getColumnDimension($column_jml_sis_betul)->setWidth(8);
		$sheet->setCellValue("J5", 'KET');
		
		
		// mulai isi nilai
		$jml_sis_tidak_ikut=0;
		$judul_kelas_nama='kosong';
		
		foreach ($d['resultset']['data'] as $row):

			$no++;
			$rowexcel++;
			$jumlah_siswa_benar[$no] = 0;
			/// DAYA BEDA
			$daya_beda_golongan[$no] = "";
			
			$judul_kelas_nama = $row['kelas_nama'];
			foreach ($map as $colex => $coldb):
				$sheet->setCellValue($colex . $rowexcel, $row[$coldb]);

			endforeach;

			$sheet->setCellValue("A" . $rowexcel, $no);
			
			// KONVERSI
			$konversi = $row['evaluasi_nilai']/25;
			$sheet->setCellValue("G" . $rowexcel, $konversi);
			
			$siswa_ikut_mengerjakan[$no] = 0;
			if (!$row['ljs_id']){
				$sheet->setCellValue("F" . $rowexcel, '-');// Belum Mengerjakan
				$sheet->getStyle("F" . $rowexcel)->applyFromArray($styleRed);
				$jml_sis_tidak_ikut++;
			}else if (!$row['evaluasi_terkoreksi']){
				$sheet->setCellValue("F" . $rowexcel, ' ');// Belum di Koreksi
				$sheet->getStyle("F" . $rowexcel)->applyFromArray($styleRed);
			}else{
				$sheet->setCellValue("F" . $rowexcel, '1');// Sudah Mengerjakan
				$siswa_ikut_mengerjakan[$no] = 1;
			}
			
			if($row['evaluasi_nilai']>$nama_file['data'][0]['kkm'])
			{
				$sheet->setCellValue("J" . $rowexcel, 'T');
			}else{
				$sheet->setCellValue("J" . $rowexcel, 'TT');
				$sheet->getStyle("J" . $rowexcel)->applyFromArray($styleRed);
			}
			$sheet->getColumnDimension("J")->setWidth(4);
			$sheet->getColumnDimension("K")->setWidth(2);
			
			$jml_soal=0;
			foreach ($d['soal_array'] as $soal_no => $soal):
				$jml_soal++;
				
				// MULAI HITUNG
				if($no==1)
				{	$jumlah_soal_benar[$jml_soal]=0;	}
			
				if($siswa_ikut_mengerjakan[$no] == 1)
				{	$daya_beda_poin_soal[$no][$jml_soal] = 0;	}
			
				$cell_soal_pilihan	= $soal['excol']['pilihan'] . $rowexcel;
				
				
					
				if(isset($d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['pilihan'])){
					
					$abre_jawaban = $d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']];
					
					if($d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['poin']>0){ 
						$benar = 1; 
						$jumlah_siswa_benar[$no]++;
						
						if($nama_file['data'][0]['pilihan_jml'] > 0){
							$jumlah_soal_benar[$jml_soal]++;
						}else{
							$nilai_benar = $abre_jawaban['poin'] / $abre_jawaban['poin_max'];
							$nilai_benar_100 = $nilai_benar * 100;
							
							$jumlah_soal_benar[$jml_soal] += $nilai_benar;
							
							if($nilai_benar_100 < $nama_file['data'][0]['kkm'])
							{
								$sheet->getStyle($cell_soal_pilihan)->applyFromArray($styleRed);
							}
							
						}
						
						if($siswa_ikut_mengerjakan[$no] == 1)
						{	$daya_beda_poin_soal[$no][$jml_soal] = 1;	}
						//$sheet->getStyle($cell_soal_pilihan)->applyFromArray($styleGreen);
					}else{ 
						$benar = 0;
						if($nama_file['data'][0]['pilihan_jml'] > 0){
							$sheet->getStyle($cell_soal_pilihan)->applyFromArray($styleRed);
						}
						
					}
					
					if($d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['pilihan']=='')
					{	$jawaban='-';	}
					else
					{	$jawaban = $d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['pilihan'];	}
				
					if($nama_file['data'][0]['pilihan_jml'] > 0){
						$sheet->setCellValue($cell_soal_pilihan, strtoupper($jawaban));
					}else{
						$sheet->setCellValue($cell_soal_pilihan, base64_decode($abre_jawaban['jawaban']));
						// $sheet->setCellValue($cell_soal_pilihan, print_r($d['jawaban'][$row['siswa_id']]));
					}
					//echo " x".$jawaban.$d['jawaban'][$row['siswa_id']]['nisisljs_array'][$soal['id']]['poin']."x";
				}else{
					$jawaban='-';
					$sheet->getStyle($cell_soal_pilihan)->applyFromArray($styleRed);
					$sheet->setCellValue($cell_soal_pilihan, "-");
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
			
			$cell_jml_sis_betul = $column_jml_sis_betul.$rowexcel;
			$sheet->setCellValue($cell_jml_sis_betul, $jumlah_siswa_benar[$no]);
		endforeach;
		
		// SISWA IKUT EVALUASI
		$siswa_ikut = $no - $jml_sis_tidak_ikut;
		
		// HITUNG DAYA BEDA
		$jml_pembeda = round(($siswa_ikut/3),0);
		
		for($i=1;$i<=$jml_pembeda;$i++)
		{
			$max = 0;
			$siswa_max = "";
			$min = 100;
			$siswa_min = "";
			$siswa=0;
			foreach ($d['resultset']['data'] as $row):
				$siswa++;
				
				if(($min>$jumlah_siswa_benar[$siswa]) && ($daya_beda_golongan[$siswa]=="") && ($siswa_ikut_mengerjakan[$siswa] == 1))
				{	
					$min = $jumlah_siswa_benar[$siswa];	
					$siswa_min = $siswa;
				}
			
				if(($max<$jumlah_siswa_benar[$siswa]) && ($daya_beda_golongan[$siswa]=="") && ($siswa_ikut_mengerjakan[$siswa] == 1))
				{	
					$max = $jumlah_siswa_benar[$siswa];
					$siswa_max = $siswa;
				}
				
			endforeach;
			
			$daya_beda_golongan[$siswa_min] = "bawah";
			$cell_min = $siswa_min+5;
			$sheet->setCellValue("I".$cell_min, $daya_beda_golongan[$siswa_min]);
			
			$daya_beda_golongan[$siswa_max] = "atas";
			$cell_max = $siswa_max+5;
			$sheet->setCellValue("I".$cell_max, $daya_beda_golongan[$siswa_max]);
		}
		
		$jml_soal=0;
		foreach ($d['soal_array'] as $soal_no => $soal):
			$jml_soal++;
			$daya_beda_atas=0;
			$daya_beda_bawah=0;
			
			$siswa=0;
			foreach ($d['resultset']['data'] as $row):
				$siswa++;
				if($daya_beda_golongan[$siswa]=='atas')
					$daya_beda_atas += $daya_beda_poin_soal[$siswa][$jml_soal];
				
				if($daya_beda_golongan[$siswa]=='bawah')
					$daya_beda_bawah += $daya_beda_poin_soal[$siswa][$jml_soal];
				
			endforeach;
			if(($daya_beda_atas - $daya_beda_bawah)==0)
				$daya_beda_soal[$jml_soal] =0;
			else
				$daya_beda_soal[$jml_soal] = ($daya_beda_atas - $daya_beda_bawah)/$jml_pembeda;
		endforeach;
		
		// rata2 dan median
		$last_row = $rowexcel;
		$jumlah_simpulan = 6;
		for($x=1;$x<=$jumlah_simpulan;$x++)
		{
			$rowexcel++;
			$simpulan[$x] = $rowexcel;
		}
		
		$sheet->setCellValue('A'.$simpulan[2], 'Jumlah Jawaban Benar');
		$sheet->setCellValue('A'.$simpulan[3], 'Skor Ketercapaian Soal (%)');
		$sheet->setCellValue('A'.$simpulan[4], 'Tingkat Kesukaran');
		$sheet->setCellValue('A'.$simpulan[5], 'Daya Beda');
		
		
		for($x=2;$x<=$jumlah_simpulan;$x++)
		{
			$cell_merge = 'A'.$simpulan[$x] . ':' . 'F'.$simpulan[$x];
			$sheet->mergeCells($cell_merge);
		}
		$cell_merge = 'A'.$simpulan[5] . ':' . 'F'.$simpulan[6];
		$sheet->mergeCells($cell_merge);
		
		$jml_soal=0;
		
		foreach ($d['soal_array'] as $soal_no => $soal):
			$jml_soal++;
			for($x=1;$x<=$jumlah_simpulan;$x++)
			{
				$cell_simpulan[$x]	= $soal['excol']['pilihan'] . $simpulan[$x];
			}
			/// JUMLAH BENAR
			$cell_soal_pilihan	= $soal['excol']['pilihan'] . $rowexcel;
			$sheet->setCellValue($cell_simpulan[2],$jumlah_soal_benar[$jml_soal]);
			
			// PERSENTAGE BENAR
			if($siswa_ikut>0){
				$persentage_benar = round((($jumlah_soal_benar[$jml_soal] / $siswa_ikut) * 100),1);
			}else{
				$persentage_benar = 0;
			}
			$sheet->setCellValue($cell_simpulan[3],$persentage_benar);
			
			// Tingkat kesukaran
			if($persentage_benar>70){	
				$kesukaran="Md";	
				$sheet->getStyle($cell_simpulan[4])->applyFromArray($styleGreen);
			}else if($persentage_benar>30){	
				$kesukaran="Sd";
				$sheet->getStyle($cell_simpulan[4])->applyFromArray($styleYellow);
			}else{	
				$kesukaran="Sl";
				$sheet->getStyle($cell_simpulan[4])->applyFromArray($styleRed);
			}
			$sheet->setCellValue($cell_simpulan[4],$kesukaran);
			
			// Daya BEDA
			/*
			0,00 ??? 0,19 = soal tidak dipakai/dibuang
			0,20 ??? 0,29 = soal diperbaiki
			0,30 ??? 0,39 = soal diterima tapi perlu diperbaiki
			0,40 ??? 1,00 = soal diterima/baik */
			
			if(($daya_beda_soal[$jml_soal]*10)<=10)
			{	$jawaban_daya_beda = 'soal diterima/baik';	}
			if(($daya_beda_soal[$jml_soal]*10)<4)
			{	$jawaban_daya_beda = 'soal diterima tapi perlu diperbaiki';	}
			if(($daya_beda_soal[$jml_soal]*10)<3)
			{	
				$jawaban_daya_beda = 'soal diperbaiki';	
				$sheet->getStyle($cell_simpulan[6])->applyFromArray($styleYellow);
			}
			if(($daya_beda_soal[$jml_soal]*10)<2)
			{	
				$jawaban_daya_beda = 'soal tidak dipakai';	
				$sheet->getStyle($cell_simpulan[6])->applyFromArray($styleRed);
			}
		
			$sheet->setCellValue($cell_simpulan[5],$daya_beda_soal[$jml_soal]);
			$sheet->setCellValue($cell_simpulan[6],$jawaban_daya_beda);
			$sheet->getStyle($cell_simpulan[6])->getAlignment()->setTextRotation(90);
			
			//$rata_jml_benar = '=AVERAGE('.$soal['excol']['poin'].'7:'.$soal['excol']['poin'].$last_row.')';
			//$sheet->setCellValue($cell_soal_poin, $rata_jml_benar);
			
			/*$max=0;
			for($x=0;$x<=5;$x++)
			{
				if($mode[$jml_soal][$x]>$max)
				{	
					$mode_opsi	= $x;
					$max		= $mode[$jml_soal][$x];
				}
			}
			*/
			//$sheet->setCellValue($cell_soal_opsi, '=MODE( $'.$soal['excol']['opsi'].'$7:$'.$soal['excol']['opsi'].'$'.$last_row.' )');
			//$sheet->setCellValue($cell_soal_pilihan,$mode_opsi);
			//$sheet->setCellValue($cell_soal_pilihan,
			//'=IF('.$cell_soal_opsi.'=1,"a",IF('.$cell_soal_opsi.'=2,"b", IF('.$cell_soal_opsi.'=3,"c", IF('.$cell_soal_opsi.'=4,"d", IF('.$cell_soal_opsi.'=5,"e", "-")))))');
			
			
			//$sheet->getColumnDimension($soal['excol']['opsi'])->setVisible(FALSE);
			//$sheet->getStyle($soal['excol']['opsi']."1:".$soal['excol']['opsi'].$rowexcel)->applyFromArray($style_nilai);
		endforeach;
		$set_font = 8;

		// format font size
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		$sheet->getStyle("A1:F70")->getFont()->setSize($set_font);
		$sheet->getStyle("A1:BJ70")->getFont()->setSize($set_font);
		
		// format garis & align
		$sheet->getStyle("A1:G4")->getFont()->setBold(true);
		$sheet->getStyle("A5:".$soal['excol']['pilihan']."5")->getFont()->setBold(true);
		$sheet->getStyle("A5:".$column_jml_sis_betul.$rowexcel)->applyFromArray($style_border);
		$sheet->getStyle("E5:{$cell_soal_pilihan}")->applyFromArray($style_nilai);
		
		$sheet->setCellValue('P2','Siswa Ikut : '.$siswa_ikut);
		$sheet->setCellValue('P3','Siswa Tidak Ikut : '.$jml_sis_tidak_ikut);
		$sheet->getStyle('L6:'.$column_jml_sis_betul.$rowexcel)->getAlignment()->setWrapText(true); 
		$sheet->getRowDimension($rowexcel)->setRowHeight(70);
		// output file 
		header("Content-Type: application/vnd.ms-excel");
		//header("Content-Disposition: attachment; filename=\"nilai_evaluasi_{$d['request']['evaluasi_id']}.xls\"");
		
		if($d['request']['kelas_id']){
			$sheet->setCellValue('E2','Kelas : '.$judul_kelas_nama);
			$sheet->getColumnDimension('B')->setVisible(FALSE);
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

	function keikutsertaan(){
		$d = & $this->ci->d;
		
		$evaluasi_id = (int) $this->input->post('evaluasi_id');
		$keikutsertaan = (int) $this->input->post('keikutsertaan');
		$array_input_ganti = $this->input->post('input_ganti');
		
		$this->db->trans_begin();
		
		$jml=0;
		$sql_bank_soal_id="";
		foreach($array_input_ganti as $evaluasi_nilai_id){
			$jml++;
			
			$query_update_evaluasi_nilai = "
				UPDATE kbm_evaluasi_nilai
				SET aktif = ".$keikutsertaan."
				WHERE id = {$evaluasi_nilai_id}
			";
			$this->db->query($query_update_evaluasi_nilai);
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$query_update_evaluasi_nilai}");
		}
		
		
		$trx = $this->trans_done('Keikutsertaan berhasil disimpan.', 'Database error, coba beberapa saat lagi.');
		return $trx;
	}
}

