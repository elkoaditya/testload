<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_buku_bab extends CI_Model {

	function chek_data_buku_bab_exit(){
		
		$data['id'] = "";
		$data['data_buku_bab'] = $this->listing($data);
		
		$chek_data = array("");
		if(isset($data['data_buku_bab']['data'])){
			foreach($data['data_buku_bab']['data'] as $buku_bab)
			{
				array_push($chek_data, $buku_bab['buku_bab_nama']);
			}
		}
		return $chek_data;
	}
	
    function listing($send_data = "") {
		/* 
		catatan :
		buku_bab sementara jadikan 1 database
		setelah nanti dibuat laporan bulanan baru dubuatkan ke database baru
		*/
		$d = $this->d;
	
		$this->db->select("*");
		$this->db->join('perpus_user_login user', 'user.login_id =  buku_bab.buku_bab_modified_id', 'left');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('buku_bab_id', $send_data['id'], false);
		}
		if(!empty($send_data['buku_id'])){ 
			$this->db->where('buku_bab_buku_id', $send_data['buku_id'], false);
		}
		if(array_key_exists("pensiun",$send_data)){ 
			$this->db->where('buku_bab_pensiun', $send_data['pensiun'], false);
		}
		$this->db->where('buku_bab_aktif', 1, false);
        $query = $this->db->get('perpus_buku_bab buku_bab');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'buku_bab_id' 			=> $arra1->buku_bab_id,
				'buku_bab_buku_id'			=> $arra1->buku_bab_buku_id,
				'buku_bab_nama' 			=> $arra1->buku_bab_nama,
				'buku_bab_jml_halaman'		=> $arra1->buku_bab_jml_halaman,
				'buku_bab_file' 		=> $arra1->buku_bab_file,
				'buku_bab_pensiun' 		=> $arra1->buku_bab_pensiun,
				'buku_bab_modified_time'	=> $arra1->buku_bab_modified_time,
				'modified_username' 				=> $arra1->login_username,
				
				'buku_nama'			=> $arra1->buku_nama,
				
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	function save($send_data = "", $upload) {
		$d = $this->d;
		
		$upload_path = $upload['full_path'];
		$file = $upload['file_name'];
		
		$chek_nama = $this->chek_data_buku_bab_exit();
		
		$data = array(
			'buku_bab_buku_id' 				=> $send_data['buku_bab_buku_id'],
			'buku_bab_nama' 				=> $send_data['buku_bab_nama'],
			'buku_bab_jml_halaman'		=> $send_data['buku_bab_jml_halaman'],
			'buku_bab_pensiun' 			=> 0,
			'buku_bab_modified_time' 	=> date("Y-m-d H:i:sa"),
			'buku_bab_modified_id' 		=> $this->session->userdata['user']['id'],
			'buku_bab_aktif' 			=> 1,
			
			);

		if($file != '')
		{	$data['buku_bab_file'] = $file;	}
	
		if(isset($send_data['buku_bab_id'])){
			$this->db->where('buku_bab_id', $send_data['buku_bab_id']);
			$this->db->update('perpus_buku_bab', $data);
		}else{
			/*if(in_array($send_data['buku_bab_nama'],$chek_nama))
			{
				return alert_error(" Data sudah ada.", "data/buku_bab/input_new");
			}*/
			$data['buku_bab_created'] = date("Y-m-d H:i:sa");
			$this->db->insert('perpus_buku_bab', $data);
		}
		
		return !$d['error'];
    }
	
	function edit_pensiun($send_data = "") {
		$d = $this->d;
		
		$data = array(
			'buku_bab_pensiun' 		=> $send_data['buku_bab_pensiun'],
			);

		$this->db->where('buku_bab_id', $send_data['buku_bab_id']);
		$this->db->update('perpus_buku_bab', $data);
		return !$d['error'];
    }
	
	function delete($send_data = "") {
		$d = $this->d;
		
		$data = array(
			'buku_bab_aktif' 		=> 0,
			);

		$this->db->where('buku_bab_id', $send_data['buku_bab_id']);
		$this->db->update('perpus_buku_bab', $data);
		return !$d['error'];
    }
	
	////////////////////////////////////////
	//////////////// EXCEL /////////////////
	////////////////////////////////////////
	function download_add(){
		
		$this->load->library('PHPExcel');

		$excel_source = 'content/template/form_tambah.xlsx';
		
		$excel_obj = PHPExcel_IOFactory::load($excel_source);
		
		$sheet = $excel_obj->getSheetByName('Sheet1');
		
		$datetime_now = date("Y-m-d H:i:s");
		$sheet->setCellValue('A1', 'FORM TAMBAH buku_bab PENYIDIK ');
		$sheet->setCellValue('A2', 'Last Download '.$datetime_now);
		
		
		return excel_output_2007($excel_obj, 'Tambah_master_buku_bab.xlsx');
    }
	
	function upload_add($upload, $data){
		
		$this->load->library('PHPExcel');
		
		$upload_path = $upload['full_path'];
		@chmod($upload['full_path'], 0777);
		
		$excel_obj = PHPExcel_IOFactory::load($upload_path);
		
		$sheet_jml = $excel_obj->getSheetCount();

		if (!$excel_obj){
			return alert_error(" File excel tak dapat dibaca.");
		}

		if ($sheet_jml < 1){
			return alert_error(" Sheet/halaman tidak dapat dibaca.");
		}
		
		$sheet = $excel_obj->setActiveSheetIndex(0);
		$row_max = $sheet->getHighestRow();
		
		// Get Value
		$row_excel=4;
		$no=0;
		
		$chek_nama = $this->chek_data_buku_bab_exit();
		
		while($row_max >= $row_excel)
		{
			// CHECK EXIT
			$temp_nama = $sheet->getCell('B' . $row_excel)->getValue();
			if(!in_array($temp_nama,$chek_nama))
			{
				$row[$no]['buku_bab_nama'] 			= $sheet->getCell('B' . $row_excel)->getValue();
				
				$row[$no]['buku_bab_created'] 		= date("Y-m-d H:i:sa");
				$row[$no]['buku_bab_modified_id'] 	= $this->session->userdata['user']['id'];
				$row[$no]['buku_bab_aktif']			= 1;
				$no++;
			}
			$row_excel++;
			
		}
		
		unset($sheet);
		$excel_obj->disconnectWorksheets();
		unset($excel_obj);
		@unlink($upload['full_path']);
		
		if ($no < 1){
			return alert_error(" Daftar kosong / sudah ada / tidak terbaca.");
		}
		
		//print_r($row);
		$this->db->trans_start();
		$this->db->insert_batch('buku_bab', $row);
		if ($this->db->trans_status() === FALSE){
			
				$this->db->trans_rollback();
		}else{
			
				$this->db->trans_commit();
		}
		
		return !$d['error'];
    }

	function list_resume($send_data = "") {
		$d = $this->d;
	
		$this->db->select("*");
		
		$this->db->join('data_user user', 'user.id =  resume.resume_user_id', 'left');
		
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  resume.resume_buku_bab_id', 'left');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'left');
		
		if(!empty($send_data['buku_bab'])){ 
			$this->db->where('resume_buku_bab_id', $send_data['buku_bab'], false);
		}
		if(!empty($send_data['user'])){ 
			$this->db->where('resume_user_id', $send_data['user'], false);
		}
		$this->db->order_by('resume_modified DESC');
        $query = $this->db->get('perpus_resume_user resume');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'buku_bab_id' 		=> $arra1->buku_bab_id,
				'buku_bab_buku_id'	=> $arra1->buku_bab_buku_id,
				'buku_bab_nama' 	=> $arra1->buku_bab_nama,
				
				'buku_nama'			=> $arra1->buku_nama,
				
				'user_nama'			=> $arra1->nama,
				'user_role'			=> $arra1->role,
				
				'resume_isi'		=> $arra1->resume_isi,
				'resume_modified'	=> $arra1->resume_modified,
				'resume_created'	=> $arra1->resume_created,
				
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
	}
	
	function check_resume_exit($check){
		
		$data['buku_bab'] = $check['resume_buku_bab_id'];
		$data['user'] = $check['resume_user_id'];
		
		$data['data_resume'] = $this->list_resume($data);
		
		$result = 0;
		if(isset($data['data_resume']['data'])){
			foreach($data['data_resume']['data'] as $data_resume)
			{
				$result = 1;
			}
		}
		return $result;
	}
	
	function save_resume($send_data = "") {
		$d = $this->d;
		
		$chek_nama = $this->chek_data_buku_bab_exit();
		
		$data = array(
			'resume_buku_bab_id' 		=> $send_data['buku_bab_id'],
			'resume_user_id' 			=> $send_data['user_id'],
			
			'resume_isi' 				=> $send_data['resume_isi'],
			'resume_modified' 			=> date("Y-m-d H:i:sa"),
			);
		
		if($this->check_resume_exit($data)==1){
			$this->db->where('resume_buku_bab_id', $send_data['buku_bab_id']);
			$this->db->where('resume_user_id', $send_data['user_id']);
			$this->db->update('perpus_resume_user', $data);
		}else{
			
			$data['resume_created'] = date("Y-m-d H:i:sa");
			$this->db->insert('perpus_resume_user', $data);
		}
		
		return !$d['error'];
    }
}
