<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_user_login_role extends CI_Model {


    function listing($send_data = "") {
		
		$d = $this->d;
	
		$this->db->select("user_login_role.*,user.login_username");
		
		$this->db->join('user_login user', 'user.login_id =  user_login_role.login_role_modified_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('user_login_role.login_role_id', $send_data['id'], false);
		}
		/*$this->db->where('login_role_show', 1, false);*/
		$this->db->where('login_role_aktif', 1, false);
        $query = $this->db->get('user_login_role');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'login_role_id' 		=> $arra1->login_role_id,
				'login_role_nama' 		=> $arra1->login_role_nama,
				'login_role_kode' 		=> $arra1->login_role_kode,
				'login_role_aktif' 		=> $arra1->login_role_aktif,
				
				'user_nama' 			=> $arra1->login_username,
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	
	

}
