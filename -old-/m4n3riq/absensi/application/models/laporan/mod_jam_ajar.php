<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_jam_ajar extends CI_Model {

	function listing($send_data = "") {
	
		$d = $this->d;
	
		$this->db->select("
			*
			");
		
		if(!empty($send_data['id'])){ 
			$this->db->where('id', $send_data['id'], false);
		}
		$this->db->where('aktif', 1, false);
        $query = $this->db->get('dakd_jam_ajar');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'id' 				=> $arra1->id,
				'nama' 				=> $arra1->nama,
				'awal' 				=> $arra1->awal,
				'modified' 			=> tglwaktu($arra1->modified),
				'aktif' 			=> $arra1->aktif,
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
}