<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_tag extends CI_Model {

	function chek_data_tag_exit(){
		
		$data['id'] = "";
		$data['data_tag'] = $this->listing($data);
		
		$chek_data = array("");
		foreach($data['data_tag']['data'] as $tag)
		{
			array_push($chek_data, $tag['tag_nama']);
		}
		return $chek_data;
	}
	
    function listing($send_data = "") {
		/* 
		catatan :
		tag sementara jadikan 1 database
		setelah nanti dibuat laporan bulanan baru dubuatkan ke database baru
		*/
		$d = $this->d;
	
		$this->db->select("*");
		$this->db->join('perpus_user_login user', 'user.login_id =  tag.tag_modified_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('tag_id', $send_data['id'], false);
		}
		
		$this->db->where('tag_aktif', 1, false);
		$this->db->order_by('tag_nama asc');
        $query = $this->db->get('perpus_tag tag');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'tag_id' 			=> $arra1->tag_id,
				'tag_nama' 			=> $arra1->tag_nama,
				
				'tag_modified_time'	=> $arra1->tag_modified_time,
				'modified_username' 				=> $arra1->login_username,
				
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	function save($send_data = "") {
		$d = $this->d;
		
		$chek_nama = $this->chek_data_tag_exit();
		
		
		$data = array(
			'tag_nama' 				=> $send_data['tag_nama'],
			
			'tag_modified_time' 	=> date("Y-m-d H:i:sa"),
			'tag_modified_id' 		=> $this->session->userdata['user']['id'],
			'tag_aktif' 			=> 1,
			
			);

		if(isset($send_data['tag_id'])){
			$this->db->where('tag_id', $send_data['tag_id']);
			$this->db->update('perpus_tag', $data);
		}else{
			if(in_array($send_data['tag_nama'],$chek_nama))
			{
				return alert_error(" Data sudah ada.", "data/tag/input_new");
			}
			$data['tag_created'] = date("Y-m-d H:i:sa");
			$this->db->insert('perpus_tag', $data);
		}
		
		return !$d['error'];
    }
	
	function edit_pensiun($send_data = "") {
		$d = $this->d;
		
		$data = array(
			'tag_pensiun' 		=> $send_data['tag_pensiun'],
			);

		$this->db->where('tag_id', $send_data['tag_id']);
		$this->db->update('perpus_tag', $data);
		return !$d['error'];
    }
	
	function delete($send_data = "") {
		$d = $this->d;
		
		$data = array(
			'tag_aktif' 		=> 0,
			);

		$this->db->where('tag_id', $send_data['tag_id']);
		$this->db->update('perpus_tag', $data);
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
		$sheet->setCellValue('A1', 'FORM TAMBAH tag PENYIDIK ');
		$sheet->setCellValue('A2', 'Last Download '.$datetime_now);
		
		
		return excel_output_2007($excel_obj, 'Tambah_master_tag_PENYIDIK.xlsx');
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
		
		$chek_nama = $this->chek_data_tag_exit();
		
		while($row_max >= $row_excel)
		{
			// CHECK EXIT
			$temp_nama = $sheet->getCell('B' . $row_excel)->getValue();
			if(!in_array($temp_nama,$chek_nama))
			{
				$row[$no]['tag_nama'] 			= $sheet->getCell('B' . $row_excel)->getValue();
				
				$row[$no]['tag_created'] 		= date("Y-m-d H:i:sa");
				$row[$no]['tag_modified_id'] 	= $this->session->userdata['user']['id'];
				$row[$no]['tag_aktif']			= 1;
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
		$this->db->insert_batch('tag', $row);
		if ($this->db->trans_status() === FALSE){
			
				$this->db->trans_rollback();
		}else{
			
				$this->db->trans_commit();
		}
		
		return !$d['error'];
    }

}
