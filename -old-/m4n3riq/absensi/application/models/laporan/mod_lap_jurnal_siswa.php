<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_lap_jurnal_siswa extends CI_Model {

	function chek_data_lap_jurnal_siswa_exit(){
		
		$data['id'] = "";
		$data['data_lap_jurnal_siswa'] = $this->listing($data);
		
		$chek_data = array("");
		foreach($data['data_lap_jurnal_siswa']['data'] as $lap_jurnal_siswa)
		{
			array_push($chek_data, $lap_jurnal_siswa['lap_jurnal_siswa_no_peserta']);
		}
		return $chek_data;
	}
	
	function listing($send_data = "") {
	
		$d = $this->d;
	
		$this->db->select("
			jurnal.*,
			
			kelas.id as id_kelas,
			kelas.nama as nama_kelas,
			
			mapel.id as id_mapel,
			mapel.nama as nama_mapel,
			
			sdm.id as id_guru,
			sdm.nama as nama_guru,
			
			
			user.nama as nama_modified,
			
			");
			
		$this->db->join('data_user user', 'user.id =  jurnal.modifier_id', 'left');
		
		$this->db->join('nilai_pelajaran nipel', 'nipel.id =  jurnal.pelajaran_nilai_id', 'left');
		$this->db->join('dakd_pelajaran pelajaran', 'pelajaran.id =  nipel.pelajaran_id', 'left');
		$this->db->join('dakd_mapel mapel', 'mapel.id =  pelajaran.mapel_id', 'left');
		
		$this->db->join('nilai_kelas nikel', 'nikel.id =  jurnal.kelas_nilai_id', 'left');
		$this->db->join('dakd_kelas kelas', 'kelas.id =  nikel.kelas_id', 'left');
		
		$this->db->join('dprofil_sdm sdm', 'sdm.id =  jurnal.guru_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('jurnal.id', $send_data['id'], false);
		}
		
		if(!empty($send_data['kelas_id'])){ 
			$this->db->where('kelas.id', $send_data['kelas_id'], false);
		}
		
		if(!empty($send_data['tanggal'])){ 
			$this->db->where('jurnal.tanggal', '"'.$send_data['tanggal'].'"', false);
		}
		
		$this->db->where('jurnal.aktif', 1, false);
		
		
        $query = $this->db->get('jurnal_siswa jurnal');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'id' 				=> $arra1->id,
				
				'id_mapel' 			=> $arra1->id_mapel,
				'nama_mapel' 		=> $arra1->nama_mapel,
				
				'id_kelas' 			=> $arra1->id_kelas,
				'nama_kelas' 		=> $arra1->nama_kelas,
				
				'id_guru' 			=> $arra1->id_guru,
				'nama_guru' 		=> $arra1->nama_guru,
				
				'materi_ajar' 			=> $arra1->materi_ajar,
				'jam_masuk' 			=> $arra1->jam_masuk,
				'jam_keluar' 			=> $arra1->jam_keluar,
				'jam_ajar_id'			=> $arra1->jam_ajar_id,
				'status_belajar_id'		=> $arra1->status_belajar_id,
				//'jml_siswa'				=> $arra1->jml_siswa,
				'keterangan' 			=> $arra1->keterangan,
				
				'aktif' 				=> $arra1->aktif,
				
				'modified'			=> tglwaktu($arra1->modified),
				'nama_modified' 	=> $arra1->nama_modified,
				
			);
			/*
			$jam_ajar = str_replace("[", "", $arra1->jam_ajar_id);
			$jam_ajar = str_replace("]", "", $jam_ajar);
			$jam_ajar_id = explode(",", $jam_ajar);
			
			foreach($jam_ajar_id as $ja_id){
				$data1['data'][$ja_id] = $datas;
			}*/
			$data1['data'][$arra1->id_kelas][] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	function listing_jml_absen($send_data = "") {
	
		$d = $this->d;
	
		$this->db->select("
			absensi.*,
			
			kelas.id as id_kelas,
			kelas.nama as nama_kelas,
			
			user.nama as nama_modified,
			count(siswa_absensi.id) as jml_siswa,
			
			");
		$this->db->join('nilai_absensi absensi', 'absensi.id =  siswa_absensi.absensi_nilai_id', 'left');
		$this->db->join('data_user user', 'user.id =  absensi.modifier_id', 'left');
		
		$this->db->join('nilai_kelas nikel', 'nikel.id =  absensi.kelas_nilai_id', 'left');
		$this->db->join('dakd_kelas kelas', 'kelas.id =  nikel.kelas_id', 'left');
		
		
		if(!empty($send_data['id'])){ 
			$this->db->where('siswa_absensi.id', $send_data['id'], false);
		}
		
		if(!empty($send_data['kelas_id'])){ 
			$this->db->where('kelas.id', $send_data['kelas_id'], false);
		}
		
		if(!empty($send_data['tanggal'])){ 
			$this->db->where('absensi.tanggal', '"'.$send_data['tanggal'].'"', false);
		}
		
		if(!empty($send_data['absen'])){ 
			$this->db->where('siswa_absensi.absen', '"'.$send_data['absen'].'"', false);
		}
		
		$this->db->where('siswa_absensi.aktif', 1, false);
		
		$this->db->group_by('absensi.id');
		
        $query = $this->db->get('nilai_siswa_absensi siswa_absensi');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'jml_siswa'				=> $arra1->jml_siswa,
			);
			
			$data1['data'][$arra1->id_kelas][$arra1->id] = $datas;
			
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
		$sheet->setCellValue('B1', 'JURNAL GURU');
		$sheet->setCellValue('B2', 'Hari '.Hari($data['tanggal']).' Tanggal '.tgltodb($data['tanggal']));
		$sheet->setCellValue('B3', $kelas);
		$sheet->setCellValue('B4', 'Last Download '.$datetime_now);
		
		$sheet->mergeCells('B1:D1');
		$sheet->mergeCells('B2:D2');
		$sheet->mergeCells('B3:D3');
		$sheet->mergeCells('B4:F4');
		
		// TOP
		$styleTop = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
			)
		);
	
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
		$coloumn		= 'A';
		
		$judul = array(
			"No",
			"KELAS",
			"MATERI",
			"MAPEL",
			"GURU",
			"MENGAJAR JAM",
			"JAM MASUK",
			"JAM KELUAR",
			"STATUS BELAJAR",
			"JML SISWA",
			"JML SISWA MASUK",
			"JML SISWA SAKIT",
			"JML SISWA IJIN",
			"JML SISWA ALPHA",
			"KETERANGAN",
		);
		
		$jurnal = array(
			"materi_ajar",
			"nama_mapel",
			"nama_siswa",
			"jam_ajar_id",
			"jam_masuk",
			"jam_keluar",
			"status_belajar_id",
			"jml_siswa",
		);
		
		$jml_absensi = array(
			"data_masuk",
			"data_sakit",
			"data_ijin",
			"data_alpha",
		);
		
		foreach($judul as $index)
		{
			$sheet->setCellValue($coloumn.$row, $index);
			$coloumn++;
		}
		$coloumn--;
		$last_coloumn = $coloumn;
 		
		$row	= 5;
		$no		= 0;
		$status_belajar = $data['data_status_belajar']['data'];
		foreach($data['data_kelas']['data'] as $value=>$key){
			if(($data['kelas_id']=='')||($data['kelas_id']==$key['id'])){
				$no++;
				$row++;
				$sheet->setCellValue("A".$row, $no);
				$sheet->setCellValue("B".$row, $key['nama']);
				
				$row_kls_awal = $row;
				if(isset($data['data_lap_jurnal_siswa']['data'][$key['id']])){
					$lap_jurnal_siswa = $data['data_lap_jurnal_siswa']['data'][$key['id']];
					foreach($lap_jurnal_siswa as $value=>$key2){
						$coloumn	= 'C';
						foreach($jurnal as $index)
						{
							if($index == 'status_belajar_id'){
								if($key2[$index]>0){
									$sheet->setCellValue($coloumn.$row, $status_belajar[$key2[$index]]['nama']);
								}
							}else{
								$sheet->setCellValue($coloumn.$row, $key2[$index]);
							}
							$coloumn++;
						}
						
						foreach($jml_absensi as $index2)
						{
							if(isset( $data[$index2]['data'][$key['id']][$key2['id']] )){
								$jml_siswa = $data[$index2]['data'][$key['id']][$key2['id']]['jml_siswa'];
								$sheet->setCellValue($coloumn.$row, $jml_siswa);
							}
							$coloumn++;
						}
						$sheet->setCellValue($coloumn.$row, $key2['keterangan']);
						
						$row++;
					}
					
					$sheet->mergeCells('A'.$row_kls_awal.':A'.$row);
					$sheet->mergeCells('B'.$row_kls_awal.':B'.$row);
					
					$sheet->getStyle('A'.$row_kls_awal.':B'.$row)->applyFromArray($styleTop);
				}
				
			}
		}
		$last_row = $row;
		
		
		$coloumn	= 'A';
		foreach($judul as $index)
		{
			$sheet->getColumnDimension($coloumn)->setAutoSize(true);
			$coloumn++;
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
		
		
		return excel_output_2007($excel_obj, 'Download Jurnal Guru '.tgltodb($data['tanggal']).' '.$kelas.'.xlsx');
    }
}