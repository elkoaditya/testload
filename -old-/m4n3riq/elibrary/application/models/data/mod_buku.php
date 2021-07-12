<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_buku extends CI_Model {

	function chek_data_buku_exit(){
		
		$data['id'] = "";
		$data['data_buku'] = $this->listing($data);
		
		$chek_data = array("");
		if(isset($data['data_buku']['data'])){
			foreach($data['data_buku']['data'] as $buku)
			{
				array_push($chek_data, $buku['buku_nama']);
			}
		}
		return $chek_data;
	}
	
    function listing($send_data = "") {
		/* 
		catatan :
		buku sementara jadikan 1 database
		setelah nanti dibuat laporan bulanan baru dubuatkan ke database baru
		*/
		$d = $this->d;
	
		$this->db->select("*");
		$this->db->join('perpus_user_login user', 'user.login_id =  buku.buku_modified_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('buku_id', $send_data['id'], false);
		}
		if(array_key_exists("pensiun",$send_data)){ 
			$this->db->where('buku_pensiun', $send_data['pensiun'], false);
		}
		$this->db->where('buku_aktif', 1, false);
		
		
		//// GETS
		if(array_key_exists("judul",$send_data)){ 
			if($send_data['judul']!=''){ 
				$this->db->where('buku_nama like "%'.$send_data['judul'].'%"');
			}
		}
		if(array_key_exists("pengarang",$send_data)){ 
			if($send_data['pengarang']!=''){ 
				$this->db->where('buku_pengarang like "%'.$send_data['pengarang'].'%"');
			}
		}
		if(array_key_exists("penerbit",$send_data)){ 
			if($send_data['penerbit']!=''){ 
				$this->db->where('buku_penerbit like "%'.$send_data['penerbit'].'%"');
			}
		}
		
		$tag=0;
		$where_tag = "(";
		$jml_tag=0;
		if(!empty($send_data['data_tag'])){ 
			foreach($send_data['data_tag']['data'] as $value=>$key) {
				if(array_key_exists("tag_".$key['tag_id'],$send_data)){ 
					
					if($tag==0){
						$this->db->join('perpus_buku_tag buku_tag', 'buku.buku_id =  buku_tag.buku_id', 'inner');
						$tag=1;
					}
					if($jml_tag>0){
						$where_tag .= " OR ";
					}
					$where_tag .= "buku_tag.tag_id = ".$key['tag_id'];
					$jml_tag++;
				}
			}
		}
		$where_tag .= ")";
		if($tag==1){
			$this->db->where($where_tag);
			$this->db->group_by('buku.buku_id');
		}
		///////////
		
		
		// LIMIT
        if(array_key_exists("limit",$send_data)){ 
			$this->db->limit( $send_data['limit'], $send_data['offset']);
		}
		////////////////
		
		//// ORDER
		$urut = 'asc';
		if(array_key_exists("urut",$send_data)){ 
			if($send_data!='populer'){
				$urut = $send_data['urut'];
			}
		}
		$this->db->order_by('buku.buku_nama '.$urut);
		/////////////////
		
		$query = $this->db->get('perpus_buku buku');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'buku_id' 			=> $arra1->buku_id,
				'buku_cover'			=> $arra1->buku_cover,
				'buku_nama' 			=> $arra1->buku_nama,
				'buku_pengarang' 		=> $arra1->buku_pengarang,
				'buku_penerbit' 		=> $arra1->buku_penerbit,
				'buku_no_seri' 		=> $arra1->buku_no_seri,
				//'buku_jenis' 			=> $arra1->buku_jenis,
				'buku_jml_bab' 		=> $arra1->buku_jml_bab,
				//'buku_jml_pembaca' 	=> $arra1->buku_jml_pembaca,
				'buku_pensiun' 		=> $arra1->buku_pensiun,
				'buku_modified_time'	=> tgltodb($arra1->buku_modified_time),
				'modified_username' 				=> $arra1->login_username,
				
			);
			
			/// tag
			$send_data['id'] = $arra1->buku_id;
			$data_tag = $this->listing_tag($send_data);
			
			$datas['buku_tag']='';
			if(isset($data_tag['data'])){
				foreach($data_tag['data'] as $value=>$key){
					if($datas['buku_tag']=='')
					{	$datas['buku_tag'] .= $key['tag_nama'];		}
					else
					{	$datas['buku_tag'] .= ', '.$key['tag_nama'];		}
				}
			}
			
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
		$data1['max_data'] = $query->num_rows();

        return $data1;
		
		return $d;
    }
	
	function listing_tag($send_data = "") {
		$d = $this->d;
	
		$this->db->select("
			buku_tag.*,
			tag_nama
		");
		$this->db->join('perpus_tag tag', 'tag.tag_id =  buku_tag.tag_id', 'left');
		
		$this->db->where('buku_id', $send_data['id'], false);
		
        $query = $this->db->get('perpus_buku_tag buku_tag');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'tag_id' 		=> $arra1->tag_id,
				'tag_nama' 		=> $arra1->tag_nama,
			);
			$data1['data'][$a] = $datas;
			
        }
        $data1['count'] = $a;
        return $data1;
	}
	
	function listing_baca($send_data = "",$role='siswa') {
		$d = $this->d;
	
		$this->db->select("
			buku.buku_id,
			buku.buku_nama,
			
			buku_bab.buku_bab_id,
			buku_bab.buku_bab_nama,
			
			user.nama as user_nama,
			baca.*,
		");
		$this->db->join('perpus_baca baca', 'baca.baca_user_id =  user.id', 'inner');
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca.baca_buku_bab_id', 'inner');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'inner');
		
		$this->db->where('buku_id', $send_data['id'], false);
		
		if(isset($send_data['siswa_id'])){
			$this->db->where('user.id', $send_data['siswa_id'], false);
		}
		if(isset($send_data['sdm_id'])){
			$this->db->where('user.id', $send_data['sdm_id'], false);
		}
		
		$this->db->order_by('baca.read_last DESC');
		
		if($role=='siswa'){
			$query = $this->db->get('dprofil_siswa user');
		}else if($role=='sdm'){
			$query = $this->db->get('dprofil_sdm user');
		}
		
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'user_id' 			=> $arra1->baca_user_id,
				'user_nama' 		=> $arra1->user_nama,
				
				'buku_id' 			=> $arra1->buku_id,
				'buku_nama' 		=> $arra1->buku_nama,
				
				'buku_bab_id' 		=> $arra1->buku_bab_id,
				'buku_bab_nama' 	=> $arra1->buku_bab_nama,
				
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
	
	function save($send_data = "", $upload="") {
		$d = $this->d;
		
		$upload_path = $upload['full_path'];
		$cover = $upload['file_name'];
		
		$chek_nama = $this->chek_data_buku_exit();
		
		$data = array(
			'buku_nama' 			=> $send_data['buku_nama'],
			'buku_pengarang' 		=> $send_data['buku_pengarang'],
			'buku_penerbit' 		=> $send_data['buku_penerbit'],
			'buku_no_seri' 			=> $send_data['buku_no_seri'],
			//'buku_jenis' 			=> $send_data['buku_jenis'],
			'buku_jml_bab' 			=> $send_data['buku_jml_bab'],
			'buku_pensiun' 			=> 0,
			'buku_modified_time' 	=> date("Y-m-d H:i:sa"),
			'buku_modified_id' 		=> $this->session->userdata['user']['id'],
			'buku_aktif' 			=> 1,
			
			);

		if($cover!='')
		{	$data['buku_cover'] = $cover;	}
		
		if(isset($send_data['buku_id'])){
			$this->db->where('buku_id', $send_data['buku_id']);
			$this->db->update('perpus_buku', $data);
		}else{
			if(in_array($send_data['buku_nama'],$chek_nama))
			{
				return alert_error(" Data sudah ada.", "data/buku/input_new");
			}
			$data['buku_created'] = date("Y-m-d H:i:sa");
			$this->db->insert('perpus_buku', $data);
			
			$send_data['buku_id'] = $this->db->insert_id();
		}
		
		///// SAVE ADDITIONAL
		$this->save_buku_tag($send_data);
		
		return !$d['error'];
    }
	
	function save_buku_tag($send_data = "") {
		$d = $this->d;
		
		$this->db->where('buku_id',  $send_data["buku_id"]);
		$this->db->delete('perpus_buku_tag');
		
		//// TAG 
		$this->db->where('tag_aktif', 1);
		$query = $this->db->get('perpus_tag tag');
		
		foreach ($query->result() as $arra1) {
			if(isset($send_data['tag_'.$arra1->tag_id])){
				if($send_data['tag_'.$arra1->tag_id] != ''){
					$data = array(
						'buku_id'		=> $send_data["buku_id"],
						'tag_id' 		=> $arra1->tag_id,
						'modified_time' => date("Y-m-d H:i:sa"),
						);
						
					$this->db->insert('perpus_buku_tag', $data);
				}
			}
			//$no++;
		}
	}
	
	function edit_pensiun($send_data = "") {
		$d = $this->d;
		
		$data = array(
			'buku_pensiun' 		=> $send_data['buku_pensiun'],
			);

		$this->db->where('buku_id', $send_data['buku_id']);
		$this->db->update('perpus_buku', $data);
		return !$d['error'];
    }
	
	function delete($send_data = "") {
		$d = $this->d;
		
		$data = array(
			'buku_aktif' 		=> 0,
			);

		$this->db->where('buku_id', $send_data['buku_id']);
		$this->db->update('perpus_buku', $data);
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
		$sheet->setCellValue('A1', 'FORM TAMBAH ANGGOTA BPK ');
		$sheet->setCellValue('A2', 'Last Download '.$datetime_now);
		
		
		return excel_output_2007($excel_obj, 'Tambah_master_buku.xlsx');
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
		
		$chek_nama = $this->chek_data_buku_exit();
		
		while($row_max >= $row_excel)
		{
			// CHECK EXIT
			$temp_nama = $sheet->getCell('B' . $row_excel)->getValue();
			if(!in_array($temp_nama,$chek_nama))
			{
				$row[$no]['buku_nama'] 			= $sheet->getCell('B' . $row_excel)->getValue();
				
				$row[$no]['buku_created'] 		= date("Y-m-d H:i:sa");
				$row[$no]['buku_modified_id'] 	= $this->session->userdata['user']['id'];
				$row[$no]['buku_aktif']			= 1;
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
		$this->db->insert_batch('perpus_buku', $row);
		if ($this->db->trans_status() === FALSE){
			
				$this->db->trans_rollback();
		}else{
			
				$this->db->trans_commit();
		}
		
		return !$d['error'];
    }

}
