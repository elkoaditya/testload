<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_lap_absensi extends CI_Model {

	function chek_data_lap_absensi_exit(){
		
		$data['id'] = "";
		$data['data_lap_absensi'] = $this->listing($data);
		
		$chek_data = array("");
		foreach($data['data_lap_absensi']['data'] as $lap_absensi)
		{
			array_push($chek_data, $lap_absensi['lap_absensi_no_peserta']);
		}
		return $chek_data;
	}
	
	function listing($send_data = "") {
	
		$d = $this->d;
	
		$this->db->select("
			DAY(absensi.tanggal) as tanggal,
			absensi.id as id_absensi,
			absensi.jam_ajar_id,
			
			kelas.id as id_kelas,
			kelas.nama as nama_kelas,
			
			mapel.id as id_mapel,
			mapel.nama as nama_mapel,
			
			sdm.id as id_guru,
			sdm.nama as nama_guru,
			
			siswa.id as id_siswa,
			siswa.nama as nama_siswa,
			
			siswa_absensi.*, 
			
			user.nama as nama_modified,
			");
		$this->db->join('data_user user', 'user.id =  siswa_absensi.modifier_id', 'left');
		$this->db->join('nilai_absensi absensi', 'absensi.id =  siswa_absensi.absensi_nilai_id', 'left');
		$this->db->join('nilai_siswa nilsis', 'nilsis.id =  siswa_absensi.siswa_nilai_id', 'left');
		$this->db->join('dprofil_siswa siswa', 'siswa.id =  nilsis.siswa_id', 'left');
		
		$this->db->join('nilai_pelajaran nipel', 'nipel.id =  absensi.pelajaran_nilai_id', 'left');
		$this->db->join('dakd_pelajaran pelajaran', 'pelajaran.id =  nipel.pelajaran_id', 'left');
		$this->db->join('dakd_mapel mapel', 'mapel.id =  pelajaran.mapel_id', 'left');
		
		$this->db->join('nilai_kelas nikel', 'nikel.id =  absensi.kelas_nilai_id', 'left');
		$this->db->join('dakd_kelas kelas', 'kelas.id =  nikel.kelas_id', 'left');
		
		$this->db->join('dprofil_sdm sdm', 'sdm.id =  absensi.guru_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('siswa_absensi.id', $send_data['id'], false);
		}
		
		if(!empty($send_data['kelas_id'])){ 
			$this->db->where('kelas.id', $send_data['kelas_id'], false);
		}
		
		if(!empty($send_data['tanggal'])){ 
			$this->db->where('absensi.tanggal', '"'.$send_data['tanggal'].'"', false);
		}
		
		if(!empty($send_data['bulan'])){ 
			if(!empty($send_data['tahun'])){ 
				$this->db->where('MONTH(absensi.tanggal) = "'.$send_data['bulan'].'" 
					AND YEAR(absensi.tanggal) = "'.$send_data['tahun'].'"' );
			}
		}
		
		$this->db->where('siswa_absensi.aktif', 1, false);
		
        $query = $this->db->get('nilai_siswa_absensi siswa_absensi');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				/*'id_siswa' 			=> $arra1->id_siswa,
				'nama_siswa' 		=> $arra1->nama_siswa,
				
				'id_guru' 			=> $arra1->id_guru,
				'nama_guru' 		=> $arra1->nama_guru,
				
				'id_mapel' 			=> $arra1->id_mapel,
				'nama_mapel' 		=> $arra1->nama_mapel,
				
				'id_kelas' 			=> $arra1->id_kelas,
				'nama_kelas' 		=> $arra1->nama_kelas,*/
				
				'tanggal'			=> $arra1->tanggal,
				'absen' 			=> $arra1->absen,
				'status' 			=> $arra1->status,
				'keterangan' 		=> $arra1->keterangan,
				'aktif' 			=> $arra1->aktif,
				
				'modified'			=> tglwaktu($arra1->modified),
				'nama_modified' 	=> $arra1->nama_modified,
				
			);
			
			$jam_ajar = str_replace("[", "", $arra1->jam_ajar_id);
			$jam_ajar = str_replace("]", "", $jam_ajar);
			$jam_ajar_id = explode(",", $jam_ajar);
			
			if(!empty($send_data['tanggal'])){ 
				
				foreach($jam_ajar_id as $ja_id){
					$data1['data'][$arra1->id_siswa][$ja_id] = $datas;
				}
				
			}else{
			
				foreach($jam_ajar_id as $ja_id){
					$data1['data'][$arra1->id_siswa][$arra1->tanggal][$ja_id] = $datas;
				}
			}
			
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	
	////////////////////////////////////////
	//////////////// EXCEL /////////////////
	////////////////////////////////////////
	
	function download_data($data){
		
		$this->load->library('PHPExcel');

		$excel_source = APP_ROOT.'content/template/form_download.xlsx';
		
		$excel_obj = PHPExcel_IOFactory::load($excel_source);
		
		$sheet = $excel_obj->getSheetByName('Sheet1');
		
		$datetime_now = date("Y-m-d H:i:s");
		$kelas = 'Semua Kelas';
		if($this->input->get('kelas')!=0){
			$kelas = 'Kelas '.$data['kelas_nama'];
		}
		
		$sheet->setCellValue('B1', 'ABSENSI SISWA');
		$sheet->setCellValue('B2', 'Hari '.Hari($data['tanggal']).' Tanggal '.tgltodb($data['tanggal']));
		$sheet->setCellValue('B3', $kelas);
		$sheet->setCellValue('B4', 'Last Download '.$datetime_now);
		
		$sheet->mergeCells('B1:D1');
		$sheet->mergeCells('B2:D2');
		$sheet->mergeCells('B3:D3');
		$sheet->mergeCells('B4:D4');
		
		/// BG color
		//// GREEN
		$green = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '26A69A')
			)
		);
		
		//// PURLE
		$purple = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '6B5FB5')
			)
		);
		
		/// YELLOW
		$yellow = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'F9C851')
			)
		);
		
		/// RED
		$red = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'F5707A')
			)
		);

		$row	= 5;
		$no		= 0;
		$coloumn		= 'C';
		
		$sheet->setCellValue('A'.$row, 'No');
		$sheet->setCellValue('B'.$row, 'KELAS');
		$sheet->setCellValue('C'.$row, 'NAMA');
		
		// JUDUL
		$value_jam_ajar = $data['data_jam_ajar']['data'];
		foreach($value_jam_ajar as $index => $vjam_ajar)
		{
			$coloumn++;
			$sheet->setCellValue($coloumn.$row, $vjam_ajar['nama']);
		}
		$last_coloumn = $coloumn;
		
		$value_siswa = $data['data_siswa']['data'];
		foreach($value_siswa as $index => $vsiswa)
		{
			$no++;
			$row++;
			$sheet->setCellValue('A'.$row, $no);
			$sheet->setCellValue('B'.$row, $vsiswa['nama_kelas']);
			$sheet->setCellValue('C'.$row, $vsiswa['nama']);
		}
		$last_row = $row;
		// ISI
		
		$row_isi=6;
		if(isset($data['data_lap_absensi']['data'])){
			$vlap_absensi = $data['data_lap_absensi']['data'] ;
		}
		$value_siswa = $data['data_siswa']['data'];
		foreach($value_siswa as $index => $vsiswa)
		{
			$coloumn='D';
			$value_jam_ajar = $data['data_jam_ajar']['data'];
			foreach($value_jam_ajar as $index => $vjam_ajar)
			{
				if(isset($vlap_absensi[$vsiswa['id']][$vjam_ajar['id']])){
					
					$absensi	= $vlap_absensi[$vsiswa['id']][$vjam_ajar['id']]['absen'];
					$status		= $vlap_absensi[$vsiswa['id']][$vjam_ajar['id']]['status'];
					
					/// STATUS
					if($status == 'gembira'){
						$icon = 'smiley.png';
					}elseif($status == 'sedih'){
						$icon = 'sad.png';
					}
					
					/// ABSEN
					if($absensi == 'm'){
						$styleIsi = $green;
						$absen_ket = 'MASUK';
					}elseif($absensi == 's'){
						$styleIsi = $purple;
						$absen_ket = 'SAKIT';
						$icon = ''; 
					}elseif($absensi == 'i'){
						$styleIsi = $yellow;
						$absen_ket = 'IJIN';
						$icon = ''; 
					}elseif($absensi == 'a'){
						$styleIsi = $red;
						$absen_ket = 'ALPHA';
						$icon = ''; 
						
					}
					
					$sheet->setCellValue($coloumn.$row_isi,  $absen_ket);
					$sheet->getStyle($coloumn.$row_isi.":".$coloumn.$row_isi)->applyFromArray($styleIsi);
				}
				//$sheet->setCellValue($coloumn.$row_isi,"aaa");
				$coloumn++;
			}
			$row_isi++;
		}
		
		
		/// AUTO WITDH
		$x = 'D';
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		
		$value_jam_ajar = $data['data_jam_ajar']['data'];
		foreach($value_jam_ajar as $index => $vjam_ajar)
		{
			$sheet->getColumnDimension($x)->setAutoSize(true);
			$x++;
		}
		
		
		/// STYLE
		$sheet->getStyle("A5:".$last_coloumn."5")->getFont()->setBold(true);
		$styleTable = array(
			  'borders' => array(
				  'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
				  )
			  )
		  );
		$sheet->getStyle("A5:".$last_coloumn.$last_row)->applyFromArray($styleTable);
		
		/*
		$_cell_input = array(
				"C4:G".$row,
		);*/
		//excel_security_cell_lock($sheet, 'A1:FA'.$row);
		//excel_security_cell_unlock($sheet, $_cell_input);
		
		
		// kunci sheet
		//excel_security_sheet_lock($sheet);
		
		
		return excel_output_2007($excel_obj, 'Download Absensi '.tgltodb($data['tanggal']).' '.$kelas.'.xlsx');
    }
	
	
	function download_data_rekap($data){
		
		$this->load->library('PHPExcel');

		$excel_source = APP_ROOT.'content/template/form_download.xlsx';
		
		$excel_obj = PHPExcel_IOFactory::load($excel_source);
		
		$sheet = $excel_obj->getSheetByName('Sheet1');
		
		$datetime_now = date("Y-m-d H:i:s");
		$kelas = 'Semua Kelas';
		if($this->input->get('kelas')!=0){
			$kelas = 'Kelas '.$data['kelas_nama'];
		}
		
		$sheet->setCellValue('B1', 'ABSENSI SISWA');
		$sheet->setCellValue('B2', 'Bulan '.$data['bulan'].' Tahun '.$data['tahun']);
		$sheet->setCellValue('B3', $kelas);
		$sheet->setCellValue('B4', 'Last Download '.$datetime_now);
		
		$sheet->mergeCells('B1:D1');
		$sheet->mergeCells('B2:D2');
		$sheet->mergeCells('B3:D3');
		$sheet->mergeCells('B4:D4');
		
		/// BG color
		//// GREY
		$grey = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'AAAAAA')
			)
		);
		
		//// GREEN
		$green = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '26A69A')
			)
		);
		
		//// PURLE
		$purple = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '6B5FB5')
			)
		);
		
		/// YELLOW
		$yellow = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'F9C851')
			)
		);
		
		/// RED
		$red = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'F5707A')
			)
		);

		/// CENTER
		$style_center = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
	
		$row	= 5;
		$no		= 0;
		$coloumn		= 'G';
		
		$sheet->setCellValue('A'.$row, 'No');
		$sheet->setCellValue('B'.$row, 'KELAS');
		$sheet->setCellValue('C'.$row, 'NAMA');
		
		$sheet->setCellValue('D'.$row, 'Masuk');
		$sheet->setCellValue('E'.$row, 'Sakit');
		$sheet->setCellValue('F'.$row, 'Ijin');
		$sheet->setCellValue('G'.$row, 'Alpha');
		
		// JUDUL
		//$value_jam_ajar = $data['data_jam_ajar']['data'];
		//foreach($value_jam_ajar as $index => $vjam_ajar)
		$tanggal =1;
		$batas_tanggal=31;
		while($tanggal <= $batas_tanggal)
		{
			$coloumn++;
			/// cek hari minggu
			$date = $data['tahun']."-".$data['bulan']."-".$tanggal;
			if(date('N',strtotime($date)) == 7 ){
				$sheet->getStyle($coloumn.$row.":".$coloumn.$row)->applyFromArray($red);
			}
			
			$sheet->setCellValue($coloumn.$row, $tanggal);
			
			$tanggal++;
		}
		$last_coloumn = $coloumn;
		
		$value_siswa = $data['data_siswa']['data'];
		foreach($value_siswa as $index => $vsiswa)
		{
			$no++;
			$row++;
			$sheet->setCellValue('A'.$row, $no);
			$sheet->setCellValue('B'.$row, $vsiswa['nama_kelas']);
			$sheet->setCellValue('C'.$row, $vsiswa['nama']);
		}
		$last_row = $row;
		// ISI
		
		$row_isi=6;
		if(isset($data['data_lap_absensi']['data'])){
			$vlap_absensi = $data['data_lap_absensi']['data'] ;
		}
		$value_siswa = $data['data_siswa']['data'];
		foreach($value_siswa as $index => $vsiswa)
		{
			//$coloumn='D';
			$coloumn='H';
			
			$tanggal =1;
			$total_masuk	= 0;
			$total_sakit	= 0;
			$total_ijin		= 0;
			$total_alpha	= 0;
			
			while($tanggal <= $batas_tanggal)
			{
				$value_jam_ajar = $data['data_jam_ajar']['data'];
				
				$temp_absensi[$tanggal]='';
				$absensi = '-';
				$styleIsi = $grey;
				foreach($value_jam_ajar as $index => $vjam_ajar)
				{
					// cek ada jam yg kosong
					
					
					if(isset($vlap_absensi[$vsiswa['id']][$tanggal][$vjam_ajar['id']])){
						
						$absensi	= $vlap_absensi[$vsiswa['id']][$tanggal][$vjam_ajar['id']]['absen'];
						$status		= $vlap_absensi[$vsiswa['id']][$tanggal][$vjam_ajar['id']]['status'];
						
						/// STATUS
						if($status == 'gembira'){
							$icon = 'smiley.png';
						}elseif($status == 'sedih'){
							$icon = 'sad.png';
						}
						
						/// ABSEN
						if($absensi == 'm'){
							$styleIsi = $green;
							$absen_ket = 'MASUK';
							
							if($temp_absensi[$tanggal]=='s'){
								$total_sakit--;
							}
							if($temp_absensi[$tanggal]=='i'){
								$total_ijin--;
							}
							if($temp_absensi[$tanggal]=='a'){
								$total_alpha--;
							}
							
							if($temp_absensi[$tanggal]!='m'){
								$total_masuk++;
							}
							$temp_absensi[$tanggal]=$absensi;
							
						}
						
						if($temp_absensi[$tanggal]=='')
						{
							if($absensi == 's'){
								$styleIsi = $purple;
								$absen_ket = 'SAKIT';
								$icon = ''; 
								
								$temp_absensi[$tanggal]=$absensi;
								$total_sakit++;
							}elseif($absensi == 'i'){
								$styleIsi = $yellow;
								$absen_ket = 'IJIN';
								$icon = ''; 
								
								$temp_absensi[$tanggal]=$absensi;
								$total_ijin++;
							}elseif($absensi == 'a'){
								$styleIsi = $red;
								$absen_ket = 'ALPHA';
								$icon = ''; 
								
								$temp_absensi[$tanggal]=$absensi;
								$total_alpha++;
							}
						}
						
						//$sheet->setCellValue($coloumn.$row_isi,  $absen_ket);
						//$sheet->getStyle($coloumn.$row_isi.":".$coloumn.$row_isi)->applyFromArray($styleIsi);
					}elseif(isset($vlap_absensi[$vsiswa['id']][$tanggal][''])){
								
						$absensi	= $vlap_absensi[$vsiswa['id']][$tanggal]['']['absen'];
						$status		= $vlap_absensi[$vsiswa['id']][$tanggal]['']['status'];
						/// STATUS
						if($status == 'gembira'){
							$icon = 'smiley.png';
						}elseif($status == 'sedih'){
							$icon = 'sad.png';
						}
						
						/// ABSEN
						if($absensi == 'm'){
							$styleIsi = $green;
							$absen_ket = 'MASUK';
							
							if($temp_absensi[$tanggal]=='s'){
								$total_sakit--;
							}
							if($temp_absensi[$tanggal]=='i'){
								$total_ijin--;
							}
							if($temp_absensi[$tanggal]=='a'){
								$total_alpha--;
							}
							
							if($temp_absensi[$tanggal]!='m'){
								$total_masuk++;
							}
							$temp_absensi[$tanggal]=$absensi;
							
						}
						
						if($temp_absensi[$tanggal]=='')
						{
							if($absensi == 's'){
								$styleIsi = $purple;
								$absen_ket = 'SAKIT';
								$icon = ''; 
								
								$temp_absensi[$tanggal]=$absensi;
								$total_sakit++;
							}elseif($absensi == 'i'){
								$styleIsi = $yellow;
								$absen_ket = 'IJIN';
								$icon = ''; 
								
								$temp_absensi[$tanggal]=$absensi;
								$total_ijin++;
							}elseif($absensi == 'a'){
								$styleIsi = $red;
								$absen_ket = 'ALPHA';
								$icon = ''; 
								
								$temp_absensi[$tanggal]=$absensi;
								$total_alpha++;
							}
						}
					}
					//$sheet->setCellValue($coloumn.$row_isi,"aaa");
					
				}
				
				/// cek hari minggu atau bukan
				$date = $data['tahun']."-".$data['bulan']."-".$tanggal;
				if(date('N',strtotime($date)) == 7 ){
					$sheet->setCellValue($coloumn.$row_isi, "-");
					$sheet->getStyle($coloumn.$row_isi.":".$coloumn.$row_isi)->applyFromArray($red);
				}else{
					$sheet->setCellValue($coloumn.$row_isi, $absensi);
					$sheet->getStyle($coloumn.$row_isi.":".$coloumn.$row_isi)->applyFromArray($styleIsi);
				}
				$coloumn++;
					
				$tanggal++;
			}
			
			$sheet->setCellValue('D'.$row_isi, $total_masuk);
			$sheet->setCellValue('E'.$row_isi, $total_sakit);
			$sheet->setCellValue('F'.$row_isi, $total_ijin);
			$sheet->setCellValue('G'.$row_isi, $total_alpha);
			
			$row_isi++;
			
		}
		
		
		/// AUTO WITDH
		$x = 'H';
		$width='6';
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setWidth($width);
		$sheet->getColumnDimension('E')->setWidth($width);
		$sheet->getColumnDimension('F')->setWidth($width);
		$sheet->getColumnDimension('G')->setWidth($width);
		
		$tanggal =1;
		while($tanggal <= $batas_tanggal)
		{
			$sheet->getColumnDimension($x)->setWidth('3');
			$tanggal++;
			$x++;
		}
		
		
		/// STYLE
		$sheet->getStyle("A5:".$last_coloumn."5")->getFont()->setBold(true);
		$styleTable = array(
			  'borders' => array(
				  'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
				  )
			  )
		  );
		$sheet->getStyle("A5:".$last_coloumn.$last_row)->applyFromArray($styleTable);
		
		// center
		$sheet->getStyle("D5:".$last_coloumn.$last_row)->applyFromArray($style_center);
		
		/*
		$_cell_input = array(
				"C4:G".$row,
		);*/
		//excel_security_cell_lock($sheet, 'A1:FA'.$row);
		//excel_security_cell_unlock($sheet, $_cell_input);
		
		
		// kunci sheet
		//excel_security_sheet_lock($sheet);
		
		
		return excel_output_2007($excel_obj, 'Download Absensi Rekap '.$data['bulan'].' '.$data['tahun'].' '.$kelas.'.xlsx');
    }
}