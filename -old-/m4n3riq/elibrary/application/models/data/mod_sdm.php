<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_sdm extends CI_Model {

    function listing($send_data = "") {
		
		$d = $this->d;
	
		$this->db->select("
					sdm.id,
					sdm.nama,
					sdm.gender,
					sdm.alamat,
					sdm.telepon,
					sdm.perpus_foto,
					sdm.perpus_buku_favorit,
					
					count(buku_bab.buku_bab_id) as jml_baca_bab,
					count(buku.buku_id) as jml_baca_buku,
					
			");
		
		$this->db->join('perpus_baca baca', 'baca.baca_user_id =  sdm.id', 'left');
		
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca.baca_buku_bab_id', 'left');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('sdm.id', $send_data['id'], false);
		}
		$this->db->where('sdm.aktif', 1, false);
		
		$this->db->group_by('sdm.id');
		
        $query = $this->db->get('dprofil_sdm sdm');
        $a=0;
		
		$gender = array(''=>'', 'p'=>'Perempuan', 'l'=>'Laki - laki');
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'sdm_id' 					=> $arra1->id,
				'sdm_nama' 				=> $arra1->nama,
				'sdm_gender'				=> $gender[$arra1->gender],
				'sdm_alamat'				=> $arra1->alamat,
				'sdm_telepon'				=> $arra1->telepon,
				
				'sdm_perpus_foto'			=> $arra1->perpus_foto,
				'sdm_perpus_buku_favorit' => $arra1->perpus_buku_favorit,
				
				'jml_baca_bab'				=> $arra1->jml_baca_bab,
				'jml_baca_buku'				=> $arra1->jml_baca_buku,
				
				//'sdm_modified_time'	=> $arra1->sdm_modified_time,
				//'modified_username' 				=> $arra1->login_username,
				
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	
	function listing_baca($send_data = "") {
		$d = $this->d;
	
		$this->db->select("
			buku.buku_id,
			buku.buku_nama,
			
			buku_bab.buku_bab_id,
			buku_bab.buku_bab_nama,
			
			baca.*,
		");
		$this->db->join('perpus_baca baca', 'baca.baca_user_id =  sdm.id', 'inner');
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca.baca_buku_bab_id', 'inner');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'inner');
		
		$this->db->where('sdm.id', $send_data['id'], false);
		
		$this->db->order_by('baca.read_last DESC');
        $query = $this->db->get('dprofil_sdm sdm');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
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
		
		$data = array(
				
				//'nama' 					=> $send_data['sdm_nama'],
				//'gender'				=> $send_data['sdm_gender'],
				'alamat'				=> $send_data['sdm_alamat'],
				'telepon'				=> $send_data['sdm_telepon'],
				
				'perpus_buku_favorit' 	=> $send_data['sdm_perpus_buku_favorit'],
			
			);

		if($cover!='')
		{	$data['perpus_foto'] = $cover;	}
		
		if(isset($send_data['sdm_id'])){
			$this->db->where('id', $send_data['sdm_id']);
			$this->db->update('dprofil_sdm', $data);
		}
	
		
		
		return !$d['error'];
    }
}
