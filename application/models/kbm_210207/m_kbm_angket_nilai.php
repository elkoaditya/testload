<?php

class M_kbm_angket_nilai extends MY_Model {

	public function __construct() {
		parent::__construct();
	}
	
	// queries

	function filter_1($query) {
		$r = & $this->ci->d['request'];
		$default = array(
				'term' => '',
				'angket_id' => 0,
				'kelas_id' => 0,
				'order_by' => 'kelas, nama',
		);
		array_default($r, $default);

		$query['where']['angketnil.angket_id'] = $r['angket_id'];
		$query['like'] = array($r['term'], array('siswa.nama', 'siswa.nis', 'kelas.nama'));

		if ($r['kelas_id'] > 0)
			$query['where']['angketnil.kelas_id'] = $r['kelas_id'];

		if ($r['order_by'] == 'nilai'):
			$query['order_by'] = 'angketnil.angket_nilai desc';
		else:
			$query['order_by'] = 'kelas.nama, siswa.nama, menilai_siswa.nama';
		endif;

		return $query;
	}

	function query_1() {
		return array(
				'select' => array(
						'angketnil.*',
						'kelas_id' => 'kelas.id',	
						'kelas_nama' => 'kelas.nama',
						'siswa_id' => 'siswa.id',
						'menilai_siswa_id' => 'menilai_siswa.id',
						'siswa_nis' => 'siswa.nis',
						'siswa_nisn' => 'siswa.nisn',
						'siswa_nama' => 'siswa.nama',
						'menilai_siswa_nama' => 'menilai_siswa.nama',
						'siswa_gender' => 'siswa.gender',
				),
				'from' => 'kbm_angket_nilai angketnil',
				'join' => array(
						array('dprofil_siswa siswa', 'angketnil.user_id = siswa.id', 'inner'),
						array('dprofil_siswa menilai_siswa', 'angketnil.menilai_user_id = menilai_siswa.id', 'inner'),
						array('dakd_kelas kelas', 'angketnil.kelas_id = kelas.id', 'inner'),
				),
		);
	}
	
	// operasi data

