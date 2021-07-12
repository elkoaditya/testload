<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_siswa extends CI_Model {

	function listing($send_data = "") {
	
		$d = $this->d;
	
		$this->db->select("
			siswa.*,
			kelas.id as id_kelas,
			kelas.nama as nama_kelas,
			");
			
		$this->db->join('nilai_siswa nilsis', 'nilsis.siswa_id =  siswa.id	', 'inner');
		$this->db->join('prd_semester semester', 'semester.id =  nilsis.semester_id	', 'inner');
		
		$this->db->join('nilai_kelas nilkls', 'nilkls.id = nilsis.kelas_nilai_id', 'left');
		$this->db->join('dakd_kelas kelas', 'nilkls.kelas_id = kelas.id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('siswa.id', $send_data['id'], false);
		}
		
		if(!empty($send_data['kelas_id'])){ 
			$this->db->where('kelas.id', $send_data['kelas_id'], false);
		}
		
		$this->db->where('semester.status', '"aktif"', false);
		$this->db->where('siswa.aktif', 1, false);
		
		$this->db->where('kelas.nama NOT LIKE "%Alumni%"');
		
		$this->db->order_by('length(kelas.nama) ASC, kelas.nama ASC , siswa.nama ASC');
		
        $query = $this->db->get('dprofil_siswa siswa');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'id' 				=> $arra1->id,
				'nama' 				=> $arra1->nama,
				
				'modified' 			=> tglwaktu($arra1->modified),
				'aktif' 			=> $arra1->aktif,
				
				'id_kelas' 			=> $arra1->id_kelas,
				'nama_kelas' 		=> $arra1->nama_kelas,
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
}