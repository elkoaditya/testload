<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_laporan extends CI_Model {
	
	function listing_waktu($send_data = "") {
		
		$d = $this->d;
	
		if(isset($send_data['bulan'])){
			$data['from'] = date($send_data['tahun']."-".$send_data['bulan']."-01 00:00:00");
			
			$bulan_depan = $send_data['bulan']+1;
			$tahun_depan = $send_data['tahun'];
			if($bulan_depan>12){
				$bulan_depan=1;
				$tahun_depan++;
			}
			$data['last'] = date($tahun_depan."-".$bulan_depan."-01 00:00:00");
		}
		
		$this->db->select("
			baca_detail.total_waktu,
			
			kelas.grade,
			kelas.nama as nama_kelas,
			siswa.id as id_siswa,
			siswa.nama as nama_siswa,
			buku.buku_id as id_buku,
			buku.buku_nama as nama_buku,
		");
		$this->db->join('dprofil_siswa siswa', 'siswa.id =  baca_detail.baca_user_id', 'inner');
		$this->db->join('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'left');
		
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca_detail.baca_buku_bab_id', 'inner');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'left');
		
		$this->db->where('read_first >=', "'".$data['from']."'", false);
		$this->db->where('read_first <=', "'".$data['last']."'", false);
		
		$this->db->where('kelas.id ', $send_data['kelas_id'], false);
		
		$this->db->order_by('nama_buku desc');
		
		if(isset($send_data['limit'])){ 
			$this->db->limit($send_data['limit'], 0);
		}
		
        $query = $this->db->get('perpus_baca_detail baca_detail');
        
		$a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			
			
			if(isset($data1['data'][$arra1->id_siswa][$arra1->id_buku])){
				$total_waktu = $data1['data'][$arra1->id_siswa][$arra1->id_buku]['total_waktu'];
				$data1['data'][$arra1->id_siswa][$arra1->id_buku]['total_waktu'] =  $total_waktu + $arra1->total_waktu;
			}else{
				$datas = array(
					'total_waktu' 	=> $arra1->total_waktu,
					'grade'			=> $arra1->grade,
					'nama_kelas'	=> $arra1->nama_kelas,
					'id_siswa'		=> $arra1->id_siswa,
					'nama_siswa'	=> $arra1->nama_siswa,
					'id_buku'		=> $arra1->id_buku,
					'nama_buku'		=> $arra1->nama_buku,
					
				);
				$data1['data'][$arra1->id_siswa][$arra1->id_buku] = $datas;
			}
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	function siswa_baca_excel($data){
		
		//print_r($data['data_siswa_baca'] );
		
		$this->load->library('PHPExcel');

		$excel_source = APP_ROOT.'content/template/siswa_baca_download.xlsx';
		
		$excel_obj = PHPExcel_IOFactory::load($excel_source);
		
		
		$datetime_now = date("Y-m-d H:i:s");
		$date = date("Y-m-d");
		$sheet_no=0;
		foreach($data['data_siswa']['data'] as $data_siswa){
			$sheet_no++;
			$sheet = clone $excel_obj->getSheetByName('Sheet1');

			//$sheet->setTitle($data_siswa['siswa_nama']);
			$sheet->setTitle(' '.$sheet_no);
			$excel_obj->addSheet($sheet, $sheet_no);
			
			///// HEADER
			$sheet->setCellValue('A1', 'LAPORAN BACA SISWA DIDIK '.SEKOLAH);
			$sheet->setCellValue('A2', 'Last Download '.$datetime_now);
			
			$sheet->setCellValue('B4', ': '.$data_siswa['siswa_nama']);
			$sheet->setCellValue('B5', ': '.$data_siswa['siswa_kelas']);
			
			$sheet->setCellValue('D4', ': '.bulan((int)$data['bulan']) );
			$sheet->setCellValue('D5', ': '.$data['tahun']);
			
			///// ISI
			$row=7;
			$no=0;
			if( isset( $data['data_siswa_baca']['data'][$data_siswa['siswa_id']]) ){
				foreach($data['data_siswa_baca']['data'][$data_siswa['siswa_id']] as $siswa_baca){
					$row++;
					$no++;
					$sheet->setCellValue('A'.$row, $no);
					$sheet->setCellValue('B'.$row, $siswa_baca['nama_buku']);
					$sheet->setCellValue('D'.$row, detikToPukul($siswa_baca['total_waktu']));
				}
			}
			/// STYLE
			$styleTable = array(
				  'borders' => array(
					  'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
					  )
				  )
			  );
			  
			$sheet->getStyle("A8:D".$row)->applyFromArray($styleTable);
		
			
			///// FOOTER
			$sheet->setCellValue('C26', 'Semarang, '.$date);
			$sheet->setCellValue('B30', $data['data_kelas']['data'][1]['nama_wali']);
			$sheet->setCellValue('B31', 'NIP. '.$data['data_kelas']['data'][1]['nip_wali']);
		}
		
		$excel_obj->removeSheetByIndex(0);
		
		return excel_output_2007($excel_obj, 'laporan_siswa_baca_'.$data['bulan'].'_'.$data['tahun'].'.xlsx');
		
    }
}
?>