	function browse($index = 0, $limit = 20) {
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);
	}
	
	function download() {
		$d = & $this->ci->d;
		$d['resultset'] = $this->browse(0, 10240);
		$r = & $this->ci->d['request'];
		
		$fallback = 'kbm/angket_nilai' . array2qs();
		
		if ($d['resultset']['selected_rows'] == 0)
				return alert_error('Data nilai kosong, periksa filter pencarian Anda.', $fallback);
			
		$this->load->library('PHPExcel');

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
		
		////////////// data jenis penilaian angket /////////
		$query=array(
				'select' => array(
						'jenis_penilaian, nama, jml_menilai_siswa'
				),
				'from' => 'kbm_angket',
				'where' => 
							array('id' => $r['angket_id'])
							
				);
		$jenis_nilai = $this->md->query($query)->resultset(0,3);
		
		////////////// data jeis penilaian angket /////////
		$query=array(
			'select' => array(
					'kak.kelas_id as kelas_id, dk.nama as nama_kelas'
			),
			'from' => 'kbm_angket_kelas kak',
			'join' => array(
					array('dakd_kelas dk', 'kak.kelas_id = dk.id', 'inner')),
			'where' => 
						array('kak.angket_id' => $r['angket_id']),
			'order_by' => 
						'dk.id desc',
						
			);
		$kelas_nilai_angket = $this->md->query($query)->resultset(0,100);
		
		
		
		if($jenis_nilai['data'][0]['jenis_penilaian']=='penilaian_diri')
		{
			///////////////// PENILAIAN DIRI /////////////////////////////////////
			$file_path = 'content/template/kbm-angket-nilai1.xls';
			$objPHPExcel = PHPExcel_IOFactory::load($file_path);
			if (!$objPHPExcel)
				return alert_error('Excel error.', $fallback);

			$map = array(
					'B' => 'kelas_nama',
					'C' => 'siswa_nama',
					'D' => 'angket_nilai',
			);
	
			// mulai isi nilai
			$sheet_no = 0;
			foreach ($kelas_nilai_angket['data'] as $data_kelas):
		
				
				//$sheet = clone $objPHPExcel->getSheetByName('nilai_pelajaran');
				$newSheet = clone $objPHPExcel->getSheetByName("Sheet1");
				$newSheet->setTitle($data_kelas['nama_kelas']);
				$newSheetIndex = 1;
				$objPHPExcel->addSheet($newSheet,$newSheetIndex);
				$sheet_no++;
				$no=0;
				$rowexcel=3;
				
				$newSheet->setCellValue("A1", "Penilaian Diri ".$jenis_nilai['data'][0]['nama']);
				
				foreach ($d['resultset']['data'] as $row):	
					if($row['kelas_id']==$data_kelas['kelas_id'])
					{					
						$no++;
						$rowexcel++;
						foreach ($map as $colex => $coldb):
							$newSheet->setCellValue($colex . $rowexcel, $row[$coldb]);
			
						endforeach;
			
						$newSheet->setCellValue("A" . $rowexcel, $no);
						$konversi_nilai = round($row['angket_nilai']/25,2);
						$newSheet->setCellValue("F" . $rowexcel, $konversi_nilai);
						
						if (!$row['ljs_id'])
							$newSheet->setCellValue("E" . $rowexcel, 'belum mengerjakan');
			
						else if (!$row['angket_terkoreksi'])
							$newSheet->setCellValue("E" . $rowexcel, 'belum dikoreksi');
						
					}					
				endforeach;	
				
				$newSheet->getStyle("A3:F{$rowexcel}")->applyFromArray($style_border);
				$newSheet->getStyle("E3:E{$rowexcel}")->applyFromArray($style_nilai);
		
			endforeach;
			$objPHPExcel->removeSheetByIndex(0);
			$objPHPExcel->setActiveSheetIndex(0);
			 
			// format garis & align
	
			// output file
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"nilai_angket_{$jenis_nilai['data'][0]['nama']}.xls\"");
			header("Cache-Control: max-age=0");

		}elseif($jenis_nilai['data'][0]['jenis_penilaian']=='penilaian_sejawat')
		{
			///////////////////// PENILAIAN SEJAWAT //////////////////////////////////
			$file_path = 'content/template/kbm-angket-nilai2.xls';
			$objPHPExcel = PHPExcel_IOFactory::load($file_path);
			if (!$objPHPExcel)
				return alert_error('Excel error.', $fallback);

			$map = array(
					'siswa_nama',
			);
			
			$map2 = array(
					'angket_nilai',
			);
	
			// mulai isi nilai
			$sheet_no = 0;
			foreach ($kelas_nilai_angket['data'] as $data_kelas):
		
				//$sheet = clone $objPHPExcel->getSheetByName('nilai_pelajaran');
				$newSheet = clone $objPHPExcel->getSheetByName("Sheet1");
				$newSheet->setTitle($data_kelas['nama_kelas']);
				$newSheetIndex = 1;
				$objPHPExcel->addSheet($newSheet,$newSheetIndex);
				$sheet_no++;
				
				
				$newSheet->setCellValue("A1", "Penilaian Sejawat ".$jenis_nilai['data'][0]['nama']);
				
				
				$no=0;
				$siswa_id=0;
				
				$colexcel1=1;
				$rowexcel1=4;
				
				$colexcel2=2;
				$rowexcel2=3;
				foreach ($d['resultset']['data'] as $row):	
					if($row['kelas_id']==$data_kelas['kelas_id'])
					{					
						if($row['siswa_id']!=$siswa_id)
						{
							$siswa_id = $row['siswa_id'];
							//////////// ROW //////////////////
							$no++;
							$rowexcel1++;
							foreach ($map as $colex => $coldb):
								$jumlah_nilai_siswa[$siswa_id]=0;
								$kory[$siswa_id]=$rowexcel1;
								//$newSheet->setCellValue($colex . $rowexcel, $row[$coldb]);
								$newSheet->setCellValueByColumnAndRow($colexcel1, $rowexcel1, $row[$coldb]);
							endforeach;
							
							$newSheet->setCellValue("A" . $rowexcel1, $no);
							
							/////////////// COLOUMN ////
							$colexcel2++;
							foreach ($map as $coldb):
								//$newSheet->setCellValue($colex . $rowexcel, $row[$coldb]);
								$newSheet->setCellValueByColumnAndRow($colexcel2, $rowexcel2, $row[$coldb]);
							endforeach;
							$newSheet->getStyleByColumnAndRow($colexcel2, $rowexcel2)->applyFromArray($style_border);
							$newSheet->getStyleByColumnAndRow($colexcel2, $rowexcel2+1)->applyFromArray($style_border);
				
						}
					}					
				endforeach;	
				$colexcel2++;
				////////////////// TOTAL ///////////////////
				$newSheet->setCellValueByColumnAndRow($colexcel2, $rowexcel2, "T.Rata-Rata");
				$newSheet->setCellValueByColumnAndRow($colexcel2+1, $rowexcel2, "Konversi");
				
				$newSheet->getStyleByColumnAndRow($colexcel2, $rowexcel2)->getFont()->setBold(true);
				$newSheet->getStyleByColumnAndRow($colexcel2, $rowexcel2)->applyFromArray($style_border);
				$newSheet->getStyleByColumnAndRow($colexcel2, $rowexcel2+1)->applyFromArray($style_border);
				
				$newSheet->getStyleByColumnAndRow($colexcel2+1, $rowexcel2)->getFont()->setBold(true);
				$newSheet->getStyleByColumnAndRow($colexcel2+1, $rowexcel2)->applyFromArray($style_border);
				$newSheet->getStyleByColumnAndRow($colexcel2+1, $rowexcel2+1)->applyFromArray($style_border);
				
				
				$colexcel3=2;
				$siswa_id=0;
				$no=0;
				//$noooo=0;
				foreach ($d['resultset']['data'] as $row1):
					
					if($row1['kelas_id']==$data_kelas['kelas_id'])
					{
						if($row1['siswa_id']!=$siswa_id)
						{
							$siswa_id = $row1['siswa_id'];
									
						$colexcel3++;
						//$rowexcel3=5;
						for($rowexcel3=5;$rowexcel3<=$rowexcel1;$rowexcel3++)
						{
							$newSheet->setCellValueByColumnAndRow($colexcel3, $rowexcel3, "-");
							$newSheet->getStyleByColumnAndRow($colexcel3, $rowexcel3)->applyFromArray($style_border);	
							//$noooo++;
						}
						foreach ($d['resultset']['data'] as $row2):	
							if($row2['kelas_id']==$data_kelas['kelas_id'])
							{		
								if($siswa_id==$row2['siswa_id'])
								{
								
									$jumlah_nilai_siswa[$row2['menilai_siswa_id']] = $jumlah_nilai_siswa[$row2['menilai_siswa_id']] + $row2['angket_nilai'];
									
									$newSheet->setCellValueByColumnAndRow($colexcel3, $kory[$row2['menilai_siswa_id']], $row2['angket_nilai']);
									$no++;
									
									$newSheet->getStyleByColumnAndRow($colexcel3, $kory[$row2['menilai_siswa_id']])->applyFromArray($style_border);
								}
								
							}					
						endforeach;
						}
					}	
				endforeach;
				
				
				$colexcel3++;
				$rowexcel3=4;
				foreach ($d['resultset']['data'] as $row):	
					if($row['kelas_id']==$data_kelas['kelas_id'])
					{		
						if($siswa_id!=$row['siswa_id'])
						{
							$rowexcel3++;
							$siswa_id = $row['siswa_id'];
							
							$jumlah_nilai_siswa[$row['siswa_id']] = round($jumlah_nilai_siswa[$row['siswa_id']]/$jenis_nilai['data'][0]['jml_menilai_siswa'],2);
							
							$konversi_nilai = round($jumlah_nilai_siswa[$row['siswa_id']]/25,2);
							
							$newSheet->setCellValueByColumnAndRow($colexcel3, $rowexcel3, $jumlah_nilai_siswa[$row['siswa_id']]);
							
							$col_konversi_nilai = $colexcel3+1;
							$newSheet->setCellValueByColumnAndRow($col_konversi_nilai, $rowexcel3, $konversi_nilai);
							
							$newSheet->getStyleByColumnAndRow($colexcel3, $rowexcel3)->applyFromArray($style_border);
							$newSheet->getStyleByColumnAndRow($col_konversi_nilai, $rowexcel3)->applyFromArray($style_border);
							
							
							//$newSheet->getStyleByColumnAndRow($colexcel3, $rowexcel3)->getFont()->setBold(true);

						}
						
					}					
				endforeach;
				
				
				$newSheet->getStyle("A3:C{$rowexcel1}")->applyFromArray($style_border);
				//$newSheet->getStyleByColumnAndRow(0,1,9,9)->applyFromArray($style_border);
				//$newSheet->getStyle("D4:D{$rowexcel1}")->applyFromArray($style_nilai);
		
			endforeach;
			$objPHPExcel->removeSheetByIndex(0);
			$objPHPExcel->setActiveSheetIndex(0); 
			
			// format garis & align
	
			// output file
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"nilai_angket_{$jenis_nilai['data'][0]['nama']}.xls\"");
			header("Cache-Control: max-age=0");
		}
		
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		exit();
	}
	
	function rowset($id) {
		$query = $this->query_1();
		$query['where']['angketnil.id'] = $id;

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
				'from' => 'kbm_angket_nilai evanil',
				'where' => array(
						'evanil.angket_id' => $r['angket_id'],
						'trial' => 0,
				),
		);

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$query['where']['evanil.kelas_id'] = $r['kelas_id'];

		$result = $this->md->query($query)->result();

		//exit_dump($result);

		if ($result['selected_rows'] == 0)
			return !alert_info('Data nilai angket kosong / tidak ditemukan.');

		$kkm = (float) $d['angket']['kkm'];
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

			if (!$row['angket_terkoreksi']):
				$jml_uncek++;
				$d['bar'][0]++;
				continue;
			endif;

			$nilai = (float) $row['angket_nilai'];
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
