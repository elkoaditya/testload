<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_kelas extends CI_Model {

	function listing($send_data = "") {
	
		$d = $this->d;
	
		$this->db->select("
			kelas.*,
			sdm.id as id_wali,
			sdm.nama as nama_wali,
			");
			
		$this->db->join('dprofil_sdm sdm', 'sdm.id =  kelas.wali_id	', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('kelas.id', $send_data['id'], false);
		}
		$this->db->where('kelas.aktif', 1, false);
		$this->db->where('kelas.nama NOT LIKE "%Alumni%"');
		
		$this->db->order_by('length(kelas.nama) ASC, kelas.nama ASC ');
		
        $query = $this->db->get('dakd_kelas kelas');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'id' 				=> $arra1->id,
				'nama' 				=> $arra1->nama,
				'grade' 			=> $arra1->grade,
				'modified' 			=> tglwaktu($arra1->modified),
				'aktif' 			=> $arra1->aktif,
				
				'id_wali' 			=> $arra1->id_wali,
				'nama_wali' 		=> $arra1->nama_wali,
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
}