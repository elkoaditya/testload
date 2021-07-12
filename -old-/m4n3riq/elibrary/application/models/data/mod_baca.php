<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_baca extends CI_Model {

	function query_baca($buku_bab_id=0,$siswa_id=0) {
	
		$query = "
				SELECT *
				FROM
					perpus_baca
				WHERE 
					baca_buku_bab_id = ".$buku_bab_id."
					AND
					baca_user_id = ".$siswa_id."
			";
			
		
		return $query;
	}
	
	function query_baca_detail($baca_kode=0) {
	
		$query = "
				SELECT *
				FROM
					perpus_baca_detail
				WHERE 
					baca_kode = '".$baca_kode."'
			";
			
		
		return $query;
	}
	
	function listing($send_data = "") {
		$d = $this->d;
	
		$this->db->select("
			buku.buku_id,
			buku.buku_nama,
			
			buku_bab.buku_bab_id,
			buku_bab.buku_bab_nama,
			
			siswa.nama as siswa_nama,
			kelas.nama as kelas_nama,
			
			baca.*,
		");
		$this->db->join('perpus_baca baca', 'baca.baca_user_id =  siswa.id', 'inner');
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca.baca_buku_bab_id', 'inner');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'inner');
		
		$this->db->join('dakd_kelas kelas', 'kelas.id =  siswa.kelas_id', 'inner');
		
		$this->db->where('baca.read_last between "'.$send_data['date'].'" and "'.$send_data['date'].' 23:59:59"');
		
		$this->db->order_by('baca.read_last DESC');
        $query = $this->db->get('dprofil_siswa siswa');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'buku_id' 			=> $arra1->buku_id,
				'buku_nama' 		=> $arra1->buku_nama,
				
				'buku_bab_id' 		=> $arra1->buku_bab_id,
				'buku_bab_nama' 	=> $arra1->buku_bab_nama,
				
				'siswa_id' 			=> $arra1->baca_user_id,
				'siswa_nama' 		=> $arra1->siswa_nama,
				
				'kelas_nama' 		=> $arra1->kelas_nama,
				
				'total_waktu' 		=> $arra1->total_waktu,
				'total_waktu_lalu'	=> $arra1->total_waktu_lalu,
				
				'jumlah_akses'		=> $arra1->jumlah_akses,
				'read_first'		=> tgltodb($arra1->read_first),
				'read_last'			=> tgltodb($arra1->read_last),
				
			);
			$data1['data'][$a] = $datas;
			
        }
        $data1['count'] = $a;
        return $data1;
	}
	
	function listing_detail($send_data = "", $role='siswa') {
		$d = $this->d;
	
		if($role=='siswa'){
			$this->db->select("
				buku.buku_id,
				buku.buku_nama,
				
				buku_bab.buku_bab_id,
				buku_bab.buku_bab_nama,
				
				user.nama as siswa_nama,
				kelas.nama as kelas_nama,
				
				baca.*,
			");
		}else if($role=='sdm'){
			$this->db->select("
				buku.buku_id,
				buku.buku_nama,
				
				buku_bab.buku_bab_id,
				buku_bab.buku_bab_nama,
				
				user.nama as guru_nama,
				
				baca.*,
			");
			
		}
		$this->db->join('perpus_baca_detail baca', 'baca.baca_user_id =  user.id', 'inner');
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca.baca_buku_bab_id', 'inner');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'inner');
		if($role=='siswa'){
			$this->db->join('dakd_kelas kelas', 'kelas.id =  user.kelas_id', 'inner');
		}
		//$this->db->where('baca.read_last between "'.$send_data['date'].'" and "'.$send_data['date'].' 23:59:59"');
		$this->db->where('baca.read_first between "'.$send_data['date'].'" and "'.$send_data['date'].' 23:59:59"');
		
		//$this->db->order_by('baca.read_last DESC');
		$this->db->order_by('baca.read_first DESC');
		if($role=='siswa'){
			$query = $this->db->get('dprofil_siswa user');
        }else if($role=='sdm'){
			$query = $this->db->get('dprofil_sdm user');
        }
		
		$a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'buku_id' 			=> $arra1->buku_id,
				'buku_nama' 		=> $arra1->buku_nama,
				
				'buku_bab_id' 		=> $arra1->buku_bab_id,
				'buku_bab_nama' 	=> $arra1->buku_bab_nama,
				
				
				'user_id'			=> $arra1->baca_user_id,
				'total_waktu' 		=> $arra1->total_waktu,
				
				
				'read_first'		=> tgltodb($arra1->read_first),
				
				
			);
			
			if($role=='siswa'){
				$datas['siswa_nama'] 	= $arra1->siswa_nama;
				$datas['kelas_nama'] 	= $arra1->kelas_nama;
				
			}elseif($role=='sdm'){
				$datas['guru_nama'] 	= $arra1->guru_nama;
				
			}
			
			$data1['data'][$a] = $datas;
			
        }
        $data1['count'] = $a;
        return $data1;
	}
	
	/////////////////////////////////////////////////////////////////////////////
	
	function save_time(){
		//echo"dddd";
		$baca_kode 		= $this->input->post('kode');
		$buku_bab_id 	= $this->input->post('buku_bab_id');
		$siswa_id		= $this->input->post('siswa_id');
		$akses			= $this->input->post('akses');
		
		$this->db->trans_start();
		//echo"a";
		//////////////////// RECORD BACA /////////////////////////
		
		$query = $this->query_baca_detail($baca_kode);
		$hasil = $this->db->query($query)->row();
		
		if(isset($hasil->baca_kode)):
			$query_dupdate = "
					UPDATE perpus_baca_detail
					SET
						total_waktu			= total_waktu + 60 ,
						modified			= '".date('Y-m-d H:i:s')."'
					WHERE 
						baca_kode = '".$baca_kode."'
				";
			$this->db->query($query_dupdate);
		else:
			$_detail = array(
				'baca_kode' 		=> $baca_kode,
				'baca_buku_bab_id'	=> $buku_bab_id,
				'baca_user_id'		=> $siswa_id,
				'total_waktu'		=> 60,
				'read_first'		=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('perpus_baca_detail',$_detail);
		endif;
		
		//echo"b";
		//////////////////// TOTAL BACA /////////////////////////
		$_raw = array(
			'baca_buku_bab_id'	=> $buku_bab_id,
			'baca_user_id'	=> $siswa_id,
			
			'read_last' => date('Y-m-d H:i:s'),
			);
		
		$query = $this->query_baca($buku_bab_id, $siswa_id);
		$hasil = $this->db->query($query)->row();
		
		
		if(isset($hasil->baca_id)):
			$set = '';
			if($akses==1){
				$set = " 
				, total_waktu_lalu	= total_waktu - 60
				, read_last			= '".date('Y-m-d H:i:s')."' ";
			}
			
			$query_update = "
				UPDATE perpus_baca
				SET
					total_waktu			= total_waktu + 60 ,
					jumlah_akses		= jumlah_akses + ".$akses."
					".$set."
				WHERE 
					baca_id = ".$hasil->baca_id."
			";
			$this->db->query($query_update);
			
		else:
			$_raw['total_waktu']	= 60;
			$_raw['jumlah_akses'] 	= 1;
			$_raw['read_first'] 	= date('Y-m-d H:i:s');
			$_raw['read_last'] 	= date('Y-m-d H:i:s');
			$this->db->insert('perpus_baca',$_raw);
			
		endif;
		
		$this->db->trans_complete();
		
		//echo"c";
		///////////// RESULT ///////////////
		
		if ($this->db->trans_status() === FALSE){
			$response['warna'] = '#FF4444';	
			$response['message'] = '<div class="alert alert-danger" role="alert">
                                        Waktu baca GAGAL di simpan, coba "REFRESH" halaman ini dan cek "INTERNET".
									</div>';	
		}else{	
			$response['warna'] = '#00AAFF';	
			$response['message'] = '<div class="alert alert-success" role="alert">
											Waktu baca berhasil di simpan.
									</div>';
		}
		//echo"d";
		
		return $response;
	}	
	
	
	////// EXCEL ///////
	function baca_excel($data){
		
		//print_r($data['data_siswa_baca'] );
		
		$this->load->library('PHPExcel');

		$excel_source = APP_ROOT.'content/template/baca_download.xlsx';
		
		$excel_obj = PHPExcel_IOFactory::load($excel_source);
		
		
		$datetime_now = date("Y-m-d H:i:s");
		$date = date("Y-m-d");
		
		$sheet = $excel_obj->getSheetByName('Sheet1');
		
		///// HEADER
		$sheet->setCellValue('A1', 'DAFTAR PEMBACA PERPUSTAKAAN '.SEKOLAH);
		$sheet->setCellValue('A2', 'Last Download '.$datetime_now);
		
		$sheet->setCellValue('C4', ': '.tgl($data['date']));
		
		///// ISI
		$row=5;
		$no=0;
		if( isset( $data['data_baca']['data']) ){
			foreach($data['data_baca']['data'] as $data_baca){
				$row++;
				$no++;
				$sheet->setCellValue('A'.$row, $no);
				$sheet->setCellValue('B'.$row, waktu_resmi($data_baca['read_first']));
				$sheet->setCellValue('C'.$row, $data_baca['siswa_nama']);
				$sheet->setCellValue('D'.$row, $data_baca['kelas_nama']);
				$sheet->setCellValue('E'.$row, $data_baca['buku_nama']);
				
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
		  
		$sheet->getStyle("A6:E".$row)->applyFromArray($styleTable);
		
		return excel_output_2007($excel_obj, 'laporan_baca_perpustakaan_'.tgl($data['date']).'.xlsx');
		
    }
}
