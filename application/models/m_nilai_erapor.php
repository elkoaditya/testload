<?php

class M_nilai_erapor extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->dm['admin'] = cfguc_admin('akses', 'nilai', 'pelajaran');
		

	}
	
	/*
	function impor1()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		
		$pengetahuan = array(
			'PengT'	=> 'TLS',
			'PengL'	=> 'LSN',
			'PengP'	=> 'TGS',
			
		);
		
		$keterampilan = array(
			'KetrPk'	=> 'PRTK',
			'KetrPj'	=> 'PRJK',
			'KetrPt'	=> 'PRTF',
			'KetrPr'	=> 'PRDK',
		);
		
		///////////// EXCEL //////////////////////////////////////
		
		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));

		if ($d['error'])
			return FALSE;

		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		
		
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;
		
		
		$this->db->trans_start();
		
		$_sheet_index = 0;
		
		$sheet			= $PHPExcel->setActiveSheetIndex($_sheet_index);
		$row_max	 	= $sheet->getHighestRow();
		$row_start	 	= 7;
		$temp_kd_id		= '';
		$isi_data		= 0 ;
		while($row_max>=$row_start):
			$pd_id		=  trim($sheet->getCell("B". $row_start)->getValue());
			$kd_id		=  trim($sheet->getCell("C". $row_start)->getValue());
			
			if($temp_kd_id =='')
			{
				$temp_kd_id = $kd_id;
			}
			
			if($temp_kd_id != $kd_id){
				$isi_data=1;
			}
			
			if($isi_data==0){
				//// GET QUERY
				$query = array(
					'from'		 => 'nilai_siswa_pelajaran nisispel',
					'join'		 => array(
						array('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner'),
						array('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner'),
						array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
						array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
						array('dakd_kompetensi_dasar kd', 
							' kd.kategori_id = kategori.id AND kd.mapel_id = mapel.id', 'left'),
						array('dprofil_sdm guru', 'nipel.guru_id = guru.id', 'left'),
						
						array('nilai_siswa nilsis', 'nisispel.siswa_nilai_id = nilsis.id', 'inner'),
						array('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'inner'),
						
						array('prd_semester semester', 'nilsis.semester_id = semester.id', 'left'),
					),
					'where'		 => array(
						'siswa.pd_id_erapor'	=> $pd_id,
						'kategori.show_rapor'	=> 1,
						'semester.status'		=> 'aktif',
						'kd.kurikulum_id' 		=> 2,
					),
					'where_strings'=>array(
						'(kd.kode_erapor_teori = "'.$kd_id.'" OR kd.kode_erapor_praktek = "'.$kd_id.'")',
					),
					
					'select'	 => array(
						'nisispel.*',
						'siswa.pd_id_erapor',
						'kd.kode',
						'kd.kode_erapor_teori',
						'kd.kode_erapor_praktek',
					),
				);
				
				
				$result[$pd_id] = $this->md->query($query)->row();
				
				if($row_start<=10){
					//print_r($result[$pd_id]);
					
					$kd = (int)trim(str_replace("KD","",$result[$pd_id]['kode'])); 
					//echo "<br>".$kd."<br>";
					
					if($result[$pd_id]['kode_erapor_teori'] == $kd_id)
					{
						$col=6;
						foreach($pengetahuan as $kolom=>$label){
							
							//$sheet->setCellValueByColumnAndRow($col, $row_start, $label);
							$sheet->setCellValue('F'.$row_start, $label);
							//echo "<br>AAAA".$col.$row_start.$label."<br>";
							$col++;
							//$sheet->setCellValueByColumnAndRow($col, $row_start, $result[$pd_id][$kolom.$kd]);
							$sheet->setCellValue('G'.$row_start, $result[$pd_id][$kolom.$kd]);
							//echo "<br>AAAA".$col.$row_start.$result[$pd_id][$kolom.$kd]."<br>";
							$col++;
						}
					}
				}
				//echo $pd_id.'<br>';
			}
			//echo $pd_id." ".$kd_id."<br>";
			$row_start++;
		endwhile;
		
		
		//return excel_output_2007($PHPExcel, "coba.xlsx");
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$upload['name'].'"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');  //downloadable file is in Excel 2003 format (.xls)

		$objWriter->save('php://output'); 
		
		//$this->trans_done('Daftar nilai telah diperbarui.', 'Database error saat memperbarui nilai siswa.');
	}*/
	
	function impor()
	{
		
		$this->form->get();
		// upload

		$pengetahuan = array(
			'PengT'	=> 'TLS',
			'PengL'	=> 'LSN',
			'PengP'	=> 'TGS',
			
		);
		
		$keterampilan = array(
			'KetrPk'	=> 'PRTK',
			'KetrPj'	=> 'PRJK',
			'KetrPt'	=> 'PRTF',
			'KetrPr'	=> 'PRDK',
		);
		
		$upload = $this->upload('upload', array('xls', 'xlsx'));

		
		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		
		$sheet_jml = $PHPExcel->getSheetCount();
		
		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		
		$this->db->trans_start();
		
		$_sheet_index = 0;
		
		$sheet			= $PHPExcel->setActiveSheetIndex($_sheet_index);
		$row_max	 	= $sheet->getHighestRow();
		$row_start	 	= 7;
		$temp_kd_id		= '';
		$isi_data		= 0 ;
		while($row_max>=$row_start):
			$pd_id		=  trim($sheet->getCell("B". $row_start)->getValue());
			$kd_id		=  trim($sheet->getCell("C". $row_start)->getValue());
			
			if($temp_kd_id =='')
			{
				$temp_kd_id = $kd_id;
			}
			
			if($temp_kd_id != $kd_id){
				$isi_data=1;
			}
			
			//if($isi_data==0){
				//// GET QUERY
				$query = array(
					'from'		 => 'nilai_siswa_pelajaran nisispel',
					'join'		 => array(
						array('nilai_pelajaran nipel', 'nisispel.pelajaran_nilai_id = nipel.id', 'inner'),
						array('dakd_pelajaran pelajaran', 'nipel.pelajaran_id = pelajaran.id', 'inner'),
						array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
						array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
						array('dakd_kompetensi_dasar kd', 
							' kd.kategori_id = kategori.id AND kd.mapel_id = mapel.id', 'left'),
						array('dprofil_sdm guru', 'nipel.guru_id = guru.id', 'left'),
						
						array('nilai_siswa nilsis', 'nisispel.siswa_nilai_id = nilsis.id', 'inner'),
						array('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'inner'),
						
						array('prd_semester semester', 'nilsis.semester_id = semester.id', 'left'),
					),
					'where'		 => array(
						'siswa.pd_id_erapor'	=> $pd_id,
						'kategori.show_rapor'	=> 1,
						'semester.status'		=> 'aktif',
						'kd.kurikulum_id' 		=> 2,
					),
					'where_strings'=>array(
						'(kd.kode_erapor_teori = "'.$kd_id.'" OR kd.kode_erapor_praktek = "'.$kd_id.'")',
					),
					
					'select'	 => array(
						'nisispel.*',
						'siswa.pd_id_erapor',
						'kd.kode',
						'kd.kode_erapor_teori',
						'kd.kode_erapor_praktek',
					),
				);
				
				
				$result[$pd_id] = $this->md->query($query)->row();
				
				////// ISI EXCEL ///// 
				//print_r($result[$pd_id]);
				$kd = (int)trim(str_replace("KD","",$result[$pd_id]['kode'])); 
				//echo "<br>".$kd."<br>";
				
				//// PENGETAHUAN
				if($result[$pd_id]['kode_erapor_teori'] == $kd_id)
				{
					$col=5;
					foreach($pengetahuan as $kolom=>$label){
						
						if($result[$pd_id][$kolom.$kd] != NULL){
							$sheet->setCellValueByColumnAndRow($col, $row_start, $label);
							//$sheet->setCellValue('F'.$row_start, $label);
							//echo "<br>AAAA".$col.$row_start.$label."<br>";
							$col++;
							$sheet->setCellValueByColumnAndRow($col, $row_start, $result[$pd_id][$kolom.$kd]);
							//$sheet->setCellValue('G'.$row_start, $result[$pd_id][$kolom.$kd]);
							//echo "<br>AAAA".$col.$row_start.$result[$pd_id][$kolom.$kd]."<br>";
							$col++;
						}
					}
				}
				
				/// KETRAMPILAN
				if($result[$pd_id]['kode_erapor_praktek'] == $kd_id)
				{
					$col=5;
					foreach($keterampilan as $kolom=>$label){
						
						if($result[$pd_id][$kolom.$kd] != NULL){
							$sheet->setCellValueByColumnAndRow($col, $row_start, $label);
							//$sheet->setCellValue('F'.$row_start, $label);
							//echo "<br>AAAA".$col.$row_start.$label."<br>";
							$col++;
							$sheet->setCellValueByColumnAndRow($col, $row_start, $result[$pd_id][$kolom.$kd]);
							//$sheet->setCellValue('G'.$row_start, $result[$pd_id][$kolom.$kd]);
							//echo "<br>AAAA".$col.$row_start.$result[$pd_id][$kolom.$kd]."<br>";
							$col++;
						}
					}
				}
				
				//echo $pd_id.'<br>';
			//}
			//echo $pd_id." ".$kd_id."<br>";
			$row_start++;
		endwhile;
		
		
		
		return excel_output_2007($PHPExcel, $upload['file_name']);
	}
}