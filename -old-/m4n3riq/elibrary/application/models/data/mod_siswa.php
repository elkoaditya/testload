<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_siswa extends CI_Model {

    function listing($send_data = "") {
		
		$d = $this->d;
	
		$this->db->select("
					siswa.id,
					siswa.nis,
					siswa.nama,
					siswa.gender,
					siswa.alamat,
					siswa.telepon,
					siswa.perpus_foto,
					siswa.perpus_buku_favorit,
					
					kelas.nama as nama_kelas,
					nilsis.kelas_nilai_id,
					
					count(buku_bab.buku_bab_id) as jml_baca_bab,
					count(buku.buku_id) as jml_baca_buku,
					
					semester.id as semester_id
			");
		$this->db->join('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'left');
		$this->db->join('nilai_kelas nilkls', 'nilsis.kelas_nilai_id = nilkls.id', 'left');
		$this->db->join('dakd_kelas kelas', 'nilkls.kelas_id = kelas.id', 'left');
		$this->db->join('prd_semester semester', 'semester.id =  nilsis.semester_id', 'left');
		
		$this->db->join('perpus_baca baca', 'baca.baca_user_id =  siswa.id', 'left');
		
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca.baca_buku_bab_id', 'left');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'left');
		
		if(!empty($send_data['kelas_id'])){ 
			$this->db->where('kelas.id', $send_data['kelas_id'], false);
		}
		
		if(!empty($send_data['id'])){ 
			$this->db->where('siswa_id', $send_data['id'], false);
		}
		$this->db->where('semester.status', "'aktif'", false);
		$this->db->where('siswa.aktif', 1, false);
		
		$this->db->group_by('siswa.id');
		
        $query = $this->db->get('nilai_siswa nilsis');
        $a=0;
		
		$gender = array(''=>'', 'p'=>'Perempuan', 'l'=>'Laki - laki');
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'siswa_id' 					=> $arra1->id,
				'siswa_nis'					=> $arra1->nis,
				'siswa_nama' 				=> $arra1->nama,
				'siswa_gender'				=> $gender[$arra1->gender],
				'siswa_alamat'				=> $arra1->alamat,
				'siswa_telepon'				=> $arra1->telepon,
				
				'siswa_perpus_foto'			=> $arra1->perpus_foto,
				'siswa_perpus_buku_favorit' => $arra1->perpus_buku_favorit,
				
				'jml_baca_bab'				=> $arra1->jml_baca_bab,
				'jml_baca_buku'				=> $arra1->jml_baca_buku,
				
				'siswa_kelas' 				=> $arra1->nama_kelas,
				//'siswa_modified_time'	=> $arra1->siswa_modified_time,
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
		$this->db->join('perpus_baca baca', 'baca.baca_user_id =  siswa.id', 'inner');
		$this->db->join('perpus_buku_bab buku_bab', 'buku_bab.buku_bab_id =  baca.baca_buku_bab_id', 'inner');
		$this->db->join('perpus_buku buku', 'buku.buku_id =  buku_bab.buku_bab_buku_id', 'inner');
		
		$this->db->where('siswa.id', $send_data['id'], false);
		
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
				//'nis'					=> $send_data['siswa_nis'],
				//'nama' 					=> $send_data['siswa_nama'],
				//'gender'				=> $send_data['siswa_gender'],
				'alamat'				=> $send_data['siswa_alamat'],
				'telepon'				=> $send_data['siswa_telepon'],
				
				'perpus_buku_favorit' 	=> $send_data['siswa_perpus_buku_favorit'],
			
			);

		if($cover!='')
		{	$data['perpus_foto'] = $cover;	}
		
		if(isset($send_data['siswa_id'])){
			$this->db->where('id', $send_data['siswa_id']);
			$this->db->update('dprofil_siswa', $data);
		}
		/*else{
			if(in_array($send_data['siswa_nama'],$chek_nama))
			{
				return alert_error(" Data sudah ada.", "data/siswa/input_new");
			}
			//$data['siswa_created'] = date("Y-m-d H:i:sa");
			//$this->db->insert('dprofil_siswa', $data);
			
			$send_data['siswa_id'] = $this->db->insert_id();
		}*/
		
		
		return !$d['error'];
    }
}
